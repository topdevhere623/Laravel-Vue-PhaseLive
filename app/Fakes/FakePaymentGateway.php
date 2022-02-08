<?php

namespace App\Fakes;

class FakePaymentGateway
{
    public function customer()
    {
        return new FakeCustomer($this);
    }
}