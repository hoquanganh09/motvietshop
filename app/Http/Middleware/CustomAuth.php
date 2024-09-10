<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $guard = 'web'): Response
    {
        $redirectGuard = [
            'web' => 'client.auth.login',
            'admin' => 'admin.auth.login',
        ];

        if (Auth::guard($guard)->check()) {
            return $next($request);
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Unauthorized.',
                'redirect' => route($redirectGuard[$guard]),
            ], 401);
        }
        return to_route($redirectGuard[$guard]);
    }
}
