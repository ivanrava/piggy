<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'type' => fake()->randomElement(['out', 'in']),
            'icon' => fake()->randomElement(['mdi:abacus', 'mdi:access-point',
                'solar:adhesive-plaster-2-linear', 'carbon:accumulation-snow']),
            'virtual' => fake()->boolean
        ];
    }
}
