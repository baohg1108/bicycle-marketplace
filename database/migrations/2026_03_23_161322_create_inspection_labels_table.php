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
Schema::create('inspection_labels', function (Blueprint $table) {
    $table->id();
    $table->foreignId('listing_id')->constrained('listings');
    $table->foreignId('report_id')->constrained('inspection_reports');
    $table->foreignId('inspector_id')->constrained('users');
    $table->enum('label_type', ['inspected', 'certified']);
    $table->timestamp('issued_at')->useCurrent();
    $table->timestamp('expires_at')->nullable();
    $table->boolean('is_active')->default(true);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_labels');
    }
};
