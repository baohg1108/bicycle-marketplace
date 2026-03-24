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
      
Schema::create('logistics_providers', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name', 100);
    $table->string('code', 30)->unique();
    $table->string('api_base_url', 500)->nullable();
    $table->boolean('is_active')->default(true);
    $table->json('config_json')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logictics_providers');
    }
};
