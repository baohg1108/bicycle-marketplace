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
        Schema::create('payment_gateway_logs', function (Blueprint $table) {
    $table->id();
    
    $table->foreignId('transaction_id')
          ->constrained('transactions')
          ->onDelete('cascade');
          
    $table->unsignedInteger('gateway_id');
    
    $table->string('gateway_ref', 200)->nullable();
    
    $table->json('request_json')->nullable();
    $table->json('response_json')->nullable();
    
    $table->enum('status', ['initiated', 'success', 'failed', 'pending'])->default('initiated');
    
    $table->timestamp('created_at')->useCurrent();

    $table->foreign('gateway_id')
          ->references('id')
          ->on('payment_gateways')
          ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways_logs');
    }
};
