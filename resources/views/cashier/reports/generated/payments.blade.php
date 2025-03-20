@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payments Report</h3>
                    <div class="card-tools">
                        <a href="{{ route('cashier.reports.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Reports
                        </a>
                        <button onclick="window.print()" class="btn btn-sm btn-primary">
                            <i class="fas fa-print"></i> Print Report
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Report Summary -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Date Range</span>
                                    <span class="info-box-number">{{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-money-bill-wave"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Payments</span>
                                    <span class="info-box-number">₱{{ number_format($totalAmount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-receipt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Payments</span>
                                    <span class="info-box-number">{{ $payments->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods Summary -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Payment Methods Summary</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Payment Method</th>
                                                    <th>Count</th>
                                                    <th>Total Amount</th>
                                                    <th>Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($paymentMethods as $method => $data)
                                                <tr>
                                                    <td>{{ ucfirst($method) }}</td>
                                                    <td>{{ $data['count'] }}</td>
                                                    <td>₱{{ number_format($data['total'], 2) }}</td>
                                                    <td>{{ number_format($data['percentage'], 2) }}%</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Payments -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Detailed Payments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Patient</th>
                                                    <th>Invoice #</th>
                                                    <th>Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Reference</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($payments as $payment)
                                                <tr>
                                                    <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                                    <td>{{ $payment->patient->name }}</td>
                                                    <td>{{ $payment->invoice->invoice_number }}</td>
                                                    <td>₱{{ number_format($payment->amount, 2) }}</td>
                                                    <td>{{ ucfirst($payment->payment_method) }}</td>
                                                    <td>{{ $payment->reference_number ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                                                            {{ ucfirst($payment->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No payments found for the selected date range.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
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