@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Staff Performance Reports</h1>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-user-md me-1"></i>
                Staff Overview
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
                        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'staff', 'format' => 'pdf']) }}">PDF</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'staff', 'format' => 'excel']) }}">Excel</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'staff', 'format' => 'csv']) }}">CSV</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Doctor Performance
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Total Appointments</th>
                                    <th>Completed</th>
                                    <th>Cancelled</th>
                                    <th>Completion Rate</th>
                                    <th>Average Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doctorStats as $stat)
                                <tr>
                                    <td>{{ $stat->name }}</td>
                                    <td>{{ $stat->total_appointments }}</td>
                                    <td>{{ $stat->completed_appointments }}</td>
                                    <td>{{ $stat->cancelled_appointments }}</td>
                                    <td>{{ $stat->total_appointments > 0 ? number_format(($stat->completed_appointments / $stat->total_appointments) * 100, 1) : 0 }}%</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">{{ number_format($stat->average_rating, 1) }}</div>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= round($stat->average_rating))
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-clock me-1"></i>
                    Staff Attendance
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Staff Type</th>
                                    <th>Staff ID</th>
                                    <th>Login Count</th>
                                    <th>Average Daily Logins</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staffAttendance as $attendance)
                                <tr>
                                    <td>{{ class_basename($attendance->causer_type) }}</td>
                                    <td>{{ $attendance->causer_id }}</td>
                                    <td>{{ $attendance->login_count }}</td>
                                    <td>{{ number_format($attendance->login_count / 30, 1) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection