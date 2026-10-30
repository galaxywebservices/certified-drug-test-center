<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update site_phone setting in settings table
        if (Schema::hasTable('settings')) {
            DB::table('settings')
                ->where('key', 'site_phone')
                ->update(['value' => '(800)-985-4339']);
        }

        // 2. Update phone on users
        if (Schema::hasTable('users')) {
            DB::table('users')
                ->where('phone', 'like', '%221%4291%')
                ->update(['phone' => '(800)-985-4339']);
        }

        // 3. Update locations if any default phone exists
        if (Schema::hasTable('locations')) {
            DB::table('locations')
                ->where('phone', 'like', '%221%4291%')
                ->update(['phone' => '(800)-985-4339']);
        }

        // 4. Batch SQL REPLACE on content columns across cities and pages
        $tablesAndCols = [
            'cities' => ['content', 'meta_title', 'meta_description'],
            'pages' => ['title', 'page_heading', 'content', 'blocks_json', 'meta_title', 'meta_description'],
        ];

        $replacements = [
            '+1-800-221-4291' => '+1-800-985-4339',
            '+18002214291' => '+18009854339',
            'tel:18002214291' => 'tel:18009854339',
            'tel:8002214291' => 'tel:8009854339',
            '18002214291' => '18009854339',
            '8002214291' => '8009854339',
            '(800) 221-4291' => '(800)-985-4339',
            '(800)-221-4291' => '(800)-985-4339',
            '(800)221-4291' => '(800)-985-4339',
            '(800) 221- 4291' => '(800)-985-4339',
            '800 221 4291' => '(800)-985-4339',
            'tel:(800) 221 4291' => 'tel:18009854339',
            '(800) 221 4291' => '(800)-985-4339',
            '800-221-4291' => '(800)-985-4339',
            '(800)−221−4291' => '(800)-985-4339',
            '(800)–221–4291' => '(800)-985-4339',
            '(800)–221-4291' => '(800)-985-4339',
        ];

        foreach ($tablesAndCols as $table => $cols) {
            if (!Schema::hasTable($table)) {
                continue;
            }
            foreach ($cols as $col) {
                if (!Schema::hasColumn($table, $col)) {
                    continue;
                }
                foreach ($replacements as $old => $new) {
                    DB::statement("UPDATE {$table} SET {$col} = REPLACE({$col}, ?, ?) WHERE {$col} LIKE ?", [
                        $old,
                        $new,
                        '%' . $old . '%',
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('settings')) {
            DB::table('settings')
                ->where('key', 'site_phone')
                ->update(['value' => '(800) 221-4291']);
        }

        if (Schema::hasTable('users')) {
            DB::table('users')
                ->where('is_super_admin', true)
                ->where('phone', '(800)-985-4339')
                ->update(['phone' => '(800) 221-4291']);
        }
    }
};
