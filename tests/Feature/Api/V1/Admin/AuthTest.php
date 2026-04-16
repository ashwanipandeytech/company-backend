<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase; // This resets the database safely for every single test

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a dedicated admin user for testing before each test runs
        $this->adminUser = User::factory()->create([
            'email' => 'testadmin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->postJson('/api/v1/admin/login', [
            'email' => 'testadmin@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         'user' => ['id', 'name', 'email', 'role'],
                         'token'
                     ]
                 ]);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/v1/admin/login', [
            'email' => 'testadmin@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422) // Laravel validation exception status
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_admin_can_logout_and_revoke_token(): void
    {
        // Issue a token to act as the authenticated user
        $token = $this->adminUser->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/admin/logout');

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Successfully logged out.',
                 ]);

        // Verify the token was actually deleted from the database
        $this->assertCount(0, $this->adminUser->tokens);
    }
}