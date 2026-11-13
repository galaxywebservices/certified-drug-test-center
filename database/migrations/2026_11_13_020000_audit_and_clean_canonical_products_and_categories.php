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
        if (!Schema::hasColumn('products', 'is_canonical')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('is_canonical')->default(true)->after('is_active');
            });
        }

        if (!Schema::hasColumn('categories', 'is_canonical')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->boolean('is_canonical')->default(true)->after('is_active');
            });
        }

        // Deactivate duplicate / placeholder categories
        // Category 20 (labblood-testing) is a duplicate of Category 8 (lab-blood)
        // Category 21 (dot-consortium) has 0 products; Category 13 holds consortium products
        DB::table('categories')
            ->whereIn('id', [20, 21])
            ->update([
                'is_active' => false,
                'is_canonical' => false,
            ]);

        // Clean up duplicate, draft, and placeholder products
        // ID 53: 'respirator-fit' (duplicate of ID 54 'respirator-fit-test')
        // ID 93: 'name-of-test-herpes-hsv-types-1-2-blood' (draft placeholder)
        // ID 94: 'name-of-test-hiv-agab-with-reflex' (draft placeholder)
        // IDs 4, 51, 86, 122: previously deactivated duplicates/test products
        DB::table('products')
            ->whereIn('id', [4, 51, 53, 86, 93, 94, 122])
            ->update([
                'is_active' => false,
                'is_canonical' => false,
            ]);

        // Clean up confusing background check product slugs to avoid keyword cannibalization
        // ID 49: 'Entry Level Background Check'
        DB::table('products')
            ->where('id', 49)
            ->update(['slug' => 'entry-level-background-check']);

        // ID 50: 'Premium Level Background Check'
        DB::table('products')
            ->where('id', 50)
            ->update(['slug' => 'premium-level-background-check']);

        // ID 65: 'Basic Level Background Check + 5 Panel Drug Test'
        DB::table('products')
            ->where('id', 65)
            ->update(['slug' => 'background-check-basic-drug-test']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'is_canonical')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('is_canonical');
            });
        }

        if (!Schema::hasColumn('categories', 'is_canonical')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('is_canonical');
            });
        }
    }
};

