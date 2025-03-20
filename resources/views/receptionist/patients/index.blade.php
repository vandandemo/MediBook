<x-receptionist-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg rounded-3 border-0">
                    <div class="card-header bg-gradient-primary text-black py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title h4 mb-0 fw-bold">Patients Management</h3>
                            <a href="{{ route('receptionist.patients.create') }}" class="btn btn-light btn-sm d-flex align-items-center gap-2">
                                <i class="fas fa-plus-circle"></i>
                                <span>New Patient</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Search Form -->
                        <form action="{{ route('receptionist.patients.search') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle bg-white mb-0">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="px-3">ID</th>
                                        <th class="px-3">Name</th>
                                        <th class="px-3">Email</th>
                                        <th class="px-3">Phone</th>
                                        <th class="px-3">Date of Birth</th>
                                        <th class="text-center px-3">Status</th>
                                        <th class="text-center px-3" style="width: 200px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($patients as $patient)
                                        <tr>
                                            <td class="px-3">{{ $patient->id }}</td>
                                            <td class="px-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </div>
                                                    <span class="fw-medium">{{ $patient->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3">{{ $patient->email }}</td>
                                            <td class="px-3">{{ $patient->phone }}</td>
                                            <td class="px-3">{{ $patient->date_of_birth->format('M d, Y') }}</td>
                                            <td class="text-center px-3">
                                                <span class="badge {{ $patient->active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $patient->active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="text-center px-3">
                                                <a href="{{ route('receptionist.patients.edit', $patient->id) }}" class="btn btn-sm btn-primary me-2">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('receptionist.patients.show', $patient->id) }}" class="btn btn-sm btn-info me-2">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('receptionist.appointments.create') }}?patient_id={{ $patient->id }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-calendar-plus"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                No patients found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $patients->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-receptionist-layout> 