<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\SetupIntent;

class CreateSetupIntent
{
    public function __invoke(Request $request)
    {
        $user = User::find($request->user_id);

        return SetupIntent::create([
            'customer' => $user->stripe_id,
        ], Cashier::stripeOptions());
    }
}
