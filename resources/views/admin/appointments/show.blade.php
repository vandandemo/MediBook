@extends('layouts.admin-layout')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-indigo-800">Appointment Details</h2>
                        <a href="{{ route('admin.appointments.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to List
                        </a>
                    </div>

                    <div class="bg-white shadow-md overflow-hidden sm:rounded-lg border border-indigo-100">
                        <div class="px-6 py-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Patient Name -->
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-lg shadow-sm">
                                    <dt class="text-sm font-semibold text-indigo-600 mb-2">Patient</dt>
                                    <dd class="text-lg text-gray-800 font-medium">{{ $appointment->patient->name }}</dd>
                                </div>

                                <!-- Doctor Name -->
                                <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-lg shadow-sm">
                                    <dt class="text-sm font-semibold text-purple-600 mb-2">Doctor</dt>
                                    <dd class="text-lg text-gray-800 font-medium">{{ $appointment->doctor->name }}</dd>
                                </div>

                                <!-- Appointment Date -->
                                <div class="bg-gradient-to-br from-green-50 to-teal-50 p-6 rounded-lg shadow-sm">
                                    <dt class="text-sm font-semibold text-green-600 mb-2">Appointment Date</dt>
                                    <dd class="text-lg text-gray-800 font-medium">
                                        {{ date('d-m-Y', strtotime($appointment->appointment_date)) }}
                                    </dd>
                                </div>

                                <!-- Scheduled Time -->
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-lg shadow-sm">
                                    <dt class="text-sm font-semibold text-gray-600 mb-2">Scheduled Time</dt>
                                    <dd class="text-lg text-gray-800 font-medium">
                                        {{ date('H:i A', strtotime($appointment->scheduled_time)) }}
                                    </dd>
                                </div>

                                <!-- Amount -->
                                <div class="bg-gradient-to-br from-red-50 to-orange-50 p-6 rounded-lg shadow-sm">
                                    <dt class="text-sm font-semibold text-red-600 mb-2">Amount</dt>
                                    <dd class="text-lg text-gray-800 font-medium">${{ $appointment->amount }}</dd>
                                </div>

                                <!-- Status -->
                                <div class="bg-gradient-to-br from-yellow-50 to-amber-50 p-6 rounded-lg shadow-sm">
                                    <dt class="text-sm font-semibold text-yellow-600 mb-2">Status</dt>
                                    <dd class="text-lg font-medium">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                                    {{ $appointment->status == 'scheduled' ? 'bg-blue-100 text-blue-800' : 
                                                    ($appointment->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                                    'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </dd>
                                </div>

                                <!-- Rating -->
                                <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-6 rounded-lg shadow-sm">
                                    <dt class="text-sm font-semibold text-purple-600 mb-2">Rating</dt>
                                    <dd class="text-lg text-gray-800 font-medium">
                                        ⭐ {{ $appointment->rating ?? 'Not Rated' }}
                                    </dd>
                                </div>

                                <!-- Notes -->
                                <div class="bg-gradient-to-br from-teal-50 to-green-50 p-6 rounded-lg shadow-sm">
                                    <dt class="text-sm font-semibold text-teal-600 mb-2">Notes</dt>
                                    <dd class="text-lg text-gray-800 font-medium">
                                        {{ $appointment->notes ?? 'No Notes Available' }}
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                           class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 
                                  text-white font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out 
                                  flex items-center shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Appointment
                        </a>

                        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 
                                           text-white font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out 
                                           flex items-center shadow-lg hover:shadow-xl"
                                    onclick="return confirm('Are you sure you want to delete this appointment?')">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Appointment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
