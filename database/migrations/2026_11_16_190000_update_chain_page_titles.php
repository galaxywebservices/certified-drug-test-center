<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set / update national chain meta title setting to client's exact specification
        Setting::set('chain_national_meta_title', 'Certified Drug Testing Centers Nationwide | 800-985-4339');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::set('chain_national_meta_title', 'Certified Drug Test Centers - (800) 985-4339');
    }
};

