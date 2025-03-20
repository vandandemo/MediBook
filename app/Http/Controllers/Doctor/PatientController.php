<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    /**
     * Display a listing of the patients.
     */
    public function index(): View
    {
        $patients = Patient::paginate(10);
        return view('doctor.patients.index', compact('patients'));
    }

    /**
     * Display the specified patient.
     */
    public function show(Patient $patient): View
    {
        return view('doctor.patients.show', compact('patient'));
    }
}