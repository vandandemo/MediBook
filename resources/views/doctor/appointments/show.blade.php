@extends('layouts.doctor')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Appointment Details</h2>
                    <a href="{{ route('doctor.appointments') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">Back to List</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Patient Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Patient Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm text-gray-600">Name:</label>
                                <p class="font-medium">{{ $appointment->patient->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Age:</label>
                                <p class="font-medium">{{ $appointment->patient->age }} years</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Contact:</label>
                                <p class="font-medium">{{ $appointment->patient->phone }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Email:</label>
                                <p class="font-medium">{{ $appointment->patient->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Appointment Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm text-gray-600">Date & Time:</label>
                                <p class="font-medium">{{ $appointment->scheduled_time->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Status:</label>
                                <span class="px-3 py-1 text-sm rounded-full 
                                    @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($appointment->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Type:</label>
                                <p class="font-medium">{{ $appointment->type ?? 'Regular Checkup' }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Reason:</label>
                                <p class="font-medium">{{ $appointment->reason ?? 'Not specified' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical Notes -->
                <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Medical Notes</h3>
                    <form action="{{ route('doctor.appointments.update', $appointment) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea id="notes" name="notes" rows="4" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $appointment->notes }}</textarea>
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Update Status</label>
                                <select id="status" name="status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="scheduled" {{ $appointment->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="no-show" {{ $appointment->status === 'no-show' ? 'selected' : '' }}>No Show</option>
                                </select>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                                    Update Appointment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 flex gap-4">
                    <a href="{{ route('doctor.prescriptions.create') }}" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Create Prescription
                    </a>
                    <a href="{{ route('doctor.lab-reports.create') }}" 
                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        Request Lab Test
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 