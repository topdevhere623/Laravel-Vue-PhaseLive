<?php

namespace App\Mail\Subscription;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Subscription;

/**
 * Class CreatedUser
 *
 * Send an email to the user when they create a subscription
 *
 * @package App\Mail\Subscription
 */
class CreatedUser extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    /**
     * @param Subscription $subscription
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
        return $this->markdown('emails.user.subscription.created')
            ->subject('Your free trial of ' . $this->subscription->subscription_plan->name . ' has started!');
    }
}
