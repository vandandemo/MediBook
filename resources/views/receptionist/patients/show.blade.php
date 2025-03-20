@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Patient Details</h5>
                    <a href="{{ route('receptionist.patients.edit', $patient->id) }}" class="btn btn-primary">Edit Patient</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Personal Information</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $patient->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $patient->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $patient->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ ucfirst($patient->gender) }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $patient->address ?: 'Not provided' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Medical Information</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Blood Group</th>
                                    <td>{{ $patient->blood_group ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <th>Allergies</th>
                                    <td>{{ $patient->allergies ?: 'None reported' }}</td>
                                </tr>
                                <tr>
                                    <th>Medical History</th>
                                    <td>{{ $patient->medical_history ?: 'No history provided' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6>Recent Appointments</h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Doctor</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patient->appointments()->latest()->take(5)->get() as $appointment)
                                <tr>
                                    <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                    <td>{{ $appointment->scheduled_time }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'scheduled' ? 'primary' : 'warning') }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('receptionist.appointments.show', $appointment->id) }}" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No appointments found</td>
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