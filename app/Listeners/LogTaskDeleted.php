<?php

namespace App\Listeners;

use App\Events\LogCreated;
use App\Log;
use App\Task;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogTaskDeleted implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
            'text' => "S'ha borrat la tasca '" . $event->task['name'] ."'",
            'time' =>  Carbon::now(),
            'action_type' => 'borrar',
            'module_type' => 'Tasques',
            'icon' => 'lock_open',
            'color' => 'primary',
            'user_id' => $event->task['user_id'],
            'loggable_id' => $event->task['id'],
            'loggable_type' => Task::class,
            'old_value' => json_encode($event->task)
        ]);
        event(new LogCreated($log));

    }
}
