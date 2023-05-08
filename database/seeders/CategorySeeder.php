<?php

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
        $user->categories()->saveMany(Category::factory()->count(20)->make());
        $user->categories()->each(function (Category $category) {
            $category->parent_category_id = fake()->randomElement([$category->id % 20 - 1 == 0 ? null : $category->id - 1, null]);
            $category->save();
        });
    }
}
