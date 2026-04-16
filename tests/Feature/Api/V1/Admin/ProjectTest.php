<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin user to act as the authenticated user
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_unauthenticated_users_cannot_access_admin_projects(): void
    {
        $response = $this->getJson('/api/v1/admin/projects');
        $response->assertStatus(401); // Unauthorized
    }

    public function test_admin_can_create_a_project(): void
    {
        // Authenticate the admin using Sanctum's testing helper
        Sanctum::actingAs($this->admin, ['*']);

        $payload = [
            'title' => 'Enterprise API',
            'status' => 'ongoing',
        ];

        $response = $this->postJson('/api/v1/admin/projects', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.title', 'Enterprise API')
                 ->assertJsonPath('data.slug', 'enterprise-api'); // Verify our auto-slug logic works

        $this->assertDatabaseHas('projects', ['slug' => 'enterprise-api']);
    }

    public function test_admin_can_delete_a_project(): void
    {
        Sanctum::actingAs($this->admin, ['*']);

        $project = Project::create([
            'title' => 'Old Project', 
            'slug' => 'old-project', 
            'status' => 'completed'
        ]);

        $response = $this->deleteJson('/api/v1/admin/projects/' . $project->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}