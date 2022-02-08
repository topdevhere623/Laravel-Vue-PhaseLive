<?php

namespace App\Traits;

use Laravel\Cashier\Payment;
use App\Traits\Marketplace\Files;
use App\Traits\Marketplace\Account;
use App\Traits\Marketplace\BankAccounts;
use Laravel\Cashier\Billable as CashierBillable;
use Stripe\PaymentIntent as StripePaymentIntent;

trait Marketplace
{
    use CashierBillable, Account, BankAccounts, Files;

//    public function charge($amount, $paymentMethod, array $options = [])
//    {
//        $options = array_merge([
//            'confirmation_method' => 'automatic',
//            'confirm' => true,
//            'currency' => $this->preferredCurrency(),
//        ], $options);
//
//        $options['amount'] = $amount;
//        $options['payment_method'] = $paymentMethod;
//
//        if ($this->stripe_id) {
//            $options['customer'] = $this->stripe_id;
//        }
//
//        $payment = new Payment(
//            StripePaymentIntent::create($options, $this->stripeOptions())
//        );
//
//        $payment->validate();
//
//        return $payment;
//    }

    protected function accountId()
    {
        return $this->stripe_account_id;
    }
}
