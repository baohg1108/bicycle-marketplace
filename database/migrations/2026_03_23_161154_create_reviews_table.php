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
       Schema::create('reviews', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained('orders');
    $table->foreignId('reviewer_id')->constrained('users');
    $table->foreignId('reviewee_id')->constrained('users');
    $table->foreignId('listing_id')->constrained('listings');
    
    $table->unsignedTinyInteger('rating'); 
    $table->text('comment')->nullable();
    $table->boolean('is_buyer_review');
    $table->timestamp('created_at')->useCurrent();

    $table->unique(['order_id', 'reviewer_id'], 'uq_review');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews_configs');
    }
};
