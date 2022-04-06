<?php

namespace Tests\Unit;

use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_has_project()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function user_has_accessible_projects()
    {
        $firstUser = $this->signIn();

        ProjectFactory::ownedBy($firstUser)->create();

        $this->assertcount(1, $firstUser->accessibleProjects());

        $secondUser = User::factory()->create();
        $thirdUser = User::factory()->create();

        ProjectFactory::ownedBy($secondUser)->create()->invite($thirdUser);

        $this->assertcount(1, $firstUser->accessibleProjects());

        ProjectFactory::ownedBy($secondUser)->create()->invite($firstUser);

        $this->assertcount(2, $firstUser->accessibleProjects());
    }
}
