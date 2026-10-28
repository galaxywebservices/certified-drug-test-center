<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 150)->unique();
            $table->string('name', 255);
            $table->text('subtitle')->nullable();
            $table->string('sku', 100)->nullable();
            $table->decimal('retail_price', 10, 2)->default(0.00);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->string('specimen_type', 50)->default('urine');
            $table->boolean('dot_required')->default(false);
            $table->string('turnaround_time', 100)->default('24-48 Hours');
            $table->text('short_description')->nullable();
            $table->longText('details')->nullable();
            $table->text('preparation_instructions')->nullable();
            $table->json('included_panels')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('position')->default(0);
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('canonical_url')->nullable();
            $table->json('schema_markup')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
