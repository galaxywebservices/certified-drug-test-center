<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('navigation_items')) {
            Schema::create('navigation_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('parent_id')
                    ->nullable()
                    ->constrained('navigation_items')
                    ->cascadeOnDelete();
                $table->string('title', 255);
                $table->string('url', 500)->nullable();
                $table->string('target', 20)->default('_self');
                $table->integer('order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->foreignId('page_id')
                    ->nullable()
                    ->constrained('pages')
                    ->nullOnDelete();
                $table->string('css_class', 100)->nullable();
                $table->string('badge', 50)->nullable();
                $table->boolean('is_cta')->default(false);
                $table->timestamps();
            });
        }

        Schema::table('pages', function (Blueprint $table) {
            if (!Schema::hasColumn('pages', 'menu_parent_id')) {
                $table->foreignId('menu_parent_id')
                    ->nullable()
                    ->after('show_in_menu')
                    ->constrained('navigation_items')
                    ->nullOnDelete();
            }
        });

        // Ensure duplicate product slugs are flagged as non-canonical
        \Illuminate\Support\Facades\DB::table('products')
            ->where('slug', '5-panel-oral-fluid-2')
            ->update(['is_canonical' => false]);

        // Automatically seed default navigation items including client-created pages
        if (class_exists(\App\Models\NavigationItem::class)) {
            \App\Models\NavigationItem::seedDefaultNavigation();
        }
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'menu_parent_id')) {
                $table->dropForeign(['menu_parent_id']);
                $table->dropColumn('menu_parent_id');
            }
        });

        Schema::dropIfExists('navigation_items');
    }
};
