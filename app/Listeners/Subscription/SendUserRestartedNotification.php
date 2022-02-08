<?php

namespace App\Listeners\Subscription;

use App\Events\Subscription\Restarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\Subscription\RestartedUser as SubscriptionRestartedUser;

/**
 * Class SendUserRestartedNotification
 *
 * Send an email to a user when they have restarted a subscription, informing them of the restart
 *
 * @package App\Listeners\Subscription
 */
class SendUserRestartedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Restarted  $event
     * @return void
     */
    public function handle(Restarted $event)
    {
        Mail::to($event->subscription->user)
            ->send(new SubscriptionRestartedUser($event->subscription));
    }
}
