<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Billing;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Invoice;

class BillingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:receptionist');
    }

    /**
     * Display a listing of invoices
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['appointment.patient'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date') && $request->date !== '') {
            $query->whereDate('created_at', $request->date);
        }

        // Search by patient name or invoice number
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('appointment.patient', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $invoices = $query->paginate(10);
            
        return view('receptionist.billing.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice
     */
    public function create()
    {
        $patients = Patient::where('active', 1)->get();
        $appointments = Appointment::whereIn('status', ['completed', 'checked-in'])
            ->whereDoesntHave('invoice')
            ->get();
        $patients = \App\Models\Patient::all(); // Fetch all patients
        
        return view('receptionist.billing.create', compact('patients', 'appointments'));
    }

    /**
     * Store a newly created invoice
     */
    public function store(Request $request)
    {
        \Log::info('Starting invoice creation process', [
            'request_data' => $request->all(),
            'route' => $request->route()->getName(),
            'method' => $request->method()
        ]);

        try {
            $request->validate([
                'appointment_id' => 'required|exists:appointments,id',
                'amount' => 'required|numeric|min:0',
                'description' => 'required|string',
                'due_date' => 'required|date',
                'status' => 'nullable|in:pending,paid,overdue'
            ]);

            \Log::info('Validation passed', [
                'validated_data' => $request->all()
            ]);

            $appointment = Appointment::findOrFail($request->appointment_id);
            \Log::info('Appointment found', [
                'appointment_id' => $appointment->id,
                'patient_id' => $appointment->patient_id
            ]);
            
            $invoice = new Invoice();
            $invoice->appointment_id = $request->appointment_id;
            $invoice->patient_id = $appointment->patient_id;
            $invoice->amount = $request->amount;
            $invoice->description = $request->description;
            $invoice->status = $request->status ?? 'pending';
            $invoice->due_date = $request->due_date;
            $invoice->invoice_number = 'INV-' . time();
            
            \Log::info('Attempting to save invoice', [
                'invoice_data' => $invoice->toArray()
            ]);

            $invoice->save();

            \Log::info('Invoice saved successfully', [
                'invoice_id' => $invoice->id
            ]);

            \Log::info('Attempting redirection', [
                'route' => 'receptionist.billing.index',
                'url' => route('receptionist.billing.index')
            ]);

            $response = redirect()->route('receptionist.billing.index')
                ->with('success', 'Invoice created successfully');

            \Log::info('Redirection response created', [
                'status' => $response->getStatusCode(),
                'headers' => $response->headers->all()
            ]);

            return $response;

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating invoice', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()
                ->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified invoice
     */
    public function show($id)
    {
        $invoice = Invoice::with(['patient', 'appointment', 'payments'])->findOrFail($id);
        
        return view('receptionist.billing.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $patients = Patient::where('active', 1)->get();
        $appointments = Appointment::whereIn('status', ['completed', 'checked-in'])
            ->where(function($query) use ($invoice) {
                $query->whereDoesntHave('invoice')
                      ->orWhere('id', $invoice->appointment_id);
            })
            ->get();
        
        return view('receptionist.billing.edit', 
            compact('invoice', 'patients', 'appointments'));
    }

    /**
     * Update the specified invoice
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'required|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|in:pending,paid,partial,cancelled',
            'due_date' => 'required|date',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->patient_id = $request->patient_id;
        $invoice->appointment_id = $request->appointment_id;
        $invoice->amount = $request->amount;
        $invoice->description = $request->description;
        $invoice->status = $request->status;
        $invoice->due_date = $request->due_date;
        $invoice->save();

        return redirect()->route('receptionist.billing.index')
            ->with('success', 'Invoice updated successfully');
    }

    /**
     * Record a payment for an invoice
     */
    public function recordPayment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,credit_card,debit_card,insurance,bank_transfer',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $invoice = Invoice::findOrFail($id);
        
        $payment = new Payment();
        $payment->invoice_id = $invoice->id;
        $payment->appointment_id = $invoice->appointment_id;
        $payment->amount = $request->amount;
        $payment->payment_method = $request->payment_method;
        $payment->payment_date = $request->payment_date;
        $payment->reference_number = $request->reference_number;
        $payment->notes = $request->notes;
        $payment->save();
        
        // Update invoice status based on payments
        $totalPaid = $invoice->payments->sum('amount') + $request->amount;
        
        if ($totalPaid >= $invoice->amount) {
            $invoice->status = 'paid';
        } else if ($totalPaid > 0) {
            $invoice->status = 'partial';
        }
        
        $invoice->save();

        return redirect()->route('receptionist.billing.show', $invoice->id)
            ->with('success', 'Payment recorded successfully');
    }

    /**
     * Print the specified invoice
     */
    public function printInvoice($id)
    {
        $invoice = Invoice::with(['appointment.patient', 'payments'])->findOrFail($id);
        
        return view('receptionist.billing.print', compact('invoice'));
    }
}