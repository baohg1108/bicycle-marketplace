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
      
Schema::create('disputes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->unique()->constrained('orders');
    $table->foreignId('initiator_id')->constrained('users');
    $table->enum('reason', ['item_not_as_described', 'item_not_received', 'payment_issue', 'other']);
    $table->text('description')->nullable();
    $table->json('evidence_json')->nullable();
    $table->enum('status', ['open', 'under_review', 'resolved', 'closed'])->default('open');
    $table->foreignId('assigned_inspector')->nullable()->constrained('users');
    $table->enum('resolution', ['refund_buyer', 'release_seller', 'split', 'other'])->nullable();
    $table->text('resolution_note')->nullable();
    $table->timestamp('resolved_at')->nullable();
    $table->timestamp('created_at')->useCurrent();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
