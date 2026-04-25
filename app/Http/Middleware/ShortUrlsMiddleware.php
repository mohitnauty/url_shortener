<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShortUrlsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }
        if ($request->route()->getName() === 'companies.admin' && !$user->hasRole('Admin')) {
            abort(403, 'Unauthorized');
        }
        if ($user->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
