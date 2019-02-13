<?php

namespace App\Events;

use App\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $newTask;
    public $oldTask;


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               // Creat per lo de La Sénia
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $oldTask, Task $newTask)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   // Creat per lo de La Sénia
    {
        $this->oldTask = $oldTask;
        $this->newTask = $newTask;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
