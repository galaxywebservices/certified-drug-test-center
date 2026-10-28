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
    }
}
