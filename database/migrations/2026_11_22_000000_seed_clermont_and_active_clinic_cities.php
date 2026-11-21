<?php

use App\Models\City;
use App\Models\Location;
use App\Models\PseoEligibleCity;
use App\Models\State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Explicitly ensure Clermont, FL (ZIP 34711) is created and active
        $flState = State::where('abbr', 'FL')->first();
        if ($flState) {
            $clermont = City::firstOrCreate(
                [
                    'state_id' => $flState->id,
                    'slug' => 'clermont',
                ],
                [
                    'name' => 'Clermont',
                    'zip_code' => '34711',
                    'lat' => 28.546031,
                    'lng' => -81.727254,
                    'is_active' => true,
                    'meta_title' => 'Clermont, FL Drug Testing Centers - (800) 985-4339',
                    'meta_description' => 'Certified Drug Test Centers in Clermont, FL. Order online or call (800) 985-4339 for an instant donor pass at local Quest & Labcorp certified clinics.',
                ]
            );

            if ($clermont) {
                PseoEligibleCity::updateOrCreate(
                    ['city_id' => $clermont->id],
                    [
                        'state_id' => $flState->id,
                        'active_centers_count' => Location::where('city', 'Clermont')->where('state', 'FL')->count() ?: 5,
                        'nearest_distance' => 0.5,
                        'is_eligible' => true,
                    ]
                );
            }
        }

        // 2. Discover any other cities that have 3+ active clinic locations in the database but lack city pages
        $missingCities = Location::where('is_active', true)
            ->whereNotNull('city')
            ->whereNotNull('state')
            ->select('city', 'state', DB::raw('count(*) as clinic_count'), DB::raw('AVG(lat) as avg_lat'), DB::raw('AVG(lng) as avg_lng'), DB::raw('MIN(zip) as min_zip'))
            ->groupBy('city', 'state')
            ->having('clinic_count', '>=', 3)
            ->get();

        $statesByAbbr = State::where('is_active', true)->get()->keyBy('abbr');

        foreach ($missingCities as $item) {
            $st = $statesByAbbr->get(strtoupper($item->state));
            if (!$st) {
                continue;
            }

            $citySlug = Str::slug($item->city);
            if (empty($citySlug)) {
                continue;
            }

            $existing = City::where('state_id', $st->id)
                ->where(function ($q) use ($item, $citySlug) {
                    $q->where('slug', $citySlug)->orWhere('name', $item->city);
                })->first();

            if (!$existing) {
                $created = City::create([
                    'state_id' => $st->id,
                    'name' => $item->city,
                    'slug' => $citySlug,
                    'zip_code' => $item->min_zip ?? '00000',
                    'lat' => $item->avg_lat,
                    'lng' => $item->avg_lng,
                    'is_active' => true,
                    'meta_title' => "{$item->city}, {$st->abbr} Drug Testing Centers - (800) 985-4339",
                    'meta_description' => "Certified Drug Test Centers in {$item->city}, {$st->abbr}. Order online or call (800) 985-4339 for an instant donor pass at local Quest & Labcorp certified clinics.",
                ]);

                PseoEligibleCity::updateOrCreate(
                    ['city_id' => $created->id],
                    [
                        'state_id' => $st->id,
                        'active_centers_count' => (int) $item->clinic_count,
                        'nearest_distance' => 0.5,
                        'is_eligible' => true,
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op to prevent deleting production city records
    }
};
