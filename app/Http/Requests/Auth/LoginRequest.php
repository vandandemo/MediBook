<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        // Get the intended guard from the session if available
        $intendedGuard = session('intended_guard');
        
        if ($intendedGuard) {
            // If we have an intended guard, only try that one
            if (Auth::guard($intendedGuard)->attempt($this->only('email', 'password'), $this->boolean('remember'))) {
                Auth::shouldUse($intendedGuard);
                
                Log::info("User authenticated successfully with intended guard.", [
                    'email' => $this->input('email'),
                    'guard' => $intendedGuard,
                    'ip' => request()->ip(),
                ]);
                
                return;
            }
        } else {
            // If no intended guard, try each guard in order
            $guards = ['doctor', 'admin', 'patient', 'receptionist', 'cashier'];
            
            foreach ($guards as $guard) {
                if (Auth::guard($guard)->attempt($this->only('email', 'password'), $this->boolean('remember'))) {
                    Auth::shouldUse($guard);
                    session(['intended_guard' => $guard]);
                    
                    Log::info("User authenticated successfully.", [
                        'email' => $this->input('email'),
                        'guard' => $guard,
                        'ip' => request()->ip(),
                    ]);
                    
                    return;
                }
            }
        }

        Log::warning("Authentication failed.", [
            'email' => $this->input('email'),
            'ip' => request()->ip(),
        ]);

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
