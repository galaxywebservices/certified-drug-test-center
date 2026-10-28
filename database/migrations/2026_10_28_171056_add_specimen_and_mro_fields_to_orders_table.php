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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('ccf_number', 50)->nullable()->after('donor_pass_token');
            $table->string('result_outcome', 30)->default('pending')->after('status');
            $table->dateTime('specimen_collected_at')->nullable()->after('result_outcome');
            $table->dateTime('mro_verified_at')->nullable()->after('specimen_collected_at');
            $table->text('mro_notes')->nullable()->after('mro_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['ccf_number', 'result_outcome', 'specimen_collected_at', 'mro_verified_at', 'mro_notes']);
        });
    }
};
