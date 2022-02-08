<?php

namespace App\Fakes;

class FakeCustomer
{
    private $_gateway;
    public $success = true;

    public function __construct($gateway)
    {
        $this->_gateway = $gateway;
    }

    public function create($attributes)
    {
        $customer = new \stdClass();
        $customer->success = true;
        $customer->customer = new \stdClass();
        $customer->customer->id = 1234;

        return $customer;
    }


}