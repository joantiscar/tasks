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

class LoggedUserTaskApiControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    public function test_can_list_logged_user_tasks()
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
    public function test_cannot_see_tasks_if_user_is_not_logged()
    {
        $task = factory(Task::class)->create();
        $response = $this->json('get', '/api/v1/user/tasks');
        $response->assertStatus(401);
    }

    public function test_user_can_edit_task()
    {
        $user = $this->loginAsTaskUser();
        //1
        $oldtask = Task::create([
            'name' => 'Comprar lejia',
            'completed' => false,
            'description' => 'tasca to guapa'
        ]);
        //2
        $user->addTask($oldtask);
        $this->actingAs($user, 'api');
        $response = $this->json('PUT','/api/v1/user/tasks/' . $oldtask->id, [
            'name' => 'Comprar pa',
            'completed' => true,
            'description' => 'Tasca no tan guapa'

        ]);
        // 2 opcions
//        $this->assertDatabaseHas('tasks',$newTask);
//        $this->assertDatabaseMissing('tasks',$task);

        $task = $oldtask->fresh();
        $this->assertEquals($task->id,$oldtask->id);
        $this->assertEquals($task->name, 'Comprar pa');
        $this->assertEquals($task->description, 'Tasca no tan guapa');
        $this->assertEquals((boolean)$task->completed, true);
        $this->assertTrue((boolean) $task->completed);
    }
    public function test_user_cannot_edit_a_task_not_associated_to_user()
    {
        $user = $this->loginAsTaskUser();
        $user2 = factory(User::class)->create();
        //1
        $task = Task::create([
            'name' => 'Comprar lejia',
            'completed' => false,
            'description' => 'asdadas',
            'user_id' => $user2->id
        ]);
        //2
        $this->actingAs($user, 'api');
        $response = $this->json('PUT','/api/v1/user/tasks/' . $task->id, [
            'name' => 'Comprar pa',
            'completed' => true,
            'description' => 'asdadas'
        ]);

        // 2 opcions
//        $this->assertDatabaseHas('tasks',$newTask);
//        $this->assertDatabaseMissing('tasks',$task);

        $response->assertStatus(404);
    }
}