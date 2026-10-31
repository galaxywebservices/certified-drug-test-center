<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        \Illuminate\Support\Facades\DB::disableQueryLog();

        $this->call([
            SuperAdminSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PageSeeder::class,
            StateCitySeeder::class,
            SettingSeeder::class,
        ]);
    }
}
