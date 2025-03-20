<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Receptionist;
use App\Models\Cashier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function financialReport(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);

        $earnings = Payment::where('status', 'completed')
            ->where('payment_date', '>=', $startDate)
            ->sum('amount');

        $refunds = Payment::where('status', 'refunded')
            ->where('refund_date', '>=', $startDate)
            ->sum('refunded_amount');

        $pendingInvoices = Invoice::where('status', 'pending')
            ->where('due_date', '>=', $startDate)
            ->sum('amount');

        $dailyEarnings = Payment::where('status', 'completed')
            ->where('payment_date', '>=', $startDate)
            ->select(DB::raw('DATE(payment_date) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->get();

        return view('admin.reports.financial', compact(
            'earnings',
            'refunds',
            'pendingInvoices',
            'dailyEarnings',
            'period'
        ));
    }

    public function appointmentReport(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);

        $totalAppointments = Appointment::where('created_at', '>=', $startDate)->count();
        $completedAppointments = Appointment::where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->count();
        $cancelledAppointments = Appointment::where('status', 'cancelled')
            ->where('created_at', '>=', $startDate)
            ->count();
        $pendingAppointments = Appointment::where('status', 'pending')
            ->where('created_at', '>=', $startDate)
            ->count();

        $appointmentsByDay = Appointment::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(appointment_date) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $appointmentsByDepartment = Appointment::where('appointments.created_at', '>=', $startDate)
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->join('departments', 'doctors.department_id', '=', 'departments.id')
            ->select('departments.name', DB::raw('COUNT(*) as total'))
            ->groupBy('departments.id', 'departments.name')
            ->orderBy('total', 'desc')
            ->get();

        $appointmentsByStatus = [
            'completed' => $completedAppointments,
            'cancelled' => $cancelledAppointments,
            'pending' => $pendingAppointments
        ];

        return view('admin.reports.appointments', compact(
            'totalAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'pendingAppointments',
            'appointmentsByDay',
            'appointmentsByDepartment',
            'appointmentsByStatus',
            'period'
        ));
    }

    public function staffReport(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);

        $stats = DB::table('appointments')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->where('appointments.created_at', '>=', $startDate)
            ->select(
                'doctors.name',
                DB::raw('COUNT(*) as total_appointments'),
                DB::raw('COUNT(CASE WHEN appointments.status = "completed" THEN 1 END) as completed_appointments'),
                DB::raw('COUNT(CASE WHEN appointments.status = "cancelled" THEN 1 END) as cancelled_appointments'),
                DB::raw('COALESCE(AVG(CASE WHEN appointments.rating IS NOT NULL THEN appointments.rating ELSE NULL END), 0) as average_rating')
            )
            ->groupBy('doctors.id', 'doctors.name')
            ->get();
            
        $doctorStats = collect([]);
        
        if (!$stats->isEmpty()) {
            $doctorStats = $stats->map(function($item) {
                return (object) [
                    'name' => $item->name,
                    'total_appointments' => $item->total_appointments,
                    'completed_appointments' => $item->completed_appointments,
                    'cancelled_appointments' => $item->cancelled_appointments,
                    'average_rating' => number_format($item->average_rating, 2)
                ];
            });
        }

        $staffAttendance = DB::table('activity_log')
            ->where('created_at', '>=', $startDate)
            ->where('description', 'logged_in')
            ->select('causer_type', 'causer_id', DB::raw('COUNT(*) as login_count'))
            ->groupBy('causer_type', 'causer_id')
            ->get();

        $cancelledAppointments = Appointment::where('status', 'cancelled')
            ->where('created_at', '>=', $startDate)
            ->count();

        return view('admin.reports.staff', compact('doctorStats', 'staffAttendance', 'period', 'cancelledAppointments'));
    }

    public function exportReport(Request $request)
    {
        $reportType = $request->get('type');
        $format = $request->get('format', 'pdf');
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);

        switch ($reportType) {
            case 'financial':
                return $this->exportFinancialReport($startDate, $format);
            case 'appointments':
                return $this->exportAppointmentReport($startDate, $format);
            case 'staff':
                return $this->exportStaffReport($startDate, $format);
            default:
                return back()->with('error', 'Invalid report type');
        }
    }

    public function index()
    {
        $totalAppointments = Appointment::count();
        $totalEarnings = Payment::where('status', 'completed')->sum('amount');
        $totalPendingInvoices = Invoice::where('status', 'pending')->count();
        $totalStaff = Doctor::count() + Receptionist::count() + Cashier::count();

        return view('admin.reports.index', compact(
            'totalAppointments',
            'totalEarnings',
            'totalPendingInvoices',
            'totalStaff'
        ));
    }

    private function getStartDate($period)
    {
        switch ($period) {
            case 'week':
                return Carbon::now()->subWeek();
            case 'month':
                return Carbon::now()->subMonth();
            case 'quarter':
                return Carbon::now()->subQuarter();
            case 'year':
                return Carbon::now()->subYear();
            default:
                return Carbon::now()->subMonth();
        }
    }

    private function exportFinancialReport($startDate, $format)
    {
        $data = [
            'earnings' => Payment::where('status', 'completed')
                ->where('payment_date', '>=', $startDate)
                ->sum('amount'),
            'refunds' => Payment::where('status', 'refunded')
                ->where('refund_date', '>=', $startDate)
                ->sum('refunded_amount'),
            'pending' => Invoice::where('status', 'pending')
                ->where('due_date', '>=', $startDate)
                ->sum('amount')
        ];

        return $this->generateExport($data, 'financial-report', $format);
    }

    private function exportAppointmentReport($startDate, $format)
    {
        $data = [
            'total' => Appointment::where('created_at', '>=', $startDate)->count(),
            'completed' => Appointment::where('status', 'completed')
                ->where('created_at', '>=', $startDate)
                ->count(),
            'cancelled' => Appointment::where('status', 'cancelled')
                ->where('created_at', '>=', $startDate)
                ->count()
        ];

        return $this->generateExport($data, 'appointment-report', $format);
    }

    private function exportStaffReport($startDate, $format)
    {
        $data = DB::table('appointments')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->join('users', 'doctors.user_id', '=', 'users.id')
            ->where('appointments.created_at', '>=', $startDate)
            ->select(
                'users.name',
                DB::raw('COUNT(*) as total_appointments'),
                DB::raw('COUNT(CASE WHEN appointments.status = "completed" THEN 1 END) as completed_appointments')
            )
            ->groupBy('doctors.id', 'users.name')
            ->get();

        return $this->generateExport($data, 'staff-report', $format);
    }

    private function generateExport($data, $filename, $format)
    {
        switch ($format) {
            case 'pdf':
                // Implement PDF export logic
                return response()->json(['message' => 'PDF export not implemented yet']);
            case 'excel':
                // Implement Excel export logic
                return response()->json(['message' => 'Excel export not implemented yet']);
            case 'csv':
                // Implement CSV export logic
                return response()->json(['message' => 'CSV export not implemented yet']);
            default:
                return response()->json(['error' => 'Invalid format']);
        }
    }
}