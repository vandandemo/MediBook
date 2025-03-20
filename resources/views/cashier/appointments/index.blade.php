@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title h4 mb-0 fw-bold">All Appointments</h3>
                <a href="{{ route('cashier.appointments.today') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-calendar-day me-2"></i>Today's Appointments
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('cashier.appointments.index') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by patient name or ID..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('cashier.appointments.index') }}" method="GET" class="d-flex justify-content-md-end mt-3 mt-md-0">
                        <div class="input-group w-md-50">
                            <input type="date" name="date" class="form-control" value="{{ request('date', date('Y-m-d')) }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle bg-white">
                    <thead>
                        <tr class="bg-light">
                            <th>Date & Time</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Invoice</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <span class="fw-medium">
                                        <a href="{{ route('cashier.patients.show', $appointment->patient->id) }}" class="text-dark">
                                            {{ $appointment->patient->name }}
                                        </a>
                                    </span>
                                </div>
                            </td>
                            <td>Dr. {{ $appointment->doctor->name }}</td>
                            <td>{{ $appointment->appointment_type }}</td>
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
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
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
                            <td colspan="7" class="text-center py-4">No appointments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $appointments->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection