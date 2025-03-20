<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        try {
            Log::info('Starting social login process', [
                'provider' => $provider,
                'time' => now()->toDateTimeString()
            ]);

            if (!in_array($provider, ['github', 'google'])) {
                Log::error('Invalid social provider attempted', [
                    'provider' => $provider,
                    'time' => now()->toDateTimeString()
                ]);
                return redirect()->route('login')
                    ->with('error', 'Invalid social login provider');
            }
            
            Log::info('Redirecting to provider', [
                'provider' => $provider,
                'time' => now()->toDateTimeString()
            ]);

            return Socialite::driver($provider)->redirect();
        } catch (Exception $e) {
            Log::error('Error in redirectToProvider', [
                'provider' => $provider,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Could not connect to ' . ucfirst($provider) . '. Please try again.');
        }
    }

    public function handleProviderCallback($provider)
    {
        try {
            Log::info('Handling provider callback', [
                'provider' => $provider,
                'request_url' => request()->fullUrl(),
                'request_method' => request()->method(),
                'request_params' => request()->all(),
                'request_headers' => request()->headers->all(),
                'time' => now()->toDateTimeString()
            ]);

            if (!in_array($provider, ['github', 'google'])) {
                Log::error('Invalid provider in callback', [
                    'provider' => $provider,
                    'time' => now()->toDateTimeString()
                ]);
                return redirect()->route('login')
                    ->with('error', 'Invalid social login provider');
            }

            try {
                $socialUser = Socialite::driver($provider)->user();
                Log::info('Successfully retrieved social user', [
                    'provider' => $provider,
                    'email' => $socialUser->getEmail(),
                    'name' => $socialUser->getName(),
                    'id' => $socialUser->getId(),
                    'time' => now()->toDateTimeString()
                ]);
            } catch (Exception $e) {
                Log::error('Failed to get social user data', [
                    'provider' => $provider,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'request_data' => request()->all(),
                    'time' => now()->toDateTimeString()
                ]);
                throw new Exception('Failed to get user information from ' . ucfirst($provider));
            }
            
            if (!$socialUser || !$socialUser->getEmail()) {
                Log::error('Missing required social user data', [
                    'provider' => $provider,
                    'has_user' => !is_null($socialUser),
                    'has_email' => $socialUser ? !is_null($socialUser->getEmail()) : false,
                    'time' => now()->toDateTimeString()
                ]);
                throw new Exception('Could not get user information from ' . ucfirst($provider));
            }

            // Find existing patient or create new
            $patient = Patient::where('email', $socialUser->getEmail())->first();
            
            if (!$patient) {
                Log::info('Creating new patient from social login', [
                    'provider' => $provider,
                    'email' => $socialUser->getEmail(),
                    'time' => now()->toDateTimeString()
                ]);

                try {
                    // Create new patient
                    $patient = Patient::create([
                        'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Patient',
                        'email' => $socialUser->getEmail(),
                        'password' => Hash::make(Str::random(24)),
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                        'email_verified_at' => now(),
                        'active' => true
                    ]);

                    Log::info('Successfully created new patient', [
                        'patient_id' => $patient->id,
                        'provider' => $provider,
                        'time' => now()->toDateTimeString()
                    ]);
                } catch (Exception $e) {
                    Log::error('Failed to create new patient', [
                        'provider' => $provider,
                        'email' => $socialUser->getEmail(),
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'time' => now()->toDateTimeString()
                    ]);
                    throw new Exception('Failed to create new patient account');
                }
            } else {
                Log::info('Found existing patient', [
                    'patient_id' => $patient->id,
                    'provider' => $provider,
                    'time' => now()->toDateTimeString()
                ]);
            }

            try {
                // Login the patient
                Auth::guard('patient')->login($patient);
                Log::info('Successfully logged in patient', [
                    'patient_id' => $patient->id,
                    'provider' => $provider,
                    'time' => now()->toDateTimeString()
                ]);
            } catch (Exception $e) {
                Log::error('Failed to login patient', [
                    'patient_id' => $patient->id,
                    'provider' => $provider,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'time' => now()->toDateTimeString()
                ]);
                throw new Exception('Failed to log in with ' . ucfirst($provider));
            }

            return redirect()->route('patient.dashboard')
                ->with('success', 'Successfully logged in with ' . ucfirst($provider));

        } catch (Exception $e) {
            Log::error('Social authentication failed', [
                'provider' => $provider,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Unable to login with ' . ucfirst($provider) . '. ' . $e->getMessage());
        }
    }
} 