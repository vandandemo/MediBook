@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-gradient-success text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title h4 mb-0 fw-bold">Payment Details</h3>
                <div>
                    <a href="{{ route('cashier.payments.index') }}" class="btn btn-light btn-sm me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Payments
                    </a>
                    <a href="{{ route('cashier.payments.receipt', $payment->id) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-print me-2"></i>Print Receipt
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body p-3">
                            <h5 class="mb-3 fw-bold text-success">Payment Information</h5>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 140px;">Receipt Number:</span>
                                <span class="fw-medium">{{ $payment->receipt_number }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 140px;">Payment Method:</span>
                                <span>{{ $payment->payment_method }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 140px;">Payment Date:</span>
                                <span>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 140px;">Amount:</span>
                                <span class="fw-bold">₱{{ number_format($payment->amount, 2) }}</span>
                            </div>
                            @if($payment->reference_number)
                            <div class="mb-0 d-flex">
                                <span class="text-secondary me-3" style="width: 140px;">Reference Number:</span>
                                <span>{{ $payment->reference_number }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body p-3">
                            <h5 class="mb-3 fw-bold text-success">Invoice Information</h5>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 140px;">Invoice Number:</span>
                                <span class="fw-medium">
                                    <a href="{{ route('cashier.invoices.show', $payment->invoice->id) }}" class="text-primary">
                                        {{ $payment->invoice->invoice_number }}
                                    </a>
                                </span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 140px;">Invoice Date:</span>
                                <span>{{ \Carbon\Carbon::parse($payment->invoice->invoice_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 140px;">Patient:</span>
                                <span>
                                    <a href="{{ route('cashier.patients.show', $payment->invoice->patient->id) }}" class="text-primary">
                                        {{ $payment->invoice->patient->name }}
                                    </a>
                                </span>
                            </div>
                            <div class="mb-0 d-flex">
                                <span class="text-secondary me-3" style="width: 140px;">Processed By:</span>
                                <span>{{ $payment->cashier->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($payment->notes)
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 bg-light">
                        <div class="card-body p-3">
                            <h5 class="mb-3 fw-bold text-success">Payment Notes</h5>
                            <p>{{ $payment->notes }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('cashier.payments.receipt', $payment->id) }}" class="btn btn-success">
                            <i class="fas fa-print me-2"></i>Print Receipt
                        </a>
                        <a href="{{ route('cashier.invoices.show', $payment->invoice->id) }}" class="btn btn-primary">
                            <i class="fas fa-file-invoice me-2"></i>View Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 