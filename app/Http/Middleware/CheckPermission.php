<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (auth()->user()->hasPermissionTo($permission)) {
            return $next($request);
        }

        throw UnauthorizedException::forPermissions([$permission]);
    }
}