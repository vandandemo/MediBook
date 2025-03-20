<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Receptionist;
use App\Models\Cashier;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function financial(Request $request)
    {
        $period = $request->get('period', 'week');
        $invoices = Invoice::with('patient')->latest()->get();
        $totalRevenue = $invoices->sum('total_amount');
        $paidInvoices = $invoices->where('status', 'paid')->count();
        $pendingInvoices = $invoices->where('status', 'pending')->count();
        $earnings = $invoices->where('status', 'paid')->sum('total_amount');
        $refunds = $invoices->where('status', 'refunded')->sum('total_amount');
        
        // Calculate daily earnings
        $dailyEarnings = $invoices
            ->where('status', 'paid')
            ->groupBy(function($invoice) {
                return $invoice->created_at->format('Y-m-d');
            })
            ->map(function($dayInvoices) {
                return $dayInvoices->sum('total_amount');
            });

        return view('admin.reports.financial', compact('invoices', 'totalRevenue', 'paidInvoices', 'pendingInvoices', 'period', 'earnings', 'refunds', 'dailyEarnings'));
    }

    public function appointments(Request $request)
    {
        $period = $request->get('period', 'week');
        $appointments = Appointment::with(['doctor', 'patient'])->latest()->get();
        $totalAppointments = $appointments->count();
        $completedAppointments = $appointments->where('status', 'completed')->count();
        $pendingAppointments = $appointments->where('status', 'pending')->count();

        return view('admin.reports.appointments', compact('appointments', 'totalAppointments', 'completedAppointments', 'pendingAppointments', 'period'));
    }

    public function staff(Request $request)
    {
        $period = $request->get('period', 'week');

        $doctors = Doctor::count();
        $patients = Patient::count();
        $receptionists = Receptionist::count();
        $cashiers = Cashier::count();

        $staffStats = [
            'doctors' => $doctors,
            'patients' => $patients,
            'receptionists' => $receptionists,
            'cashiers' => $cashiers
        ];

        return view('admin.reports.staff', compact('staffStats', 'period'));
    }

    public function export($type)
    {
        switch ($type) {
            case 'financial':
                $data = Invoice::with('patient')->latest()->get();
                break;
            case 'appointments':
                $data = Appointment::with(['doctor', 'patient'])->latest()->get();
                break;
            case 'staff':
                $data = [
                    'doctors' => Doctor::all(),
                    'receptionists' => Receptionist::all(),
                    'cashiers' => Cashier::all()
                ];
                break;
            default:
                return back()->with('error', 'Invalid report type');
        }

        // Here you would implement the actual export logic
        // For example, generating CSV, PDF, or Excel files

        return back()->with('success', 'Report exported successfully');
    }
}