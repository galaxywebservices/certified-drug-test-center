<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\City;
use App\Models\Location;
use App\Models\Product;
use App\Services\GeoLocationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    /**
     * Directory of all 51 US States
     */
    public function index(Request $request, GeoLocationService $geo)
    {
        if ($request->filled('zip')) {
            $zip = trim($request->input('zip'));
            $cleanZip = preg_replace('/[^0-9]/', '', $zip);
            if (strlen($cleanZip) >= 3) {
                $location = $geo->findNearestLocationsByZip($cleanZip, 1)->first();
                if ($location) {
                    $state = State::where('abbr', strtoupper($location->state))->first();
                    if ($state) {
                        $citySlug = Str::slug($location->city);
                        $city = City::where('state_id', $state->id)
                            ->where(function ($q) use ($location, $citySlug) {
                                $q->where('slug', $citySlug)->orWhere('name', $location->city);
                            })->first();
                        if ($city) {
                            return redirect()->to("/locations/{$state->slug}/{$city->slug}");
                        }
                        return redirect()->to("/locations/{$state->slug}");
                    }
                }
            }
        }

        return redirect()->to('/certified-drug-test-centers', 301);
    }

    /**
     * State Landing Page (e.g. /locations/florida or /certified-drug-test-centers/florida)
     */
    public function state(string $stateSlug)
    {
        $state = State::where('slug', $stateSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $cities = City::join('pseo_eligible_cities', 'cities.id', '=', 'pseo_eligible_cities.city_id')
            ->where('cities.state_id', $state->id)
            ->where('cities.is_active', true)
            ->where('pseo_eligible_cities.is_eligible', true)
            ->where('cities.name', 'NOT LIKE', '%County%')
            ->whereNotIn('cities.slug', ['coconino', 'north-pinal'])
            ->orderBy('cities.name')
            ->select('cities.*')
            ->get();

        $questLocations = Location::where('state', $state->abbr)
            ->where('provider', 'quest')
            ->where('is_active', true)
            ->limit(8)
            ->get();

        $labcorpLocations = Location::where('state', $state->abbr)
            ->where('provider', 'labcorp')
            ->where('is_active', true)
            ->limit(8)
            ->get();

        if ($questLocations->isNotEmpty() && $labcorpLocations->isNotEmpty()) {
            $sampleLocations = $questLocations->zip($labcorpLocations)->flatten()->filter()->values();
        } else {
            $sampleLocations = Location::where('state', $state->abbr)
                ->where('is_active', true)
                ->limit(16)
                ->get();
        }

        $popularTests = $this->getPopularTests(4);

        $isChainRoute = request()->is('certified-drug-test-centers*');
        $baseRoutePrefix = $isChainRoute ? '/certified-drug-test-centers' : '/locations';
        $baseTitle = $isChainRoute ? 'Certified Drug Test Centers' : 'Locations';
        $canonicalUrl = rtrim(url($baseRoutePrefix . '/' . $state->slug), '/');

        $defaultKeywords = 'Drug Test near me, DOT Drug Test near me, Alcohol test near me, Drug Testing, Drug testing center near me, employer drug testing programs, 5 panel urine test, 5 panel drug test, 10 panel drug test, DOT consortium Enrollment, where can i get a drug test, Hair drug test';

        $pageTitle = $state->meta_title ?: "{$state->name} Drug Testing Centers - (800) 985-4339";
        $metaDescription = $state->meta_description ?: "Certified Drug Test Centers are located in {$state->name} and in most cases within minutes of your home or office. Order a drug or alcohol test online or call (800) 985-4339 and receive an electronic donor pass via email or text immediately. Same-day testing available for employment, DOT, probation and personal purposes at more than 20,000 certified drug testing centers — including Quest Diagnostics, Labcorp and affiliated locations. Negative results are typically available within 24–48 hours.";
        $metaKeywords = $defaultKeywords;
        $pageAbout = "{$state->name} Drug Testing";

        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Locations', 'url' => url('/certified-drug-test-centers')],
            ['name' => $state->name, 'url' => $canonicalUrl],
        ];

        return view('locations.state', compact(
            'state',
            'cities',
            'sampleLocations',
            'popularTests',
            'pageTitle',
            'metaDescription',
            'metaKeywords',
            'pageAbout',
            'isChainRoute',
            'baseRoutePrefix',
            'baseTitle',
            'canonicalUrl',
            'breadcrumbs'
        ));
    }

    /**
     * City Landing Page (e.g. /locations/florida/orlando or /certified-drug-test-centers/florida/orlando)
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

        $popularTests = $this->getPopularTests(6);

        $isChainRoute = request()->is('certified-drug-test-centers*');
        $baseRoutePrefix = $isChainRoute ? '/certified-drug-test-centers' : '/locations';
        $baseTitle = $isChainRoute ? 'Certified Drug Test Centers' : 'Locations';
        $canonicalUrl = rtrim(url($baseRoutePrefix . '/' . $state->slug . '/' . $citySlug), '/');

        // Automate Sibling Linking: Filter out county records and sort eligible sibling cities by Haversine distance
        $candidateSiblings = City::join('pseo_eligible_cities', 'cities.id', '=', 'pseo_eligible_cities.city_id')
            ->where('cities.state_id', $state->id)
            ->where('cities.is_active', true)
            ->where('pseo_eligible_cities.is_eligible', true)
            ->where('cities.name', 'NOT LIKE', '%County%')
            ->whereNotIn('cities.slug', ['coconino', 'north-pinal'])
            ->when($city, fn($q) => $q->where('cities.id', '!=', $city->id))
            ->select('cities.id', 'cities.name', 'cities.slug', 'cities.state_id')
            ->get();

        $refLoc = $locations->first(fn($l) => !empty($l->lat) && !empty($l->lng));
        if ($refLoc && $candidateSiblings->isNotEmpty()) {
            $lat1 = (float)$refLoc->lat;
            $lon1 = (float)$refLoc->lng;

            $siblingNames = $candidateSiblings->pluck('name')->toArray();
            $siblingLocations = Location::where('state', $state->abbr)
                ->whereIn('city', $siblingNames)
                ->whereNotNull('lat')
                ->whereNotNull('lng')
                ->get(['city', 'lat', 'lng'])
                ->groupBy(fn($l) => strtolower($l->city));

            $siblingCities = $candidateSiblings->map(function ($sib) use ($lat1, $lon1, $siblingLocations) {
                $cLoc = $siblingLocations->get(strtolower($sib->name))?->first();
                if ($cLoc) {
                    $lat2 = (float)$cLoc->lat;
                    $lon2 = (float)$cLoc->lng;
                    $d = 3959 * acos(min(1.0, max(-1.0, cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon2) - deg2rad($lon1)) + sin(deg2rad($lat1)) * sin(deg2rad($lat2)))));
                    $sib->distance_miles = round($d, 1);
                } else {
                    $sib->distance_miles = 9999;
                }
                return $sib;
            })->sortBy('distance_miles')->take(10)->values();
        } else {
            $siblingCities = $candidateSiblings->sortBy('name')->take(10)->values();
        }

        // Dynamic City Metrics for genuine local value & AEO uniqueness
        $coveredZips = $locations->pluck('zip')->filter()->unique()->values();
        $coveredZipsString = $coveredZips->take(12)->implode(', ') . ($coveredZips->count() > 12 ? ' +' . ($coveredZips->count() - 12) . ' more' : '');

        $has24Hrs = false;
        $weekendOr24Count = 0;
        $earliestOpen = '8:00 AM';

        foreach ($locations as $loc) {
            $h = strtolower($loc->hours ?? '');
            if (str_contains($h, '24 hr') || str_contains($h, '24/7') || str_contains($h, '24 hour')) {
                $has24Hrs = true;
                $weekendOr24Count++;
            } elseif (str_contains($h, 'sa') || str_contains($h, 'sat') || str_contains($h, 'saturday') || str_contains($h, 'su ') || str_contains($h, 'sun')) {
                $weekendOr24Count++;
            }

            if (preg_match('/(\b(?:6|7|8|9)(?::\d{2})?\s*(?:am|pm)?)/i', $loc->hours, $m)) {
                $timeStr = strtoupper(trim($m[1]));
                if (str_starts_with($timeStr, '6:')) {
                    $earliestOpen = '6:30 AM';
                } elseif (str_starts_with($timeStr, '7:')) {
                    if ($earliestOpen !== '6:30 AM') {
                        $earliestOpen = '7:00 AM';
                    }
                }
            }
        }

        $defaultKeywords = 'Drug Test near me, DOT Drug Test near me, Alcohol test near me, Drug Testing, Drug testing center near me, employer drug testing programs, 5 panel urine test, 5 panel drug test, 10 panel drug test, DOT consortium Enrollment, where can i get a drug test, Hair drug test';

        $pageTitle = $city?->meta_title ?: "{$cityName}, {$state->abbr} Drug Testing Centers - (800) 985-4339";
        $metaDescription = $city?->meta_description ?: "Certified Drug Test Centers are located in {$cityName}, {$state->abbr} and in most cases within minutes of your home or office. Order a drug or alcohol test online or call (800) 985-4339 and receive an electronic donor pass via email or text immediately. Same-day testing available for employment, DOT, probation and personal purposes at more than 20,000 certified drug testing centers — including Quest Diagnostics, Labcorp and affiliated locations. Negative results are typically available within 24–48 hours.";
        $metaKeywords = $defaultKeywords;
        $pageAbout = "{$cityName}, {$state->abbr} Drug Testing";

        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Locations', 'url' => url('/certified-drug-test-centers')],
            ['name' => $state->name, 'url' => url('/locations/' . $state->slug)],
            ['name' => $cityName, 'url' => $canonicalUrl],
        ];

        return view('locations.city', compact(
            'state',
            'city',
            'cityName',
            'locations',
            'popularTests',
            'pageTitle',
            'metaDescription',
            'metaKeywords',
            'pageAbout',
            'coveredZipsString',
            'earliestOpen',
            'weekendOr24Count',
            'has24Hrs',
            'siblingCities',
            'isChainRoute',
            'baseRoutePrefix',
            'baseTitle',
            'canonicalUrl',
            'breadcrumbs'
        ));
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
        $popularTests = $this->getPopularTests(6);

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
        $metaRobots = 'noindex, follow';

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
            'metaDescription',
            'metaRobots'
        ));
    }

    /**
     * Fast ZIP code locator API
     */
    public function searchZip(Request $request, GeoLocationService $geo): JsonResponse
    {
        $zip = trim($request->input('zip', ''));
        if (strlen($zip) < 3) {
            return response()->json(['success' => false, 'message' => 'Please enter at least 3 digits of a US ZIP code.']);
        }

        $locations = $geo->findNearestLocationsByZip($zip, 6);

        $formatted = $locations->map(function ($loc) {
            $hasCoords = !empty($loc->lat) && !empty($loc->lng);
            $dest = $hasCoords ? "{$loc->lat},{$loc->lng}" : urlencode("{$loc->address1}, {$loc->city}, {$loc->state} {$loc->zip}");
            return [
                'id' => $loc->id,
                'name' => $loc->name,
                'provider' => ucfirst($loc->provider),
                'address' => $loc->address1 . ($loc->address2 ? ' ' . $loc->address2 : ''),
                'address1' => $loc->address1 . ($loc->address2 ? ' ' . $loc->address2 : ''),
                'address2' => $loc->address2,
                'city' => $loc->city,
                'state' => $loc->state,
                'zip' => $loc->zip,
                'phone' => $loc->phone ?: '(800)-985-4339',
                'hours' => $loc->hours ?: 'Monday - Friday 8:00 AM - 5:00 PM',
                'distance_miles' => $loc->distance_miles ?? null,
                'distance_label' => $loc->distance_label ?? null,
                'profile_url' => route('locations.show', $loc->id),
                'checkout_url' => route('checkout.index', ['location_id' => $loc->id, 'zip' => $loc->zip]),
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
     * Programmatic SEO Chain Handler (e.g. /drug-testing-orlando-fl, /certified-drug-test-centers-tampa-fl)
     */
    public function resolveChainCity(string $slug)
    {
        $clean = preg_replace('/^(certified-drug-test-centers-|local-drug-testing-locations-|drug-testing-locations-|drug-testing-)/', '', $slug);

        if (preg_match('/^(.*?)-([a-z]{2})$/i', $clean, $matches)) {
            $citySlug = $matches[1];
            $stateAbbr = strtoupper($matches[2]);

            $state = State::where('abbr', $stateAbbr)->where('is_active', true)->first();
            if ($state) {
                return redirect()->to("/locations/{$state->slug}/{$citySlug}", 301);
            }
        }

        abort(404);
    }

    /**
     * Retrieve active popular tests excluding add-ons like Body Hair
     */
    protected function getPopularTests(int $limit = 6)
    {
        return Product::where('is_popular', true)
            ->where('is_active', true)
            ->where('slug', '!=', 'body-hair-collection')
            ->where('name', 'NOT LIKE', '%Body Hair%')
            ->orderByRaw("CASE WHEN slug = '5-panel-hair-follicle' THEN 0 ELSE 1 END")
            ->limit($limit)
            ->get();
    }
}
