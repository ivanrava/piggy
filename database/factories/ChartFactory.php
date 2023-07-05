<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chart>
 */
class ChartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return fake()->randomElement([
            $this->random_list(),
            $this->random_pie(),
            $this->random_linebar()
        ]);
    }

    private function random_list(): array
    {
        return [
            'kind' => 'list',
            'interval' => fake()->randomElement(['all', 'year', 'month']),
            'stat' => fake()->randomElement(['sum', 'count', 'avg', 'max']),
            'filter' => fake()->randomElement(['accounts', 'beneficiaries', 'categories']),
            'favorite' => fake()->randomElement([true, false])
        ];
    }

    private function random_linebar(): array
    {
        $filter = fake()->randomElement(['all', 'accounts', 'beneficiaries', 'categories']);
        return [
            'kind' => fake()->randomElement(['line', 'bar']),
            'interval' => fake()->randomElement(['month', 'year']),
            'stat' => fake()->randomElement(['sum', 'count', 'avg', 'max']),
            'filter' => $filter,
            'favorite' => fake()->randomElement([true, false])
        ];
    }

    private function random_pie(): array
    {
        $filter = fake()->randomElement(['accounts', 'beneficiaries', 'categories']);
        return [
            'kind' => 'pie',
            'interval' => fake()->randomElement(['all', 'month', 'year']),
            'stat' => fake()->randomElement(['sum', 'count', 'avg', 'max']),
            'filter' => $filter,
            'favorite' => fake()->randomElement([true, false])
        ];
    }
}
