<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(0, 100),
            'initial_value' => fake()->randomFloat(
                2,
                100,
                1000000
            ),
            'name' => fake()->word,
            'icon' => fake()->randomElement(['clarity:home-solid', 'fluent-emoji-high-contrast:framed-picture',
                'cil:fridge', 'game-icons:pc']),
            'description' => fake()->text(100)
        ];
    }
}
