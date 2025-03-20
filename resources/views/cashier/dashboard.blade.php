@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 text-center mb-4">
            <h1 class="h2 mb-2">Cashier Dashboard</h1>
            <p class="text-muted">Welcome back, {{ Auth::guard('cashier')->user()->name }}!</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-5 justify-content-center">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                TODAY'S PAYMENTS</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">₱{{ number_format($todaysPayments, 2) }}</div>
                        </div>
                        <div class="col-4 text-center">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                MONTHLY REVENUE</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">₱{{ number_format($monthlyRevenue, 2) }}</div>
                        </div>
                        <div class="col-4 text-center">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                PENDING INVOICES</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $pendingInvoices }}</div>
                        </div>
                        <div class="col-4 text-center">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                APPOINTMENTS TODAY</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $appointmentsToday }}</div>
                        </div>
                        <div class="col-4 text-center">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <!-- Recent Payments -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Payments</h6>
                    <a href="{{ route('cashier.payments.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Patient</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPayments as $payment)
                                <tr>
                                    <td>
                                        <a href="{{ route('cashier.invoices.show', $payment->invoice->id) }}">
                                            {{ $payment->invoice->invoice_number }}
                                        </a>
                                    </td>
                                    <td>{{ $payment->invoice->patient->name }}</td>
                                    <td>₱{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">Paid</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No recent payments found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('cashier.invoices.create') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-file-invoice me-2"></i> New Invoice
                        </a>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('cashier.payments.create') }}" class="btn btn-success btn-block">
                            <i class="fas fa-credit-card me-2"></i> Process Payment
                        </a>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('cashier.patients.search') }}?query=" class="btn btn-info btn-block text-white">
                            <i class="fas fa-search me-2"></i> Search Patient
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('cashier.appointments.today') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-calendar-day me-2"></i> Today's Appointments
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Today's Appointments</h6>
                    <a href="{{ route('cashier.appointments.today') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Time</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayAppointments as $appointment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium">
                                                <a href="{{ route('cashier.patients.show', $appointment->patient->id) }}" class="text-dark">
                                                    {{ $appointment->patient->name }}
                                                </a>
                                            </span>
                                        </div>
                                    </td>
                                    <td>Dr. {{ $appointment->doctor->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}</td>
                                    <td>{{ $appointment->appointment_type ?? 'Regular' }}</td>
                                    <td>
                                        <span class="badge {{ $appointment->status === 'Completed' ? 'bg-success' : ($appointment->status === 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $appointment->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('cashier.appointments.show', $appointment->id) }}" class="btn btn-sm btn-info me-2">
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
                                    <td colspan="6" class="text-center py-4">No appointments scheduled for today.</td>
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
@endsection

@push('styles')
<style>
    .card {
        border-left: 0.25rem solid #ddd;
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .col-xl-3:nth-child(1) .card {
        border-left-color: #4e73df;
    }
    
    .col-xl-3:nth-child(2) .card {
        border-left-color: #1cc88a;
    }
    
    .col-xl-3:nth-child(3) .card {
        border-left-color: #36b9cc;
    }
    
    .col-xl-3:nth-child(4) .card {
        border-left-color: #f6c23e;
    }
    
    .btn-block {
        display: block;
        width: 100%;
    }
    
    .table th {
        font-size: 0.85rem;
        text-transform: uppercase;
    }
    
    .font-weight-bold {
        font-weight: 700 !important;
    }
</style>
@endpush