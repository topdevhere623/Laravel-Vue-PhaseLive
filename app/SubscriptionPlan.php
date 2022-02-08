<?php

namespace App;

/**
 * Class SubscriptionPlan
 *
 * Represents a subscription plan that a user can subscribe to.
 *
 * @package App
 */
class SubscriptionPlan extends PhaseModel
{
    protected $guarded = [];

    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }
}
