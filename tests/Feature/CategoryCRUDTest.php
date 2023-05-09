<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryCRUDTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::find(1);
        Sanctum::actingAs($this->user);
    }

    public function test_category_index(): void
    {
        $parent = Category::factory()->createOne(['user_id' => $this->user->id]);
        $children = Category::factory()->count(2)->make(['user_id' => $this->user->id]);
        $grandchildren = Category::factory()->count(1)->make(['user_id' => $this->user->id]);
        $parent->children()->saveMany($children);
        $children[1]->children()->saveMany($grandchildren);

        $response = $this->get('/api/categories');

        $response->assertStatus(200);
        $a_category = $this->user->categories()->first();
        $response->assertJsonFragment([
            'name' => $a_category->name,
            'icon' => $a_category->icon,
            'type' => $a_category->type
        ]);
        $response->assertJsonFragment([
            'name' => $grandchildren[0]->name,
            'icon' => $grandchildren[0]->icon,
            'type' => $grandchildren[0]->type,
            'children' => []
        ]);
    }

    public function test_category_show(): void
    {
        $a_category = $this->user->categories()->first();
        $response = $this->get('/api/categories/'.$a_category->id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $a_category->name,
            'icon' => $a_category->icon,
            'type' => $a_category->type
    ]);
}

    public function test_category_show_with_children(): void
    {
        $parent = Category::factory()->createOne(['user_id' => $this->user->id]);
        $children = Category::factory()->count(5)->make(['user_id' => $this->user->id]);
        $grandchildren = Category::factory()->count(5)->make(['user_id' => $this->user->id]);
        $parent->children()->saveMany($children);
        $children[1]->children()->saveMany($grandchildren);

        $response = $this->get('/api/categories/'.$parent->id);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $parent->name,
            'icon' => $parent->icon,
            'type' => $parent->type
        ]);
        $response->assertJsonFragment([
            'name' => $grandchildren[0]->name,
            'icon' => $grandchildren[0]->icon,
            'type' => $grandchildren[0]->type,
            'children' => []
        ]);
    }

    public function test_category_show_unauthorized(): void
    {
        $another_user = User::find(2);
        $a_category = $another_user->categories()->first();
        $response = $this->get('/api/categories/'.$a_category->id);
        $response->assertStatus(404);
    }

    public function test_category_store(): void
    {
        $base_fields = [
            'user_id' => 1,
            'name' => 'Name',
            'icon' => 'fas-solid',
            'parent_category_id' => 2,
            'type' => 'in'
        ];
        $response = $this->post('/api/categories', $base_fields);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $base_fields);
    }

    public function test_category_update(): void
    {
        $base_fields = [
            'user_id' => 1,
            'name' => 'Name',
            'icon' => 'fas-solid',
            'parent_category_id' => 2,
            'type' => 'in'
        ];
        $a_category = $this->user->categories()->first();
        $response = $this->put('/api/categories/'.$a_category->id, $base_fields);
        $response->assertStatus(204);
        $this->assertDatabaseHas('categories', $base_fields);
        $this->assertDatabaseMissing('categories', [
            'name' => $a_category->name,
            'icon' => $a_category->icon,
            'type' => $a_category->type
        ]);
    }

    public function test_category_delete(): void
    {
        $a_category = $this->user->categories()->first();
        $response = $this->delete('/api/categories/'.$a_category->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', [
            'id' => $a_category->id
        ]);
    }

    public function test_category_delete_errors_on_wrong_user(): void
    {
        $a_category = User::find(2)->categories()->first();
        $response = $this->delete('/api/categories/'.$a_category->id);
        $response->assertStatus(404);
        $this->assertDatabaseHas('categories', [
            'id' => $a_category->id
        ]);
    }
}
