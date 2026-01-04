<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:admin')
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Session::get('auth_user');

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        if ($user->role !== $role) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
