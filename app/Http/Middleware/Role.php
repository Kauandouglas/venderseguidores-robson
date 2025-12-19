<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param int $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $role)
    {
        if ($role == 1) {
            // Login Dashboard
            if (Auth::user() && Auth::user()->role == 1) {
                return $next($request);
            }

            return redirect()->route('dashboard.auth.formLogin');
        } else if ($role == 2) {
            // Login Panel
            if (Auth::user() && Auth::user()->role == 2) {
                return $next($request);
            }

            return redirect()->route('panel.auth.formLogin');
        }
    }
}
