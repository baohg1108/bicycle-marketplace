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
       // Checklist chi tiết
Schema::create('inspection_checklist_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('report_id')->constrained('inspection_reports')->onDelete('cascade');
    $table->string('component', 150);
    $table->enum('status', ['pass', 'warn', 'fail']);
    $table->text('notes')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_checklist_items');
    }
};
