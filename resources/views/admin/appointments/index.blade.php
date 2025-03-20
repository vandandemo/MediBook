@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Appointments</h1>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-calendar-check"></i> Manage Appointments
            </div>
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Appointment
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Rating</th>
                            <th>Amount</th>
                            <th>Notes</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->patient->name }}</td>
                                <td>{{ $appointment->doctor->name }}</td>
                                <td>{{ $appointment->appointment_date->format('M d, Y h:i A') }}</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $appointment->status === 'confirmed' ? 'success' : 
                                        ($appointment->status === 'pending' ? 'warning' : 
                                        ($appointment->status === 'cancelled' ? 'danger' : 'secondary')) }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $appointment->rating ?? 'N/A' }}</td>
                                <td class="text-center">${{ number_format($appointment->amount, 2) }}</td>
                                <td>{{ Str::limit($appointment->notes, 30) }}</td>
                                <td>{{ $appointment->created_at->format('M d, Y h:i A') }}</td>
                                <td>{{ $appointment->updated_at->format('M d, Y h:i A') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-appointment" data-id="{{ $appointment->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">No appointments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        font-size: 0.875em;
    }
    .table th {
        background-color: #f8f9fa;
        padding: 12px 8px;
    }
    .table td {
        padding: 12px 8px;
        font-size: 0.95rem;
        line-height: 1.4;
        vertical-align: middle;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .table th, .table td {
        padding: 12px 8px;
        font-size: 14px;
        white-space: nowrap;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-appointment').forEach(button => {
            button.addEventListener('click', function() {
                const appointmentId = this.dataset.id;
                if (confirm('Are you sure you want to delete this appointment?')) {
                    fetch(`/admin/appointments/${appointmentId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('tr').remove();
                            alert(data.message);
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => {
                        alert('Error: ' + error.message);
                    });
                }
            });
        });
    });
</script>
@endpush
