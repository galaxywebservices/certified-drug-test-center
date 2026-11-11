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
        // 1. Remove body hair from popular tests (it is only an add-on, not a primary popular test)
        DB::table('products')
            ->where('slug', 'body-hair-collection')
            ->orWhere('name', 'LIKE', '%Body Hair%')
            ->update([
                'is_popular' => false,
            ]);

        // 2. Ensure 5 Panel Hair Follicle Test ($189.99) is in the top/popular tests
        DB::table('products')
            ->where('slug', '5-panel-hair-follicle')
            ->orWhere('id', 15)
            ->update([
                'name' => '5 Panel Hair Follicle Test',
                'price' => 189.99,
                'is_popular' => true,
                'is_active' => true,
            ]);

        // 3. Update homepage estimator & badge settings if old values were stored
        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            DB::table('settings')->where('key', 'homepage_estimator_title')->update(['value' => 'Express Online Order']);
            DB::table('settings')->where('key', 'homepage_hero_badge')->where('value', 'LIKE', '%Express Online Drug%')->update(['value' => 'Nationwide - All States - All CITIES']);
            DB::table('settings')->where('key', 'homepage_estimator_button')->where('value', 'LIKE', '%Register & Obtain%')->update(['value' => 'Schedule Online Now']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('products')
            ->where('slug', 'body-hair-collection')
            ->update([
                'is_popular' => true,
            ]);
    }
};

