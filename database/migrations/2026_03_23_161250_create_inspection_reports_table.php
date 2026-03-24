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
Schema::create('inspection_reports', function (Blueprint $table) {
    $table->id();
    $table->foreignId('request_id')->unique()->constrained('inspection_requests');
    $table->foreignId('inspector_id')->constrained('users');
    
    $table->enum('overall_condition', ['excellent', 'good', 'fair', 'poor']);
    $table->enum('frame_condition', ['excellent', 'good', 'fair', 'poor'])->nullable();
    $table->enum('brake_condition', ['excellent', 'good', 'fair', 'poor'])->nullable();
    $table->enum('drivetrain_condition', ['excellent', 'good', 'fair', 'poor'])->nullable();
    $table->enum('wheelset_condition', ['excellent', 'good', 'fair', 'poor'])->nullable();
    $table->enum('electrical_condition', ['excellent', 'good', 'fair', 'poor', 'na'])->default('na');
    
    $table->text('summary')->nullable();
    $table->enum('recommendation', ['approve', 'approve_with_notes', 'reject']);
    $table->string('report_url', 1000)->nullable();
    $table->timestamp('created_at')->useCurrent();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_reports');
    }
};
