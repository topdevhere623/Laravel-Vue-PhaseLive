<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    function getClientSecret()
    {
        return [
            'intent' => Auth::user()->createSetupIntent()
        ];
    }

    public function store(Request $request)
    {
        if (!$this->checkDatesStillAvailable()) {
            return ['The dates you selected are no longer available.'];
        }

        $result = $this->gateway->transaction()->sale([
            'amount' => $this->getAmount($request),
            'paymentMethodNone' => $request->nonce,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);

        if ($result->success) {
            return ['Payment successful'];
        } else {
            return ['error'];
        }
    }

    protected function getAmount($request)
    {
        $pricePerSlot = setting('featured_spot_price');
        $dates = $request->dates;
    }

    protected function checkDatesStillAvailable()
    {
    }
}
