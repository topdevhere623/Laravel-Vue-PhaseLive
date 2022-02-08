<?php

namespace App;

use App\Events\Subscription\PaymentSucceeded as SubscriptionPaymentSucceeded;
use App\Events\Subscription\PaymentFailed as SubscriptionPaymentFailed;
use App\Events\Subscription\Cancelled as SubscriptionCancelled;
use App\Events\Subscription\Resumed as SubscriptionResumed;
use App\Events\Subscription\Restarted as SubscriptionRestarted;

/**
 * Class Subscription
 *
 * Represents a single users subscription to a single subscription plan
 *
 * @package App
 */
class Subscription extends PhaseModel
{
    protected $guarded = [];

    protected $with = ['subscription_plan'];

    protected $appends = ['active', 'expired', 'on_grace_period', 'on_trial'];

    protected $dates = [
        'created_at',
        'updated_at',
        'trial_ends_at',
        'ends_at',
    ];

    public function subscription_plan()
    {
        return $this->belongsTo('App\SubscriptionPlan');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeFindUserOnPlan($query, $userID, $planID)
    {
        return $query->where('user_id', $userID)->where('subscription_plan_id', $planID);
    }

    public function getActiveAttribute()
    {
        return $this->ends_at > now();
    }

    public function getExpiredAttribute()
    {
        return ($this->ends_at <= now());
    }

    public function getOnGracePeriodAttribute()
    {
        return ($this->renew == false && $this->ends_at > now());
    }

    public function getOnTrialAttribute()
    {
        return ($this->trial_ends_at > now());
    }

    /**
     * Sets a subscription to not renew. User will stay subscribed until end date passes
     *
     * @return $this
     */
    public function cancel()
    {
        $this->renew = false;
        $this->save();

        event(new SubscriptionCancelled($this));

        return $this;
    }

    /**
     * Resumes a subscription on its original billing cycle if it has been cancelled but the end date has not yet passed
     *
     * @return $this
     */
    public function resume()
    {
        // We can only resume subscriptions which have not ended yet (not passed end date), otherwise they must be
        // restarted
        if($this->ends_at > now()) {
            $this->renew = true;
            $this->save();
            event(new SubscriptionResumed($this));
        }

        return $this;
    }

    /**
     * Restarts a subscription on a new billing cycle starting now
     *
     * @return $this
     */
    public function restart()
    {
        // We can only restart subscriptions which have properly ended (passed end date), otherwise they must be resumed
        if($this->ends_at <= now()) {
            $this->charge();
            $this->ends_at = startOfToday()->addMonth();
            $this->renew = true;
            $this->save();
            event(new SubscriptionRestarted($this));
        }
        return $this;
    }

    /**
     * Attempt to immediately charge the user to renew for a month
     *
     * @return $this
     */
    public function renewSubscription()
    {
        $this->renew = true;
        $this->save();

        $this->charge();

        return $this;
    }

    /**
     * Update the ends_at column to the date $months months **after the current ends_at date**
     *
     * @param int $months
     * @return $this
     */
    public function extendByMonths($months = 1)
    {
        $this->ends_at = $this->ends_at->addMonths($months);
        $this->save();

        return $this;
    }

    ///////////////////////////////////////////////// PRIVATE METHODS //////////////////////////////////////////////////

    /**
     * Decide how to charge the subscriber.
     *
     * @return \Exception|\Stripe\ApiResource
     */
    private function charge()
    {
        switch ($this->user->payment_method) {
            case 'card':
                return $this->stripeCharge();
                break;
            case 'paypal':
                return $this->paypalCharge();
                break;
        }
    }

    /**
     * Charge the subscriber using Stripe.
     *
     * @return \Exception|\Stripe\ApiResource
     */
    private function stripeCharge()
    {
        $customer = \Stripe\Customer::retrieve($this->user->stripe);
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $this->subscription_plan->monthly_cost,
                "currency" => "gbp",
                "customer" => $customer->id,
                "description" => 'Phase subscription renewal'
            ));
            $this->paymentSucceeded();
            return $charge;
        } catch (\Exception $e) {
            $this->paymentFailed();
            return $e;
        }
    }

    /**
     * Charge the subscriber using Paypal.
     *
     * @return mixed
     */
    private function paypalCharge()
    {
        $gateway = resolve(\Braintree\Gateway::class);
        $customer = $gateway->customer()->find($this->user->braintree);

        if(!count($customer->paymentMethods)) {
            // Error, no payment methods available on Braintree
            $paymentMethod = null;
            return $this->paymentFailed();
        } else {
            $paymentMethod = $customer->paymentMethods[0];
        }
        $result = $gateway->transaction()->sale([
            'amount' => ($this->subscription_plan->monthly_cost / 100),
            'paymentMethodToken' => $paymentMethod->token,
            'recurring' => true,
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);
        if($result->success) {
            $this->paymentSucceeded();
        } else {
            $this->paymentFailed();
        }
        return $result;
    }

    private function paymentSucceeded()
    {
        $this->extendByMonths(1);
        $this->setRolesSuccess();
        event(new SubscriptionPaymentSucceeded($this));
    }

    private function paymentFailed()
    {
        $this->renew = false;
        $this->save();
        $this->setRolesFailure();
        event(new SubscriptionPaymentFailed($this));
    }

    private function setRolesSuccess()
    {
        if(!$this->user->hasRole('pro')) {
            $this->user->assignRole('pro');
        }
        $this->user->removeRole('artist');
    }

    private function setRolesFailure()
    {
        if(!$this->user->hasRole('artist')) {
            $this->user->assignRole('artist');
        }
        $this->user->removeRole('pro');
    }
}
