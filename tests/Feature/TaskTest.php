<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function todo()
    {

        $this->login();
        $this->withExceptionHandling();

        Task::create([

            'name'=>'comprar pa',
            'completed'=>false
        ]);
        Task::create([

            'name'=>'Estudiar PHP',
            'completed'=>false
        ]);
        Task::create([

            'name'=>'comprar llet',
            'completed'=>false
        ]);



        $response = $this->get('/tasks');


//        dd($response);
        $response->assertSuccessful();
        $response->assertSee('comprar pa');
        $response->assertSee('comprar llet');
        $response->assertSee('Estudiar PHP');


        //comprovar que es veuen les tasques que hi ha a la base de dades
    }


    public function test_cannot_delete_an_unexisting_task()
    {

        $user = factory(User::class)->create();
                $this->actingAs($user);
        $this->withExceptionHandling();


        $response = $this->delete('/tasks/1');

        $response->assertStatus(404);
//        $response->assertSuccessful();
//
//        $this->assertDatabaseMissing('tasks',['name' => 'Comprar llet']);
    }
    public function test_can_delete_task()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->withExceptionHandling();

        $task = Task::create([
            'name' => 'Comprar llet'
        ]);



        $response = $this->delete('/tasks/' . $task->id);

        $response->assertStatus(302);
//        $response->assertSuccessful();
//
    $this->assertDatabaseMissing('tasks',['name' => 'Comprar llet']);
    }

    public function test_cannot_edit_an_unexisting_task()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        //TDD TasksVueControllertest Driven Development ->

        //$this->withExceptionHandling();
        //2
        $response = $this->put('/tasks/1',[]);
        $response->assertStatus(404);

    }

    public function can_edit_a_task()
    {
        //1
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $task = Task::create([
            'name' => 'Comprar lejia',
            'completed' => false
        ]);
        //2
        $response = $this->put('/tasks/' . $task->id,$newTask = [
            'name' => 'Comprar pa',
            'completed' => true
        ]);
//        $response->assertSuccessful();

        // 2 opcions
//        $this->assertDatabaseHas('tasks',$newTask);
//        $this->assertDatabaseMissing('tasks',$task);

        $task = $task->fresh();
        $this->assertEquals($newTask->name,'Comprar pa');
        $this->assertEquals($newTask->completed, true);
    }

    public function test_can_show_edit_form()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);
    $task = task::create([
        'name' => 'Comprar pa',
        'completed' => false
    ]);
    $response = $this->get('/tasks_edit/' . $task->id);
    $response->assertSuccessful();

    $response->assertSee('Comprar pa');


    }
    public function cannot_show_edit_form()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->withExceptionHandling();
        $task = task::create([
            'name' => 'Comprar pa',
            'completed' => false
        ]);
        $response = $this->get('/tasks_edit/' . $task->id);



    }

    public function login(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
    }

    public function test_map()
    {

        $task = Task::create([
            'name' => 'Comprar pa',
            'completed' => false,
            'user_id' => $user->id
        ]);

        $mappedTask = $task->map();

        $this->assertEquals($mappedTask['id'], $user->id);




    }
}
