@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-gradient-success text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title h4 mb-0 fw-bold">Payment Records</h3>
                <a href="{{ route('cashier.payments.create') }}" class="btn btn-light btn-sm d-flex align-items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    <span>Process Payment</span>
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle bg-white">
                    <thead>
                        <tr class="bg-light">
                            <th>Receipt #</th>
                            <th>Invoice #</th>
                            <th>Patient</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>
                                <a href="{{ route('cashier.payments.show', $payment->id) }}" class="fw-bold text-success">
                                    {{ $payment->receipt_number }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('cashier.invoices.show', $payment->invoice->id) }}" class="text-primary">
                                    {{ $payment->invoice->invoice_number }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <span class="fw-medium">{{ $payment->invoice->patient->name }}</span>
                                </div>
                            </td>
                            <td>₱{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->payment_method }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('cashier.payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('cashier.payments.receipt', $payment->id) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No payment records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 