@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Financial Reports</h1>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-chart-line me-1"></i>
                Financial Overview
            </div>
            <div class="d-flex gap-2">
                <select class="form-select" name="period" onchange="this.form.submit()">
                    <option value="week" {{ $period === 'week' ? 'selected' : '' }}>Last Week</option>
                    <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Last Month</option>
                    <option value="quarter" {{ $period === 'quarter' ? 'selected' : '' }}>Last Quarter</option>
                    <option value="year" {{ $period === 'year' ? 'selected' : '' }}>Last Year</option>
                </select>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                        Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'financial', 'format' => 'pdf']) }}">PDF</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'financial', 'format' => 'excel']) }}">Excel</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'financial', 'format' => 'csv']) }}">CSV</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            <h4>Total Earnings</h4>
                            <h2>${{ number_format($earnings, 2) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">
                            <h4>Pending Invoices</h4>
                            <h2>${{ number_format($pendingInvoices, 2) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">
                            <h4>Total Refunds</h4>
                            <h2>${{ number_format($refunds, 2) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Daily Earnings
                </div>
                <div class="card-body">
                    <canvas id="earningsChart" width="100%" height="30"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('earningsChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyEarnings->pluck('date')) !!},
            datasets: [{
                label: 'Daily Earnings',
                data: {!! json_encode($dailyEarnings->pluck('total')) !!},
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection