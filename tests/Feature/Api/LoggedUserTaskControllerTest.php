<?php
/**
 * Created by PhpStorm.
 * User: dios
 * Date: 22/10/18
 * Time: 21:17
 */

namespace Tests\Feature\Api;


use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoggedUserTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_logged_user_tasks()
    {

        $user = factory(User::class)->create();
        $task1 = factory(Task::class)->create();
        $task2 = factory(Task::class)->create();
        $task3 = factory(Task::class)->create();
        $tasks = [$task1, $task2, $task3];
        $this->actingAs($user, 'api');



        $response = $this->json('get', '/user/tasks');
        $response->assertSuccessful();
        $resultJson = json_decode($response->getContent());


        $this->assertEquals($tesult[0]->is($task1);)
        $this->assertEquals($tesult[1]->is($task2);)
        $this->assertEquals($tesult[2]->is($task3);)
    }
    public function test_cannot_see_tasks_if_user_is_not_logged()
    {

        $user = factory(User::class)->create();
        $task = factory(Task::class)->create();
        $response = $this->json('get', '/user/tasks');
        $response->assertStatus(401);
    }
}