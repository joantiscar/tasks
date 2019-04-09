<?php

namespace App\Notifications;

use App\CodeGenerator\MobileCodesGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyMobile extends Notification
{
    use Queueable;


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['nexmo'];
    }

    public function toNexmo($notifiable)
    {

        $code = MobileCodesGenerator::generate();

        return (new NexmoMessage)
                    ->content('Ets lo puto amo. El teu codi es: ' . $code);
    }

}
