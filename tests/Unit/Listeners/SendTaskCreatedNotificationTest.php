<?php

namespace Tests\Unit;

use App\DatabaseNotification;
use App\Listeners\SendTaskCreatedNotification;
use App\Notifications\SimpleNotification;
use App\Notifications\TaskCreated;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class DatabaseNotificationTest.
 *
 * @package Tests\Unit
 */
class SendTaskCreatedNotificationTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */

    public function test_send_task_created_notification()
    {
        $task = factory(Task::class)->create();
        $user = factory(User::class)->create();
        $event = new \App\Events\TaskCreated($task);
        $listener = new SendTaskCreatedNotification();

        Notification::fake();
        $listener->handle($event);
        Notification::assertSentTo(
          $user,
          TaskCreated::class,
          function ($notification, $channels) use ($task){
              return $notification->task->id = $task->id;
          }
        );

    }
}
