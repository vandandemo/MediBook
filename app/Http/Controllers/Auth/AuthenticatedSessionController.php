<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            // Use the intended guard from the session if available
            $currentGuard = session('intended_guard');
            
            if (!$currentGuard) {
                // Fallback to checking guards if no intended guard is set
                $guards = ['doctor', 'admin', 'patient', 'receptionist', 'cashier', 'web'];
                foreach ($guards as $guard) {
                    if (Auth::guard($guard)->check()) {
                        Auth::shouldUse($guard);
                        $currentGuard = $guard;
                        break;
                    }
                }
            } else {
                Auth::shouldUse($currentGuard);
            }

            if (!$currentGuard) {
                Log::error("Login failed: No valid authentication guard found.", [
                    'email' => $request->input('email'),
                    'ip' => $request->ip(),
                ]);
                throw new \Exception('No valid authentication guard found.');
            }

            // Set user's status to active when logging in
            $user = Auth::guard($currentGuard)->user();
            if ($user) {
                $user->active = true;
                $user->save();
                
                Log::info('User status set to active.', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role' => $currentGuard
                ]);
            }

            Log::info("User logged in successfully.", [
                'email' => $request->input('email'),
                'guard' => $currentGuard,
                'ip' => $request->ip(),
            ]);

            // Define redirect routes for each guard
            $redirectRoutes = [
                'admin' => '/admin/dashboard',
                'doctor' => '/doctor/dashboard',
                'patient' => '/patient/dashboard',
                'receptionist' => '/receptionist/dashboard',
                'cashier' => '/cashier/dashboard',
                'web' => '/dashboard'
            ];

            return redirect()->intended($redirectRoutes[$currentGuard] ?? '/dashboard');
        } catch (\Exception $e) {
            Log::warning("Login attempt failed.", [
                'email' => $request->input('email'),
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);
            return back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ])->onlyInput('email');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Debug logging to verify method is called
        Log::debug('Destroy method called', [
            'request_path' => $request->path(),
            'request_method' => $request->method(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
            'guard_param' => $request->input('guard')
        ]);
        
        Log::info('Logout process started');
        
        try {
            $currentGuard = $request->input('guard');
            $guards = ['admin', 'doctor', 'patient', 'receptionist', 'cashier', 'web'];
            
            Log::info('Attempting logout with guard', [
                'requested_guard' => $currentGuard,
                'session_guard' => session('intended_guard'),
                'has_receptionist' => Auth::guard('receptionist')->check(),
                'has_admin' => Auth::guard('admin')->check()
            ]);
            
            // If a specific guard is provided, try that first
            if ($currentGuard && in_array($currentGuard, $guards)) {
                if (Auth::guard($currentGuard)->check()) {
                    $user = Auth::guard($currentGuard)->user();
                    
                    Log::info('Logging out specific guard', [
                        'guard' => $currentGuard,
                        'email' => $user ? $user->email : 'Unknown',
                        'user_data' => $user ? json_encode($user->toArray()) : 'No user data'
                    ]);
                    
                    // Set user's status to inactive
                    if ($user) {
                        try {
                            $user->active = false;
                            $user->save();
                            
                            Log::info('User status set to inactive during logout', [
                                'user_id' => $user->id,
                                'email' => $user->email,
                                'role' => $currentGuard
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Failed to update user status during logout:', [
                                'user_id' => $user->id,
                                'role' => $currentGuard,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                    
                    Auth::guard($currentGuard)->logout();
                    Log::info('Guard logged out successfully', ['guard' => $currentGuard]);
                } else {
                    Log::warning('Guard specified but not authenticated', ['guard' => $currentGuard]);
                }
            } else {
                // If no specific guard provided or not found, try all guards
                foreach ($guards as $guard) {
                    if (Auth::guard($guard)->check()) {
                        $user = Auth::guard($guard)->user();
                        
                        Log::info('Active guard found during logout', [
                            'guard' => $guard,
                            'email' => $user ? $user->email : 'Unknown'
                        ]);
                        
                        // Set user's status to inactive
                        if ($user) {
                            try {
                                $user->active = false;
                                $user->save();
                                
                                Log::info('User status set to inactive during logout', [
                                    'user_id' => $user->id,
                                    'email' => $user->email,
                                    'role' => $guard
                                ]);
                            } catch (\Exception $e) {
                                Log::error('Failed to update user status during logout:', [
                                    'user_id' => $user->id,
                                    'role' => $guard,
                                    'error' => $e->getMessage()
                                ]);
                            }
                        }
                        
                        Auth::guard($guard)->logout();
                        Log::info('Guard logged out successfully', ['guard' => $guard]);
                    }
                }
            }
            
            // Clear all sessions and authentication data
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Log::info('Session invalidated and token regenerated');
            
            // Clear any intended URLs and guard
            $request->session()->forget(['url.intended', 'intended_guard']);
            Log::info('Session data cleared');
            
            // Clear any cached data
            cache()->flush();
            Log::info('Cache flushed');
            
            // Clear all guards explicitly
            foreach ($guards as $guard) {
                Auth::guard($guard)->logout();
            }
            Log::info('All guards cleared');
            
            Log::info('Logout process completed successfully');
        } catch (\Exception $e) {
            Log::error('Error during logout process', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    
        return redirect('/login');
    }
    
}
