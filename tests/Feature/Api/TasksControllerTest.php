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
use Illuminate\Support\Facades\Gate;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class TasksControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    public function test_superadmin_can_show_a_task()
    {
        $user = $this->login('api');
        $user->admin = true;
        $user->save();
        $task = factory(Task::class)->create();


        $this->withoutExceptionHandling();



        $response = $this->get('/api/v1/tasks/' . $task->id);


        $result = json_decode($response->getContent());

        $response->assertSuccessful();
        $this->assertEquals($task->name, $result->name);
        $this->assertEquals($task->completed, (boolean) $result->completed);
    }

    public function test_manager_can_show_a_task()
    {
        initialize_roles();
        $user = $this->login('api');
        $task = factory(Task::class)->create();

        $user->assignRole('TaskManager');

        $this->withoutExceptionHandling();



        $response = $this->get('/api/v1/tasks/' . $task->id);


        $result = json_decode($response->getContent());

        $response->assertSuccessful();
        $this->assertEquals($task->name, $result->name);
        $this->assertEquals($task->completed, (boolean) $result->completed);
    }
    public function test_regular_user_cannot_show_a_task()
    {

        $user = $this->login('api');

        $task = factory(Task::class)->create();
        $task->user_id = 1234;
        $task->save();

//        $this->withoutExceptionHandling();


        $response = $this->get('/api/v1/tasks/' . $task->id);


        $result = json_decode($response->getContent());

        $response->assertStatus(403);
    }

    public function test_superAdmin_can_delete_task()
    {
        $user = $this->login('api');
        $user->admin = true;
        $user->save();
        $task = factory(Task::class)->create();

        $response = $this->DELETE('/api/v1/tasks/' . $task->id);

//        $this->assertNotContains('')
        $result = json_decode($response->getContent());
        $this->assertEquals('', $result);
//        $this->assertDatabaseMissing('tasks', $task);
        $this->assertNull(Task::find($task->id));
    }
    public function test_manager_can_delete_task()
    {
        initialize_roles();
        $user = $this->login('api');
        $task = factory(Task::class)->create();

        $user->assignRole('TaskManager');
        $task = factory(Task::class)->create();

        $response = $this->DELETE('/api/v1/tasks/' . $task->id);

//        $this->assertNotContains('')
        $result = json_decode($response->getContent());
        $this->assertEquals('', $result);
//        $this->assertDatabaseMissing('tasks', $task);
        $this->assertNull(Task::find($task->id));
    }
    public function test_regular_user_cannot_delete_task()
    {
        $user = $this->login('api');

        $task = factory(Task::class)->create();
        $task->user_id = 1234;
        $task->save();

        $response = $this->DELETE('/api/v1/tasks/' . $task->id);

//        $this->assertNotContains('')

        $result = json_decode($response->getContent());

        $response->assertStatus(403);
    }
    public function test_superAdmin_can_create_task()
    {
        $user = $this->login('api');
        $user->admin = true;
        $user->save();
        $task = factory(Task::class)->create();

        $response = $this->post('/api/v1/tasks/',[
            'name' => 'Comprar pa',
            'description' => 'Hauria d\'anar a comprar pa, que no ne queda',
            'user_id' => 1
        ]);

//        $this->assertNotContains('')
        $result = json_decode($response->getContent());


        $this->assertNotNull($task = Task::find($result->id));

        $this->assertEquals('Comprar pa', $result->name);

        $this->assertFalse($result->completed);
    }
    public function test_manager_can_create_task()
    {
        initialize_roles();
        $user = $this->login('api');
        $task = factory(Task::class)->create();

        $user->assignRole('TaskManager');
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
    public function test_regular_user_cannot_create_task()
    {
        $user = $this->login('api');

        $task = factory(Task::class)->create();
        $task->user_id = 1234;
        $task->save();
        $response = $this->post('/api/v1/tasks/',[
            'name' => 'Comprar pa'
        ]);


        $result = json_decode($response->getContent());

        $response->assertStatus(403);
    }
    public function test_superAdmin_can_edit_a_task()
    {
        $user = $this->loginAsSuperAdmin('api');
        $user->admin = true;
        $user->save();
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
    public function test_manager_can_edit_a_task()
    {
        initialize_roles();
        $user = $this->login('api');
        $task = factory(Task::class)->create();

        $user->assignRole('TaskManager');
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
    public function test_regular_user_cannot_edit_a_task()
    {
        $user = $this->login('api');

        $task = factory(Task::class)->create();
        $task->user_id = 1234;
        $task->save();
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

        $result = json_decode($response->getContent());

        $response->assertStatus(403);
    }

    public function test_superAdmin_can_browse_tasks()
    {
        $user = $this->login('api');
        $user->admin = true;
        $user->save();

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
    public function test_manager_can_browse_tasks()
    {
        initialize_roles();
        $user = $this->login('api');

        $user->assignRole('TaskManager');
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
    public function test_regular_user_cannot_browse_tasks()
    {
        $user = $this->login('api');

        $task = factory(Task::class)->create();
        $task->user_id = 1234;
        $task->save();

        $task1 = factory(Task::class)->create();
        $task2 = factory(Task::class)->create();
        $task3 = factory(Task::class)->create();


        $this->post('/api/v1/tasks/'.$task1);
        $this->post('/api/v1/tasks/'.$task2);
        $this->post('/api/v1/tasks/'.$task3);

        $response = $this->get('/api/v1/tasks');


        $result = json_decode($response->getContent());

        $response->assertStatus(403);


    }

    public function test_cannot_create_tasks_without_name()
    {
        $user = $this->login('api');
        $user->admin = true;
        $user->save();

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
        $user = $this->login('api');
        $user->admin = true;
        $user->save();
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
