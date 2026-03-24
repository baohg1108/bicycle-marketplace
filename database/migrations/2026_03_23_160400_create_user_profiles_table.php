<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->foreignId("user_id")->primary()->constrained('users')->onDelete('cascade');

            // address info
            $table->text("bio")->nullable();
            $table->string("city", 100)-> nullable();
            $table->string("district", 100)->nullable();

            // verification info
            $table->string("id_number", 30)->nullable();
            $table->boolean("is_verified")->default(false);

            $table->decimal("rating_score", 3, 2)->default(0.00);

            $table->unsignedInteger("rating_count")->default(0);
            $table->unsignedInteger("total_sold")->default(0);
            $table->unsignedInteger("total_bought")->default(0);

            $table->unsignedTinyInteger("response_rate")->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
