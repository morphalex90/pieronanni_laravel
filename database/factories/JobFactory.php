<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'company' => ['name' => fake()->name(), 'url' => fake()->url()],
            'location' => fake()->country(),
            'description' => fake()->sentence(50),
            'description_cv' => fake()->paragraphs(3, true),
            'started_at' => fake()->date(),
            'ended_at' => fake()->date(),
        ];
    }
}
