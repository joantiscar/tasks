<?php
/**
 * Created by PhpStorm.
 * User: dios
 * Date: 11/10/18
 * Time: 19:24
 */

namespace Tests\Feature\Api;


use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_can_show_a_task()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        // http://tasks.test/api/v1/tasks

        //CRUD -> CRU -> CREATE RETRIEVE UPDATE DELETE
        //BREAD -> PA -> BROWSE READ EDIT ADD DELETE

        //HTTP -> GET / POST / PUT / DELETE


//        Task::create([]);
        $task = factory(Task::class)->create();


        $this->withoutExceptionHandling();



        $response = $this->get('/api/v1/tasks/' . $task->id);


        $result = json_decode($response->getContent());

        $response->assertSuccessful();
        $this->assertEquals($task->name, $result->name);
        $this->assertEquals($task->completed, (boolean) $result->completed);
    }

    public function test_can_delete_task()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        $task = factory(Task::class)->create();

        $response = $this->DELETE('/api/v1/tasks/' . $task->id);

//        $this->assertNotContains('')
        $result = json_decode($response->getContent());
        $this->assertEquals('', $result);
//        $this->assertDatabaseMissing('tasks', $task);
        $this->assertNull(Task::find($task->id));
    }
    public function test_can_create_task()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        $task = factory(Task::class)->create();

        $response = $this->post('/api/v1/tasks/',[
            'name' => 'Comprar pa'
        ]);

//        $this->assertNotContains('')
        $result = json_decode($response->getContent());


        $this->assertNotNull($task = Task::find($result->id));

        $this->assertEquals('Comprar pa', $result->name);

        $this->assertFalse($result->completed);
    }
    public function test_can_edit_a_task()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        //1
        $task = Task::create([
            'name' => 'Comprar lejia',
            'completed' => false
        ]);
        //2
        $response = $this->json('PUT','/api/v1/tasks/' . $task->id, [
            'name' => 'Comprar pa',
            'completed' => true
        ]);

        // 2 opcions
//        $this->assertDatabaseHas('tasks',$newTask);
//        $this->assertDatabaseMissing('tasks',$task);

        $task = $task->fresh();
        $this->assertEquals($task->name,'Comprar pa');
        $this->assertEquals($task->completed, true);
        $this->assertTrue((boolean) $task->completed);
    }

    public function test_can_browse_tasks()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");

        $task1 = factory(Task::class)->create();
        $task2 = factory(Task::class)->create();
        $task3 = factory(Task::class)->create();


        $this->post('/api/v1/tasks/'.$task1);
        $this->post('/api/v1/tasks/'.$task2);
        $this->post('/api/v1/tasks/'.$task3);

        $response = $this->get('/api/v1/tasks');
        $response->assertSuccessful();

        $result = json_decode($response->getContent());

        $this->assertCount(3,$result);
        

    }

    public function test_cannot_create_tasks_without_name()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");

        // XHR -> JSON
        $response = $this->json('POST', '/api/v1/tasks',[
            'name' => ''
        ]);


//        $this->withoutExceptionHandling();
//        $response = $this->post('/api/v1/tasks/', [
//            'name' => ''
//            ])
        $response->assertStatus(422);



    }
    public function test_cannot_edit_tasks_without_name()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        //1
        $task = Task::create([
            'name' => 'Comprar lejia',
            'completed' => false
        ]);
        //2
        $response = $this->json('PUT','/api/v1/tasks/' . $task->id,$newTask = [
            'name' => '',
            'completed' => true
        ]);


//        $this->withoutExceptionHandling();
//        $response = $this->post('/api/v1/tasks/', [
//            'name' => ''
//            ])
        $response->assertStatus(422);



    }

}