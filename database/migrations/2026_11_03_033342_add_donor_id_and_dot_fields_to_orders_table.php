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
            $table->string('dot_agency', 50)->nullable()->after('test_reason');
            $table->string('donor_id_type', 50)->nullable()->after('donor_ssn_last4');
            $table->string('donor_id_number', 100)->nullable()->after('donor_id_type');
            $table->string('cdl_number', 100)->nullable()->after('donor_id_number');
            $table->string('cdl_state', 10)->nullable()->after('cdl_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['dot_agency', 'donor_id_type', 'donor_id_number', 'cdl_number', 'cdl_state']);
        });
    }
};
