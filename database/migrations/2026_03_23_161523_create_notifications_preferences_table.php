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
      
Schema::create('notification_preferences', function (Blueprint $table) {
    $table->foreignId('user_id')->primary()->constrained('users')->onDelete('cascade');
    $table->boolean('email_messages')->default(true);
    $table->boolean('email_orders')->default(true);
    $table->boolean('push_messages')->default(true);
    $table->boolean('push_orders')->default(true);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications_preferences');
    }
};
