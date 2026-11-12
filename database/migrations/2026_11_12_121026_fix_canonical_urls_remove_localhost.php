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
        $baseUrl = rtrim(config('app.url') ?: 'https://certifieddrugtestingcenters.com', '/');

        // Fix categories
        $categories = DB::table('categories')
            ->where('canonical_url', 'LIKE', '%localhost%')
            ->orWhere('canonical_url', 'LIKE', '%127.0.0.1%')
            ->get();

        foreach ($categories as $cat) {
            $newCanonical = $baseUrl . '/category/' . $cat->slug;
            DB::table('categories')->where('id', $cat->id)->update(['canonical_url' => $newCanonical]);
        }

        // Fix products
        $products = DB::table('products')
            ->where('canonical_url', 'LIKE', '%localhost%')
            ->orWhere('canonical_url', 'LIKE', '%127.0.0.1%')
            ->get();

        foreach ($products as $prod) {
            $newCanonical = $baseUrl . '/product/' . $prod->slug;
            DB::table('products')->where('id', $prod->id)->update(['canonical_url' => $newCanonical]);
        }

        // Fix CMS pages
        if (Schema::hasTable('pages')) {
            $pages = DB::table('pages')
                ->where('canonical_url', 'LIKE', '%localhost%')
                ->orWhere('canonical_url', 'LIKE', '%127.0.0.1%')
                ->get();

            foreach ($pages as $p) {
                $slug = ltrim($p->slug, '/');
                $newCanonical = $baseUrl . '/' . $slug;
                DB::table('pages')->where('id', $p->id)->update(['canonical_url' => $newCanonical]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed for canonical URL domain fixes
    }
};
