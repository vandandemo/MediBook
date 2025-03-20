@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaction Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('cashier.transactions.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Transactions
                        </a>
                        <a href="{{ route('cashier.transactions.print-receipt', $transaction) }}" class="btn btn-sm btn-primary" target="_blank">
                            <i class="fas fa-print"></i> Print Receipt
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Transaction Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Transaction Information</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;">Transaction ID</th>
                                            <td>{{ $transaction->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td>{{ $transaction->transaction_date->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td>₱{{ number_format($transaction->amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Method</th>
                                            <td>{{ ucfirst($transaction->payment_method) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge badge-{{ $transaction->status === 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Reference Number</th>
                                            <td>{{ $transaction->reference_number ?? 'N/A' }}</td>
                                        </tr>
                                        @if($transaction->notes)
                                        <tr>
                                            <th>Notes</th>
                                            <td>{{ $transaction->notes }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Patient Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Patient Information</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;">Name</th>
                                            <td>{{ $transaction->patient->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $transaction->patient->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $transaction->patient->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $transaction->patient->address }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Information -->
                        <div class="col-12 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Invoice Information</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;">Invoice Number</th>
                                            <td>{{ $transaction->invoice->invoice_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td>{{ $transaction->invoice->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge badge-{{ $transaction->invoice->status === 'paid' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($transaction->invoice->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total Amount</th>
                                            <td>₱{{ number_format($transaction->invoice->total_amount, 2) }}</td>
                                        </tr>
                                    </table>

                                    <!-- Invoice Items -->
                                    <h4 class="mt-4">Invoice Items</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transaction->invoice->items as $item)
                                                <tr>
                                                    <td>{{ $item->description }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>₱{{ number_format($item->unit_price, 2) }}</td>
                                                    <td>₱{{ number_format($item->total_price, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-right">Total Amount:</th>
                                                    <th>₱{{ number_format($transaction->invoice->total_amount, 2) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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
@endsection 