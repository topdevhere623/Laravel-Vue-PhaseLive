<?php

namespace App\Http\Controllers;

use App\User;
use Laravel\Cashier\Cashier;
use Illuminate\Http\Request;
use Stripe\PaymentIntent as StripePaymentIntent;
use Stripe\SetupIntent;

class ProcessPaymentController extends Controller
{
    public function paymentIntent(Request $request)
    {
        $total = collect($request->items)->sum(function ($item) {
            return ($item['price'] * 0.2) + $item['price'];
        });

        return StripePaymentIntent::create([
            'amount' => ceil($total),
            'currency' => 'gbp',
            'payment_method_types' => ['card'],
            'transfer_group' => "Order-{$request->order_id}",
            'metadata' => [
                'integration_check' => 'accept_a_payment',
                'order_id' => $request->order_id
            ],
        ], Cashier::stripeOptions())->client_secret;
    }

    public function featuredPaymentIntent(Request $request)
    {
//        $total = ($request->items * (int) setting('featured_spot_price')) * 100;
        $user = User::find($request->user_id);
//
//        $user->featuredOrders()->create([
//            'amount' => $total,
//        ]);

        return SetupIntent::create([
            'customer' => $user->stripe_id,
        ], Cashier::stripeOptions())->client_secret;
//        return StripePaymentIntent::create([
//            'amount' => ceil($total),
//            'currency' => 'gbp',
//        ], Cashier::stripeOptions())->client_secret;
    }
}
