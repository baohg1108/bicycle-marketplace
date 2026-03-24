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
        Schema::create('listing_media', function (Blueprint $table) {
    $table->id();
    $table->foreignId('listing_id')->constrained('listings')->onDelete('cascade');
    $table->string('url', 1000);
    $table->string('thumb_url', 1000)->nullable();
    $table->enum('type', ['image', 'video'])->default('image');
    $table->unsignedTinyInteger('sort_order')->default(0);
    $table->boolean('is_primary')->default(false);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_media');
    }
};
