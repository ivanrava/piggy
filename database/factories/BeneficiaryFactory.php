<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beneficiary>
 */
class BeneficiaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'img' => fake()->randomElement([fake()->imageUrl(width: 64, height: 64), fake()->randomElement(['shapes', 'bottts'])]),
            'created_at' => fake()->dateTime
        ];
    }
}
