@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title h4 mb-0 fw-bold">Invoice Details</h3>
                <div>
                    <a href="{{ route('cashier.invoices.index') }}" class="btn btn-light btn-sm me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Invoices
                    </a>
                    <a href="{{ route('cashier.invoices.print', $invoice->id) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-print me-2"></i>Print Invoice
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body p-3">
                            <h5 class="mb-3 fw-bold text-primary">Invoice Information</h5>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 130px;">Invoice Number:</span>
                                <span class="fw-medium">{{ $invoice->invoice_number }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 130px;">Status:</span>
                                <span class="badge {{ $invoice->status === 'Paid' ? 'bg-success' : ($invoice->status === 'Pending' ? 'bg-warning' : 'bg-danger') }} py-1">
                                    {{ $invoice->status }}
                                </span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 130px;">Invoice Date:</span>
                                <span>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 130px;">Due Date:</span>
                                <span>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="mb-0 d-flex">
                                <span class="text-secondary me-3" style="width: 130px;">Amount:</span>
                                <span class="fw-bold">₱{{ number_format($invoice->amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body p-3">
                            <h5 class="mb-3 fw-bold text-primary">Patient Information</h5>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 130px;">Patient:</span>
                                <span class="fw-medium">{{ $invoice->patient->name }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 130px;">Email:</span>
                                <span>{{ $invoice->patient->email }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 130px;">Phone:</span>
                                <span>{{ $invoice->patient->phone }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 130px;">Address:</span>
                                <span>{{ $invoice->patient->address }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 bg-light">
                        <div class="card-body p-3">
                            <h5 class="mb-3 fw-bold text-primary">Invoice Description</h5>
                            <p>{{ $invoice->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($invoice->appointment)
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 bg-light">
                        <div class="card-body p-3">
                            <h5 class="mb-3 fw-bold text-primary">Appointment Details</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2 d-flex">
                                        <span class="text-secondary me-3" style="width: 130px;">Doctor:</span>
                                        <span>Dr. {{ $invoice->appointment->doctor->name }}</span>
                                    </div>
                                    <div class="mb-2 d-flex">
                                        <span class="text-secondary me-3" style="width: 130px;">Date:</span>
                                        <span>{{ \Carbon\Carbon::parse($invoice->appointment->appointment_date)->format('M d, Y h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2 d-flex">
                                        <span class="text-secondary me-3" style="width: 130px;">Status:</span>
                                        <span class="badge {{ $invoice->appointment->status === 'Completed' ? 'bg-success' : ($invoice->appointment->status === 'Pending' ? 'bg-warning' : 'bg-danger') }} py-1">
                                            {{ $invoice->appointment->status }}
                                        </span>
                                    </div>
                                    <div class="mb-2 d-flex">
                                        <span class="text-secondary me-3" style="width: 130px;">Type:</span>
                                        <span>{{ $invoice->appointment->appointment_type }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end gap-2">
                        @if($invoice->status === 'Pending')
                        <a href="{{ route('cashier.payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-success">
                            <i class="fas fa-credit-card me-2"></i>Process Payment
                        </a>
                        <a href="{{ route('cashier.invoices.edit', $invoice->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Invoice
                        </a>
                        @endif
                        <form action="{{ route('cashier.invoices.destroy', $invoice->id) }}" method="POST" 
                            onsubmit="return confirm('Are you sure you want to delete this invoice? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" {{ $invoice->status === 'Paid' ? 'disabled' : '' }}>
                                <i class="fas fa-trash-alt me-2"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 