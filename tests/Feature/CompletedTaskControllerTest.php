<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompletedTaskControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */

    public function can_complete_a_task()
    {
        //1

        $user = factory(User::class)->create();
        $this->actingAs($user);
        $task= Task::create([
            'name' => 'comprar pa',
            'completed' => false
        ]);


        //2
        $response = $this->post('/completed_task/' . $task->id);

        //3 Dos opcions: 1) Comprovar les dades directament
        // 2) Comprovar canvis al objecte $task

        $task = $task->fresh();
        $response->assertStatus(200);
        $this->assertTrue((boolean)$task->completed);

    }

    public function test_can_uncomplete_a_task()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $task= Task::create([
            'name' => 'comprar pa',
            'completed' => true
        ]);


        //2
        $response = $this->delete('/completed_task/' . $task->id);

        //3 Dos opcions: 1) Comprovar les dades directament
        // 2) Comprovar canvis al objecte $task

        $task = $task->fresh();
        $response->assertStatus(200);
        $this->assertFalse((boolean)$task->completed);
    }








    public function test_cannot_uncomplete_a_unexisting_task()
    {
       //1 no cal fer res
        $user = factory(User::class)->create();
        $this->actingAs($user);
        //2
        $response=$this->delete('completed_task/1');
        //3 Assert



        $response->assertStatus(404);



}}

