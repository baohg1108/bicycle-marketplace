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
        Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('listing_id')->constrained('listings');
    $table->foreignId('buyer_id')->constrained('users');
    $table->foreignId('seller_id')->constrained('users');
    $table->decimal('amount', 12, 2);
    $table->decimal('deposit_amount', 12, 2)->default(0);
    $table->enum('status', ['pending', 'deposit_paid', 'confirmed', 'inspecting', 'completed', 'cancelled', 'disputed', 'refunded'])->default('pending');
    $table->boolean('inspection_required')->default(false);
    $table->text('notes')->nullable();
    $table->text('cancelled_reason')->nullable();
    $table->foreignId('cancelled_by')->nullable()->constrained('users');
    $table->timestamp('completed_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
