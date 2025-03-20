<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:cashier');
    }

    public function index()
    {
        $patients = Patient::orderBy('name')
            ->paginate(15);
        
        return view('cashier.patients.index', compact('patients'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $patients = Patient::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->orderBy('name')
            ->paginate(15);
            
        return view('cashier.patients.index', compact('patients', 'query'));
    }

    public function show(Patient $patient)
    {
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor'])
            ->orderBy('appointment_date', 'desc')
            ->take(10)
            ->get();
            
        $invoices = Invoice::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        return view('cashier.patients.show', compact('patient', 'appointments', 'invoices'));
    }
} 