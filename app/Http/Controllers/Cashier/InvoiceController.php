<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:cashier');
    }

    public function index()
    {
        $invoices = Invoice::with(['patient', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('cashier.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        
        try {
            $pendingAppointments = Appointment::where('status', 'Completed')
                ->whereNull('invoice_id')
                ->with(['patient', 'doctor'])
                ->get();
        } catch (\Exception $e) {
            // Fallback query if invoice_id column doesn't exist yet
            $pendingAppointments = Appointment::where('status', 'Completed')
                ->with(['patient', 'doctor'])
                ->get();
        }
            
        Log::info('Accessed create method in InvoiceController', ['patients_count' => $patients->count(), 'doctors_count' => $doctors->count()]);
        
        return view('cashier.invoices.create', compact('patients', 'doctors', 'pendingAppointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'required|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $invoice = new Invoice();
            $invoice->patient_id = $request->patient_id;
            $invoice->appointment_id = $request->appointment_id;
            $invoice->amount = $request->amount;
            $invoice->description = $request->description;
            $invoice->due_date = $request->due_date;
            $invoice->status = 'Pending';
            $invoice->cashier_id = auth()->guard('cashier')->id();
            $invoice->invoice_date = now();
            $invoice->invoice_number = 'INV-' . date('Ymd') . '-' . random_int(1000, 9999);
            $invoice->save();

            // Update appointment with invoice_id
            $appointment = Appointment::find($request->appointment_id);
            $appointment->invoice_id = $invoice->id;
            $appointment->save();

            DB::commit();
            return redirect()->route('cashier.invoices.show', $invoice->id)
                ->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'appointment', 'appointment.doctor']);
        return view('cashier.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $patients = Patient::all();
        $invoice->load(['patient', 'appointment']);
        
        return view('cashier.invoices.edit', compact('invoice', 'patients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'status' => 'required|in:Pending,Paid,Cancelled',
        ]);

        $invoice->amount = $request->amount;
        $invoice->description = $request->description;
        $invoice->due_date = $request->due_date;
        $invoice->status = $request->status;
        $invoice->save();

        return redirect()->route('cashier.invoices.show', $invoice->id)
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->status === 'Paid') {
            return back()->with('error', 'Cannot delete a paid invoice.');
        }

        // Update appointment to remove invoice_id
        if ($invoice->appointment) {
            $invoice->appointment->invoice_id = null;
            $invoice->appointment->save();
        }

        $invoice->delete();
        return redirect()->route('cashier.invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['patient', 'appointment', 'appointment.doctor']);
        return view('cashier.invoices.print', compact('invoice'));
    }
} 