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
        $user->categories()->saveMany(Category::factory()->count(10)->make());
        $user->categories()->each(
            fn (Category $parent) => self::maybeAddRandomChildren($parent)
        );
        $user->categories()->each(function (Category $parent) {
            $parent->children()->each(
                fn (Category $child) => self::maybeAddRandomChildren($child)
            );
        });
    }

    private static function maybeAddRandomChildren(Category $parent): void
    {
        // Do not add any child at random
        if (fake()->boolean)
            return;

        // Adds a random number of children of coherent user and type
        $children = Category::factory()->count(
            fake()->randomElement([1, 2])
        )->make(['user_id' => $parent->user_id, 'type' => $parent->type]);
        $parent->children()->saveMany($children);
    }
}
