<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminIsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // check user is authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }

        // check user has permission to view the admin dashboard
        if (!Auth::user()->hasPermissionTo('view admin dashboard')) {
            return redirect('/account');
        }

        return $next($request);
    }
}
