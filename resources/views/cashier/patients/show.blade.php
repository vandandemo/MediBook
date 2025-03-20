@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-gradient-info text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title h4 mb-0 fw-bold">Patient Details</h3>
                <div>
                    <a href="{{ route('cashier.patients.index') }}" class="btn btn-light btn-sm me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Patients
                    </a>
                    <a href="{{ route('cashier.invoices.create', ['patient_id' => $patient->id]) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-file-invoice me-2"></i>Create Invoice
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body p-3">
                            <h5 class="mb-3 fw-bold text-primary">Patient Information</h5>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 120px;">Patient ID:</span>
                                <span class="fw-medium">{{ $patient->patient_id }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 120px;">Name:</span>
                                <span class="fw-medium">{{ $patient->name }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 120px;">Email:</span>
                                <span>{{ $patient->email }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 120px;">Phone:</span>
                                <span>{{ $patient->phone }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 120px;">Address:</span>
                                <span>{{ $patient->address }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body p-3">
                            <h5 class="mb-3 fw-bold text-primary">Additional Information</h5>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 120px;">Date of Birth:</span>
                                <span>{{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('M d, Y') : 'N/A' }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 120px;">Age:</span>
                                <span>{{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->age : 'N/A' }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 120px;">Gender:</span>
                                <span>{{ $patient->gender ?? 'N/A' }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 120px;">Blood Type:</span>
                                <span>{{ $patient->blood_type ?? 'N/A' }}</span>
                            </div>
                            <div class="mb-2 d-flex">
                                <span class="text-secondary me-3" style="width: 120px;">Insurance:</span>
                                <span>{{ $patient->insurance_provider ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Invoices -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow border-0">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Invoices</h6>
                            <a href="{{ route('cashier.invoices.create', ['patient_id' => $patient->id]) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus-circle me-2"></i>New Invoice
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($invoices as $invoice)
                                        <tr>
                                            <td>
                                                <a href="{{ route('cashier.invoices.show', $invoice->id) }}" class="fw-bold text-primary">
                                                    {{ $invoice->invoice_number }}
                                                </a>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</td>
                                            <td>₱{{ number_format($invoice->amount, 2) }}</td>
                                            <td>
                                                <span class="badge {{ $invoice->status === 'Paid' ? 'bg-success' : ($invoice->status === 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $invoice->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('cashier.invoices.show', $invoice->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($invoice->status === 'Pending')
                                                    <a href="{{ route('cashier.payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-sm btn-success">
                                                        <i class="fas fa-credit-card"></i>
                                                    </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">No invoices found for this patient.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow border-0">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Appointments</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th>Date & Time</th>
                                            <th>Doctor</th>
                                            <th>Status</th>
                                            <th>Invoice Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($appointments as $appointment)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y h:i A') }}</td>
                                            <td>Dr. {{ $appointment->doctor->name }}</td>
                                            <td>
                                                <span class="badge {{ $appointment->status === 'Completed' ? 'bg-success' : ($appointment->status === 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($appointment->invoice_id)
                                                <a href="{{ route('cashier.invoices.show', $appointment->invoice_id) }}" class="badge bg-primary">
                                                    Invoiced
                                                </a>
                                                @else
                                                <span class="badge bg-secondary">Not Invoiced</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('cashier.appointments.show', $appointment->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($appointment->status === 'Completed' && !$appointment->invoice_id)
                                                    <a href="{{ route('cashier.invoices.create', ['appointment_id' => $appointment->id]) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">No appointments found for this patient.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 