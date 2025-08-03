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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Plan name: Free, Basic, Pro, Enterprise');
            $table->string('slug')->unique()->comment('URL-friendly identifier');
            $table->text('description')->comment('Plan description and features');
            $table->decimal('price_monthly', 10, 2)->default(0)->comment('Monthly price in IDR');
            $table->decimal('price_yearly', 10, 2)->default(0)->comment('Yearly price in IDR');
            $table->integer('credits_monthly')->comment('Credits allocated per month');
            $table->json('features')->comment('List of features included in this plan');
            $table->integer('max_team_members')->default(1)->comment('Maximum team members allowed');
            $table->boolean('is_popular')->default(false)->comment('Mark as popular/recommended plan');
            $table->boolean('is_active')->default(true)->comment('Plan availability status');
            $table->integer('sort_order')->default(0)->comment('Display order on pricing page');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('slug');
            $table->index('is_active');
            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};