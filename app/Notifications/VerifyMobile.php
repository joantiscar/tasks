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

    public $codi;

    public function __construct($codi)
    {
        $this->codi = $codi;
    }

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
        return (new NexmoMessage)
                    ->content('Ets lo puto amo. El teu codi es: ' . $this->codi . '. Verificat aqui: ' . env('APP_URL') . '/verificar_mobil   .');
    }

}
