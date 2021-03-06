<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created_project', $project->activity[0]->description);
        $this->assertNull($project->activity->last()->changes);
    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectFactory::create();
        $originalTitle = $project->title;
        $project->update(['title' => 'Changed']);

        $expected = [
            'before' => ['title' => $originalTitle],
            'after' => ['title' => 'Changed']
        ];

        $this->assertCount(2, $project->activity);

        $activity = $project->activity->last();

        $this->assertEquals('updated_project', $activity->description);
        $this->assertEquals($expected, $activity->changes);
    }

    /** @test */
    public function creating_a_new_task()
    {
        $project = ProjectFactory::create();

        $project->addTask('some task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);
        $this->assertInstanceOf(Task::class, $project->activity->last()->subject);
    }

    /** @test */
    public function completing_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch(
            $project->tasks[0]->path(),
            ['body' => 'test', 'completed' => true]
        );

        $this->assertCount(3, $project->activity);

        $activity = $project->activity->last();

        $this->assertEquals('completed_task', $activity->description);
        $this->assertInstanceOf(Task::class, $activity->subject);
    }

    /** @test */
    public function incompleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch(
            $project->tasks[0]->path(),
            ['body' => 'test', 'completed' => true]
        );

        $this->assertCount(3, $project->activity);

        $this->actingAs($project->owner)->patch(
            $project->tasks[0]->path(),
            ['body' => 'test', 'completed' => false]
        );

        $this->assertCount(4, $project->refresh()->activity);

        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }

    /** @test */
    public function deleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
        $this->assertEquals('deleted_task', $project->activity->last()->description);
    }
}
