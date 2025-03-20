<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (str_contains($credentials['email'], '@hospital.com')) {
            // Clear any existing guard from session
            session()->forget('intended_guard');
            
            // Check if the email exists in doctors table first
            $doctor = \App\Models\Doctor::where('email', $credentials['email'])->first();
            if ($doctor && Auth::guard('doctor')->attempt($credentials)) {
                // Explicitly set the intended guard
                Auth::shouldUse('doctor');
                session(['intended_guard' => 'doctor']);
                
                Log::info('User authenticated successfully.', [
                    'email' => $credentials['email'],
                    'guard' => 'doctor',
                    'ip' => $request->ip()
                ]);
                return redirect('/doctor/dashboard');
            }
            
            // If not a doctor, try admin
            $admin = \App\Models\Admin::where('email', $credentials['email'])->first();
            if ($admin && Auth::guard('admin')->attempt($credentials)) {
                // Explicitly set the intended guard
                Auth::shouldUse('admin');
                session(['intended_guard' => 'admin']);
                
                Log::info('User authenticated successfully.', [
                    'email' => $credentials['email'],
                    'guard' => 'admin',
                    'ip' => $request->ip()
                ]);
                return redirect('/admin/dashboard');
            }

            // If not an admin, try receptionist
            $receptionist = \App\Models\Receptionist::where('email', $credentials['email'])->first();
            if ($receptionist && Auth::guard('receptionist')->attempt($credentials)) {
                // Explicitly set the intended guard
                Auth::shouldUse('receptionist');
                session(['intended_guard' => 'receptionist']);
                
                Log::info('User authenticated successfully.', [
                    'email' => $credentials['email'],
                    'guard' => 'receptionist',
                    'ip' => $request->ip()
                ]);
                return redirect('/receptionist/dashboard');
            }
        }
    
        Log::warning('Login failed - Invalid credentials.', [
            'email' => $credentials['email'],
            'ip' => $request->ip()
        ]);
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        $guards = ['admin', 'doctor', 'patient', 'receptionist', 'cashier'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $user->status = 'inactive';
                $user->save();

                Auth::guard($guard)->logout();

                Log::info('User forcefully logged out.', ['email' => $user->email, 'guard' => $guard]);
            }
        }

        return redirect('/login');
    }
}
