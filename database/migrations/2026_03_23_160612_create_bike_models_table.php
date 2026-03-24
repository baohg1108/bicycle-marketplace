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
        Schema::create('bike_models', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('brand_id');
    $table->unsignedInteger('category_id');
    $table->string('name', 150);
    $table->year('year_start')->nullable();
    $table->year('year_end')->nullable();
    $table->decimal('msrp', 12, 2)->nullable(); // Giá bán lẻ gốc
    $table->text('description')->nullable();
    
    $table->foreign('brand_id')->references('id')->on('bike_brands');
    $table->foreign('category_id')->references('id')->on('bike_categories');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bike_models');
    }
};
