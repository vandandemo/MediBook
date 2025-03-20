@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Daily Statistics -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Today's Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text">Transactions</span>
                                    <span class="info-box-number">{{ $dailyTransactions }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text">Revenue</span>
                                    <span class="info-box-number">₱{{ number_format($dailyRevenue, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Statistics -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">This Month's Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text">Transactions</span>
                                    <span class="info-box-number">{{ $monthlyTransactions }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text">Revenue</span>
                                    <span class="info-box-number">₱{{ number_format($monthlyRevenue, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generate Reports</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('cashier.reports.generate') }}" method="GET" class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="report_type">Report Type</label>
                                <select name="report_type" id="report_type" class="form-control" required>
                                    <option value="transactions">Transactions Report</option>
                                    <option value="payments">Payments Report</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Links</h3>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('cashier.reports.transactions') }}" class="list-group-item list-group-item-action">
                            View Transaction Reports
                        </a>
                        <a href="{{ route('cashier.reports.payments') }}" class="list-group-item list-group-item-action">
                            View Payment Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 