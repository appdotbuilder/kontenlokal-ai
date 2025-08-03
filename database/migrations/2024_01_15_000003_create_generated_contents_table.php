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
        Schema::create('generated_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('content_type_id')->constrained()->onDelete('cascade');
            $table->string('title')->comment('User-provided title for the content');
            $table->json('input_data')->comment('User input data used for generation');
            $table->text('generated_content')->nullable()->comment('AI-generated content result');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending')->comment('Generation status');
            $table->text('error_message')->nullable()->comment('Error details if generation failed');
            $table->integer('credits_used')->default(1)->comment('Credits consumed for this generation');
            $table->string('ai_model_used')->nullable()->comment('AI model used for generation');
            $table->decimal('processing_time', 8, 2)->nullable()->comment('Processing time in seconds');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'created_at']);
            $table->index('status');
            $table->index('content_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_contents');
    }
};