<?php

namespace Tests\Feature;

use App\Models\AccountType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTypeIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_type_index(): void
    {
        $types = AccountType::factory()->count(3)->create();
        $response = $this->get('/api/account_types');

        $response->assertStatus(200);
        $response->assertExactJson($types->toArray());
    }
}
