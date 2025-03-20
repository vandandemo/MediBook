<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Appointment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:cashier');
    }

    public function index()
    {
        // Get today's date
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        
        // Calculate today's payments
        $todaysPayments = Payment::whereDate('payment_date', $today)
            ->sum('amount');
            
        // Calculate monthly revenue
        $monthlyRevenue = Payment::whereMonth('payment_date', $today->month)
            ->whereYear('payment_date', $today->year)
            ->sum('amount');
            
        // Count pending invoices
        $pendingInvoices = Invoice::where('status', 'Pending')->count();
        
        // Count appointments today
        $appointmentsToday = Appointment::whereDate('appointment_date', $today)->count();
        
        // Get recent payments
        $recentPayments = Payment::with(['invoice', 'invoice.patient'])
            ->orderBy('payment_date', 'desc')
            ->limit(5)
            ->get();
            
        // Get today's appointments
        $todayAppointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_date')
            ->limit(5)
            ->get();
        
        return view('cashier.dashboard', compact(
            'todaysPayments', 
            'monthlyRevenue', 
            'pendingInvoices', 
            'appointmentsToday',
            'recentPayments',
            'todayAppointments'
        ));
    }
}