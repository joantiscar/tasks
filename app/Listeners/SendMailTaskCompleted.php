<?php
/**
 * Created by PhpStorm.
 * User: dios
 * Date: 21/01/19
 * Time: 20:06
 */

namespace App\Listeners;


use App\Mail\TaskCompleted;
use Illuminate\Support\Facades\Mail;

class SendMailTaskCompleted
{

    /**
     * SendMailTaskCompleted constructor.
     */
    public function handle($event)
    {
        $subject = $event->task->subject();
        Mail::to($event->task->user)
            ->cc(config('tasks.manager_email'))
            ->send((new TaskCompleted($event->task))->subject($subject));
    }
}
