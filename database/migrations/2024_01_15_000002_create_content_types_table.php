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
        Schema::create('content_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Content type name');
            $table->string('slug')->unique()->comment('URL-friendly identifier');
            $table->text('description')->comment('Content type description');
            $table->integer('credit_cost')->default(1)->comment('Credits required to generate this content type');
            $table->json('prompt_template')->comment('AI prompt template with placeholders');
            $table->json('input_fields')->comment('Required input fields configuration');
            $table->boolean('is_active')->default(true)->comment('Content type availability status');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('slug');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_types');
    }
};