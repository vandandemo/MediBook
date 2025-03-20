<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // If a specific guard is authenticated
            if (Auth::guard($guard)->check()) {
                return $this->redirectToDashboard($guard);
            }
            
            // If no specific guard but we have an intended guard in session
            if ($guard === null && session()->has('intended_guard')) {
                $intendedGuard = session('intended_guard');
                if (Auth::guard($intendedGuard)->check()) {
                    return $this->redirectToDashboard($intendedGuard);
                }
            }
        }
    
        return $next($request);
    }
    
    /**
     * Redirect to the correct dashboard based on the guard
     */
    protected function redirectToDashboard($guard)
    {
        $redirectRoutes = [
            'admin' => '/admin/dashboard',
            'doctor' => '/doctor/dashboard',
            'patient' => '/patient/dashboard',
            'receptionist' => '/receptionist/dashboard',
            'cashier' => '/cashier/dashboard'
        ];

        $guard = $guard ?? session('intended_guard', 'web');
        Log::info('Redirecting authenticated user', ['guard' => $guard]);

        return redirect($redirectRoutes[$guard] ?? '/home');
    }
}
