<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:receptionist');
        $this->middleware('auth.session');
    }

    public function index()
    {
        try {
            // Ensure we have an authenticated receptionist
            if (!Auth::guard('receptionist')->check()) {
                Log::warning('Unauthenticated access attempt to receptionist dashboard');
                return redirect()->route('login')->with('error', 'Please login as a receptionist.');
            }

            $receptionist = Auth::guard('receptionist')->user();
            if (!$receptionist) {
                Log::error('Null receptionist user in dashboard', [
                    'session_id' => session()->getId(),
                    'guard' => Auth::getDefaultDriver(),
                    'session_data' => session()->all()
                ]);
                Auth::guard('receptionist')->logout();
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            }

            if (!$receptionist->active) {
                Log::warning('Inactive receptionist attempted to access dashboard', [
                    'receptionist_id' => $receptionist->id
                ]);
                Auth::guard('receptionist')->logout();
                return redirect()->route('login')->with('error', 'Your account is inactive. Please contact administrator.');
            }

            // Get today's date
            $today = Carbon::today();
            $thisMonth = Carbon::now()->startOfMonth();
            
            // Quick stats
            $totalAppointments = Appointment::count();
            $todayAppointments = Appointment::whereDate('appointment_date', $today)->count();
            $upcomingAppointments = Appointment::where('appointment_date', '>=', $today)
                ->where('status', 'scheduled')
                ->count();
            $newPatients = Patient::whereDate('created_at', '>=', $thisMonth)->count();
            
            // Today's appointments
            $todayAppointmentsList = Appointment::with(['doctor', 'patient'])
                ->whereDate('appointment_date', $today)
                ->orderBy('scheduled_time')
                ->take(5)
                ->get();
            
            // Recent patients
            $recentPatients = Patient::orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            // Pending invoices
            $pendingInvoices = Invoice::with(['appointment.patient'])
                ->where('status', 'pending')
                ->orderBy('due_date')
                ->take(5)
                ->get();

            // Debug logging for pending invoices
            Log::info('Pending invoices data:', [
                'count' => $pendingInvoices->count(),
                'invoices' => $pendingInvoices->map(function($invoice) {
                    return [
                        'id' => $invoice->id,
                        'appointment_id' => $invoice->appointment_id,
                        'has_appointment' => $invoice->appointment ? true : false,
                        'has_patient' => $invoice->appointment && $invoice->appointment->patient ? true : false,
                        'patient_name' => $invoice->appointment && $invoice->appointment->patient ? $invoice->appointment->patient->name : 'null'
                    ];
                })
            ]);
            
            // Available doctors today
            $availableDoctors = Doctor::where('active', 1)
                ->whereDoesntHave('leaves', function($query) use ($today) {
                    $query->whereDate('start_date', '<=', $today)
                          ->whereDate('end_date', '>=', $today);
                })
                ->take(5)
                ->get();

            // Get statistics for the dashboard
            $stats = [
                'today_appointments' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
                'pending_appointments' => Appointment::where('status', 'pending')->count(),
                'total_patients' => Patient::count(),
                'available_doctors' => Doctor::where('active', true)
                    ->whereDoesntHave('leaves', function($query) {
                        $query->where('status', 'approved')
                            ->where('start_date', '<=', Carbon::today())
                            ->where('end_date', '>=', Carbon::today());
                    })->count(),
                'recent_appointments' => Appointment::with(['patient', 'doctor'])
                    ->latest()
                    ->take(5)
                    ->get(),
                'recent_patients' => Patient::latest()
                    ->take(5)
                    ->get()
            ];

            // Get recent activities
            $recent_activities = DB::table('activity_log')
                ->where('causer_type', 'App\Models\Receptionist')
                ->latest()
                ->take(10)
                ->get();

            return view('receptionist.dashboard', compact(
                'receptionist',
                'totalAppointments', 
                'todayAppointments', 
                'upcomingAppointments', 
                'newPatients',
                'todayAppointmentsList',
                'recentPatients',
                'pendingInvoices',
                'availableDoctors',
                'stats',
                'recent_activities'
            ));
        } catch (\Exception $e) {
            Log::error('Error in receptionist dashboard', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'session_id' => session()->getId(),
                'guard' => Auth::getDefaultDriver()
            ]);
            return back()->with('error', 'An error occurred while loading the dashboard.');
        }
    }
}