<?php

use App\Events\TaskUncompleted;
use App\Listeners\LogTaskUncompleted;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogTaskUncompletedTest extends TestCase
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
          'completed' => true,
          'user_id'   => 1,
        ]);
        //2
        event(new TaskUncompleted($task));
        $listener = new LogTaskUncompleted();
        $listener->handle(new TaskUncompleted($task));

        $this->assertDatabaseHas('logs', [
          'text'          => "S'ha marcat com a pendent la tasca 'comprar pa'",
          'action_type'   => 'descompletar',
          'module_type'   => 'Tasques',
          'user_id'       => $user->id,
          'old_value'     => json_encode(true),
          'new_value'     => json_encode(false),
          'loggable_id'   => $task->id,
          'loggable_type' => Task::class,
          'icon'          => 'lock_open',
          'color'         => 'primary',
        ]);
    }
}
