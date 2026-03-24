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
      
Schema::create('system_configs', function (Blueprint $table) {
    $table->string('config_key', 100)->primary();
    $table->text('value');
    $table->text('description')->nullable();
    $table->foreignId('updated_by')->nullable()->constrained('users');
    $table->timestamp('updated_at')->useCurrent();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_configs');
    }
};
