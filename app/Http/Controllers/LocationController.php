<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\City;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
            ->limit(5)
            ->get();

        if ($locations->isEmpty()) {
            // Fallback to state or first matching
            $locations = Location::limit(3)->get();
        }

        return response()->json([
            'success' => true,
            'count' => $locations->count(),
            'locations' => $locations,
        ]);
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
