<?php

use App\Mail\TaskCompleted;
use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ForgetTasksCacheController extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function test_cache_has_ben_forgotten_after_task_created()
    {
        // 1 Preparar
        $user = factory(User::class)->create();
        $task = Task::create([
          'name'    => 'Comprar pa',
          'user_id' => $user->id,
        ]);

        // Executar
        //        event(new TaskUncompleted($task));

        $listener = new \App\Listeners\ForgetTasksCache();
        Cache::shouldReceive('forget')->once()->with(Task::TASKS_CACHE_KEY);
        $listener->handle(new \App\Events\TaskCreated($task));
        // 3 ASSERT

    }
}
