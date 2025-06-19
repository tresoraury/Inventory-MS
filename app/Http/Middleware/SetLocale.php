<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $language = 'en';
        if (Auth::check()) {
            $language = Auth::user()->language ?? 'en';
            Log::debug('SetLocale: User language', ['language' => $language, 'user_id' => Auth::id()]);
        } else {
            $language = Session::get('locale', 'en');
            Log::debug('SetLocale: Session/fallback', ['language' => $language]);
        }

        
        Session::flush();
        Config::set('app.locale', $language);
        App::setLocale($language);
        Session::put('locale', $language);
        Log::debug('SetLocale: Applied', [
            'locale' => App::getLocale(),
            'language' => $language,
            'session' => Session::get('locale'),
            'config' => Config::get('app.locale')
        ]);

        return $next($request);
    }
}