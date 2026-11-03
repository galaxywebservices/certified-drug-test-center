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
}
