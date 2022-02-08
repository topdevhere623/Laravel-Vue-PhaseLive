<?php

namespace App\Listeners;

use App\Events\SettleFeaturedDateOrderEvent;
use App\Mail\FeaturedOrderPaymentFailedMail;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Cashier;
use Stripe\Exception\CardException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;

class PayFeaturedDateOrderListener
{
    public function __construct()
    {
        //
    }

    public function handle(SettleFeaturedDateOrderEvent $event)
    {
        $stripeOptions = Cashier::stripeOptions();
        $order = $event->order;
        $customer = $order->user;

        $paymentID = PaymentMethod::retrieve($order->payment_id, $stripeOptions)->id;

        try {
            $payment = PaymentIntent::create([
                'amount' => $order->amount,
                'currency' => 'gbp',
                'customer' => $customer->stripe_id,
                'payment_method' => $paymentID,
                'off_session' => true,
                'confirm' => true,
            ], $stripeOptions);

            if ($payment->status === 'succeeded') {
                $event->order->featuredDates->each->approve();
            }
        } catch (CardException $e) {
            Mail::to($customer->email)->send(new FeaturedOrderPaymentFailedMail($order, $e));
        }
    }
}
