<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->string('donor_first_name', 100);
            $table->string('donor_last_name', 100);
            $table->string('donor_email', 150);
            $table->string('donor_phone', 50);
            $table->date('donor_dob')->nullable();
            $table->string('donor_ssn_last4', 4)->nullable();
            $table->string('test_reason', 100)->nullable();
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2);
            $table->string('payment_status', 50)->default('pending');
            $table->string('payment_gateway', 50)->default('paytrace');
            $table->string('paytrace_transaction_id', 100)->nullable();
            $table->string('paytrace_approval_code', 100)->nullable();
            $table->string('donor_pass_token', 64)->unique();
            $table->string('status', 50)->default('registered');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('product_name', 255);
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
