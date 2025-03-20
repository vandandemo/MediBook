<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Patient;
use App\Models\Invoice;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['patient', 'invoice'])
            ->latest()
            ->paginate(10);
            
        return view('cashier.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $patients = Patient::all();
        $invoices = Invoice::where('status', 'pending')->get();
        return view('cashier.transactions.create', compact('patients', 'invoices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'transaction_date' => 'required|date',
        ]);

        // Add cashier_id to the validated data
        $validated['cashier_id'] = auth()->id();

        $transaction = Transaction::create($validated);

        // Update invoice status
        $invoice = Invoice::find($validated['invoice_id']);
        $invoice->status = 'paid';
        $invoice->save();

        return redirect()->route('cashier.transactions.show', $transaction)
            ->with('success', 'Transaction recorded successfully.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['patient', 'invoice.items']);
        return view('cashier.transactions.show', compact('transaction'));
    }

    public function printReceipt(Transaction $transaction)
    {
        $transaction->load(['patient', 'invoice.items']);
        return view('cashier.transactions.print-receipt', compact('transaction'));
    }
} 