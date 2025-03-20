@extends('layouts.admin-layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Reports & Analytics</h2>

            <div class="row">
                <!-- Financial Reports Card -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Financial Reports</h5>
                            <p class="card-text">View detailed financial reports, revenue analysis, and payment statistics.</p>
                            <a href="{{ route('admin.reports.financial') }}" class="btn btn-primary">
                                <i class="fas fa-chart-line me-2"></i>View Financial Reports
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Appointment Reports Card -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Appointment Reports</h5>
                            <p class="card-text">Track appointment statistics, scheduling patterns, and patient flow.</p>
                            <a href="{{ route('admin.reports.appointments') }}" class="btn btn-primary">
                                <i class="fas fa-calendar-check me-2"></i>View Appointment Reports
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Staff Reports Card -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Staff Reports</h5>
                            <p class="card-text">Monitor staff performance, workload distribution, and department statistics.</p>
                            <a href="{{ route('admin.reports.staff') }}" class="btn btn-primary">
                                <i class="fas fa-user-md me-2"></i>View Staff Reports
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Export Options Card -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Export Reports</h5>
                            <p class="card-text">Export various reports in different formats for further analysis.</p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.reports.export', 'financial') }}" class="btn btn-secondary">
                                    <i class="fas fa-file-export me-2"></i>Export Financial
                                </a>
                                <a href="{{ route('admin.reports.export', 'appointments') }}" class="btn btn-secondary">
                                    <i class="fas fa-file-export me-2"></i>Export Appointments
                                </a>
                                <a href="{{ route('admin.reports.export', 'staff') }}" class="btn btn-secondary">
                                    <i class="fas fa-file-export me-2"></i>Export Staff
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection