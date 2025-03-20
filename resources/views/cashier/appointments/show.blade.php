@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-gradient-info text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title h4 mb-0 fw-bold">Appointment Details</h3>
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm me-2">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                    @if($appointment->status === 'Completed' && !$appointment->invoice_id)
                    <a href="{{ route('cashier.invoices.create', ['appointment_id' => $appointment->id]) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-file-invoice me-1"></i>Create Invoice
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0 fw-bold">Appointment Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Appointment ID</label>
                                <p class="fw-bold mb-0">{{ $appointment->id }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Appointment Date & Time</label>
                                <p class="fw-bold mb-0">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y h:i A') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Type</label>
                                <p class="fw-bold mb-0">{{ $appointment->appointment_type }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Status</label>
                                <p class="mb-0">
                                    <span class="badge {{ $appointment->status === 'Completed' ? 'bg-success' : ($appointment->status === 'Pending' ? 'bg-warning' : 'bg-danger') }} px-3 py-2">
                                        {{ $appointment->status }}
                                    </span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Invoice Status</label>
                                <p class="mb-0">
                                    @if($appointment->invoice_id)
                                    <a href="{{ route('cashier.invoices.show', $appointment->invoice_id) }}" class="badge bg-primary px-3 py-2">
                                        Invoiced - View Invoice
                                    </a>
                                    @else
                                    <span class="badge bg-secondary px-3 py-2">Not Invoiced</span>
                                    @endif
                                </p>
                            </div>
                            @if($appointment->notes)
                            <div class="mb-0">
                                <label class="text-muted small mb-1">Notes</label>
                                <p class="mb-0">{{ $appointment->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0 fw-bold">Patient Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                    <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">{{ $appointment->patient->name }}</h5>
                                    <p class="text-muted small mb-0">Patient ID: {{ $appointment->patient->id }}</p>
                                </div>
                                <a href="{{ route('cashier.patients.show', $appointment->patient->id) }}" class="btn btn-sm btn-outline-primary ms-auto">
                                    <i class="fas fa-eye me-1"></i>View Profile
                                </a>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small mb-1">Phone</label>
                                    <p class="fw-bold mb-0">{{ $appointment->patient->phone }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small mb-1">Email</label>
                                    <p class="fw-bold mb-0">{{ $appointment->patient->email }}</p>
                                </div>
                                @if($appointment->patient->date_of_birth)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small mb-1">Age</label>
                                    <p class="fw-bold mb-0">{{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age }} years</p>
                                </div>
                                @endif
                                @if($appointment->patient->gender)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small mb-1">Gender</label>
                                    <p class="fw-bold mb-0">{{ $appointment->patient->gender }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0 fw-bold">Doctor Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                    <i class="fas fa-user-md fa-2x text-info"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Dr. {{ $appointment->doctor->name }}</h5>
                                    <p class="text-muted small mb-0">{{ $appointment->doctor->specialization }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 