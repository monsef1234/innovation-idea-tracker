<?php

namespace Database\Factories;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "idea_id" => Idea::all()->random()->id,
            "user_id" => User::where("role", "admin")->orWhere("role", "reviewer")->get()->random()->id,
            "vote_type" => fake()->randomElement(["up", "down"]),
        ];
    }
}
