<?php

namespace Tests\Feature;

use App\Models\AccountType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AccountTypeIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_account_type_index_no_auth(): void
    {
        $response = $this->get('/api/account_types');

        $response->assertStatus(500);
    }

    public function test_account_type_index_sanctum(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->get('/api/account_types');

        $response->assertStatus(200);
        $response->assertExactJson(AccountType::all()->toArray());
    }
}
