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
        Schema::table('states', function (Blueprint $table) {
            $table->string('statute_code')->nullable()->after('content');
            $table->string('medical_marijuana_status', 50)->nullable()->after('statute_code');
            $table->string('recreational_marijuana_status', 50)->nullable()->after('medical_marijuana_status');
            $table->text('employer_rights_summary')->nullable()->after('recreational_marijuana_status');
            $table->text('worker_comp_rules')->nullable()->after('employer_rights_summary');
            $table->json('faqs_json')->nullable()->after('worker_comp_rules');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('states', function (Blueprint $table) {
            $table->dropColumn([
                'statute_code',
                'medical_marijuana_status',
                'recreational_marijuana_status',
                'employer_rights_summary',
                'worker_comp_rules',
                'faqs_json',
            ]);
        });
    }
};
