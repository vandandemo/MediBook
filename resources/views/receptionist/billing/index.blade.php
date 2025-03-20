@extends('layouts.receptionist')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Billing & Invoices</h3>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-control" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="partial">Partial</option>
                                <option value="paid">Paid</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="dateFilter" placeholder="Filter by Date">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchFilter" placeholder="Search by Patient/Invoice #">
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('receptionist.billing.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create New Invoice
                            </a>
                        </div>
                    </div>

                    <!-- Invoices Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->appointment ? $invoice->appointment->patient->name : 'N/A' }}</td>
                                    <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                    <td>${{ number_format($invoice->amount, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'partial' ? 'warning' : ($invoice->status === 'cancelled' ? 'danger' : 'info')) }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $invoice->due_date->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('receptionist.billing.show', $invoice->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('receptionist.billing.edit', $invoice->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('receptionist.billing.print', $invoice->id) }}" class="btn btn-sm btn-secondary" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No invoices found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Status filter
    $('#statusFilter').change(function() {
        filterInvoices();
    });

    // Date filter
    $('#dateFilter').change(function() {
        filterInvoices();
    });

    // Search filter
    $('#searchFilter').on('keyup', function() {
        filterInvoices();
    });

    function filterInvoices() {
        let status = $('#statusFilter').val();
        let date = $('#dateFilter').val();
        let search = $('#searchFilter').val();

        window.location.href = "{{ route('receptionist.billing.index') }}" + 
            "?status=" + status + 
            "&date=" + date + 
            "&search=" + search;
    }
});
</script>
@endpush
@endsection 