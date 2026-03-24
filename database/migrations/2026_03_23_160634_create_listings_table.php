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
        Schema::create('listings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('seller_id')->constrained('users');
    $table->unsignedInteger('category_id');
    $table->unsignedInteger('brand_id')->nullable();
    $table->unsignedInteger('model_id')->nullable();
    
    $table->string('title');
    $table->text('description')->nullable();
    $table->decimal('price', 12, 2);
    $table->boolean('negotiable')->default(true);
    
    $table->enum('condition', ['new','like_new','good','fair','poor']);
    $table->enum('status', ['draft','pending_review','active','sold','hidden','rejected','expired'])->default('pending_review');

    $table->string('frame_size', 30)->nullable();
    $table->string('wheel_size', 20)->nullable();
    $table->enum('frame_material', ['aluminum','carbon','steel','titanium','other'])->nullable();
    $table->string('color', 80)->nullable();
    $table->year('manufacture_year')->nullable();
    $table->unsignedInteger('mileage_km')->nullable();

    $table->string('city', 100)->nullable();
    $table->string('district', 100)->nullable();
    $table->decimal('lat', 10, 8)->nullable();
    $table->decimal('lng', 11, 8)->nullable();

    $table->unsignedInteger('view_count')->default(0);
    $table->boolean('is_featured')->default(false);
    $table->boolean('is_inspected')->default(false);
    $table->timestamp('expires_at')->nullable();
    $table->timestamp('published_at')->nullable();
    
    $table->timestamps();

    // $table->index(['status', 'city']);
    // $table->index('price');
    
    $table->foreign('category_id')->references('id')->on('bike_categories');
    $table->foreign('brand_id')->references('id')->on('bike_brands');
    $table->foreign('model_id')->references('id')->on('bike_models');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
