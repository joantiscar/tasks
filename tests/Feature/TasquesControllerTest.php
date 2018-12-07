<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasquesControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function todo()
    {

        $this->loginAsSuperAdmin();
        $this->withoutExceptionHandling();

        $task1 = factory(Task::class)->create();
        $task2 = factory(Task::class)->create();
        $task3 = factory(Task::class)->create();


        $response = $this->get('/tasks');


//        dd($response);
        $response->assertSuccessful();
        $response->assertSee($task1->name);
        $response->assertSee($task2->name);
        $response->assertSee($task3->name);


        //comprovar que es veuen les tasques que hi ha a la base de dades
    }


    public function test_cannot_delete_an_unexisting_task()
    {
        $this->login();
        $user = factory(User::class)->create();
                $this->actingAs($user);
        $this->withExceptionHandling();


        $response = $this->delete('/tasks/1');

        $response->assertStatus(403);
//        $response->assertSuccessful();
//
//        $this->assertDatabaseMissing('tasks',['name' => 'Comprar llet']);
    }
    public function test_can_delete_task()
    {

        $this->loginAsSuperAdmin();
        $this->withExceptionHandling();

        $task = Task::create([
            'name' => 'Comprar pa',
            'completed' => false,
            'user_id' => 1
        ]);

        $response = $this->delete('/tasks/' . $task->id);

        $response->assertStatus(302);
//        $response->assertSuccessful();
//
    $this->assertDatabaseMissing('tasks',['name' => 'Comprar pa']);
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
        $this->login();
        $task = Task::create([
            'name' => 'Comprar pa',
            'completed' => false,
            'user_id' => Auth::user()->id
        ]);

        $mappedTask = $task->map();

        $this->assertEquals($mappedTask['id'], Auth::user()->id);




    }
}
