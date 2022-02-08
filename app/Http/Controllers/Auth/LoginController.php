<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Release;
use App\Track;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('throttle:20,1,login')->except('logout');
    }

    public function attempt()
    {
        $credentials = $this->request->only('email', 'password');
        $remember = $this->request->input('remember', false);
        $guestCart = $this->request->input('guestCart');

        if (Auth::attempt($credentials, $remember)) {
            Log::info(Auth::user());

            if (!is_null($guestCart)) {
                auth()->user()->syncGuestCart($guestCart);
            }

            if ($this->request->expectsJson()) {
                return [
                    'success' => true,
                    'user' => Auth::user()
                ];
            }

            return redirect('admin');
        } else if ($user = User::withTrashed()->where('email',$credentials['email'])->first()) {
                if ($user->isBanned()) {
                    return [
                        'success' => false,
                        'banned' => true,
                    ];
                } else {
                    return [
                        'success' => false,
                        'deactivated' => false
                    ];
                }
        } else {
           return [
                'success' => false,
                'deactivated' => false
           ];
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
