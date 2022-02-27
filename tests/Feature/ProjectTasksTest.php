<?php

namespace App\tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_not_add_tasks()
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertRedirect('/login');
    }

    public function test_only_project_owner_may_add_task()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    public function test_project_can_have_taks()
    {
        $project = Project::factory()->create();

        $this->actingAs($project->owner)->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    public function test_task_requires_a_body()
    {
        $project = ProjectFactory::create();

        $task = Task::factory()->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $task)
            ->assertSessionHasErrors('body');
    }

    public function test_a_task_can_be_updated()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    public function test_a_task_can_be_updated_only_by_owner()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $projAnother = ProjectFactory::ownedBy($this->signIn())->create();

        $this->patch($projAnother->path() . '/tasks/' . $project->tasks[0]->id, [
            'body' => 'changed'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
            'body' => 'changed'
        ]);
    }
}
