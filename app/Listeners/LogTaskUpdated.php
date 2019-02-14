<?php

namespace App\Listeners;

use App\Log;
use App\Task;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogTaskUpdated implements shouldQueue
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
        Log::create([
            'text' => "S'ha editat la tasca '" . $event->oldTask['name'] ."'",
            'time' =>  Carbon::now(),
            'action_type' => 'editar',
            'module_type' => 'Tasques',
            'icon' => 'lock_open',
            'color' => 'primary',
            'user_id' => $event->newTask->user->id,
            'loggable_id' => $event->newTask->id,
            'loggable_type' => Task::class,
            'new_value' => json_encode($event->newTask->mapSimple()),
            'old_value' => json_encode($event->oldTask)
        ]);
    }
}
