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
    public function can_index_tags()
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

}
