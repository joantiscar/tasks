<?php

namespace App\Listeners;

use App\Events\LogCreated;
use App\Log;
use App\Task;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogTaskCompleted implements shouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // Creat per lo de La Sénia
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $log = Log::create([
            'text' => "S'ha marcat com a completada la tasca '" . $event->task->name ."'",
            'time' =>  Carbon::now(),
            'action_type' => 'completar',
            'module_type' => 'Tasques',
            'icon' => 'lock_open',
            'color' => 'primary',
            'user_id' => $event->task['user_id'],
            'loggable_id' => $event->task->id,
            'loggable_type' => Task::class,
            'new_value' => json_encode(true),
            'old_value' => json_encode(false),

        ]);
        event(new LogCreated($log));

    }
}
