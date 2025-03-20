@extends('layouts.receptionist')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Invoice Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('receptionist.billing.print', $invoice->id) }}" class="btn btn-secondary" target="_blank">
                            <i class="fas fa-print"></i> Print Invoice
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Invoice Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Patient Information</h5>
                            <p><strong>Name:</strong> {{ $invoice->patient->name }}</p>
                            <p><strong>ID:</strong> {{ $invoice->patient->id }}</p>
                            <p><strong>Contact:</strong> {{ $invoice->patient->phone }}</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <h5>Invoice Information</h5>
                            <p><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
                            <p><strong>Date:</strong> {{ $invoice->created_at->format('M d, Y') }}</p>
                            <p><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge badge-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'partial' ? 'warning' : ($invoice->status === 'cancelled' ? 'danger' : 'info')) }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $invoice->description }}</td>
                                    <td>${{ number_format($invoice->amount, 2) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total Amount</th>
                                    <th>${{ number_format($invoice->amount, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Payment History -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Payment History</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th>Reference</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($invoice->payments as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                            <td>${{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                            <td>{{ $payment->reference_number ?? 'N/A' }}</td>
                                            <td>{{ $payment->notes ?? 'N/A' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No payments recorded yet</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Record Payment Form -->
                    @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Record Payment</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('receptionist.billing.payment', $invoice->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" step="0.01" name="amount" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payment Method</label>
                                            <select name="payment_method" class="form-control" required>
                                                <option value="cash">Cash</option>
                                                <option value="credit_card">Credit Card</option>
                                                <option value="debit_card">Debit Card</option>
                                                <option value="insurance">Insurance</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payment Date</label>
                                            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Reference Number</label>
                                            <input type="text" name="reference_number" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea name="notes" class="form-control" rows="2"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Record Payment</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 