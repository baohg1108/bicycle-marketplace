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
       Schema::create('service_fee_configs', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name', 100);
    $table->enum('type', ['percentage', 'fixed']);
    $table->decimal('value', 8, 4); // Ví dụ: 0.0500 cho 5%
    $table->enum('applicable_to', ['all', 'featured_listing', 'inspection', 'transaction']);
    $table->decimal('min_amount', 10, 2)->nullable();
    $table->decimal('max_amount', 10, 2)->nullable();
    $table->boolean('is_active')->default(true);
    $table->date('effective_from')->nullable();
    $table->date('effective_to')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_fee_configs');
    }
};
