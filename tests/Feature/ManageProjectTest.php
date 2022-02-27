<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guests_can_not_manage_projects()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('projects/create')->assertRedirect('login');
        $this->get($project->path() . '/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    public function test_a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('projects/create')->assertStatus(200);

        $attributes = [
            "title" => $this->faker->sentence(),
            "description" => $this->faker->sentence(),
            "notes" => $this->faker->sentence()
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    public function test_a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    public function test_a_users_can_view_their_project()
    {
        $project = ProjectFactory::create();

        $this
            ->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_an_auth_user_can_not_view_projects_of_others()
    {
        $project = Project::factory()->create();

        $this
            ->actingAs($this->signIn())
            ->get($project->path())
            ->assertStatus(403);
    }

    public function test_an_auth_user_can_not_update_projects_of_others()
    {
        $project = Project::factory()->create();

        $this
            ->actingAs($this->signIn())
            ->patch($project->path())
            ->assertStatus(403);
    }

    public function test_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $attributes = [
            'notes' => 'changed notes',
            'description' => 'changed description',
            'title' => 'changed'
        ];

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes)
            ->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);
    }
}
