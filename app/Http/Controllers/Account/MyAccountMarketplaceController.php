<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyAccountMarketplaceController extends Controller
{
    public function account()
    {
        $account = Auth::user()->getAccount();

        if ($account) {
            $requirements = collect($account->requirements->currently_due)
                ->mapToGroups(function ($item) {
                    $string = Str::replaceFirst('.', ' ', $item);
                    $parts = collect(explode(' ', $string));

                    return [
                        $parts->first() => $parts->slice(1)
                            ->mapToGroups(function ($item) {
                                $parts = collect(explode('.', $item));

                                return [$parts->first() => $parts->last()];
                            }),
                    ];
                });
        }

        return [
            'account' => $account,
            'requirements' => $requirements ?? null,
        ];
    }

    public function store(Request $request)
    {
        return [
            'account' => Auth::user()->createAccount([
                'account_token' => $request->token,
                'business_profile' => $request->business_profile,
            ]),
        ];
    }

    public function update(Request $request)
    {
        return [
            'account' => Auth::user()->updateAccount([
                'account_token' => $request->token,
                'business_profile' => $request->business_profile,
            ]),
        ];
    }

    public function getBankAccounts()
    {
        return [
            'accounts' => Auth::user()->listBankAccounts(),
        ];
    }

    public function removeBankAccount(Request $request)
    {
        return Auth::user()->removeBankAccount($request->account);
    }

    public function addBankAccount(Request $request)
    {
        return Auth::user()->createBankAccount($request->token);
    }

    public function setDefaultBankAccount(Request $request)
    {
        return Auth::user()->updateBankAccount($request->account, ['default_for_currency' => true]);
    }

    public function getFiles()
    {
        return Auth::user()->allFiles();
    }

    public function getFile($id)
    {
        return Auth::user()->retrieveFile($id);
    }
}
