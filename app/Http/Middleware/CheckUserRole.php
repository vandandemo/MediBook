<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        if ($user && $user->role === $role) {
            // Ensure user is authenticated with the correct guard
            $currentGuard = Auth::getDefaultDriver();
            if ($currentGuard === $role) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}