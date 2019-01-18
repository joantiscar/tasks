<?php

namespace Tests\Feature\Api;


use App\Events\TaskUncompleted;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class CompletedTaskControllerTest extends TestCase {
    use RefreshDatabase,CanLogin;

    /**
     * @test
     */
    public function can_complete_a_task()
    {
        $this->loginAsSuperAdmin('api');
        $task= Task::create([
            'name' => 'comprar pa',
            'completed' => false
        ]);
        $this->loginAsSuperAdmin('api');
        $response = $this->json('POST','/api/v1/completed_task/' . $task->id);
        $response->assertSuccessful();
        $task = $task->fresh();
        $this->assertEquals($task->completed, true);
    }

    /**
     * @test
     */
    public function cannot_complete_a_unexisting_task()
    {
        $this->login('api');
        $response = $this->json('POST','/api/v1/completed_task/1');
        //3 Assert
        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_uncomplete_a_task()
    {
//        Mail::fake();
        Event::fake();
        $this->withoutExceptionHandling();
        $user = $this->loginAsSuperAdmin('api');
        $task= Task::create([
            'name' => 'comprar pa',
            'completed' => true
        ]);
        //2
        $response = $this->json('DELETE','/api/v1/completed_task/' . $task->id);
        $response->assertSuccessful();
        $task = $task->fresh();
        $this->assertEquals((boolean) $task->completed, false);

//        Event::assertDispatched(TaskUncompleted::class, function ($e) use ($task) {
//            return $e->task->is($task);
//        });


//        $this->assertDatabaseHas('logs', [
//        'text' => "S'ha marcat com a pendent la tasca 'comprar pa'",
//        'action_type' => 'descompletar',
//        'module_type' => 'Tasques',
//        'user_id' => $user->id,
//        'old_value' => json_encode(true),
//        'new_value' => json_encode(false),
//        'loggable_id' => $task->id,
//        'loggable_type'=> Task::class,
//        'icon' => 'lock_open',
//        'color' => 'primary'
//    ]);
//        Mail::assertSent(TaskUncompleted::class, function ($mail) use ($task, $user) {
//            return $mail->task->is($task) &&
//                    $mail->hasTo($user->email) &&
//                  $mail->hasCc(config('tasks.manager_email'));
////            'taskmanager@miempresa.com'
//        });
    }

    /**
     * @test
     */
    public function cannot_uncomplete_a_unexisting_task()
    {
        $this->login('api');
        $response= $this->delete('/api/v1/completed_task/1');
        $response->assertStatus(404);
    }
}
