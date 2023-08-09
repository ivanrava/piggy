<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }

    public static function seed(User $user): void
    {
        $user->categories()->where('parent_category_id', '!=', null)->each(
            function (Category $category) {
                if (fake()->boolean)
                    $category->budget()->saveMany(Budget::factory()->count(1)->make());
                else {
                    $category->budget_overall = fake()->randomFloat(2,0,1000);
                    $category->save();
                }
            }
        );
    }
}
