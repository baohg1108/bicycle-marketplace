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
       Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained('orders');
    $table->foreignId('user_id')->constrained('users');
    $table->enum('type', ['deposit', 'full_payment', 'refund', 'service_fee', 'inspection_fee']);
    $table->decimal('amount', 12, 2);
    $table->decimal('fee', 10, 2)->default(0);
    $table->decimal('net_amount', 12, 2);
    $table->enum('payment_method', ['cash', 'bank_transfer', 'momo', 'zalopay', 'vnpay', 'other'])->nullable();
    $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
    $table->string('reference_code', 100)->nullable();
    $table->json('gateway_response')->nullable();
    $table->timestamp('created_at')->useCurrent();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
