<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasquesTest extends TestCase
{

    use RefreshDatabase, CanLogin;

    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function test_can_superadmin_index_tasks()
    {
        $this->withoutExceptionHandling();
        initialize_roles();
        create_Example_tasks();
        create_Example_tags();
        $this->loginAsSuperAdmin('web');
        $response = $this->get('/tasques');
        $response->assertSuccessful();
        $response->assertViewHas('tasks', function ($tasks) {
            return count($tasks) === 3;
        });
        $response->assertViewHas('tags', function ($tags) {
            return count($tags) === 3;
        });
    }

    public function test_can_taskManager_index_tasks()
    {
        initialize_roles();
        create_Example_tasks();
        $this->loginAsUsingRole('web', ['TaskManager', 'Tasks']);
        $response = $this->get('/tasques');
        $response->assertSuccessful();
        $response->assertViewHas('tasks', function ($tasks) {
            return count($tasks) === 3;
        });
    }

    public function test_user_with_tasks_role_can_index_tasks()
    {
        initialize_roles();
        create_Example_tasks();

        $user = $this->loginAsTaskUser();
        $task = Task::create([
          'name'      => 'Tasca Usuari',
          'completed' => true,
          'user_id'   => $user->id,
        ]);
        $response = $this->get('/tasques');
        $response->assertStatus(200);
        $response->assertViewIs('tasques');
        $response->assertViewHas('tasks', function ($tasks) {
            return count($tasks) === 2;
        });
    }

    public function test_regular_user_cannot_index_tasks()
    {
        initialize_roles();
        create_Example_tasks();
        $this->login('web');
        $response = $this->get('/tasques');
        $response->assertStatus(403);
    }

    public function test_guest_user_cannot_index_tasks()
    {
        initialize_roles();
        create_Example_tasks();
        $response = $this->get('/tasques');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
