@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Appointment Reports</h1>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-calendar-check me-1"></i>
                Appointment Overview
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
                        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'appointments', 'format' => 'pdf']) }}">PDF</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'appointments', 'format' => 'excel']) }}">Excel</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'appointments', 'format' => 'csv']) }}">CSV</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            <h4>Total Appointments</h4>
                            <h2>{{ $totalAppointments }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">
                            <h4>Completed</h4>
                            <h2>{{ $completedAppointments }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">
                            <h4>Cancelled</h4>
                            <h2>{{ $cancelledAppointments }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Daily Appointments
                        </div>
                        <div class="card-body">
                            <canvas id="appointmentsChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-pie me-1"></i>
                            Appointments by Department
                        </div>
                        <div class="card-body">
                            <canvas id="departmentChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Daily Appointments Chart
    const appointmentsCtx = document.getElementById('appointmentsChart');
    new Chart(appointmentsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($appointmentsByDay->pluck('date')) !!},
            datasets: [{
                label: 'Daily Appointments',
                data: {!! json_encode($appointmentsByDay->pluck('total')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Department Distribution Chart
    const departmentCtx = document.getElementById('departmentChart');
    new Chart(departmentCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($appointmentsByDepartment->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode($appointmentsByDepartment->pluck('total')) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
@endsection