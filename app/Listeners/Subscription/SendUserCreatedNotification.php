<?php

namespace App\Listeners\Subscription;

use App\Events\Subscription\Created;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\Subscription\CreatedUser as SubscriptionCreatedUser;

/**
 * Class SendUserCreatedNotification
 *
 * Send an email to a user when they create a subscription informing them of the creation
 *
 * @package App\Listeners\Subscription
 */
class SendUserCreatedNotification
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
     * @param  Created  $event
     * @return void
     */
    public function handle(Created $event)
    {
        Mail::to($event->subscription->user)
            ->send(new SubscriptionCreatedUser($event->subscription));
    }
}
