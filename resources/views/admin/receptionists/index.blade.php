@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Receptionists</h1>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-user-tie"></i> Manage Receptionists
            </div>
            <a href="{{ route('admin.receptionists.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Receptionist
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Shift</th>
                            <th>Employee ID</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receptionists as $receptionist)
                            <tr>
                                <td>{{ $receptionist->id }}</td>
                                <td>{{ $receptionist->name }}</td>
                                <td>{{ $receptionist->email }}</td>
                                <td>{{ $receptionist->phone ?? 'N/A' }}</td>
                                <td>{{ ucfirst($receptionist->shift) }}</td>
                                <td>{{ $receptionist->employee_id }}</td>
                                <td>
                                    <span class="badge bg-{{ $receptionist->active ? 'success' : 'danger' }}">
                                        {{ $receptionist->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $receptionist->created_at->format('M d, Y h:i A') }}</td>
                                <td>{{ $receptionist->updated_at->format('M d, Y h:i A') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.receptionists.show', $receptionist) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.receptionists.edit', $receptionist) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.receptionists.destroy', $receptionist) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this receptionist?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">No receptionists found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $receptionists->links() }}
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
