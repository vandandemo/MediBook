<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Payment;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $dailyTransactions = Transaction::whereDate('created_at', $today)->count();
        $dailyRevenue = Transaction::whereDate('created_at', $today)->sum('amount');
        
        $monthlyTransactions = Transaction::whereMonth('created_at', $today->month)
            ->whereYear('created_at', $today->year)
            ->count();
        $monthlyRevenue = Transaction::whereMonth('created_at', $today->month)
            ->whereYear('created_at', $today->year)
            ->sum('amount');

        return view('cashier.reports.index', compact(
            'dailyTransactions',
            'dailyRevenue',
            'monthlyTransactions',
            'monthlyRevenue'
        ));
    }

    public function transactions(Request $request)
    {
        $query = Transaction::with(['patient', 'invoice']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $transactions = $query->latest()->paginate(15);
        $totalAmount = $query->sum('amount');

        return view('cashier.reports.transactions', compact('transactions', 'totalAmount'));
    }

    public function payments(Request $request)
    {
        $query = Payment::with(['patient', 'invoice']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(15);
        $totalAmount = $query->sum('amount');

        return view('cashier.reports.payments', compact('payments', 'totalAmount'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:transactions,payments',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        if ($request->report_type === 'transactions') {
            $transactions = Transaction::with(['patient', 'invoice'])
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->get();
            
            $totalAmount = $transactions->sum('amount');
            
            // Calculate payment methods summary
            $paymentMethods = [];
            foreach ($transactions as $transaction) {
                $method = $transaction->payment_method;
                if (!isset($paymentMethods[$method])) {
                    $paymentMethods[$method] = [
                        'count' => 0,
                        'total' => 0,
                        'percentage' => 0
                    ];
                }
                $paymentMethods[$method]['count']++;
                $paymentMethods[$method]['total'] += $transaction->amount;
            }

            // Calculate percentages
            foreach ($paymentMethods as &$method) {
                $method['percentage'] = ($method['count'] / $transactions->count()) * 100;
            }

            return view('cashier.reports.generated.transactions', compact(
                'transactions',
                'totalAmount',
                'startDate',
                'endDate',
                'paymentMethods'
            ));
        } else {
            $payments = Payment::with(['patient', 'invoice'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
            
            $totalAmount = $payments->sum('amount');
            
            // Calculate payment methods summary
            $paymentMethods = [];
            foreach ($payments as $payment) {
                $method = $payment->payment_method;
                if (!isset($paymentMethods[$method])) {
                    $paymentMethods[$method] = [
                        'count' => 0,
                        'total' => 0,
                        'percentage' => 0
                    ];
                }
                $paymentMethods[$method]['count']++;
                $paymentMethods[$method]['total'] += $payment->amount;
            }

            // Calculate percentages
            foreach ($paymentMethods as &$method) {
                $method['percentage'] = ($method['count'] / $payments->count()) * 100;
            }

            return view('cashier.reports.generated.payments', compact(
                'payments',
                'totalAmount',
                'startDate',
                'endDate',
                'paymentMethods'
            ));
        }
    }
} 