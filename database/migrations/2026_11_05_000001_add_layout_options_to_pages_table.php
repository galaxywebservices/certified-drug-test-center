<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (!Schema::hasColumn('pages', 'show_sidebar')) {
                $table->boolean('show_sidebar')->default(true)->after('template');
            }
            if (!Schema::hasColumn('pages', 'show_hero')) {
                $table->boolean('show_hero')->default(true)->after('show_sidebar');
            }
            if (!Schema::hasColumn('pages', 'full_width')) {
                $table->boolean('full_width')->default(false)->after('show_hero');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('pages', 'show_sidebar')) {
                $columnsToDrop[] = 'show_sidebar';
            }
            if (Schema::hasColumn('pages', 'show_hero')) {
                $columnsToDrop[] = 'show_hero';
            }
            if (Schema::hasColumn('pages', 'full_width')) {
                $columnsToDrop[] = 'full_width';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
