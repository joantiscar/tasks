<?php

namespace App\Listeners;

use App\Notifications\LogCreated;
use App\Log;
use Illuminate\Support\Facades\Log as Loog;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLogCreatedNotification
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Loog::debug($event->log->user_id);
        Loog::debug(User::find($event->log->user_id));
        $user = User::find($event->log->user_id);
        $user->notify(new LogCreated($event->log));
    }
}
