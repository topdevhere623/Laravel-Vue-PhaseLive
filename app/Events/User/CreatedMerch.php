<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

use App\Merch;

class CreatedMerch
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $merch;

    /**
     * Create a new event instance.
     *
     * @param Merch $merch
     */
    public function __construct(Merch $merch)
    {
        $this->merch = $merch;
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
