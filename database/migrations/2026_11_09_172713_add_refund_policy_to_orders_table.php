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
            $table->boolean('refund_policy_agreed')->default(false)->after('status');
            $table->timestamp('refund_policy_agreed_at')->nullable()->after('refund_policy_agreed');
            $table->string('donor_ip', 45)->nullable()->after('refund_policy_agreed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['refund_policy_agreed', 'refund_policy_agreed_at', 'donor_ip']);
        });
    }
};
