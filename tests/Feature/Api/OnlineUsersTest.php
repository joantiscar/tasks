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
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class OnlineUsersTest extends TestCase
{

    use RefreshDatabase, CanLogin;

    public function test_can_list_all_online_users()
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAsTaskUser();
        $task1 = factory(Task::class)->create();
        $task2 = factory(Task::class)->create();
        $task3 = factory(Task::class)->create();
        $tasks = [$task1, $task2, $task3];
        $user->addTasks($tasks);
        $this->actingAs($user, 'api');

        $response = $this->json('get', '/api/v1/user/tasks');
        $response->assertSuccessful();

        $resultJson = json_decode($response->getContent());
        $this->assertCount(3, $resultJson);
    }
}
