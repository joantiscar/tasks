<?php

namespace App\Notifications;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class TaskCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    /**
     * Create a new notification instance.
     *
     * @param \App\Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
          ->line('The introduction to the notification.')
          ->action('Notification Action', url('/'))
          ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
          'title' => 'S\'ha creat una nova tasca: ' . $this->task->name,
            'url' => '/tasks/' . $this->task->id,
            'icon' => 'build',
            'iconColor' => 'accent',

        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
          ->title("La tasca " . $this->task->name . "ha estat creada!")
          ->body('Fes click per a anar a la tasca.')
          ->action('Obrir tasca', 'open_url')
          ->data([
            'url' => env('APP_URL') . '/tasques/' . $this->task->id
          ]);
    }
}
