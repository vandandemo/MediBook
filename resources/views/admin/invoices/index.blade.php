@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Invoices</h1>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-file-invoice"></i> Manage Invoices
            </div>
            <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Create New Invoice
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Invoice No.</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Issued Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->patient->name }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>${{ number_format($invoice->amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $invoice->payment_status === 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($invoice->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ $invoice->issued_date ? $invoice->issued_date->format('M d, Y') : 'N/A' }}</td>
                                <td>{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $invoice->status === 'active' ? 'primary' : 'danger' }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>{{ $invoice->created_at ? $invoice->created_at->format('M d, Y h:i A') : 'N/A' }}</td>
                                <td>{{ $invoice->updated_at ? $invoice->updated_at->format('M d, Y h:i A') : 'N/A' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.open('{{ route('admin.invoices.print', $invoice) }}', '_blank', 'width=800,height=600')">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this invoice?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">No invoices found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $invoices->links() }}
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
