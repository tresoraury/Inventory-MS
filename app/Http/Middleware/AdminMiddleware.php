<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasAnyRole(['admin', 'staff'])) {
            return $next($request);
        }
        return redirect('/home')->with('status', 'It seems you do not have permission to access this system. Please contact your administrator for assistance.');
    }
}