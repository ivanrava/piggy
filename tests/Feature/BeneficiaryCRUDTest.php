<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BeneficiaryCRUDTest extends TestCase
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

    public function test_beneficiary_index(): void
    {
        $response = $this->get('/api/beneficiaries');

        $response->assertStatus(200);
        $a_beneficiary = $this->user->beneficiaries()->first();
        $response->assertJsonFragment([
            'name' => $a_beneficiary->name,
            'img' => $a_beneficiary->img,
        ]);
    }

    public function test_beneficiary_show(): void
    {
        $a_beneficiary = $this->user->beneficiaries()->first();
        $response = $this->get('/api/beneficiaries/'.$a_beneficiary->id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $a_beneficiary->name,
            'img' => $a_beneficiary->img,
        ]);
    }

    public function test_beneficiary_show_unauthorized(): void
    {
        $another_user = User::find(2);
        $a_beneficiary = $another_user->beneficiaries()->first();
        $response = $this->get('/api/beneficiaries/'.$a_beneficiary->id);
        $response->assertStatus(404);
    }

    public function test_beneficiary_store(): void
    {
        $base_fields = [
            'user_id' => 1,
            'name' => 'Name',
            'img' => 'hello.png',
        ];
        $response = $this->post('/api/beneficiaries', $base_fields);
        $response->assertStatus(201);
        $this->assertDatabaseHas('beneficiaries', $base_fields);
    }

    public function test_beneficiary_update(): void
    {
        $base_fields = [
            'user_id' => 1,
            'name' => 'Name',
            'img' => 'hello.png',
        ];
        $a_beneficiary = $this->user->beneficiaries()->first();
        $response = $this->put('/api/beneficiaries/'.$a_beneficiary->id, $base_fields);
        $response->assertStatus(204);
        $this->assertDatabaseHas('beneficiaries', $base_fields);
        $this->assertDatabaseMissing('beneficiaries', [
            'name' => $a_beneficiary->name,
            'img' => $a_beneficiary->img
        ]);
    }

    public function test_beneficiary_delete(): void
    {
        $a_beneficiary = $this->user->beneficiaries()->first();
        $response = $this->delete('/api/beneficiaries/'.$a_beneficiary->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('beneficiaries', [
            'id' => $a_beneficiary->id
        ]);
    }

    public function test_beneficiary_delete_errors_on_wrong_user(): void
    {
        $a_beneficiary = User::find(2)->beneficiaries()->first();
        $response = $this->delete('/api/accounts/'.$a_beneficiary->id);
        $response->assertStatus(404);
        $this->assertDatabaseHas('beneficiaries', [
            'id' => $a_beneficiary->id
        ]);
    }
}
