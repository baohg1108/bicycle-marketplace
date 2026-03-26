<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->string('label', 50)->nullable(); 
    $table->text('full_address');
    $table->string('city', 100)->nullable();
    $table->string('district', 100)->nullable();
    $table->string('ward', 100)->nullable();
    
    $table->decimal('lat', 10, 8)->nullable();
    $table->decimal('lng', 11, 8)->nullable();
    
    $table->boolean('is_default')->default(false);
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
