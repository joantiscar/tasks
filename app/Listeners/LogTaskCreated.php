<?php

namespace App\Listeners;

use App\Log;
use App\Task;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogTaskCreated implements shouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //                                                                                                                                                                                                                                                                                                                                     Fet per lo de La Sénia
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
            'text' => "S'ha creat la tasca '" . $event->task->name ."'",
            'time' =>  Carbon::now(),
            'action_type' => 'crear',
            'module_type' => 'Tasques',
            'icon' => 'lock_open',
            'color' => 'primary',
            'user_id' => $event->task->id,
            'loggable_id' => $event->task->id,
            'loggable_type' => Task::class,
            'new_value' => json_encode($event->task->mapSimple())
        ]);
    }
}
