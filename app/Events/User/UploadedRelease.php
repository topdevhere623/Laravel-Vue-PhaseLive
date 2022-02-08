<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

use App\Release;

/**
 * Class UploadedRelease
 *
 * When a user uploads a new release
 *
 * @package App\Events\User
 */
class UploadedRelease
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $release;

    /**
     * Create a new event instance.
     *
     * @param Release $release
     */
    public function __construct(Release $release)
    {
        $this->release = $release;
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
