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
        Schema::create('price_offers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('message_id')->constrained('messages');
    $table->foreignId('conversation_id')->constrained('conversations');
    $table->decimal('amount', 12, 2);
    $table->enum('status', ['pending', 'accepted', 'rejected', 'expired', 'countered'])->default('pending');
    $table->decimal('counter_amount', 12, 2)->nullable();
    $table->timestamp('expires_at')->nullable();
    $table->timestamp('responded_at')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('price_offers');
    }
};
