@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Patients</h1>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-user-injured"></i>
                    Manage Patients
                </div>
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Patient
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Blood Group</th>
                                <th>DOB</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($patients as $patient)
                                <tr>
                                    <td>{{ $patient->name }}</td>
                                    <td>{{ $patient->email }}</td>
                                    <td>{{ $patient->phone }}</td>
                                    <td>{{ $patient->address }}</td>
                                    <td>
                                        <span class="badge bg-danger">{{ $patient->blood_group }}</span>
                                    </td>
                                    <td>{{ $patient->date_of_birth->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $patient->active ? 'success' : 'danger' }}">
                                            {{ $patient->active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $patient->created_at->format('M d, Y H:i A') }}</td>
                                    <td>{{ $patient->updated_at->format('M d, Y H:i A') }}</td>
                                    <td>
                                        <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No patients found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $patients->links() }}
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
        overflow-x: auto; /* Ensure table is scrollable if needed */
    }
    .table th, .table td {
        padding: 12px 8px; /* Increase padding for better spacing */
        font-size: 14px; /* Adjust font size */
        white-space: nowrap; /* Prevent text from wrapping */
    }
</style>
@endpush
