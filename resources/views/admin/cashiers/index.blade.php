@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Cashiers</h1>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-user-tie"></i> Manage Cashiers
                </div>
                <a href="{{ route('admin.cashiers.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Cashier
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
                                <th>Email Verified</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Employee ID</th>
                                <th>Shift</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cashiers as $cashier)
                                <tr>
                                    <td>{{ $cashier->id }}</td>
                                    <td>{{ $cashier->name }}</td>
                                    <td>{{ $cashier->email }}</td>
                                    <td>
                                        @if ($cashier->email_verified_at)
                                            <span class="badge bg-success">{{ $cashier->email_verified_at->format('M d, Y H:i A') }}</span>
                                        @else
                                            <span class="badge bg-danger">Not Verified</span>
                                        @endif
                                    </td>
                                    <td>{{ $cashier->phone ?? 'N/A' }}</td>
                                    <td>{{ $cashier->address ?? 'N/A' }}</td>
                                    <td>{{ $cashier->employee_id ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($cashier->shift) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $cashier->active ? 'success' : 'danger' }}">
                                            {{ $cashier->active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $cashier->created_at->format('M d, Y H:i A') }}</td>
                                    <td>{{ $cashier->updated_at->format('M d, Y H:i A') }}</td>
                                    <td>
                                        <a href="{{ route('admin.cashiers.show', $cashier) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.cashiers.edit', $cashier) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.cashiers.destroy', $cashier) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No cashiers found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $cashiers->links() }}
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
