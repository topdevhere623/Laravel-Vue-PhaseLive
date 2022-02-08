<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

/**
 * Class SharedItem
 *
 * When a user 'shares' an item to their profile/followers
 *
 * @package App\Events\User
 */
class SharedItem
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $share;

    /**
     * Create a new event instance.
     *
     * @param $share
     */
    public function __construct($share)
    {
        $this->share = $share;
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
