<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Patient;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $billings = Billing::with('patient')->latest()->paginate(10);
        return view('admin.billing.index', compact('billings'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('admin.billing.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'billing_date' => 'required|date',
        ]);

        Billing::create([
            'patient_id' => $request->patient_id,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'amount' => $request->amount,
            'billing_date' => $request->billing_date,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.billing.index')->with('success', 'Billing record created successfully.');
    }

    public function show(Billing $billing)
    {
        return view('admin.billing.show', compact('billing'));
    }

    public function edit(Billing $billing)
    {
        $patients = Patient::all();
        return view('admin.billing.edit', compact('billing', 'patients'));
    }

    public function update(Request $request, Billing $billing)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'billing_date' => 'required|date',
            'status' => 'required|in:pending,paid,canceled',
        ]);

        $billing->update($request->all());

        return redirect()->route('admin.billing.index')->with('success', 'Billing record updated successfully.');
    }

    public function destroy(Billing $billing)
    {
        $billing->delete();
        return redirect()->route('admin.billing.index')->with('success', 'Billing record deleted successfully.');
    }
}
