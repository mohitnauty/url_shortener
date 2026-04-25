<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if (!$user->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
