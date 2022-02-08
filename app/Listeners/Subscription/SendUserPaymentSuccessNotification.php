<?php

namespace App\Listeners\Subscription;

use App\Events\Subscription\PaymentSucceeded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\Subscription\PaymentSuccess as SubscriptionPaymentSuccess;

/**
 * Class SendUserPaymentSuccessNotification
 *
 * Send an email to a user when a charge has been attempted on them to renew a subscription and has succeeded
 *
 * @package App\Listeners\Subscription
 */
class SendUserPaymentSuccessNotification
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
     * @param  PaymentSucceeded  $event
     * @return void
     */
    public function handle(PaymentSucceeded $event)
    {
        Mail::to($event->subscription->user)
            ->send(new SubscriptionPaymentSuccess($event->subscription));
    }
}
