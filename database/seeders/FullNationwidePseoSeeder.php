<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class FullNationwidePseoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info("Seeding full nationwide cities and locations from ADT source database...");
        Artisan::call('cdtc:import-full-cities', [], $this->command->getOutput());
    }
}
