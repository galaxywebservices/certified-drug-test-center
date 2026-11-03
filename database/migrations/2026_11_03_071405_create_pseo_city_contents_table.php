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
        Schema::create('pseo_city_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->unique()->constrained('cities')->onDelete('cascade');
            $table->string('county')->nullable();
            $table->unsignedInteger('population')->nullable();
            $table->mediumText('gpt_5panel')->nullable();
            $table->mediumText('gpt_10panel')->nullable();
            $table->mediumText('gpt_dot')->nullable();
            $table->mediumText('gpt_hair')->nullable();
            $table->mediumText('gpt_alcohol')->nullable();
            $table->mediumText('gpt_services')->nullable();
            $table->mediumText('gpt_consortium')->nullable();
            $table->mediumText('gpt_physical')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pseo_city_contents');
    }
};
