<?php

namespace App\Listeners;

use App\Mail\TaskDeleted;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendMailTaskDeleted implements ShouldQueue
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
        $user = User::find($event->task['user_id']);
        Mail::to($user)
            ->cc(config('tasks.manager_email'))
            ->send((new TaskDeleted($event->task))->subject("Tasca " . $event->task['name'] . "esborrada"));
    }
}
