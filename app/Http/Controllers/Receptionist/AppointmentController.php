<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:receptionist');
    }

    /**
     * Display a listing of appointments
     */
    public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
            
        return view('receptionist.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment
     */
    public function create()
    {
        // Get all patients first to check if there are any
        $allPatients = Patient::all();
        \Illuminate\Support\Facades\Log::info('All patients in database:', [
            'total_patients' => $allPatients->count(),
            'patients' => $allPatients->map(function($patient) {
                return [
                    'id' => $patient->id,
                    'name' => $patient->name,
                    'active' => $patient->active
                ];
            })
        ]);

        $doctors = Doctor::where('active', 1)
            ->with('specialization')
            ->get();
            
        $patients = Patient::where('active', 1)
            ->orderBy('name')
            ->get();
        
        // Get doctor_id from URL if present
        $selectedDoctorId = request('doctor_id');
        
        // Debug logging
        \Illuminate\Support\Facades\Log::info('Appointment creation form data:', [
            'doctors_count' => $doctors->count(),
            'patients_count' => $patients->count(),
            'selected_doctor_id' => $selectedDoctorId,
            'active_patients' => $patients->map(function($patient) {
                return [
                    'id' => $patient->id,
                    'name' => $patient->name,
                    'phone' => $patient->phone
                ];
            })
        ]);
        
        return view('receptionist.appointments.create', compact('doctors', 'patients', 'selectedDoctorId'));
    }

    /**
     * Store a newly created appointment
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'required|string|max:255',
        ]);

        $appointment = new Appointment();
        $appointment->patient_id = $request->patient_id;
        $appointment->doctor_id = $request->doctor_id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->reason = $request->reason;
        $appointment->status = 'scheduled';
        $appointment->save();

        return redirect()->route('receptionist.appointments.index')
            ->with('success', 'Appointment created successfully');
    }

    /**
     * Display the specified appointment
     */
    public function show($id)
    {
        $appointment = Appointment::with(['doctor', 'patient'])->findOrFail($id);
        
        return view('receptionist.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment
     */
    public function edit($id)
    {
        \Illuminate\Support\Facades\Log::info('Appointment edit page accessed', [
            'appointment_id' => $id
        ]);

        $appointment = Appointment::findOrFail($id);
        $doctors = Doctor::where('active', 1)->get();
        $patients = Patient::where('active', 1)->get();
        
        \Illuminate\Support\Facades\Log::info('Appointment edit data loaded', [
            'appointment' => [
                'id' => $appointment->id,
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,
                'status' => $appointment->status,
                'reason' => $appointment->reason
            ],
            'doctors_count' => $doctors->count(),
            'patients_count' => $patients->count()
        ]);
        
        return view('receptionist.appointments.edit', 
            compact('appointment', 'doctors', 'patients'));
    }

    /**
     * Update the specified appointment
     */
    public function update(Request $request, $id)
    {
        \Illuminate\Support\Facades\Log::info('=== START APPOINTMENT UPDATE ===');
        \Illuminate\Support\Facades\Log::info('Session state before update', [
            'session_id' => session()->getId(),
            'has_session' => session()->has('intended_guard'),
            'intended_guard' => session('intended_guard'),
            'all_session_data' => session()->all()
        ]);

        \Illuminate\Support\Facades\Log::info('Appointment update request received', [
            'appointment_id' => $id,
            'request_data' => $request->all(),
            'user' => auth()->guard('receptionist')->user() ? auth()->guard('receptionist')->user()->id : 'not authenticated'
        ]);

        try {
            // Convert datetime-local to separate date and time
            $appointmentDateTime = Carbon::parse($request->appointment_date);
            
            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'required|exists:doctors,id',
                'appointment_date' => 'required|date',
                'reason' => 'nullable|string|max:255',
                'status' => 'required|in:scheduled,completed,cancelled,no_show',
                'amount' => 'required|numeric|min:0',
                'notes' => 'nullable|string'
            ]);

            \Illuminate\Support\Facades\Log::info('Validation passed', ['validated_data' => $validated]);

            $appointment = Appointment::findOrFail($id);
            
            \Illuminate\Support\Facades\Log::info('Current appointment data before update', [
                'appointment' => [
                    'id' => $appointment->id,
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $appointment->doctor_id,
                    'appointment_date' => $appointment->appointment_date,
                    'appointment_time' => $appointment->appointment_time,
                    'status' => $appointment->status,
                    'reason' => $appointment->reason,
                    'amount' => $appointment->amount,
                    'notes' => $appointment->notes
                ]
            ]);

            $appointment->patient_id = $request->patient_id;
            $appointment->doctor_id = $request->doctor_id;
            $appointment->appointment_date = $appointmentDateTime->format('Y-m-d');
            $appointment->appointment_time = $appointmentDateTime->format('H:i:s');
            $appointment->reason = $request->reason ?? $appointment->reason;
            $appointment->status = $request->status;
            $appointment->amount = $request->amount;
            $appointment->notes = $request->notes;
            $appointment->save();

            \Illuminate\Support\Facades\Log::info('Appointment updated successfully', [
                'appointment_id' => $id,
                'new_status' => $appointment->status,
                'new_amount' => $appointment->amount
            ]);

            \Illuminate\Support\Facades\Log::info('Session state before redirect', [
                'session_id' => session()->getId(),
                'has_session' => session()->has('intended_guard'),
                'intended_guard' => session('intended_guard'),
                'all_session_data' => session()->all()
            ]);

            \Illuminate\Support\Facades\Log::info('Attempting redirect to appointments index');
            
            // Try route-based redirect first
            try {
                \Illuminate\Support\Facades\Log::info('Attempting route-based redirect');
                $response = redirect()->route('receptionist.appointments.index')
                    ->with('success', 'Appointment updated successfully');
                \Illuminate\Support\Facades\Log::info('Route-based redirect response created', [
                    'status' => $response->getStatusCode(),
                    'headers' => $response->headers->all()
                ]);
                return $response;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Route-based redirect failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Try direct URL redirect
                try {
                    \Illuminate\Support\Facades\Log::info('Attempting direct URL redirect');
                    $response = redirect('/receptionist/appointments')
                        ->with('success', 'Appointment updated successfully');
                    \Illuminate\Support\Facades\Log::info('Direct URL redirect response created', [
                        'status' => $response->getStatusCode(),
                        'headers' => $response->headers->all()
                    ]);
                    return $response;
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Direct URL redirect failed', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    // Fallback to back() with message
                    \Illuminate\Support\Facades\Log::info('Falling back to back() redirect');
                    return back()->with('success', 'Appointment updated successfully. Please navigate to the appointments list manually.');
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::error('Validation failed', [
                'errors' => $e->errors()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'An error occurred while updating the appointment. Please try again.');
        } finally {
            \Illuminate\Support\Facades\Log::info('=== END APPOINTMENT UPDATE ===');
        }
    }

    /**
     * Remove the specified appointment
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('receptionist.appointments.index')
            ->with('success', 'Appointment deleted successfully');
    }

    /**
     * Display today's appointments
     */
    public function todayAppointments()
    {
        $today = Carbon::today()->format('Y-m-d');
        $appointments = Appointment::with(['doctor', 'patient'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time')
            ->paginate(10);
            
        return view('receptionist.appointments.today', compact('appointments'));
    }

    /**
     * Mark patient as checked in
     */
    public function checkIn($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'checked-in';
        $appointment->save();

        return redirect()->back()->with('success', 'Patient checked in successfully');
    }
}