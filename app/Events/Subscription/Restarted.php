<?php

namespace App\Events\Subscription;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

use App\Subscription;

/**
 * Class Restarted
 *
 * When a user restarts a previously active subscription to a specific subscription plan.
 *
 * A plan is considered 'restarted' if the user re-subscribes to a plan that they were previously subscribed to, but
 * cancelled their subscription and the expiry date passed (grace period expired).
 *
 * @package App\Events\Subscription
 */
class Restarted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subscription;

    /**
     * Create a new event instance.
     *
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
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
