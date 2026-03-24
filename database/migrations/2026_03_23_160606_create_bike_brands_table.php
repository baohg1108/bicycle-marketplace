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
        Schema::create('bike_brands', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name', 100)->unique();
    $table->string('slug', 120)->unique();
    $table->string('country_origin', 80)->nullable();
    $table->string('logo_url', 500)->nullable();
    $table->string('website_url', 500)->nullable();
    $table->text('description')->nullable();
    $table->boolean('is_active')->default(true);
    $table->unsignedTinyInteger('sort_order')->default(0);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bike_brands');
    }
};
