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
