<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
      Schema::create('users', function (Blueprint $table) {
    $table->id(); // bigint unsigned auto-increment primary key
    $table->string('full_name', 150);
    $table->string('phone', 20)->unique();
    $table->string('email')->unique();
    $table->string('password');
    $table->string('avatar_url', 500)->nullable();

    
    $table->enum('role', ['guest','buyer','seller','inspector','admin'])->default('buyer');
    $table->enum('status', ['active','inactive','banned','pending_verify'])->default('active');
    
    $table->timestamp('email_verified_at')->nullable();
    $table->timestamp('phone_verified_at')->nullable();
    $table->timestamp('last_login_at')->nullable();
    
    // create created_at and updated_at automatically
    $table->timestamps();

    // create index if system larger: optinal, i can be added later when needed
    // $table->index(['role','status']);
});

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
