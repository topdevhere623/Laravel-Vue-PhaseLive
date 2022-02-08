<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

use App\Asset;

/**
 * Class UpdatedAvatar
 *
 * When a user uploads a new avatar
 *
 * @package App\Events\User
 */
class UpdatedAvatar
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $avatar_asset;

    /**
     * Create a new event instance.
     *
     * @param Asset $avatar_asset
     */
    public function __construct(Asset $avatar_asset)
    {
        $this->avatar_asset = $avatar_asset;
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
