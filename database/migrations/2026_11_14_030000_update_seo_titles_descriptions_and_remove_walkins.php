<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update State Meta Titles & Meta Descriptions
        $states = DB::table('states')->get();
        foreach ($states as $state) {
            $metaTitle = "{$state->name} Drug Testing Centers - (800) 985-4339";
            $metaDesc = "Certified Drug Test Centers are located in {$state->name} and in most cases within minutes of your home or office. Order a drug or alcohol test online or call (800) 985-4339 and receive an electronic donor pass via email or text immediately. Same-day testing available for employment, DOT, probation and personal purposes at more than 20,000 certified drug testing centers — including Quest Diagnostics, Labcorp and affiliated locations. Negative results are typically available within 24–48 hours.";

            DB::table('states')
                ->where('id', $state->id)
                ->update([
                    'meta_title' => $metaTitle,
                    'meta_description' => $metaDesc,
                ]);
        }

        // 2. Update City Meta Titles & Meta Descriptions (Remove Walk-ins Welcome, Add 800-985-4339)
        $cities = DB::table('cities')
            ->join('states', 'cities.state_id', '=', 'states.id')
            ->select('cities.id', 'cities.name as city_name', 'states.abbr as state_abbr')
            ->get();

        foreach ($cities as $city) {
            $metaTitle = "{$city->city_name}, {$city->state_abbr} Drug Testing Centers - (800) 985-4339";
            $metaDesc = "Certified Drug Test Centers are located in {$city->city_name}, {$city->state_abbr} and in most cases within minutes of your home or office. Order a drug or alcohol test online or call (800) 985-4339 and receive an electronic donor pass via email or text immediately. Same-day testing available for employment, DOT, probation and personal purposes at more than 20,000 certified drug testing centers — including Quest Diagnostics, Labcorp and affiliated locations. Negative results are typically available within 24–48 hours.";

            DB::table('cities')
                ->where('id', $city->id)
                ->update([
                    'meta_title' => $metaTitle,
                    'meta_description' => $metaDesc,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed
    }
};
