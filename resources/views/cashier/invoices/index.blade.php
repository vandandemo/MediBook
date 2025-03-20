@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title h4 mb-0 fw-bold">Invoice Management</h3>
                <a href="{{ route('cashier.invoices.create') }}" class="btn btn-light btn-sm d-flex align-items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    <span>New Invoice</span>
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle bg-white">
                    <thead>
                        <tr class="bg-light">
                            <th>Invoice #</th>
                            <th>Patient</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            <td>
                                <a href="{{ route('cashier.invoices.show', $invoice->id) }}" class="fw-bold text-primary">
                                    {{ $invoice->invoice_number }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <span class="fw-medium">{{ $invoice->patient->name }}</span>
                                </div>
                            </td>
                            <td>₱{{ number_format($invoice->amount, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $invoice->status === 'Paid' ? 'bg-success' : ($invoice->status === 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('cashier.invoices.show', $invoice->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($invoice->status !== 'Paid')
                                    <a href="{{ route('cashier.invoices.edit', $invoice->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('cashier.invoices.print', $invoice->id) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    @if($invoice->status === 'Pending')
                                    <a href="{{ route('cashier.payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-credit-card"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No invoices found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 