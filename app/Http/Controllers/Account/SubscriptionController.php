<?php

namespace App\Http\Controllers\Account;

use App\Mail\AccountDowngraded;
use App\Plan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function getPlans()
    {
        return Plan::where('price', '>', 0)->get();
    }

    public function getSubscriptions(Request $request)
    {
        return $request->user()->subscriptions;
    }

    public function subscribeToPlan(Request $request, $planid)
    {
        $plan = Plan::findOrFail($planid);
        $stripeUser = $request->user()->createOrGetStripeCustomer();
        $user = Cashier::findBillable($stripeUser->id);

        if (! $user->hasPaymentMethod()) {
            return [
                'success' => false,
                'message' => 'You need to add a card to your billing section first.'
            ];
        }

        $subscription = $user->newSubscription('default', Str::snake($plan->title))
            ->create($user->defaultPaymentMethod()->id, [
                'email' => $user->email
            ]);

        $user->syncRoles('pro');

        return [
            'success' => true,
            'subscription' => $subscription->refresh(),
        ];
    }

    public function unsubscribeFromPlan(Request $request, $planid)
    {
        $plan = Plan::findOrFail($planid);
        $user = $request->user();

        $subscription = $user->subscription('default', Str::snake($plan->title))->cancel();

        $user->syncRoles('artist');

        Mail::to($user->email)->send(new AccountDowngraded($user));

        return [
            'success' => true,
            'subscription' => $subscription->refresh(),
        ];
    }

    public function resumeSubscription(Request $request, $planid)
    {
        $plan = Plan::findOrFail($planid);
        $user = $request->user();

        $subscription = $user->subscription('default', Str::snake($plan->title))->resume();

        $user->syncRoles('pro');

        return [
            'success' => true,
            'subscription' => $subscription->refresh(),
        ];
    }

    public function restartSubscription(Request $request, $planid)
    {
//        $plan = Plan::findOrFail($planid);
//        $user = $request->user();
//
//        $subscription = Subscription::findUserOnPlan($user->id, $plan->id)->first();
//
//        $subscription->restart();
//
//        return [
//            'success' => true,
//            'subscription' => $subscription->refresh(),
//        ];
    }
}
