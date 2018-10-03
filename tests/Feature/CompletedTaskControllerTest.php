<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompletedTaskControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */

    public function can_complete_a_task()
    {
        //1
        $task= Task::create([
            'name' => 'comprar pa',
            'completed' => false
        ]);


        //2
        $this->post('/completed_task/' . $task->id);

        //3 Dos opcions: 1) Comprovar les dades directament
        // 2) Comprovar canvis al objecte $task

        $task = $task->fresh();
        $this->assertStatus(404);

    }

    public function test_can_uncomplete_a_task()
    {
        //1
        $task= Task::create([
            'name' => 'comprar pa',
            'completed' => false
        ]);


        //2
        $this->delete('/completed_task/' . $task->id);

        //3 Dos opcions: 1) Comprovar les dades directament
        // 2) Comprovar canvis al objecte $task

        $task = $task->fresh();
        $this->assertEquals($task->completed, false);
    }








    public function test_cannot_uncomplete_a_unexisting_task()
    {
       //1 no cal fer res
        //2
        $response=$this->delete('completed_task/1');
        //3 Assert
        $response->assertStatus(404);
}
