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
        $zipPath = database_path('seeders/data/us_zipcodes.json');
        if (!file_exists($zipPath)) {
            return;
        }

        $zipMap = json_decode(file_get_contents($zipPath), true);
        if (empty($zipMap)) {
            return;
        }

        $missing = DB::table('locations')
            ->where(function ($q) {
                $q->whereNull('lat')->orWhere('lat', 0);
            })
            ->get(['id', 'zip']);

        foreach ($missing as $loc) {
            $clean = substr(preg_replace('/[^0-9]/', '', $loc->zip), 0, 5);
            if (isset($zipMap[$clean])) {
                DB::table('locations')->where('id', $loc->id)->update([
                    'lat' => $zipMap[$clean][0],
                    'lng' => $zipMap[$clean][1],
                ]);
            }
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

