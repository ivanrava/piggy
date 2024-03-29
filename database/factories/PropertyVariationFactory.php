<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyVariation>
 */
class PropertyVariationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->date,
            'type' => fake()->randomElement(['out', 'in']),
            'amount' => fake()->randomFloat(
                2,
                10,
                1000
            ),
            'notes' => fake()->text
        ];
    }
}
