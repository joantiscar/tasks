<?php

namespace App\Notifications;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class TaskCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @param \App\Task $task
     */
    public function __construct(Task $task, $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', WebPushChannel::class];
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
    public function toArray($notifiable)
    {
        return [
          'title' => "La tasca" . $this->task->name . "ha estat completada!",
          'body' => 'Fes click per a anar a la tasca.',
          'action_url' => env('APP_URL') . '/tasks/' . $this->task->id,
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
          ->title("La tasca " . $this->task->name . "ha estat completada!")
          ->body('Fes click per a anar a la tasca.')
          ->action('View app', env('APP_URL') . '/tasks/' . $this->task->id);
    }
}
