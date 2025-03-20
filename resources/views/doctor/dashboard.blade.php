@extends('layouts.doctor')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow">
                <h3 class="text-lg font-semibold mb-2">Total Patients</h3>
                <p class="text-3xl font-bold">{{ $totalPatients }}</p>
                <p class="text-sm opacity-80 mt-2">This Month</p>
            </div>
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow">
                <h3 class="text-lg font-semibold mb-2">Checked In Today</h3>
                <p class="text-3xl font-bold">{{ $checkedInPatients }}</p>
                <p class="text-sm opacity-80 mt-2">Active Patients</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow">
                <h3 class="text-lg font-semibold mb-2">Pending</h3>
                <p class="text-3xl font-bold">{{ $pendingAppointments }}</p>
                <p class="text-sm opacity-80 mt-2">Appointments</p>
            </div>
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow">
                <h3 class="text-lg font-semibold mb-2">Cancellations</h3>
                <p class="text-3xl font-bold">{{ $cancelledAppointments }}</p>
                <p class="text-sm opacity-80 mt-2">This Month</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Upcoming Appointments -->
            <div class="bg-white shadow-lg rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Upcoming Appointments</h2>
                    <a href="{{ route('doctor.appointments') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                </div>
                <div class="space-y-4">
                    @forelse($upcomingAppointments as $appointment)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <div>
                                <h4 class="font-semibold">{{ $appointment->patient->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $appointment->scheduled_time->format('M d, Y h:i A') }}</p>
                            </div>
                            <span class="px-3 py-1 text-sm rounded-full 
                                @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($appointment->status === 'confirmed') bg-green-100 text-green-800
                                @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No upcoming appointments</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white shadow-lg rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Recent Activities</h2>
                </div>
                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                        <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                @if($activity->type === 'appointment')
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-800">{{ $activity->description }}</p>
                                <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No recent activities</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Prescriptions -->
            <div class="bg-white shadow-lg rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Recent Prescriptions</h2>
                    <a href="{{ route('doctor.prescriptions.index') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                </div>
                <div class="space-y-4">
                    @forelse($recentPrescriptions as $prescription)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold">{{ $prescription->patient->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $prescription->created_at->format('M d, Y') }}</p>
                                </div>
                                <a href="{{ route('doctor.prescriptions.show', $prescription) }}" class="text-blue-600 hover:text-blue-800">View</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No recent prescriptions</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('doctor.appointments') }}" class="flex items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100">
                        <div class="text-center">
                            <svg class="w-8 h-8 text-blue-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="text-sm font-medium text-blue-700">Manage Appointments</span>
                        </div>
                    </a>
                    <a href="{{ route('doctor.prescriptions.create') }}" class="flex items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100">
                        <div class="text-center">
                            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm font-medium text-green-700">New Prescription</span>
                        </div>
                    </a>
                    <a href="{{ route('doctor.lab-reports.create') }}" class="flex items-center justify-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100">
                        <div class="text-center">
                            <svg class="w-8 h-8 text-purple-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                            <span class="text-sm font-medium text-purple-700">New Lab Report</span>
                        </div>
                    </a>
                    <a href="{{ route('doctor.patients.index') }}" class="flex items-center justify-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100">
                        <div class="text-center">
                            <svg class="w-8 h-8 text-yellow-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span class="text-sm font-medium text-yellow-700">View Patients</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
