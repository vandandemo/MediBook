@extends('layouts.admin-layout')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Dashboard Overview</h2>
            
            <!-- Stats Grid -->
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Patients -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Patients</dt>
                                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $stats['total_patients'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Doctors -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Doctors</dt>
                                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $stats['total_doctors'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Appointments -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Appointments</dt>
                                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $stats['total_appointments'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Revenue</dt>
                                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Leave Requests -->
            <div class="mt-8">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Pending Leave Requests</h3>
                    <a href="{{ route('admin.leaves.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                </div>
                <div class="mt-2 bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($stats['pending_leaves'] as $leave)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                        Dr. {{ $leave->doctor->name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ ucfirst($leave->type) }} Leave ({{ $leave->start_date->format('M d, Y') }} - {{ $leave->end_date->format('M d, Y') }})
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Reason: {{ Str::limit($leave->reason, 50) }}
                                    </div>
                                </div>
                                <div class="ml-2">
                                    <a href="{{ route('admin.leaves.show', $leave) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                        Review
                                    </a>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="px-4 py-4 sm:px-6">
                            <div class="text-sm text-gray-500 dark:text-gray-400">No pending leave requests</div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="mt-8">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Recent Activities</h3>
                <div class="mt-2 bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recent_activities as $activity)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400 truncate">
                                    {{ $activity->description ?? 'No description available' }}
                                </div>
                                <div class="ml-2 flex-shrink-0 flex">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">
                                        {{ $activity->created_at ? $activity->created_at->diffForHumans() : 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="px-4 py-4 sm:px-6">
                            <div class="text-sm text-gray-500 dark:text-gray-400">No recent activities found</div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <a href="{{ route('admin.doctors.index') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Manage Doctors</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">View and manage doctor profiles</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.patients.index') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Manage Patients</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">View and manage patient records</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.appointments.index') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Manage Appointments</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Schedule and manage appointments</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection