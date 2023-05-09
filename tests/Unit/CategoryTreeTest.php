<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTreeTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_children_relationship(): void
    {
        $user = User::factory()->createOne();
        $parent = Category::factory()->createOne(['user_id' => $user->id]);
        $children = Category::factory()->count(5)->make(['user_id' => $user->id]);
        $parent->children()->saveMany($children);
        $this->assertDatabaseHas('categories', [
            'name' => $parent->name,
            'type' => $parent->type,
            'icon' => $parent->icon,
            'parent_category_id' => null
        ]);
        $children->each(function (Category $category) use ($parent) {
            $this->assertDatabaseHas('categories', [
                'name' => $category->name,
                'type' => $category->type,
                'icon' => $category->icon,
                'parent_category_id' => $parent->id
            ]);
        });
    }
}
