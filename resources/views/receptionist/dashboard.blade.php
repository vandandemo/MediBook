@extends('layouts.receptionist-layout')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-2xl font-semibold mb-6">Dashboard Overview</h2>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Today's Appointments -->
                    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Today's Appointments</dt>
                                        <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $stats['today_appointments'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Appointments -->
                    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Pending Appointments</dt>
                                        <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $stats['pending_appointments'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Patients -->
                    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Patients</dt>
                                        <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $stats['total_patients'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Available Doctors -->
                    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Available Doctors</dt>
                                        <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $stats['available_doctors'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Appointments -->
                <div class="mt-8">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Recent Appointments</h3>
                        <a href="{{ route('receptionist.appointments.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                    <div class="mt-2 bg-white dark:bg-gray-700 shadow overflow-hidden sm:rounded-lg">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse($stats['recent_appointments'] as $appointment)
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                        {{ $appointment->patient->name }} with Dr. {{ $appointment->doctor->name }}
                                    </div>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($appointment->status === 'completed') bg-green-100 text-green-800
                                            @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-blue-100 text-blue-800
                                            @endif">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            {{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="px-4 py-4 sm:px-6">
                                <div class="text-sm text-gray-500 dark:text-gray-400">No recent appointments</div>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Recent Patients -->
                <div class="mt-8">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Recent Patients</h3>
                        <a href="{{ route('receptionist.patients.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                    <div class="mt-2 bg-white dark:bg-gray-700 shadow overflow-hidden sm:rounded-lg">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse($stats['recent_patients'] as $patient)
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $patient->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $patient->email }}</div>
                                    </div>
                                    <div>
                                        <a href="{{ route('receptionist.patients.show', $patient) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View</a>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="px-4 py-4 sm:px-6">
                                <div class="text-sm text-gray-500 dark:text-gray-400">No recent patients</div>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="mt-8">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Recent Activities</h3>
                    <div class="mt-2 bg-white dark:bg-gray-700 shadow overflow-hidden sm:rounded-md">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse($recent_activities as $activity)
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $activity->description }}
                                    </div>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="px-4 py-4 sm:px-6">
                                <div class="text-sm text-gray-500 dark:text-gray-400">No recent activities</div>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <a href="{{ route('receptionist.appointments.create') }}" class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg p-6 hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">New Appointment</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Schedule a new appointment</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('receptionist.patients.create') }}" class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg p-6 hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Register Patient</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Add a new patient</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('receptionist.billing.create') }}" class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg p-6 hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">New Invoice</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Create a new invoice</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection