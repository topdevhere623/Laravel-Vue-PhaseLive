<?php

namespace App\Http\Controllers\Account;

use Carbon\Carbon;
use Stripe\PaymentMethod;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        $user->updateDefaultPaymentMethod($request->payment_method);

        if (!$user->subscribedToPlan('artist_pro', 'default') && $user->roles->first()->name !== 'standard') {
            $user->newSubscription('default', 'artist_pro')
                ->trialUntil(Carbon::parse($user->trial_ends_at))
                ->create(
                    $request->payment_method, [
                        'email' => $user->email,
                    ]
                );
        }

        return [
            'user' => $user,
            'card' => $user->defaultPaymentMethod(),
        ];
    }

        public function getPaymentMethod()
        {
            if (Auth::user()->defaultPaymentMethod()) {
                $paymentMethod = PaymentMethod::retrieve(
                    Auth::user()->defaultPaymentMethod()->id,
                    Cashier::stripeOptions()
                );
            }

            return [
                'payment_method' => $paymentMethod ?? null
            ];
        }
}
