<?php

namespace Tests\Feature\Api\V1;

use App\Models\Client;
use App\Models\ProjectType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicApiTest extends TestCase
{
    use RefreshDatabase; // Automatically resets the DB for every test

    public function test_it_can_fetch_active_clients(): void
    {
        // Arrange: Use standard create() instead of factory()
        Client::create(['name' => 'Active Client', 'is_active' => true]);
        Client::create(['name' => 'Hidden Client', 'is_active' => false]);

        // Act: Hit the endpoint
        $response = $this->getJson('/api/v1/clients');

        // Assert: Verify it only returns the active one
        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data')
                 ->assertJsonPath('data.0.name', 'Active Client');
    }

    public function test_it_can_submit_an_enquiry_successfully(): void
    {
        $projectType = ProjectType::create(['name' => 'Web Dev', 'is_active' => true]);

        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'project_type_id' => $projectType->id,
            'requirements' => 'I need a corporate website.',
        ];

        $response = $this->postJson('/api/v1/enquiries', $payload);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Your project enquiry has been submitted successfully.',
                 ]);

        // Verify it actually saved to the database
        $this->assertDatabaseHas('enquiries', [
            'email' => 'john@example.com',
            'project_type_id' => $projectType->id,
        ]);
    }

    public function test_enquiry_fails_validation_without_email(): void
    {
        $response = $this->postJson('/api/v1/enquiries', [
            'name' => 'John Doe',
            'requirements' => 'I need a website.',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email', 'project_type_id']);
    }
}