<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing category if it exists
        $updated = DB::table('categories')
            ->where('slug', 'occupational-health')
            ->orWhere('id', 9)
            ->update([
                'name' => 'Occupational Health (OCC Health)',
                'display_name' => 'Occupational Health (OCC Health)',
            ]);

        // If it doesn't exist at all on the live server, insert it
        if ($updated === 0 && !DB::table('categories')->where('slug', 'occupational-health')->exists()) {
            DB::table('categories')->insert([
                'id' => 9,
                'name' => 'Occupational Health (OCC Health)',
                'display_name' => 'Occupational Health (OCC Health)',
                'slug' => 'occupational-health',
                'position' => 12,
                'is_active' => 1,
                'meta_title' => 'Occupational Health (OCC Health) Testing | Certified Drug Test Center',
                'meta_description' => 'Order occupational health (OCC health) testing with fast online registration and walk-in testing at accredited facilities nationwide.',
                'canonical_url' => url('/category/occupational-health'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')
            ->where('slug', 'occupational-health')
            ->orWhere('id', 9)
            ->update([
                'name' => 'Occupational Health Testing',
                'display_name' => 'Occupational Health Testing',
            ]);
    }
};
