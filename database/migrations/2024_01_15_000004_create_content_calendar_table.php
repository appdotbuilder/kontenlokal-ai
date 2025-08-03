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
        Schema::create('content_calendar', function (Blueprint $table) {
            $table->id();
            $table->date('event_date')->comment('Date of the Indonesian holiday or special event');
            $table->string('event_name')->comment('Name of the holiday or special event');
            $table->string('event_type')->comment('Type: national_holiday, religious, cultural, commercial');
            $table->text('description')->comment('Event description and significance');
            $table->json('content_ideas')->comment('Suggested content ideas for this event');
            $table->json('hashtags')->nullable()->comment('Relevant hashtags for social media');
            $table->boolean('is_active')->default(true)->comment('Calendar entry status');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('event_date');
            $table->index('event_type');
            $table->index('is_active');
            $table->index(['event_date', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_calendar');
    }
};