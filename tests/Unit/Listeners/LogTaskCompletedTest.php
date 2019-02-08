<?php

use App\Events\TaskCompleted;
use App\Listeners\LogTaskCompleted;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogTaskCompletedTest extends TestCase
{

    use RefreshDatabase, \Tests\Feature\Traits\CanLogin;

    /**
     * @test
     */
    public function a_log_has_been_created()
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAsSuperAdmin('api');
        $task = Task::create([
          'name'      => 'comprar pa',
          'completed' => false,
          'user_id'   => 1,
        ]);
        //2
        event(new TaskCompleted($task));
        $listener = new LogTaskCompleted();
        $listener->handle(new TaskCompleted($task));

        $this->assertDatabaseHas('logs', [
          'text'          => "S'ha marcat com a completada la tasca 'comprar pa'",
          'action_type'   => 'completar',
          'module_type'   => 'Tasques',
          'user_id'       => $user->id,
          'old_value'     => json_encode(false),
          'new_value'     => json_encode(true),
          'loggable_id'   => $task->id,
          'loggable_type' => Task::class,
          'icon'          => 'lock_open',
          'color'         => 'primary',
        ]);
    }
}
