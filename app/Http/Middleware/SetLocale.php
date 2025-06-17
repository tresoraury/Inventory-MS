<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $language = Auth::user()->language ?? 'en';
            App::setLocale($language);
            Session::put('locale', $language); 
            Log::debug('SetLocale Middleware: Set locale to', ['language' => $language, 'user_id' => Auth::id()]);
        } else {
            $language = 'en';
            App::setLocale($language);
            Session::put('locale', $language);
            Log::debug('SetLocale Middleware: Set default locale to en');
        }

        return $next($request);
    }
}