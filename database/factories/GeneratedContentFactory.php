<?php

namespace Database\Factories;

use App\Models\ContentType;
use App\Models\GeneratedContent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GeneratedContent>
 */
class GeneratedContentFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['pending', 'processing', 'completed', 'failed']);
        
        return [
            'user_id' => User::factory(),
            'content_type_id' => ContentType::factory(),
            'title' => $this->faker->sentence(4),
            'input_data' => [
                'description' => $this->faker->paragraph(),
                'style' => $this->faker->randomElement(['casual', 'professional', 'humorous'])
            ],
            'generated_content' => $status === 'completed' ? $this->faker->paragraphs(3, true) : null,
            'status' => $status,
            'error_message' => $status === 'failed' ? $this->faker->sentence() : null,
            'credits_used' => $this->faker->numberBetween(1, 3),
            'ai_model_used' => $status === 'completed' ? 'gpt-3.5-turbo' : null,
            'processing_time' => $status === 'completed' ? $this->faker->randomFloat(2, 1, 30) : null,
        ];
    }

    /**
     * Indicate that the content is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'generated_content' => $this->faker->paragraphs(3, true),
            'ai_model_used' => 'gpt-3.5-turbo',
            'processing_time' => $this->faker->randomFloat(2, 1, 30),
            'error_message' => null,
        ]);
    }

    /**
     * Indicate that the content is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'generated_content' => null,
            'ai_model_used' => null,
            'processing_time' => null,
            'error_message' => null,
        ]);
    }
}