<?php

namespace App\Listeners\Subscription;

use App\Events\Subscription\Resumed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\Subscription\ResumedUser as SubscriptionResumedUser;

/**
 * Class SendUserResumedNotification
 *
 * Send an email to a user when they have resumed a subscription, informing them of the resume
 *
 * @package App\Listeners\Subscription
 */
class SendUserResumedNotification
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
     * @param  Resumed  $event
     * @return void
     */
    public function handle(Resumed $event)
    {
        Mail::to($event->subscription->user)
            ->send(new SubscriptionResumedUser($event->subscription));
    }
}
