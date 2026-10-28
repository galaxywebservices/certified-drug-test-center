<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StateCitySeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/states.json');
        if (!File::exists($file)) {
            return;
        }

        $states = json_decode(File::get($file), true);
        foreach ($states as $st) {
            State::updateOrCreate(['abbr' => $st['abbr']], $st);
        }

        // Seed 1,000 city unique chain pages
        $citiesFile = database_path('seeders/data/chains_unique_cities.json');
        if (File::exists($citiesFile)) {
            $cities = json_decode(File::get($citiesFile), true);
            $statesMap = State::all()->keyBy('abbr');

            foreach ($cities as $c) {
                $abbr = $c['state_abbr'] ?? null;
                if (!$abbr || !isset($statesMap[$abbr])) {
                    continue;
                }
                $state = $statesMap[$abbr];

                City::updateOrCreate(
                    [
                        'state_id' => $state->id,
                        'slug' => $c['slug'],
                    ],
                    [
                        'name' => $c['city_name'],
                        'is_active' => true,
                        'meta_title' => "{$c['city_name']}, {$abbr} Drug Testing Centers | Walk-ins Welcome",
                        'meta_description' => "Find certified drug testing collection centers in {$c['city_name']}, {$abbr}. Same-day walk-in testing at Quest & Labcorp certified sites.",
                        'content' => $c['content'],
                    ]
                );
            }
        }
    }
}
