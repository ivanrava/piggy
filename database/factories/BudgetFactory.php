<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jan'       => fake()->randomFloat(2, 0, 1000),
            'feb'       => fake()->randomFloat(2, 0, 1000),
            'mar'       => fake()->randomFloat(2, 0, 1000),
            'apr'       => fake()->randomFloat(2, 0, 1000),
            'may'       => fake()->randomFloat(2, 0, 1000),
            'jun'       => fake()->randomFloat(2, 0, 1000),
            'jul'       => fake()->randomFloat(2, 0, 1000),
            'aug'       => fake()->randomFloat(2, 0, 1000),
            'sep'       => fake()->randomFloat(2, 0, 1000),
            'oct'       => fake()->randomFloat(2, 0, 1000),
            'nov'       => fake()->randomFloat(2, 0, 1000),
            'dec'       => fake()->randomFloat(2, 0, 1000),
        ];
    }
}
