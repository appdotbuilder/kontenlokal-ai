<?php

namespace App\Services;

use App\Models\GeneratedContent;
use Illuminate\Support\Facades\Log;

/**
 * Service for processing content generation.
 */
class ContentGenerationService
{
    /**
     * Create a new content generation service instance.
     */
    public function __construct(
        private AIEngineService $aiService
    ) {}

    /**
     * Process content generation for the given content.
     *
     * @param GeneratedContent $generatedContent
     * @return void
     */
    public function processGeneration(GeneratedContent $generatedContent): void
    {
        try {
            // Mark as processing
            $generatedContent->markAsProcessing();

            Log::info('Starting content generation', [
                'content_id' => $generatedContent->id,
                'user_id' => $generatedContent->user_id,
            ]);

            // Generate content using AI service
            $result = $this->aiService->generateContent($generatedContent);

            if ($result['success']) {
                // Mark as completed with generated content
                $generatedContent->markAsCompleted(
                    $result['content'],
                    $result['model'] ?? null,
                    $result['processing_time'] ?? null
                );

                Log::info('Content generation completed', [
                    'content_id' => $generatedContent->id,
                    'processing_time' => $result['processing_time'] ?? null,
                ]);

            } else {
                // Mark as failed
                $generatedContent->markAsFailed($result['error']);

                Log::error('Content generation failed', [
                    'content_id' => $generatedContent->id,
                    'error' => $result['error'],
                ]);
            }

        } catch (\Exception $e) {
            // Mark as failed and log error
            $generatedContent->markAsFailed('Terjadi kesalahan sistem: ' . $e->getMessage());

            Log::error('Content generation service failed', [
                'content_id' => $generatedContent->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }
}