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
        Schema::create('shipments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained('orders');
    $table->unsignedInteger('provider_id');
    $table->string('tracking_number', 100)->nullable();
    $table->enum('status', ['pending', 'picked_up', 'in_transit', 'delivered', 'failed', 'returned'])->default('pending');
    $table->decimal('shipping_fee', 10, 2)->nullable();
    $table->foreignId('sender_address_id')->nullable()->constrained('user_addresses');
    $table->foreignId('receiver_address_id')->nullable()->constrained('user_addresses');
    $table->date('estimated_delivery')->nullable();
    $table->timestamp('delivered_at')->nullable();
    $table->json('provider_response')->nullable();
    $table->timestamp('created_at')->useCurrent();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
