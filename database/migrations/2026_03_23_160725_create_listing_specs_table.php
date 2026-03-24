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
        Schema::create('listing_specs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('listing_id')->constrained('listings')->onDelete('cascade');
    
    $table->string('spec_key', 100);   
    $table->string('spec_value', 255); 
    
    $table->timestamps();
    
    // Index để tìm kiếm theo thuộc tính nhanh hơn
    $table->index(['spec_key', 'spec_value']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_specs');
    }
};
