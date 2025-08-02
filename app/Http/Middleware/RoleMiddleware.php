<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        
        if (!Auth::check()) {
        abort(403, 'Not authenticated.');
    }

    $role = Auth::user()->role;

    if (strtolower(Auth::user()->role) !== strtolower($role)) {
        abort(403, 'Unauthorized access. Your role is: ' . Auth::user()->role);
    }

    return $next($request);
    }
}
