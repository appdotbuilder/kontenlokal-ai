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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('credits')->default(20)->comment('Available credits for content generation');
            $table->text('brand_voice')->nullable()->comment('User brand voice description for AI personalization');
            $table->string('subscription_tier')->default('free')->comment('Current subscription tier: free, basic, pro, enterprise');
            $table->timestamp('subscription_expires_at')->nullable()->comment('Subscription expiration date');
            $table->boolean('is_active')->default(true)->comment('Account status');
            
            // Indexes for performance
            $table->index('subscription_tier');
            $table->index('is_active');
            $table->index('subscription_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'credits',
                'brand_voice', 
                'subscription_tier',
                'subscription_expires_at',
                'is_active'
            ]);
        });
    }
};