<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->index(['state_id', 'is_active', 'slug'], 'idx_cities_state_active_slug');
            $table->index(['lat', 'lng'], 'idx_cities_coordinates');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->index(['is_active', 'state'], 'idx_locations_active_state');
            $table->index(['lat', 'lng'], 'idx_locations_coordinates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropIndex('idx_cities_state_active_slug');
            $table->dropIndex('idx_cities_coordinates');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropIndex('idx_locations_active_state');
            $table->dropIndex('idx_locations_coordinates');
        });
    }
};
