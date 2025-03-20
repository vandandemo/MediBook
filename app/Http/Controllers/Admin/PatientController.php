<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $patients = Patient::latest()->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        if (!$patient) {
            abort(404, 'Patient not found');
        }

        return view('admin.patients.show', compact('patient'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'required|string|max:20',
            'blood_group' => 'required|string|max:5',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255'
        ]);

        $validated['password'] = bcrypt('password123'); // Set a default password

        $patient = Patient::create($validated);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient created successfully.');
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        //dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'blood_group' => 'required|string|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'address' => 'required|string',
            'active' => 'required|in:0,1'
        ]);

        // Ensure the active status is included in the update
        $validated['active'] = (int) $request->input('active');// Defaults to 0 if not provided


        $patient->update($validated);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient updated successfully');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient deleted successfully.');
    }
}