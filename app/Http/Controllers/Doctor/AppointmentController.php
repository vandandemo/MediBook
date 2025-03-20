<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient'])
            ->where('doctor_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('doctor.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        // Ensure the doctor can only view their own appointments
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('doctor.appointments.show', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        // Validate the doctor can only update their own appointments
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled,no-show',
            'notes' => 'nullable|string|max:1000',
        ]);

        $appointment->update($validated);

        return redirect()->route('doctor.appointments.show', $appointment)
            ->with('success', 'Appointment status updated successfully.');
    }
}