<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

/**
 * Class FollowedUser
 *
 * When a user follows another user
 *
 * @package App\Events\User
 */
class FollowedUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $follower, $followed;

    /**
     * Create a new event instance.
     *
     * @param $follower
     * @param $followed
     */
    public function __construct($follower, $followed)
    {
        $this->follower = $follower;
        $this->followed = $followed;
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
