<?php

namespace App\Services;

use App\Models\City;
use App\Models\Location;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GeoLocationService
{
    public const EARTH_RADIUS_MILES = 3959;
    public const DEFAULT_RADIUS_MILES = 35.0;

    /**
     * Calculate Haversine distance in miles between two coordinates in PHP.
     */
    public static function distanceMiles(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $latFrom = deg2rad($lat1);
        $lngFrom = deg2rad($lng1);
        $latTo = deg2rad($lat2);
        $lngTo = deg2rad($lng2);

        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lngDelta / 2), 2)));

        return $angle * self::EARTH_RADIUS_MILES;
    }

    /**
     * Retrieve active collection centers within max miles of a city using the Haversine formula.
     * Guaranteed to obey the 35-mile doorway prevention guardrail.
     *
     * @return Collection<int, Location>
     */
    public function getNearestLocationsForCity(City $city, float $maxMiles = self::DEFAULT_RADIUS_MILES, int $limit = 10): Collection
    {
        $hasCoords = !empty($city->lat) && !empty($city->lng);

        if ($hasCoords) {
            $lat = (float) $city->lat;
            $lng = (float) $city->lng;

            $latDelta = ($maxMiles / 69.0) + 0.05;
            $cosLat = cos(deg2rad($lat));
            $lngDelta = ($maxMiles / (69.0 * max(0.15, abs($cosLat)))) + 0.05;

            // MySQL Haversine query on indexed coordinates bounded by bounding box
            $rawLocations = Location::select([
                'locations.*',
                DB::raw("(3959 * acos(
                    least(1.0, greatest(-1.0, 
                        cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + 
                        sin(radians(?)) * sin(radians(lat))
                    ))
                )) AS distance")
            ])
            ->setBindings([$lat, $lng, $lat], 'select')
            ->where('is_active', true)
            ->whereBetween('lat', [$lat - $latDelta, $lat + $latDelta])
            ->whereBetween('lng', [$lng - $lngDelta, $lng + $lngDelta])
            ->having('distance', '<=', $maxMiles)
            ->orderBy('distance', 'asc')
            ->limit($limit)
            ->get();

            // Attach formatted distance
            foreach ($rawLocations as $loc) {
                $dist = (float) $loc->distance;
                $loc->distance_miles = round($dist, 1);
                $loc->distance_label = $dist < 0.2 ? 'In-City Location (< 0.2 mi)' : number_format($dist, 1) . ' miles away';
            }

            if ($rawLocations->isNotEmpty()) {
                return $rawLocations;
            }
        }

        // Fallback for direct city name match in same state if coordinates are missing or no coords found
        $stateAbbr = $city->state ? $city->state->abbr : null;
        if ($stateAbbr) {
            $directLocations = Location::where('is_active', true)
                ->where('state', $stateAbbr)
                ->where(function ($q) use ($city) {
                    $q->where('city', $city->name)
                      ->orWhere('city', 'LIKE', $city->name);
                })
                ->limit($limit)
                ->get();

            if ($directLocations->isNotEmpty()) {
                foreach ($directLocations as $loc) {
                    $loc->distance_miles = 0.5;
                    $loc->distance_label = 'Downtown Collection Site';
                }
                return $directLocations;
            }
        }

        return collect();
    }

    /**
     * Count active collection centers within max miles of a city.
     */
    public function countActiveCenters(City $city, float $maxMiles = self::DEFAULT_RADIUS_MILES): int
    {
        $hasCoords = !empty($city->lat) && !empty($city->lng);

        if ($hasCoords) {
            $lat = (float) $city->lat;
            $lng = (float) $city->lng;

            $count = DB::table('locations')
                ->where('is_active', true)
                ->whereNotNull('lat')
                ->whereNotNull('lng')
                ->whereRaw('(3959 * acos(
                    least(1.0, greatest(-1.0, 
                        cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + 
                        sin(radians(?)) * sin(radians(lat))
                    ))
                )) <= ?', [$lat, $lng, $lat, $maxMiles])
                ->count();

            if ($count > 0) {
                return $count;
            }
        }

        // Direct city match fallback
        $stateAbbr = $city->state ? $city->state->abbr : null;
        if ($stateAbbr) {
            return Location::where('is_active', true)
                ->where('state', $stateAbbr)
                ->where(function ($q) use ($city) {
                    $q->where('city', $city->name)
                      ->orWhere('city', 'LIKE', $city->name);
                })
                ->count();
        }

        return 0;
    }

    /**
     * Check if a city is eligible for programmatic page generation (>= 1 active center within 35 miles).
     */
    public function isCityEligible(City $city, float $maxMiles = self::DEFAULT_RADIUS_MILES): bool
    {
        return $this->countActiveCenters($city, $maxMiles) >= 1;
    }

    /**
     * Get coordinates [lat, lng] for any US 5-digit zip code.
     */
    public static function getCoordinatesForZip(string $zip): ?array
    {
        $cleanZip = substr(preg_replace('/[^0-9]/', '', $zip), 0, 5);
        if (strlen($cleanZip) < 5) {
            return null;
        }

        // 1. Check if we have an active location in database with these coordinates
        $loc = Location::where('zip', $cleanZip)
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->where('lat', '!=', 0)
            ->first();
        if ($loc) {
            return [(float) $loc->lat, (float) $loc->lng];
        }

        // 2. Look up in compact nationwide 40k US zip codes dataset
        $zipData = cache()->rememberForever('cdtc_us_zipcodes_coords', function () {
            $path = database_path('seeders/data/us_zipcodes.json');
            if (file_exists($path)) {
                return json_decode(file_get_contents($path), true) ?: [];
            }
            return [];
        });

        if (isset($zipData[$cleanZip])) {
            return [(float) $zipData[$cleanZip][0], (float) $zipData[$cleanZip][1]];
        }

        return null;
    }

    /**
     * Find nearest collection centers to a US ZIP code using true geographic Haversine distance.
     * Prioritizes exact 5-digit ZIP matches first, then sorts surrounding centers by radial miles.
     *
     * @return Collection<int, Location>
     */
    public function findNearestLocationsByZip(string $zip, int $limit = 6, float $maxMiles = 60.0): Collection
    {
        $cleanZip = preg_replace('/[^0-9]/', '', trim($zip));
        if (strlen($cleanZip) < 3) {
            return collect();
        }

        $results = collect();
        $coords = strlen($cleanZip) >= 5 ? self::getCoordinatesForZip($cleanZip) : null;

        // 1. If 5-digit zip entered, fetch exact zip match locations first
        if (strlen($cleanZip) >= 5) {
            $exactMatches = Location::where('zip', $cleanZip)
                ->where('is_active', true)
                ->get();

            foreach ($exactMatches as $loc) {
                $loc->distance = 0.0;
                $loc->distance_miles = 0.0;
                $loc->distance_label = 'At Your ZIP Code';
                $results->push($loc);
            }
        }

        // If we already filled limit from exact matches, return them
        if ($results->count() >= $limit) {
            return $results->slice(0, $limit);
        }

        $excludeIds = $results->pluck('id')->all();

        // 2. If coordinates known for this ZIP, compute true geographic Haversine distance
        if ($coords) {
            $lat = $coords[0];
            $lng = $coords[1];

            // Bounding box for fast indexed pruning
            $latDelta = ($maxMiles / 69.0) + 0.05;
            $cosLat = cos(deg2rad($lat));
            $lngDelta = ($maxMiles / (69.0 * max(0.15, abs($cosLat)))) + 0.05;

            $remainingLimit = $limit - $results->count();

            $geoLocations = Location::select([
                'locations.*',
                DB::raw("(3959 * acos(
                    least(1.0, greatest(-1.0, 
                        cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + 
                        sin(radians(?)) * sin(radians(lat))
                    ))
                )) AS distance")
            ])
            ->setBindings([$lat, $lng, $lat], 'select')
            ->where('is_active', true)
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->where('lat', '!=', 0)
            ->whereBetween('lat', [$lat - $latDelta, $lat + $latDelta])
            ->whereBetween('lng', [$lng - $lngDelta, $lng + $lngDelta])
            ->when(!empty($excludeIds), fn($q) => $q->whereNotIn('id', $excludeIds))
            ->having('distance', '<=', $maxMiles)
            ->orderBy('distance', 'asc')
            ->limit($remainingLimit)
            ->get();

            foreach ($geoLocations as $loc) {
                $dist = (float) $loc->distance;
                $loc->distance_miles = round($dist, 1);
                $loc->distance_label = $dist < 0.2 ? 'In-City (< 0.2 mi)' : number_format($dist, 1) . ' miles away';
                $results->push($loc);
            }

            if ($results->isNotEmpty()) {
                return $results->slice(0, $limit);
            }
        }

        // 3. Fallback if coordinates unavailable: match by zip prefix (e.g. first 3 digits)
        $prefix = substr($cleanZip, 0, 3);
        $remainingLimit = $limit - $results->count();
        $prefixLocations = Location::where('zip', 'LIKE', "{$prefix}%")
            ->where('is_active', true)
            ->when(!empty($excludeIds), fn($q) => $q->whereNotIn('id', $excludeIds))
            ->limit($remainingLimit)
            ->get();

        foreach ($prefixLocations as $loc) {
            $loc->distance_miles = null;
            $loc->distance_label = 'Nearby Collection Center';
            $results->push($loc);
        }

        if ($results->isEmpty()) {
            $fallback = Location::where('is_active', true)->limit($limit)->get();
            foreach ($fallback as $loc) {
                $loc->distance_miles = null;
                $loc->distance_label = 'Certified Collection Center';
                $results->push($loc);
            }
        }

        return $results->slice(0, $limit);
    }
}
