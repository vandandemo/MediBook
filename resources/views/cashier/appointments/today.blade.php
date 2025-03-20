@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-gradient-warning text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title h4 mb-0 fw-bold">Today's Appointments</h3>
                <a href="{{ route('cashier.appointments.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-calendar me-2"></i>All Appointments
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle bg-white">
                    <thead>
                        <tr class="bg-light">
                            <th>Time</th>
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
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}</td>
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
                            <td colspan="7" class="text-center py-4">No appointments scheduled for today.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 