<x-receptionist-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg rounded-3 border-0">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title h4 mb-0 fw-bold">Appointment Details</h3>
                            <div>
                                <a href="{{ route('receptionist.appointments.edit', $appointment) }}" class="btn btn-light btn-sm me-2">
                                    <i class="fas fa-edit me-2"></i>Edit
                                </a>
                                <a href="{{ route('receptionist.appointments.index') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-arrow-left me-2"></i>Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h5 class="fw-bold mb-3">Patient Information</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                                <i class="fas fa-user fa-2x text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1">{{ $appointment->patient->name }}</h6>
                                                <p class="text-muted mb-0">Patient ID: {{ $appointment->patient->id }}</p>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-envelope text-muted me-2"></i>
                                            {{ $appointment->patient->email }}
                                        </div>
                                        <div>
                                            <i class="fas fa-phone text-muted me-2"></i>
                                            {{ $appointment->patient->phone }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h5 class="fw-bold mb-3">Doctor Information</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                                <i class="fas fa-user-md fa-2x text-info"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1">{{ $appointment->doctor->name }}</h6>
                                                <p class="text-muted mb-0">Doctor ID: {{ $appointment->doctor->id }}</p>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-envelope text-muted me-2"></i>
                                            {{ $appointment->doctor->email }}
                                        </div>
                                        <div>
                                            <i class="fas fa-phone text-muted me-2"></i>
                                            {{ $appointment->doctor->phone }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <h5 class="fw-bold mb-3">Appointment Details</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <p class="text-muted mb-1">Appointment Date</p>
                                                <p class="fw-medium">{{ $appointment->appointment_date }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <p class="text-muted mb-1">Status</p>
                                                <span class="badge {{ $appointment->status === 'Completed' ? 'bg-success' : ($appointment->status === 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $appointment->status }}
                                                </span>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <p class="text-muted mb-1">Amount</p>
                                                <p class="fw-medium">₱{{ number_format($appointment->amount, 2) }}</p>
                                            </div>
                                            <div class="col-12">
                                                <p class="text-muted mb-1">Notes</p>
                                                <p class="fw-medium mb-0">{{ $appointment->notes ?? 'No notes available' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-receptionist-layout> 