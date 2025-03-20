<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use Illuminate\Http\Request;
use PDF;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'medicines'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('doctor.prescriptions.index', compact('prescriptions'));
    }

    public function create(Request $request)
    {
        $patients = Patient::all();
        $medicines = Medicine::all();
        $appointmentId = $request->query('appointment');
        return view('doctor.prescriptions.create', compact('patients', 'medicines', 'appointmentId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required|string',
            'prescription_date' => 'required|date',
            'medicines' => 'required|array|min:1',
            'medicines.*' => 'required|exists:medicines,id',
            'dosages' => 'required|array|min:1',
            'dosages.*' => 'required|string',
            'durations' => 'required|array|min:1',
            'durations.*' => 'required|string',
            'instructions' => 'required|array|min:1',
            'instructions.*' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => auth()->id(),
            'appointment_id' => $request->appointment_id,
            'diagnosis' => $request->diagnosis,
            'prescription_date' => now(),
            'valid_until' => now()->addDays(30), // Prescriptions valid for 30 days by default
            'notes' => $request->notes,
            'status' => 'active'
        ]);

        foreach ($request->medicines as $index => $medicineId) {
            PrescriptionMedicine::create([
                'prescription_id' => $prescription->id,
                'medicine_id' => $medicineId,
                'dosage' => $request->dosages[$index],
                'duration' => $request->durations[$index],
                'instructions' => $request->instructions[$index] ?? null,
            ]);
        }

        if ($request->action === 'save_and_print') {
            return redirect()->route('doctor.prescriptions.print', $prescription)
                ->with('success', 'Prescription created successfully.');
        }

        return redirect()->route('doctor.prescriptions.index')
            ->with('success', 'Prescription created successfully.');
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient', 'medicines', 'doctor']);
        return view('doctor.prescriptions.show', compact('prescription'));
    }

    public function print(Prescription $prescription)
    {
        $prescription->load(['patient', 'medicines', 'doctor']);
        
        $pdf = PDF::loadView('doctor.prescriptions.print', compact('prescription'));
        
        return $pdf->stream('prescription.pdf');
    }

    public function edit(Prescription $prescription)
    {
        $patients = Patient::all();
        $medicines = Medicine::all();
        $prescription->load(['patient', 'medicines', 'doctor']);
        
        return view('doctor.prescriptions.edit', compact('prescription', 'patients', 'medicines'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required|string',
            'medicines' => 'required|array|min:1',
            'medicines.*' => 'required|exists:medicines,id',
            'dosages' => 'required|array|min:1',
            'dosages.*' => 'required|string',
            'durations' => 'required|array|min:1',
            'durations.*' => 'required|string',
            'instructions' => 'required|array|min:1',
            'instructions.*' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $prescription->update([
            'patient_id' => $request->patient_id,
            'diagnosis' => $request->diagnosis,
            'notes' => $request->notes,
        ]);

        // Sync medicines with their pivot data
        $medicines = collect($request->medicines)->mapWithKeys(function ($medicineId, $index) use ($request) {
            return [$medicineId => [
                'dosage' => $request->dosages[$index],
                'duration' => $request->durations[$index],
                'instructions' => $request->instructions[$index] ?? null,
            ]];
        })->all();

        $prescription->medicines()->sync($medicines);

        return redirect()->route('doctor.prescriptions.show', $prescription)
            ->with('success', 'Prescription updated successfully.');
    }
}