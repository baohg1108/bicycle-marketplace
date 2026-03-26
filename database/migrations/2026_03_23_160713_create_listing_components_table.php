<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('listing_components', function (Blueprint $table) {
    $table->id();
    $table->foreignId('listing_id')->constrained('listings')->onDelete('cascade');
    
    // Phân loại linh kiện
    $table->enum('component_type', [
        'drivetrain', 'brakes', 'wheelset', 'handlebars', 
        'saddle', 'fork', 'pedals', 'other'
    ]);
    
    $table->string('brand', 100)->nullable();      
    $table->string('model_name', 150)->nullable(); 
    
    // Tình trạng riêng của linh kiện đó
    $table->enum('condition', ['excellent', 'good', 'fair', 'poor'])->nullable();
    
    $table->text('notes')->nullable(); 
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_components');
    }
};
