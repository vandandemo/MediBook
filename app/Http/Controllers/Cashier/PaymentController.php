<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:cashier');
    }

    public function index()
    {
        $payments = Payment::with(['invoice', 'invoice.patient'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('cashier.payments.index', compact('payments'));
    }

    public function create()
    {
        // Get all pending invoices with their patients
        $invoices = Invoice::where('status', 'pending')
            ->with(['patient'])
            ->get();
            
        // Debug the invoices
        \Log::info('Pending Invoices:', ['count' => $invoices->count(), 'invoices' => $invoices->toArray()]);
            
        return view('cashier.payments.create', compact('invoices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:Cash,Credit Card,Debit Card,Bank Transfer,Insurance',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $invoice = Invoice::findOrFail($request->invoice_id);
            
            // Check if payment amount equals invoice amount
            if ($request->amount != $invoice->amount) {
                return back()->with('error', 'Payment amount must match the invoice amount.')
                    ->withInput();
            }
            
            $payment = new Payment();
            $payment->invoice_id = $request->invoice_id;
            $payment->amount = $request->amount;
            $payment->payment_method = $request->payment_method;
            $payment->payment_date = $request->payment_date;
            $payment->reference_number = $request->reference_number;
            $payment->notes = $request->notes;
            $payment->cashier_id = auth()->guard('cashier')->id();
            $payment->receipt_number = 'RCPT-' . date('Ymd') . '-' . random_int(1000, 9999);
            $payment->save();

            // Update invoice status to Paid
            $invoice->status = 'Paid';
            $invoice->save();

            DB::commit();
            return redirect()->route('cashier.payments.show', $payment->id)
                ->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to record payment: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Payment $payment)
    {
        $payment->load(['invoice', 'invoice.patient', 'cashier']);
        return view('cashier.payments.show', compact('payment'));
    }

    public function printReceipt(Payment $payment)
    {
        $payment->load(['invoice', 'invoice.patient', 'cashier']);
        return view('cashier.payments.receipt', compact('payment'));
    }
} 