<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Idea>
 */
class IdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => fake()->sentence(6),
            "description" => fake()->paragraph(3),
            "category" => fake()->randomElement(["Category 1", "Category 2", "Category 3"]),
            "submitter_id" => User::all()->random()->id,
        ];
    }
}
