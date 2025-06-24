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
        $source = 'fallback';

        if (Auth::check()) {
            
            $user = Auth::user()->fresh();
            $language = $user->language ?? 'en';
            $source = 'user';
            Log::info('SetLocale: User language retrieved', [
                'user_id' => $user->id,
                'email' => $user->email,
                'language' => $language,
                'source' => $source,
                'db_language' => $user->language
            ]);
        } else {
            $language = Session::get('locale', 'en');
            $source = Session::has('locale') ? 'session' : 'fallback';
            Log::info('SetLocale: Non-authenticated language', [
                'language' => $language,
                'source' => $source,
                'session_locale' => Session::get('locale')
            ]);
        }

        
        if (!in_array($language, ['en', 'fr'])) {
            Log::warning('SetLocale: Invalid language detected, reverting to fallback', [
                'invalid_language' => $language
            ]);
            $language = 'en';
        }

        
        Config::set('app.locale', $language);
        App::setLocale($language);
        Session::put('locale', $language);

        Log::info('SetLocale: Locale applied', [
            'locale' => App::getLocale(),
            'language' => $language,
            'session_locale' => Session::get('locale'),
            'config_locale' => Config::get('app.locale'),
            'source' => $source
        ]);

        return $next($request);
    }
}