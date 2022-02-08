<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

use App\Video;

/**
 * Class UploadedVideo
 *
 * When a user uploads a new video
 *
 * @package App\Events\User
 */
class UploadedVideo
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $video;

    /**
     * Create a new event instance.
     *
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
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
