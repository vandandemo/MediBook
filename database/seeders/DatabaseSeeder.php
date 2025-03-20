<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Receptionist;
use App\Models\Cashier;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        Admin::firstOrCreate(
            ['email' => 'admin@hospital.com'],
            [
            'name' => 'System Admin',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('admin123')
        ]);

        // Create Doctor
        Doctor::firstOrCreate(
            ['email' => 'doctor@hospital.com'],
            [
                'name' => 'Dr. John Smith',
                'email' => 'doctor@hospital.com',
                'password' => Hash::make('doctor123'),
                'specialization_id' => DB::table('specializations')->where('name', 'General Medicine')->value('id'),
                'license_number' => 'MD12345'
            ]
        );

        // Create Receptionist
        Receptionist::firstOrCreate(
            ['email' => 'receptionist@hospital.com'],
            [
                'name' => 'Jane Doe',
                'email' => 'receptionist@hospital.com',
                'password' => Hash::make('receptionist123'),
                'employee_id' => 'REC001',
                'shift' => 'Morning'
            ]
        );

        // Create Cashier
        Cashier::firstOrCreate(
            ['email' => 'cashier@hospital.com'],
            [
                'name' => 'Mike Johnson',
                'email' => 'cashier@hospital.com',
                'password' => Hash::make('cashier123'),
                'employee_id' => 'CASH001',
                'shift' => 'Morning'
            ]
        );

        // Create Patient
        Patient::firstOrCreate(
            ['email' => 'patient@hospital.com'],
            [
                'name' => 'Patient User',
                'email' => 'patient@hospital.com',
                'password' => Hash::make('patient123'),
                'date_of_birth' => '1990-01-01',
                'blood_group' => 'O+',
                'address' => '123 Patient Street',
                'phone' => '1234567890'
            ]
        );
    }
}
