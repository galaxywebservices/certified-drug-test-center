<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $slugMap = [
            'Fingernail-drug-Testing' => 'fingernail-drug-testing',
            'Respirator-Fit-Testing' => 'respirator-fit-testing',
            'Lift-Test' => 'lift-test',
            'Tb-Testing' => 'tb-testing',
        ];

        if (Schema::hasTable('pages')) {
            foreach ($slugMap as $oldSlug => $newSlug) {
                DB::table('pages')
                    ->where('slug', $oldSlug)
                    ->update(['slug' => $newSlug]);
            }
        }

        if (Schema::hasTable('navigation_items')) {
            foreach ($slugMap as $oldSlug => $newSlug) {
                DB::table('navigation_items')
                    ->where('url', '/' . $oldSlug)
                    ->update(['url' => '/' . $newSlug]);
            }
        }
    }

    public function down(): void
    {
        $slugMap = [
            'fingernail-drug-testing' => 'Fingernail-drug-Testing',
            'respirator-fit-testing' => 'Respirator-Fit-Testing',
            'lift-test' => 'Lift-Test',
            'tb-testing' => 'Tb-Testing',
        ];

        if (Schema::hasTable('pages')) {
            foreach ($slugMap as $newSlug => $oldSlug) {
                DB::table('pages')
                    ->where('slug', $newSlug)
                    ->update(['slug' => $oldSlug]);
            }
        }

        if (Schema::hasTable('navigation_items')) {
            foreach ($slugMap as $newSlug => $oldSlug) {
                DB::table('navigation_items')
                    ->where('url', '/' . $newSlug)
                    ->update(['url' => '/' . $oldSlug]);
            }
        }
    }
};
