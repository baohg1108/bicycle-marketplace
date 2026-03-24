<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspector_profiles', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->primary()
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('certification')->nullable();
            
            
            $table->string('specialty')->comment('road,mtb,bmx,triathlon,electric');

            $table->string('service_area')->nullable();
            
            // DECIMAL(10,2) phù hợp cho giá tiền (lên đến 99,999,999.99)
            $table->decimal('inspection_fee', 10, 2)->default(0.00);
            
            $table->unsignedInteger('total_inspected')->default(0);
            $table->boolean('is_available')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspector_profiles');
    }
};
