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
       Schema::create('messages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
    $table->foreignId('sender_id')->constrained('users');
    $table->text('content')->nullable();
    $table->enum('type', ['text', 'image', 'offer', 'system'])->default('text');
    $table->json('metadata_json')->nullable();
    $table->timestamp('read_at')->nullable();
    $table->timestamp('created_at')->useCurrent();

    $table->index(['conversation_id', 'created_at'], 'idx_conv_created');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
