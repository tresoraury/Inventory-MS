<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
{
    if (Auth::check() && Auth::user()->usertype == 'admin') {
        return $next($request);
    } else {
        \Log::info('User is not an admin:', ['user' => Auth::user()]);
        return redirect('/home')->with('status', 'vous n etes pas autorise');
    }
}
}
