<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AccountCRUDTest extends TestCase
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

    public function test_account_index(): void
    {
        $response = $this->get('/api/accounts');

        $response->assertStatus(200);
        $an_account = $this->user->accounts()->first();
        $response->assertJsonFragment([
            'name' => $an_account->name,
            'balance' => $an_account->initial_balance,
            'type' => $an_account->type->type,
            'color' => $an_account->color,
            'icon' => $an_account->icon,
            'last_update' => $an_account->updated_at
        ]);
    }

    public function test_account_show(): void
    {
        $an_account = $this->user->accounts()->first();
        $response = $this->get('/api/accounts/'.$an_account->id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $an_account->name,
            'balance' => $an_account->initial_balance,
            'type' => $an_account->type->type,
            'color' => $an_account->color,
            'icon' => $an_account->icon,
            'last_update' => $an_account->updated_at
        ]);
    }

    public function test_account_show_unauthorized(): void
    {
        $another_user = User::find(2);
        $an_account = $another_user->accounts()->first();
        $response = $this->get('/api/accounts/'.$an_account->id);
        $response->assertStatus(404);
    }

    public function test_account_store(): void
    {
        $base_fields = [
            'user_id' => 1,
            'name' => 'Name',
            'initial_balance' => '42.42',
            'account_type_id' => 1,
            'icon' => 'ciao',
            'color' => '123456',
            'opening' => '2021-04-02',
            'closing' => null,
            'description' => null
        ];
        $response = $this->post('/api/accounts', $base_fields);
        $response->assertStatus(201);
        $this->assertDatabaseHas('accounts', $base_fields);
    }

    public function test_account_store_errors_on_closing_previous(): void
    {
        $base_fields = [
            'user_id' => 1,
            'name' => 'Name',
            'initial_balance' => '42.42',
            'account_type_id' => 1,
            'icon' => 'ciao',
            'color' => '123456',
            'opening' => '2021-04-02',
            'closing' => '2020-01-01',
            'description' => null
        ];
        $response = $this->post('/api/accounts', $base_fields);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('accounts', $base_fields);
    }

    public function test_account_update(): void
    {
        $base_fields = [
            'user_id' => 1,
            'name' => 'Name',
            'account_type_id' => 1,
            'icon' => 'ciao',
            'color' => '123456',
            'opening' => '2021-04-02',
            'closing' => null,
            'description' => null
        ];
        $an_account = $this->user->accounts()->first();
        $response = $this->put('/api/accounts/'.$an_account->id, $base_fields);
        $response->assertStatus(204);
        $this->assertDatabaseHas('accounts', $base_fields);
        $this->assertDatabaseMissing('accounts', $an_account->toArray());
    }

    public function test_account_delete(): void
    {
        $an_account = $this->user->accounts()->first();
        $response = $this->delete('/api/accounts/'.$an_account->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('accounts', [
            'id' => $an_account->id
        ]);
    }

    public function test_account_delete_errors_on_wrong_user(): void
    {
        $an_account = User::find(2)->accounts()->first();
        $response = $this->delete('/api/accounts/'.$an_account->id);
        $response->assertStatus(404);
        $this->assertDatabaseHas('accounts', [
            'id' => $an_account->id
        ]);
    }
}
