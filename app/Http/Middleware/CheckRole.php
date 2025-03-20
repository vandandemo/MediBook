<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $guards = ['admin', 'doctor', 'patient', 'receptionist', 'cashier'];
        
        // Check if the requested role matches the current guard
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && $guard === $role) {
                return $next($request);
            }
        }

        // If no matching guard is found or user is not authenticated with the correct guard
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        // Redirect to login if not authenticated at all
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // If authenticated but wrong role, redirect to appropriate dashboard
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect()->route($guard . '.dashboard');
            }
        }

        return redirect()->route('login');
    }
} 