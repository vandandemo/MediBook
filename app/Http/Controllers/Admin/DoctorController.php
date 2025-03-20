<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Specialization;

class DoctorController extends Controller
{
    public function create()
    {
        $departments = Department::all();
        $specializations = Specialization::all();
        
        return view('admin.doctors.create', compact('departments', 'specializations'));
    }

    public function store(Request $request)
    {
        // Store logic will be implemented here
        return redirect()->route('admin.doctors.index');
    }
}