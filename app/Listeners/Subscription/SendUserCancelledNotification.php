<?php

namespace App\Listeners\Subscription;

use App\Events\Subscription\Cancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\Subscription\CancelledUser as SubscriptionCancelledUser;

/**
 * Class SendUserCancelledNotification
 *
 * Send an email to a user when they cancel a subscription informing them of the cancellation
 *
 * @package App\Listeners\Subscription
 */
class SendUserCancelledNotification
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
     * @param  Cancelled  $event
     * @return void
     */
    public function handle(Cancelled $event)
    {
        Mail::to($event->subscription->user)
            ->send(new SubscriptionCancelledUser($event->subscription));
    }
}
