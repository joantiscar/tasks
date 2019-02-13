<?php

namespace App\Listeners;

use App\Mail\TaskUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendMailTaskUpdated implements shouldQueue
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
        $subject = $event->newTask->subject();
        Mail::to($event->newTask->user)
            ->cc(config('tasks.manager_email'))
            ->send((new TaskUpdated($event->oldTask, $event->newTask))->subject($subject));
    }
}
