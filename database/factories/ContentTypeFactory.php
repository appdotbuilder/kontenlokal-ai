<?php

namespace Database\Factories;

use App\Models\ContentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContentType>
 */
class ContentTypeFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(),
            'credit_cost' => $this->faker->numberBetween(1, 3),
            'prompt_template' => [
                'system' => 'You are a helpful AI assistant.',
                'user' => 'Generate content based on: {description}'
            ],
            'input_fields' => [
                [
                    'name' => 'description',
                    'label' => 'Description',
                    'type' => 'textarea',
                    'required' => true
                ]
            ],
            'is_active' => true,
        ];
    }
}