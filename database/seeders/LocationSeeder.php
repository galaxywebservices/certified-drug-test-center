<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LocationSeeder extends Seeder
{
    /**
     * Seed the 7,382 nationwide Quest Diagnostics and Labcorp collection facilities.
     */
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        DB::disableQueryLog();

        $sqlFile = database_path('seeders/data/locations.sql');
        if (File::exists($sqlFile)) {
            $this->command?->info("Importing collection facilities via locations.sql...");
            DB::unprepared(File::get($sqlFile));
            $count = Location::count();
            $this->command?->info("Imported {$count} locations successfully.");
            return;
        }

        $jsonFile = database_path('seeders/data/locations.json');
        if (File::exists($jsonFile)) {
            $this->command?->info("Importing collection facilities via locations.json...");
            $locations = json_decode(File::get($jsonFile), true);
            if (is_array($locations)) {
                foreach (array_chunk($locations, 250) as $chunk) {
                    Location::upsert(
                        $chunk,
                        ['id'],
                        ['name', 'provider', 'address1', 'address2', 'city', 'state', 'zip', 'phone', 'hours', 'lat', 'lng', 'is_active']
                    );
                }
                $count = Location::count();
                $this->command?->info("Imported {$count} locations successfully.");
            }
        }
    }
}
