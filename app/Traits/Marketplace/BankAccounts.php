<?php

namespace App\Traits\Marketplace;

use Stripe\Account as StripeAccount;

trait BankAccounts
{
    public function createBankAccount($token)
    {
        return StripeAccount::createExternalAccount(
            $this->accountId(), [
                'external_account' => $token
            ],
            $this->stripeOptions()
        );
    }

    public function updateBankAccount($id, $data = [])
    {
        return StripeAccount::updateExternalAccount(
            $this->accountId(),
            $id,
            $data,
            $this->stripeOptions()
        );
    }

    public function removeBankAccount($id)
    {
        return StripeAccount::deleteExternalAccount(
            $this->accountId(),
            $id,
            null,
            $this->stripeOptions()
        );
    }

    public function retrieveBankAccount($id)
    {
        return StripeAccount::retrieveExternalAccount(
            $this->accountId(),
            $id,
            null,
            $this->stripeOptions()
        );
    }

    public function listBankAccounts()
    {
        if (!$this->accountId()) return;

        return StripeAccount::allExternalAccounts($this->accountId(), null, $this->stripeOptions());
    }
}
