<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\City;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    /**
     * Directory of all 51 US States
     */
    public function index()
    {
        $states = State::where('is_active', true)
            ->withCount('cities')
            ->orderBy('name')
            ->get();

        $pageTitle = "Nationwide Certified Drug Testing Locations | 20,000+ Quest & Labcorp Sites";
        $metaDescription = "Find accredited drug testing centers in all 51 states. Walk-in same-day urine, hair, DOT, and alcohol testing at Quest Diagnostics and Labcorp facilities.";

        return view('locations.index', compact('states', 'pageTitle', 'metaDescription'));
    }

    /**
     * State Landing Page (e.g. /locations/florida)
     */
    public function state(string $stateSlug)
    {
        $state = State::where('slug', $stateSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $cities = City::where('state_id', $state->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $sampleLocations = Location::where('state', $state->abbr)
            ->where('is_active', true)
            ->limit(10)
            ->get();

        $popularTests = Product::where('is_popular', true)->where('is_active', true)->limit(4)->get();

        $pageTitle = $state->meta_title ?: "{$state->name} Drug Testing Locations & Walk-in Centers";
        $metaDescription = $state->meta_description ?: "Accredited drug testing collection facilities in {$state->name}. Find local Quest & Labcorp centers for employment, court, and DOT testing.";

        return view('locations.state', compact('state', 'cities', 'sampleLocations', 'popularTests', 'pageTitle', 'metaDescription'));
    }

    /**
     * City Landing Page (e.g. /locations/florida/orlando)
     */
    public function city(string $stateSlug, string $citySlug)
    {
        $state = State::where('slug', $stateSlug)->where('is_active', true)->firstOrFail();

        $city = City::where('state_id', $state->id)
            ->where('slug', $citySlug)
            ->first();

        // Search locations in this city
        $cityName = $city ? $city->name : str_replace('-', ' ', $citySlug);

        $locations = Location::where('state', $state->abbr)
            ->where('city', 'LIKE', $cityName)
            ->where('is_active', true)
            ->get();

        // If no direct city match, fetch nearby locations in the same state
        if ($locations->isEmpty()) {
            $locations = Location::where('state', $state->abbr)
                ->where('is_active', true)
                ->limit(6)
                ->get();
        }

        $popularTests = Product::where('is_popular', true)->where('is_active', true)->limit(6)->get();

        $pageTitle = $city?->meta_title ?: "{$cityName}, {$state->abbr} Drug Testing Centers & Walk-in Labs";
        $metaDescription = $city?->meta_description ?: "Fast, certified drug and alcohol testing in {$cityName}, {$state->abbr}. Walk in today at Quest Diagnostics and Labcorp certified collection facilities.";

        return view('locations.city', compact('state', 'city', 'cityName', 'locations', 'popularTests', 'pageTitle', 'metaDescription'));
    }

    /**
     * Dedicated Facility Detail Profile (e.g. /location/1 or /locations/site/1)
     */
    public function show(Request $request, $id)
    {
        $location = Location::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        // Find state and city models if available
        $state = State::where('abbr', strtoupper($location->state))->first();
        $city = null;
        if ($state) {
            $city = City::where('state_id', $state->id)
                ->where(function($q) use ($location) {
                    $q->where('name', $location->city)
                      ->orWhere('slug', Str::slug($location->city));
                })->first();
        }

        // Nearby alternative locations in same city / state
        $nearbyLocations = Location::where('state', $location->state)
            ->where('id', '!=', $location->id)
            ->where('is_active', true)
            ->orderByRaw("CASE WHEN LOWER(city) = ? THEN 0 ELSE 1 END", [strtolower($location->city)])
            ->limit(4)
            ->get();

        // Popular tests for direct checkout
        $popularTests = Product::where('is_popular', true)->where('is_active', true)->limit(6)->get();

        // Turn-by-turn navigation URLs
        $hasCoords = !empty($location->lat) && !empty($location->lng);
        $coordDest = $hasCoords ? "{$location->lat},{$location->lng}" : '';
        $addrDest = urlencode("{$location->address1}, {$location->city}, {$location->state} {$location->zip}");

        $googleMapsUrl = $hasCoords 
            ? "https://www.google.com/maps/dir/?api=1&destination={$coordDest}"
            : "https://www.google.com/maps/dir/?api=1&destination={$addrDest}";

        $appleMapsUrl = $hasCoords
            ? "https://maps.apple.com/?daddr={$coordDest}"
            : "https://maps.apple.com/?daddr={$addrDest}";

        $wazeUrl = $hasCoords
            ? "https://waze.com/ul?ll={$coordDest}&navigate=yes"
            : "https://waze.com/ul?q={$addrDest}";

        // Operating hours parser
        $parsedHours = $this->parseOperatingHours($location->hours);

        $providerName = ucfirst($location->provider ?: 'Quest / Labcorp');
        $pageTitle = "{$location->name} - {$location->address1}, {$location->city}, {$location->state} {$location->zip} | Certified Drug Test Centers";
        $metaDescription = "Walk-in drug and alcohol testing at {$location->name} in {$location->city}, {$location->state}. Same-day testing, DOT urine screening, hair testing, and fast MRO lab results.";

        return view('locations.show', compact(
            'location',
            'state',
            'city',
            'nearbyLocations',
            'popularTests',
            'googleMapsUrl',
            'appleMapsUrl',
            'wazeUrl',
            'parsedHours',
            'providerName',
            'pageTitle',
            'metaDescription'
        ));
    }

    /**
     * Fast ZIP code locator API
     */
    public function searchZip(Request $request): JsonResponse
    {
        $zip = trim($request->input('zip', ''));
        if (strlen($zip) < 3) {
            return response()->json(['success' => false, 'message' => 'Please enter at least 3 digits of a US ZIP code.']);
        }

        $prefix = substr($zip, 0, 3);
        $locations = Location::where('zip', 'LIKE', "{$prefix}%")
            ->where('is_active', true)
            ->limit(6)
            ->get();

        if ($locations->isEmpty()) {
            // Fallback to first matching
            $locations = Location::where('is_active', true)->limit(3)->get();
        }

        $formatted = $locations->map(function ($loc) {
            $hasCoords = !empty($loc->lat) && !empty($loc->lng);
            $dest = $hasCoords ? "{$loc->lat},{$loc->lng}" : urlencode("{$loc->address1}, {$loc->city}, {$loc->state} {$loc->zip}");
            return [
                'id' => $loc->id,
                'name' => $loc->name,
                'provider' => ucfirst($loc->provider),
                'address' => $loc->address1 . ($loc->address2 ? ' ' . $loc->address2 : ''),
                'city' => $loc->city,
                'state' => $loc->state,
                'zip' => $loc->zip,
                'phone' => $loc->phone ?: '(800) 221-4291',
                'hours' => $loc->hours ?: 'Monday - Friday 8:00 AM - 5:00 PM',
                'profile_url' => route('locations.show', $loc->id),
                'checkout_url' => route('checkout.index', ['location_id' => $loc->id]),
                'directions_url' => "https://www.google.com/maps/dir/?api=1&destination={$dest}",
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $formatted->count(),
            'locations' => $formatted,
        ]);
    }

    /**
     * Parse raw operating hours into structured daily timetable
     */
    protected function parseOperatingHours(?string $rawHours): array
    {
        $defaultSchedule = [
            ['day' => 'Monday', 'hours' => '8:00 am - 5:00 pm', 'is_today' => false, 'is_closed' => false],
            ['day' => 'Tuesday', 'hours' => '8:00 am - 5:00 pm', 'is_today' => false, 'is_closed' => false],
            ['day' => 'Wednesday', 'hours' => '8:00 am - 5:00 pm', 'is_today' => false, 'is_closed' => false],
            ['day' => 'Thursday', 'hours' => '8:00 am - 5:00 pm', 'is_today' => false, 'is_closed' => false],
            ['day' => 'Friday', 'hours' => '8:00 am - 5:00 pm', 'is_today' => false, 'is_closed' => false],
            ['day' => 'Saturday', 'hours' => 'Closed', 'is_today' => false, 'is_closed' => true],
            ['day' => 'Sunday', 'hours' => 'Closed', 'is_today' => false, 'is_closed' => true],
        ];

        if (empty($rawHours)) {
            $today = date('l');
            foreach ($defaultSchedule as &$item) {
                if ($item['day'] === $today) {
                    $item['is_today'] = true;
                }
            }
            return [
                'days' => $defaultSchedule,
                'today_status' => 'Open Today (8:00 am - 5:00 pm)',
                'is_open_today' => !in_array($today, ['Saturday', 'Sunday']),
            ];
        }

        $parts = array_filter(array_map('trim', explode(';', $rawHours)));
        $days = [];
        $currentDayName = date('l');
        $todayStatus = 'Hours Available Online';
        $isOpenToday = false;

        foreach ($parts as $part) {
            if (str_contains($part, ':')) {
                [$dayKey, $timeVal] = explode(':', $part, 2);
                $dayKey = trim($dayKey);
                $timeVal = trim($timeVal);

                $isToday = (strcasecmp($dayKey, $currentDayName) === 0);
                $isClosed = (stripos($timeVal, 'closed') !== false);

                if ($isToday) {
                    $isOpenToday = !$isClosed;
                    $todayStatus = $isClosed ? 'Closed Today' : 'Open Today: ' . $timeVal;
                }

                $days[] = [
                    'day' => ucfirst(strtolower($dayKey)),
                    'hours' => $timeVal,
                    'is_today' => $isToday,
                    'is_closed' => $isClosed,
                ];
            }
        }

        if (empty($days)) {
            $days = $defaultSchedule;
            $today = date('l');
            foreach ($days as &$item) {
                if ($item['day'] === $today) {
                    $item['is_today'] = true;
                }
            }
            $todayStatus = 'Open Monday - Friday';
            $isOpenToday = !in_array($today, ['Saturday', 'Sunday']);
        }

        return [
            'days' => $days,
            'today_status' => $todayStatus,
            'is_open_today' => $isOpenToday,
        ];
    }

    /**
     * Programmatic SEO Chain Handler (e.g. /drug-testing-orlando-fl, /drug-testing-locations-memphis-tn)
     */
    public function resolveChainCity(string $slug)
    {
        $clean = preg_replace('/^(local-drug-testing-locations-|drug-testing-locations-|drug-testing-)/', '', $slug);

        if (preg_match('/^(.*?)-([a-z]{2})$/i', $clean, $matches)) {
            $citySlug = $matches[1];
            $stateAbbr = strtoupper($matches[2]);

            $state = State::where('abbr', $stateAbbr)->where('is_active', true)->first();
            if ($state) {
                return $this->city($state->slug, $citySlug);
            }
        }

        abort(404);
    }
}
