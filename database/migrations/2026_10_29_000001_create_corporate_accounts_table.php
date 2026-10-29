<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corporate_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('account_code')->unique();
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone');
            $table->string('industry')->nullable();
            $table->string('billing_type')->default('net30');
            $table->decimal('credit_limit', 10, 2)->default(15000.00);
            $table->decimal('active_balance', 10, 2)->default(0.00);
            $table->boolean('is_dot_regulated')->default(false);
            $table->string('dot_agency')->nullable();
            $table->string('access_pin')->default('123456');
            $table->string('access_token', 64)->unique();
            $table->string('status')->default('active');
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('corporate_account_id')->nullable()->after('location_id')->constrained('corporate_accounts')->nullOnDelete();
            $table->string('candidate_department')->nullable()->after('notes');
            $table->string('candidate_job_title')->nullable()->after('candidate_department');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['corporate_account_id']);
            $table->dropColumn(['corporate_account_id', 'candidate_department', 'candidate_job_title']);
        });

        Schema::dropIfExists('corporate_accounts');
    }
};
