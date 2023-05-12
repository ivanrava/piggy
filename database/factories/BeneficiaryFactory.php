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
            'name' => fake()->randomElement([fake()->name, fake()->company]),
            'img' => fake()->randomElement([fake()->randomElement(['shapes', 'bottts', 'thumbs'])]),
            'created_at' => fake()->dateTime
        ];
    }
}
