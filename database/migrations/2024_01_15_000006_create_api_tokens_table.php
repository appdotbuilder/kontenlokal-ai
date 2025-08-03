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
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->comment('Token name for identification');
            $table->string('token', 64)->unique()->comment('Hashed API token');
            $table->json('abilities')->comment('Token permissions and scopes');
            $table->timestamp('last_used_at')->nullable()->comment('Last usage timestamp');
            $table->timestamp('expires_at')->nullable()->comment('Token expiration date');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('token');
            $table->index(['user_id', 'name']);
            $table->index('last_used_at');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_tokens');
    }
};