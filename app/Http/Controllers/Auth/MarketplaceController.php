<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketplaceController extends Controller
{
    public function store(Request $request)
    {
        $user = User::find($request->user_id);

        $user->createAccount($request);

        return $user;
    }

    public function update(Request $request)
    {
        $user = User::find($request->user_id);

        $user->updateAccount([
            'account_token' => $request->token,
            'business_profile' => $request->business_profile,
        ]);

        return $user;
    }
}
