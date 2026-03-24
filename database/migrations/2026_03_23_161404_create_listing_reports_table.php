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
Schema::create('listing_reports', function (Blueprint $table) {
    $table->id();
    $table->foreignId('listing_id')->constrained('listings');
    $table->foreignId('reporter_id')->constrained('users');
    $table->enum('reason', ['fake', 'wrong_info', 'inappropriate', 'spam', 'already_sold', 'other']);
    $table->text('description')->nullable();
    $table->enum('status', ['pending', 'reviewing', 'resolved', 'dismissed'])->default('pending');
    $table->foreignId('resolved_by')->nullable()->constrained('users');
    $table->timestamp('resolved_at')->nullable();
    $table->text('resolution_note')->nullable();
    $table->timestamp('created_at')->useCurrent();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_reports');
    }
};
