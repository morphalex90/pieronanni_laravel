<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_id' => fake()->numberBetween(1, 10),
            'title' => fake()->title(),
            'url' => fake()->url(),
            'github' => fake()->url(),
            'description' => fake()->sentence(50),
            'published_at' => fake()->date(),
        ];
    }
}
