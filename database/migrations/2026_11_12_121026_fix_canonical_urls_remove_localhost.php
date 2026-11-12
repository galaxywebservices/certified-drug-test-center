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
        @ini_set('memory_limit', '512M');

        $baseUrl = rtrim(config('app.url') ?: 'https://certifieddrugtestingcenters.com', '/');

        // Execute direct SQL queries without loading large blobs into PHP memory
        DB::statement(
            "UPDATE categories SET canonical_url = CONCAT(?, '/category/', slug) WHERE canonical_url LIKE '%localhost%' OR canonical_url LIKE '%127.0.0.1%'",
            [$baseUrl]
        );

        DB::statement(
            "UPDATE products SET canonical_url = CONCAT(?, '/product/', slug) WHERE canonical_url LIKE '%localhost%' OR canonical_url LIKE '%127.0.0.1%'",
            [$baseUrl]
        );

        if (Schema::hasTable('pages')) {
            DB::statement(
                "UPDATE pages SET canonical_url = CONCAT(?, '/', TRIM(LEADING '/' FROM slug)) WHERE canonical_url LIKE '%localhost%' OR canonical_url LIKE '%127.0.0.1%'",
                [$baseUrl]
            );
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
