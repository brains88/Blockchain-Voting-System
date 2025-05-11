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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('wallet_address')->nullable()->unique(); 
            $table->string('voter_id')->nullable()->unique();      
            $table->date('date_of_birth')->nullable();             
            $table->string('nonce')->nullable(); 
            $table->string('auth_method')->default('wallet');       
            $table->string('auth_message')->nullable();
            $table->string('name')->nullable('voter');
            $table->string('role')->default('voter');  
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            
            // Voting-specific fields
            $table->boolean('is_verified')->default(false);
            $table->boolean('has_voted')->default(false);
            $table->timestamp('last_voted_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('wallet_address');
            $table->index('voter_id');
        });

        // Password reset tokens can be kept if you'll have email auth
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    
        // Sessions table is fine as is
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
