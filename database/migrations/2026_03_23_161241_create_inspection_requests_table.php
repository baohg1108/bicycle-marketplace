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
Schema::create('inspection_requests', function (Blueprint $table) {
    $table->id();
    $table->foreignId('listing_id')->constrained('listings');
    $table->foreignId('order_id')->nullable()->constrained('orders');
    $table->foreignId('requester_id')->constrained('users');
    $table->foreignId('inspector_id')->nullable()->constrained('users');
    
    $table->enum('type', ['pre_listing', 'pre_purchase', 'dispute'])->default('pre_listing');
    $table->enum('status', ['pending', 'assigned', 'scheduled', 'in_progress', 'completed', 'cancelled'])->default('pending');
    
    $table->decimal('inspection_fee', 10, 2)->nullable();
    $table->timestamp('scheduled_at')->nullable();
    $table->text('location')->nullable();
    $table->text('notes')->nullable();
    $table->timestamp('created_at')->useCurrent();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_requests');
    }
};
