<?php

namespace App\Traits;

use App\SubscriptionPlan;
use App\Subscription;

use App\Events\Subscription\Created as SubscriptionCreated;

/**
 * Trait CanSubscribe
 *
 * Applied to classes that have the ability to subscribe to a subscription plan
 *
 * @package App\Traits
 */
trait CanSubscribe
{
    /**
     * Check if the subscriber has a subscription to a plan and the end date is now or in the future
     *
     * @param $planID
     * @return Subscription
     */
    public function subscription($planID)
    {
        $plan = SubscriptionPlan::find($planID);
        return Subscription::findUserOnPlan($this->id, $plan->id)->first();
    }

    /**
     * Determine if a subscriber is actively subscribed to a plan
     *
     * @param $planID
     * @return bool
     */
    public function subscribed($planID)
    {
        $subscription = $this->subscription($planID);

        if($subscription) {
            return $subscription->active;
        } else {
            return false;
        }
    }

    /**
     * Subscribe to a new plan, or resume/restart an existing one
     *
     * @param $planID
     * @return Subscription
     */
    public function subscribeTo($planID)
    {
        // Check to see if the subscriber has or has ever subscribed to this plan already
        $subscription = $this->subscription($planID);

        if(!$subscription) { // subscriber has never subscribed to this plan before
            return $this->createNewSubscription($planID);
        }

        if($subscription->on_grace_period) {
            $subscription->resume();
        } elseif ($subscription->expired) {
            $subscription->restart();
        }

        return $subscription;
    }

    /**
     * Create a brand new subscription record
     *
     * @param $planID
     * @return Subscription
     */
    private function createNewSubscription($planID)
    {
        $end = startOfToday()->addMonth();
        $subscription = new Subscription([
            'user_id' => $this->id,
            'subscription_plan_id' => $planID,
            'trial_ends_at' => $end,
            'ends_at' => $end,
        ]);
        $subscription->save();
        $subscription->refresh();
        event(new SubscriptionCreated($subscription));
        return $subscription;
    }
}