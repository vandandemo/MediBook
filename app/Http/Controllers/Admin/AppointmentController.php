<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Invoice;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('Starting appointment creation process', [
                'request_data' => $request->except(['_token']),
                'user_id' => auth()->id(),
                'timestamp' => now()
            ]);

            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'required|exists:doctors,id',
                'appointment_date' => 'required|date|after:now',
                'scheduled_time' => 'required|date_format:H:i',
                'amount' => 'required|numeric|min:0',
                'notes' => 'nullable|string|max:1000',
                'status' => 'required|in:scheduled,completed,cancelled,no_show',
                'rating' => 'nullable|numeric|min:0|max:5'
            ]);

            // Check for existing appointments for the doctor at the same time
            $appointmentDateTime = date('Y-m-d H:i:s', strtotime($validated['appointment_date'] . ' ' . $validated['scheduled_time']));
            $existingAppointment = Appointment::where('doctor_id', $validated['doctor_id'])
                ->where('appointment_date', $appointmentDateTime)
                ->first();

            if ($existingAppointment) {
                Log::warning('Appointment slot already booked', [
                    'doctor_id' => $validated['doctor_id'],
                    'appointment_date' => $appointmentDateTime,
                    'existing_appointment_id' => $existingAppointment->id
                ]);
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'This time slot is already booked for the selected doctor.');
            }

            DB::beginTransaction();

            $validated['appointment_date'] = $appointmentDateTime;
            unset($validated['scheduled_time']);

            Log::info('Validated data prepared for appointment creation', [
                'validated_data' => $validated
            ]);

            $appointment = Appointment::create($validated);

            // Create an invoice for the appointment
            Invoice::create([
                'patient_id' => $validated['patient_id'],
                'appointment_id' => $appointment->id,
                'amount' => $validated['amount'],
                'status' => 'pending',
                'due_date' => now()->addDays(30),
                'payment_method' => null,
                'notes' => 'Automatically generated invoice for appointment'
            ]);

            Log::info('Appointment and invoice created successfully', [
                'appointment_id' => $appointment->id,
                'invoice_id' => $appointment->invoice->id,
                'data' => $appointment->toArray()
            ]);

            DB::commit();

            return redirect()
                ->route('admin.appointments.index')
                ->with('success', 'Appointment created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed during appointment creation', [
                'errors' => $e->errors(),
                'input' => $request->except(['_token'])
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            Log::error('Failed to create appointment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['_token'])
            ]);
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Failed to create appointment. Please try again.');
        }
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:scheduled,completed,cancelled,no_show'
        ]);

        try {
            DB::beginTransaction();

            $appointment->update($validated);

            DB::commit();

            return redirect()
                ->route('admin.appointments.index')
                ->with('success', 'Appointment updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update appointment. Please try again.');
        }
    }

    public function destroy(Appointment $appointment)
    {
        try {
            $appointment->delete();

            return redirect()
                ->route('admin.appointments.index')
                ->with('success', 'Appointment deleted successfully.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete appointment. Please try again.');
        }
    }

    public function show($id)
{
    $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($id);
    return view('admin.appointments.show', compact('appointment'));
}

}