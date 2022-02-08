<?php

namespace App\Listeners\Subscription;

use App\Events\Subscription\PaymentFailed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\Subscription\PaymentFailure as SubscriptionPaymentFailure;

/**
 * Class SendUserPaymentFailureNotification
 *
 * Send an email to a user when a charge has been attempted on them to renew a subscription but has failed
 *
 * @package App\Listeners\Subscription
 */
class SendUserPaymentFailureNotification
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
     * @param  PaymentFailed  $event
     * @return void
     */
    public function handle(PaymentFailed $event)
    {
        Mail::to($event->subscription->user)
            ->send(new SubscriptionPaymentFailure($event->subscription));
    }
}
