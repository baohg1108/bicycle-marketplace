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
        Schema::create('conversations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('listing_id')->constrained('listings');
    $table->foreignId('buyer_id')->constrained('users');
    $table->foreignId('seller_id')->constrained('users');
    $table->enum('status', ['active', 'archived', 'blocked'])->default('active');
    $table->timestamp('last_message_at')->nullable();
    $table->unsignedInteger('buyer_unread')->default(0);
    $table->unsignedInteger('seller_unread')->default(0);
    $table->timestamps();

    $table->unique(['listing_id', 'buyer_id', 'seller_id'], 'uq_conv');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
