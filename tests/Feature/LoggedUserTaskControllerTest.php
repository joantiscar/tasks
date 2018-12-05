<?php
/**
 * Created by PhpStorm.
 * User: dios
 * Date: 22/10/18
 * Time: 21:17
 */

namespace Tests\Feature;


use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class LoggedUserTaskControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    public function test_can_list_logged_user_tasks()
    {
        $user = $this->login();
        $task1 = factory(Task::class)->create();
        $task2 = factory(Task::class)->create();
        $task3 = factory(Task::class)->create();
        $tasks = [$task1, $task2, $task3];
        $user->addTasks($tasks);
        $this->actingAs($user, 'api');



        $response = $this->get('/user/tasks');
        $response->assertSuccessful();

        $response->assertViewIs('tasques');
        $response->assertViewHas('tasks', map_collection($user->tasks));

    }
    public function test_cannot_see_tasks_if_user_is_not_logged()
    {
        $task = factory(Task::class)->create();
        $response = $this->json('get', '/user/tasks');
        $response->assertStatus(401);
    }
}