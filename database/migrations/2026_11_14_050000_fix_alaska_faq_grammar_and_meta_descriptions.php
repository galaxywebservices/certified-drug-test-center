<?php

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
        // 1. Fix FAQ Grammar in States table
        $states = DB::table('states')->get();
        foreach ($states as $state) {
            $faqs = json_decode($state->faqs_json, true);
            $dirty = false;

            if (is_array($faqs)) {
                foreach ($faqs as &$faq) {
                    if (isset($faq['answer'])) {
                        if (str_contains($faq['answer'], 'a employer rights under')) {
                            $faq['answer'] = str_replace('a employer rights under', 'employer rights under', $faq['answer']);
                            $dirty = true;
                        }
                        if (str_contains($faq['answer'], 'statutes allows')) {
                            $faq['answer'] = str_replace('statutes allows', 'statutes allow', $faq['answer']);
                            $dirty = true;
                        }
                    }
                }
                unset($faq);
            }

            $updateData = [];
            if ($dirty) {
                $updateData['faqs_json'] = json_encode($faqs);
            }

            // Update meta_description to concise ~150 char format
            $updateData['meta_description'] = "Certified Drug Test Centers in {$state->name} ({$state->abbr}). Order online or call (800) 985-4339 for an instant donor pass at local Quest & Labcorp walk-in clinics.";

            DB::table('states')->where('id', $state->id)->update($updateData);
        }

        // 2. Trim meta_description across all cities in cities table
        $cities = DB::table('cities')
            ->join('states', 'cities.state_id', '=', 'states.id')
            ->select('cities.id', 'cities.name', 'states.abbr as state_abbr')
            ->get();

        foreach ($cities as $city) {
            DB::table('cities')->where('id', $city->id)->update([
                'meta_description' => "Certified Drug Test Centers in {$city->name}, {$city->state_abbr}. Order online or call (800) 985-4339 for an instant donor pass at local Quest & Labcorp walk-in clinics.",
            ]);
        }

        // 3. Add Alaska Cities (Fairbanks, Wasilla, Juneau) to cities and pseo_eligible_cities
        $alaska = DB::table('states')->where('slug', 'alaska')->first();
        if ($alaska) {
            $alaskaCities = [
                [
                    'name' => 'Fairbanks',
                    'slug' => 'fairbanks',
                    'lat' => 64.820400,
                    'lng' => -147.742947,
                    'active_centers_count' => 4,
                ],
                [
                    'name' => 'Wasilla',
                    'slug' => 'wasilla',
                    'lat' => 61.576810,
                    'lng' => -149.408473,
                    'active_centers_count' => 2,
                ],
                [
                    'name' => 'Juneau',
                    'slug' => 'juneau',
                    'lat' => 58.362800,
                    'lng' => -134.529400,
                    'active_centers_count' => 1,
                ],
            ];

            foreach ($alaskaCities as $cData) {
                $city = DB::table('cities')
                    ->where('state_id', $alaska->id)
                    ->where('slug', $cData['slug'])
                    ->first();

                $cityId = $city ? $city->id : null;

                if (!$cityId) {
                    $cityId = DB::table('cities')->insertGetId([
                        'state_id' => $alaska->id,
                        'name' => $cData['name'],
                        'slug' => $cData['slug'],
                        'lat' => $cData['lat'],
                        'lng' => $cData['lng'],
                        'is_active' => true,
                        'meta_title' => "{$cData['name']}, {$alaska->abbr} Drug Testing Centers - (800) 985-4339",
                        'meta_description' => "Certified Drug Test Centers in {$cData['name']}, {$alaska->abbr}. Order online or call (800) 985-4339 for an instant donor pass at local Quest & Labcorp walk-in clinics.",
                        'content' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    DB::table('cities')->where('id', $cityId)->update([
                        'meta_title' => "{$cData['name']}, {$alaska->abbr} Drug Testing Centers - (800) 985-4339",
                        'meta_description' => "Certified Drug Test Centers in {$cData['name']}, {$alaska->abbr}. Order online or call (800) 985-4339 for an instant donor pass at local Quest & Labcorp walk-in clinics.",
                        'is_active' => true,
                        'updated_at' => now(),
                    ]);
                }

                // Add or update pseo_eligible_cities
                DB::table('pseo_eligible_cities')->updateOrInsert(
                    ['city_id' => $cityId],
                    [
                        'state_id' => $alaska->id,
                        'active_centers_count' => $cData['active_centers_count'],
                        'nearest_distance' => 0.50,
                        'is_eligible' => 1,
                        'updated_at' => now(),
                        'created_at' => now(),
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
        // Safe reversible migration
    }
};

