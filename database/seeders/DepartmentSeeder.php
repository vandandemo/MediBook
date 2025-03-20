<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Cardiology', 'description' => 'Heart and cardiovascular system'],
            ['name' => 'Neurology', 'description' => 'Brain and nervous system'],
            ['name' => 'Pediatrics', 'description' => 'Child healthcare'],
            ['name' => 'Orthopedics', 'description' => 'Bones and joints'],
            ['name' => 'Dermatology', 'description' => 'Skin conditions'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}