<?php

namespace App\Traits\Marketplace;

use Stripe\Account as StripeAccount;

trait Account
{
    public function getAccount()
    {
        if (! $this->accountId()) return;

        return StripeAccount::retrieve($this->accountId(), $this->stripeOptions());
    }

    public function createAccount($data)
    {
        $account = StripeAccount::create([
            'country' => 'GB',
            'type' => 'custom',
            'requested_capabilities' => ['card_payments', 'transfers'],
            'account_token' => $data['account_token'],
            'email' => $this->email,
            'metadata' => [
                'internal_id' => $this->id
            ],
            'business_profile' => [
                'mcc' => 5815,
                'url' => isset($data['website']) ? $data['website'] : 'https://phase.com',
            ],
        ], $this->stripeOptions());

        $this->stripe_account_id = $account->id;
        $this->save();

        return $account;
    }

    public function updateAccount($data)
    {
        return StripeAccount::update($this->accountId(), [
            'account_token' => $data['account_token'],
            'business_profile' => $data['business_profile']
        ], $this->stripeOptions());
    }
}
