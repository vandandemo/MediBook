<x-receptionist-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg rounded-3 border-0">
                    <div class="card-header bg-gradient-primary text-black py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title h4 mb-0 fw-bold">Today's Appointments</h3>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle bg-white mb-0">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="text-center px-3" style="width: 60px;">ID</th>
                                        <th class="px-3">Patient</th>
                                        <th class="px-3">Doctor</th>
                                        <th class="px-3">Date</th>
                                        <th class="text-center px-3">Status</th>
                                        <th class="text-end px-3">Amount</th>
                                        <th class="text-center px-3" style="width: 200px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $appointment)
                                        <tr class="align-middle">
                                            <td class="text-center fw-semibold text-secondary px-3">{{ $appointment->id }}</td>
                                            <td class="px-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </div>
                                                    <span class="fw-medium">{{ $appointment->patient->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-info bg-opacity-10 p-2 me-3">
                                                        <i class="fas fa-user-md text-info"></i>
                                                    </div>
                                                    <span class="fw-medium">{{ $appointment->doctor->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3">
                                                {{ $appointment->appointment_date }}
                                            </td>
                                            <td class="text-center px-3">
                                                <span class="badge {{ $appointment->status === 'Completed' ? 'bg-success' : ($appointment->status === 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                            <td class="text-end px-3">
                                                ₱{{ number_format($appointment->amount, 2) }}
                                            </td>
                                            <td class="text-center px-3">
                                                <a href="{{ route('receptionist.appointments.edit', $appointment) }}" class="btn btn-sm btn-primary me-2">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('receptionist.appointments.show', $appointment) }}" class="btn btn-sm btn-info me-2">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('receptionist.appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this appointment?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                No appointments found for today.
                                            </td>
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
        </div>
    </div>
</x-receptionist-layout> 