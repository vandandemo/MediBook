<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // Get hospital statistics
        $stats = [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'total_appointments' => Appointment::count(),
            'total_revenue' => Appointment::sum('amount'),
            'recent_appointments' => Appointment::with(['patient', 'doctor'])
                ->latest()
                ->take(5)
                ->get(),
            'monthly_revenue' => Appointment::whereMonth('created_at', Carbon::now()->month)
                ->sum('amount'),
            'daily_appointments' => Appointment::whereDate('appointment_date', Carbon::today())
                ->count(),
            'pending_leaves' => \App\Models\Leave::where('status', 'pending')
                ->with('doctor')
                ->latest()
                ->take(5)
                ->get()
        ];

        // Get recent activities
        $recent_activities = DB::table('activity_log')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_activities'));
    }

    public function logout(Request $request)
    {
        activity()->log('Admin logged out');
        auth('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}