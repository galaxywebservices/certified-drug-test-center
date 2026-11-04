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
        if (Schema::hasTable('pagebuilder__page_translations')) {
            try {
                DB::statement('ALTER TABLE `pagebuilder__page_translations` MODIFY `meta_description` TEXT NULL');
            } catch (\Throwable $e) {}

            try {
                DB::statement('ALTER TABLE `pagebuilder__page_translations` MODIFY `meta_title` VARCHAR(500) NULL');
            } catch (\Throwable $e) {}

            try {
                DB::statement('ALTER TABLE `pagebuilder__page_translations` MODIFY `title` VARCHAR(500) NOT NULL');
            } catch (\Throwable $e) {}
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pagebuilder__page_translations')) {
            try {
                DB::statement('ALTER TABLE `pagebuilder__page_translations` MODIFY `meta_description` VARCHAR(255) NOT NULL');
            } catch (\Throwable $e) {}

            try {
                DB::statement('ALTER TABLE `pagebuilder__page_translations` MODIFY `meta_title` VARCHAR(255) NOT NULL');
            } catch (\Throwable $e) {}

            try {
                DB::statement('ALTER TABLE `pagebuilder__page_translations` MODIFY `title` VARCHAR(255) NOT NULL');
            } catch (\Throwable $e) {}
        }
    }
};
