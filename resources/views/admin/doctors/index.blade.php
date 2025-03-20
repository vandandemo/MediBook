@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Doctors</h1>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-user-md"></i> Manage Doctors
                </div>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Doctor
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Specialization</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($doctors as $doctor)
                                <tr>
                                    <td>{{ $doctor->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 30px; height: 30px;">
                                                <i class="fas fa-user-md"></i>
                                            </div>
                                            {{ $doctor->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ optional($doctor->specialization)->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ optional($doctor->department)->name ?? 'N/A' }}</td>
                                    <td>{{ $doctor->email }}</td>
                                    <td>{{ $doctor->phone_number }}</td>
                                    <td>
                                        <span class="badge bg-{{ $doctor->active ? 'success' : 'danger' }}">
                                            {{ $doctor->active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $doctor->created_at->format('M d, Y H:i A') }}</td>
                                    <td>
                                        <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this doctor?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No doctors found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $doctors->links() }}
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
