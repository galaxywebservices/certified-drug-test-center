<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('provider', 50)->default('quest');
            $table->string('address1', 255);
            $table->string('address2', 255)->nullable();
            $table->string('city', 100);
            $table->string('state', 10);
            $table->string('zip', 20);
            $table->string('phone', 50)->nullable();
            $table->string('hours', 500)->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('zip');
            $table->index('state');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
