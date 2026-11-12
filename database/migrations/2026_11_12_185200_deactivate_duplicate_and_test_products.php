<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Deactivate duplicate products (IDs 4, 51, 86) and test dummy products (ID 122)
        // 4: Duplicate of '5 Panel DOT Drug Test' (ID 3)
        // 51: Duplicate of 'Executive Level Background Check' (ID 27)
        // 86: Duplicate of '1 Year Consortium Membership & DOT Drug Test' (ID 37)
        // 122: 'Test product' dummy test entry ($1.00)
        DB::table('products')
            ->whereIn('id', [4, 51, 86, 122])
            ->orWhere('name', 'LIKE', '%Test product%')
            ->update(['is_active' => false]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('products')
            ->whereIn('id', [4, 51, 86])
            ->update(['is_active' => true]);
    }
};

