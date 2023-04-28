<?php

namespace Tests\Feature;

use App\Models\AccountType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTypeCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_type_index(): void
    {
        $types = AccountType::factory()->count(3)->create();
        $response = $this->get('/api/account_types');

        $response->assertStatus(200);
        $response->assertExactJson($types->toArray());
    }

    public function test_account_type_show(): void
    {
        $types = AccountType::factory()->count(1)->create(['id' => 666]);
        $response = $this->get('/api/account_types/666');

        $response->assertStatus(200);
        $response->assertExactJson($types->toArray()[0]);

        $this->get('/api/account_types/404')->assertStatus(404);
    }

    public function test_account_type_delete(): void
    {
        AccountType::factory()->count(1)->create(['id' => 666]);
        $response = $this->delete('/api/account_types/666');

        $response->assertNoContent();

        $this->get('/api/account_types/404')->assertStatus(404);
    }

    public function test_account_type_store(): void
    {
        $response = $this->post('/api/account_types', [
            'type' => 'Bank account'
        ]);
        $response->assertCreated();
        $this->assertDatabaseHas('account_types', ['type' => 'Bank account']);

        $this->post('/api/account_types', [
            'type' => str_repeat('a', 400)
        ])->assertInvalid();
        $this->post('/api/account_types')->assertInvalid();
    }

    public function test_account_type_update(): void
    {
        AccountType::factory()->count(1)->create(['id' => 666]);
        $response = $this->put('/api/account_types/666', [
            'type' => 'Wallet'
        ]);
        $response->assertNoContent();
        $this->assertDatabaseHas('account_types', ['type' => 'Wallet']);

        $this->put('/api/account_types/666', [
            'type' => str_repeat('a', 400)
        ])->assertInvalid();
        $this->put('/api/account_types/42')->assertInvalid();
    }
}
