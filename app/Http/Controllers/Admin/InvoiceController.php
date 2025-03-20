<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\InsuranceClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['patient', 'appointment.patient', 'insuranceClaim'])
            ->latest()
            ->paginate(10);

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $patients = \App\Models\Patient::where('active', true)->get();
        $appointments = \App\Models\Appointment::where('status', 'scheduled')
            ->with('patient')
            ->get();
        return view('admin.invoices.create', compact('patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'sometimes|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'payment_method' => 'required|string|in:cash,credit_card,debit_card,insurance',
            'insurance_claim_id' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $validated['status'] = 'pending';
        $validated['issued_date'] = now();
        $validated['invoice_number'] = 'INV-' . strtoupper(uniqid());
        
        DB::beginTransaction();
        try {
            $invoice = Invoice::create($validated);
            $invoice->load(['patient', 'appointment', 'payments', 'insuranceClaim']);
            
            DB::commit();
            return redirect()->route('admin.invoices.show', $invoice)
                ->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create invoice. Please try again.');
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'appointment', 'payments', 'insuranceClaim']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $patients = \App\Models\Patient::where('active', true)->get();
        return view('admin.invoices.edit', compact('invoice', 'patients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        try {
            $validated = $request->validate([
                'patient_id' => 'sometimes|exists:patients,id',
                'amount' => 'required|numeric|min:0',
                'due_date' => 'required|date',
                'status' => 'required|in:pending,paid,partially_paid,overdue,cancelled',
                'payment_method' => 'required|string|in:cash,credit_card,debit_card,insurance',
                'insurance_claim_id' => 'nullable|string|max:255',
                'notes' => 'nullable|string'
            ]);

            \Log::info('Updating invoice #' . $invoice->id, [
                'current_insurance_claim_id' => $invoice->insurance_claim_id,
                'new_insurance_claim_id' => $validated['insurance_claim_id'],
                'request_data' => $request->all()
            ]);

            DB::beginTransaction();
            
            // Update the invoice with validated data
            $invoice->insurance_claim_id = $validated['insurance_claim_id'];
            $invoice->fill($request->only(['amount', 'due_date', 'status', 'payment_method', 'insurance_claim_id', 'notes']));
        if ($request->has('patient_id')) {
            $invoice->patient_id = $validated['patient_id'];
        }
            $invoice->save();

            // Update insurance claim status if provided
            if ($validated['insurance_claim_id'] && isset($request->insurance_claim_status)) {
                $insuranceClaim = InsuranceClaim::where('id', $validated['insurance_claim_id'])->first();
                if ($insuranceClaim) {
                    $insuranceClaim->status = $request->insurance_claim_status;
                    $insuranceClaim->save();
                }
            }
            
            \Log::info('Invoice #' . $invoice->id . ' updated successfully', [
                'updated_data' => $invoice->getDirty()
            ]);
            
            DB::commit();

            return redirect()
                ->route('admin.invoices.index')
                ->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Invoice update failed: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Failed to update invoice. Please try again.');
        }
    }

    public function destroy(Invoice $invoice)
    {
        try {
            DB::beginTransaction();
            $invoice->delete();
            DB::commit();

            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete invoice. Please try again.');
        }
    }

    public function recordPayment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'transaction_id' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($invoice, $validated) {
            $payment = $invoice->payments()->create([
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'payment_date' => $validated['payment_date'],
                'transaction_id' => $validated['transaction_id'] ?? null,
                'status' => 'completed'
            ]);

            $totalPaid = $invoice->payments()->where('status', 'completed')
                ->sum('amount');

            $invoice->status = $totalPaid >= $invoice->amount ? 'paid' : 'partially_paid';
            $invoice->save();
        });

        return redirect()->route('admin.invoices.show', $invoice)
            ->with('success', 'Payment recorded successfully.');
    }

    public function processRefund(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'refund_amount' => 'required|numeric|min:0|max:' . $payment->getRefundableAmount(),
            'refund_reason' => 'required|string'
        ]);

        DB::transaction(function () use ($payment, $validated) {
            $payment->refunded_amount = $validated['refund_amount'];
            $payment->refund_reason = $validated['refund_reason'];
            $payment->refund_date = now();
            $payment->status = 'refunded';
            $payment->save();

            $invoice = $payment->invoice;
            $totalPaid = $invoice->payments()
                ->where('status', 'completed')
                ->sum('amount');

            $invoice->status = $totalPaid >= $invoice->amount ? 'paid' : 'partially_paid';
            $invoice->save();
        });

        return redirect()->back()->with('success', 'Refund processed successfully.');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['patient', 'appointment', 'payments', 'insuranceClaim']);
        return view('admin.invoices.print', compact('invoice'));
    }

    public function attachInsuranceClaim(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'insurance_provider' => 'required|string',
            'policy_number' => 'required|string',
            'amount_claimed' => 'required|numeric|min:0|max:' . $invoice->amount,
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $documents = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $path = $document->store('insurance-claims', 'public');
                $documents[] = $path;
            }
        }

        $insuranceClaim = InsuranceClaim::create([
            'patient_id' => $invoice->patient_id,
            'insurance_provider' => $validated['insurance_provider'],
            'policy_number' => $validated['policy_number'],
            'amount_claimed' => $validated['amount_claimed'],
            'status' => 'pending',
            'submission_date' => now(),
            'documents' => $documents
        ]);

        $invoice->insurance_claim_id = $insuranceClaim->id;
        $invoice->save();

        return redirect()->route('admin.invoices.show', $invoice)
            ->with('success', 'Insurance claim attached successfully.');
    }

    public function updateInsuranceClaim(Request $request, InsuranceClaim $claim)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'amount_approved' => 'required_if:status,approved|nullable|numeric|min:0',
            'rejection_reason' => 'required_if:status,rejected|nullable|string'
        ]);

        $claim->update([
            'status' => $validated['status'],
            'amount_approved' => $validated['amount_approved'] ?? null,
            'rejection_reason' => $validated['rejection_reason'] ?? null,
            'approval_date' => $validated['status'] === 'approved' ? now() : null
        ]);

        return redirect()->back()->with('success', 'Insurance claim updated successfully.');
    }
}