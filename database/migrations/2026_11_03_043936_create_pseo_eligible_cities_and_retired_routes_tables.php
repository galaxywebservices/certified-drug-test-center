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
        Schema::create('pseo_eligible_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->unique()->constrained('cities')->onDelete('cascade');
            $table->foreignId('state_id')->constrained('states')->onDelete('cascade');
            $table->unsignedInteger('active_centers_count')->default(0);
            $table->decimal('nearest_distance', 6, 2)->nullable();
            $table->boolean('is_eligible')->default(true)->index();
            $table->timestamps();

            $table->index(['state_id', 'is_eligible']);
        });

        Schema::create('retired_routes', function (Blueprint $table) {
            $table->id();
            $table->string('legacy_url', 500)->unique();
            $table->enum('action', ['410', '301'])->default('410');
            $table->string('target_url', 500)->nullable();
            $table->timestamps();

            $table->index('legacy_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retired_routes');
        Schema::dropIfExists('pseo_eligible_cities');
    }
};
