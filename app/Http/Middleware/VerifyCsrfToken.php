<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Log;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        '/logout'
    ];

    protected function tokensMatch($request)
    {
        $match = parent::tokensMatch($request);
        if (!$match) {
            Log::warning('CSRF token mismatch', [
                'url' => $request->url(),
                'method' => $request->method(),
                'token' => $request->header('X-CSRF-TOKEN') ?: $request->input('_token'),
            ]);
        }
        return $match;
    }
}