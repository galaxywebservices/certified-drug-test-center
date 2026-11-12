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
        DB::table('settings')->where('key', 'site_tagline')->where('value', 'LIKE', '%Accredited Drug Testing%')->update([
            'value' => 'Certified Drug Testing Made Fast, Simple & Confidential'
        ]);

        DB::table('categories')->where('meta_description', 'LIKE', '%accredited%')->update([
            'meta_description' => DB::raw("REPLACE(meta_description, 'accredited facilities', 'certified collection facilities')")
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed
    }
};
