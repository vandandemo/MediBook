<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:receptionist');
    }

    /**
     * Display a listing of patients
     */
    public function index()
    {
        $patients = Patient::orderBy('created_at', 'desc')->paginate(10);
        return view('receptionist.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient
     */
    public function create()
    {
        return view('receptionist.patients.create');
    }

    /**
     * Store a newly created patient
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:10',
            'emergency_contact' => 'required|string|max:255',
            'emergency_contact_relation' => 'required|string|max:50',
            'emergency_contact_phone' => 'required|string|max:20',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        $patient = new Patient();
        $patient->name = $request->name;
        $patient->email = $request->email;
        $patient->phone = $request->phone;
        $patient->address = $request->address;
        $patient->date_of_birth = $request->date_of_birth;
        $patient->gender = $request->gender;
        $patient->blood_group = $request->blood_group;
        $patient->emergency_contact = $request->emergency_contact;
        $patient->emergency_contact_relation = $request->emergency_contact_relation;
        $patient->emergency_contact_phone = $request->emergency_contact_phone;
        $patient->medical_history = $request->medical_history;
        $patient->allergies = $request->allergies;
        $patient->active = 1;
        $patient->save();

        return redirect()->route('receptionist.patients.index')
            ->with('success', 'Patient registered successfully');
    }

    /**
     * Display the specified patient
     */
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return view('receptionist.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified patient
     */
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('receptionist.patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients,email,' . $patient->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:10',
            'emergency_contact' => 'required|string|max:255',
            'emergency_contact_relation' => 'required|string|max:50',
            'emergency_contact_phone' => 'required|string|max:20',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'active' => 'required|boolean',
        ]);

        $patient->name = $request->name;
        $patient->email = $request->email;
        $patient->phone = $request->phone;
        $patient->address = $request->address;
        $patient->date_of_birth = $request->date_of_birth;
        $patient->gender = $request->gender;
        $patient->blood_group = $request->blood_group;
        $patient->emergency_contact = $request->emergency_contact;
        $patient->emergency_contact_relation = $request->emergency_contact_relation;
        $patient->emergency_contact_phone = $request->emergency_contact_phone;
        $patient->medical_history = $request->medical_history;
        $patient->allergies = $request->allergies;
        $patient->active = $request->active;
        $patient->save();

        return redirect()->route('receptionist.patients.index')
            ->with('success', 'Patient updated successfully');
    }

    /**
     * Search for patients by name, email, or phone
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $patients = Patient::where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->paginate(10);

        return view('receptionist.patients.index', compact('patients', 'search'));
    }
}