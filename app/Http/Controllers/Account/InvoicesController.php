<?php

namespace App\Http\Controllers\Account;

use Stripe\Invoice as StripeInvoices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    public function index()
    {
        return StripeInvoices::all([
            'customer' => Auth::user()->stripe_id,
            'subscription' => optional(Auth::user()->subscription())->stripe_id
        ], Auth::user()->stripeOptions());
    }
}
