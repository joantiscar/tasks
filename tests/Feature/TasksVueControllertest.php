<?php
/**
 * Created by PhpStorm.
 * User: dios
 * Date: 9/10/18
 * Time: 20:40
 */

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksVueControllertest extends TestCase
{

    use RefreshDatabase;

    public function test_can_show_vue_tasks()
    {
        // 1 PREPARE
        $this->withExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        create_example_tasks();

        // 2 EXECUTE

        $response = $this->get('/tasks_vue');

        // 3 ASSERT

        $response->assertSuccessful();

        $response->assertViewIs('tasks_vue');

        $response->assertViewHas('tasks');

        $response->assertViewHas('tasks', []);

        //        $response->assertSee('Comprar llet');
        //        $response->assertSee('Comprar pa');
        //        $response->assertSee('Estudiar PHP');
    }
}
