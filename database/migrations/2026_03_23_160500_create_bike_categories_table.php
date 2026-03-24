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
       Schema::create('bike_categories', function (Blueprint $table) {
    $table->increments('id'); // INT UNSIGNED
    $table->unsignedInteger('parent_id')->nullable();
    $table->string('name', 100);
    $table->string('slug', 120)->unique();
    $table->text('description')->nullable();
    $table->string('icon_url', 500)->nullable();
    $table->unsignedTinyInteger('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    
    $table->foreign('parent_id')->references('id')->on('bike_categories')->onDelete('set null');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bike_categories');
    }
};
