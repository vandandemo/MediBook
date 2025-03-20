<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $user = User::firstOrCreate(
                ['email' => 'doctor@hospital.com'],
                [
                'name' => 'Dr. John Doe',
                'email' => 'doctor@hospital.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            Doctor::firstOrCreate(
                ['user_id' => $user->id],
                [
                'license_number' => 'LIC123456',
                'user_id' => $user->id
            ]);
        });
    }
}
