<?php

namespace App\Listeners;

use App\Log;
use App\Task;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class ForgetTasksCache implements shouldQueue
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
        Cache::forget(Task::TASKS_CACHE_KEY);
    }
}
