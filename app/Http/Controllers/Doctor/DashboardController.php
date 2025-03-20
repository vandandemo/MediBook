<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\LabReport;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        $doctor = Auth::guard('doctor')->user();
        
        // Get total patients this month
        $totalPatients = Appointment::where('doctor_id', $doctor->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->distinct('patient_id')
            ->count();

        // Get checked-in patients today
        $checkedInPatients = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('scheduled_time', Carbon::today())
            ->where('status', 'checked_in')
            ->count();

        // Get pending appointments
        $pendingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'pending')
            ->where('scheduled_time', '>', Carbon::now())
            ->count();

        // Get cancelled appointments this month
        $cancelledAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('status', 'cancelled')
            ->count();

        // Get recent appointments
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('doctor_id', $doctor->id)
            ->orderBy('scheduled_time', 'desc')
            ->take(5)
            ->get();

        // Get upcoming appointments
        $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('scheduled_time', '>', Carbon::now())
            ->orderBy('scheduled_time', 'asc')
            ->take(5)
            ->get();

        // Get recent prescriptions
        $recentPrescriptions = Prescription::whereHas('appointment', function ($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })
            ->latest()
            ->take(5)
            ->get();

        // Get recent activities (Appointments, Lab Reports)
        $recentActivities = collect()
            ->merge(Appointment::where('doctor_id', $doctor->id)
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($appointment) {
                    return (object) [
                        'type' => 'appointment',
                        'description' => "New appointment with {$appointment->patient->name}",
                        'created_at' => $appointment->created_at
                    ];
                })
            )
            ->merge(LabReport::where('doctor_id', $doctor->id)
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($report) {
                    return (object) [
                        'type' => 'report',
                        'description' => "Lab report created for {$report->patient->name}",
                        'created_at' => $report->created_at
                    ];
                })
            )
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        return view('doctor.dashboard', compact(
            'totalPatients',
            'checkedInPatients',
            'pendingAppointments',
            'cancelledAppointments',
            'appointments',
            'upcomingAppointments',
            'recentPrescriptions',
            'recentActivities'
        ));
    }
}
