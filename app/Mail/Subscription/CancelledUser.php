<?php

namespace App\Mail\Subscription;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Subscription;

/**
 * Class CancelledUser
 *
 * Send an email to the user when they cancel a subscription
 *
 * @package App\Mail\Subscription
 */
class CancelledUser extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.subscription.cancelled')
            ->subject('Your subscription to ' . $this->subscription->subscription_plan->name . ' has been cancelled');
    }
}
