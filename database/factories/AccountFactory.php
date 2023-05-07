<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTime;
        return [
            'user_id' => fake()->numberBetween(0, 100),
            'account_type_id' => fake()->numberBetween(1, 4),
            'initial_balance' => fake()->randomFloat(
                2,
                0,
                1000
            ),
            'name' => fake()->creditCardType,
            'icon' => fake()->randomElement(['mdi:abacus', 'mdi:access-point',
                'solar:adhesive-plaster-2-linear', 'carbon:accumulation-snow']),
            'color' => substr(fake()->hexColor, 1),
            'opening' => $startDate,
            'closing' => fake()->optional()->dateTimeBetween(
                $startDate->add(\DateInterval::createFromDateString('1 day'))
            ),
            'description' => fake()->text(500)
        ];
    }
}
