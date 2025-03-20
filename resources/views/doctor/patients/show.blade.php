@extends('layouts.doctor')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Patient Details</h2>
                        <a href="{{ route('doctor.patients.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium">Name:</span>
                                    <span class="ml-2">{{ $patient->name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Email:</span>
                                    <span class="ml-2">{{ $patient->email }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Phone:</span>
                                    <span class="ml-2">{{ $patient->phone }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Date of Birth:</span>
                                    <span class="ml-2">{{ $patient->date_of_birth }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Gender:</span>
                                    <span class="ml-2">{{ $patient->gender }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Medical Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium">Blood Type:</span>
                                    <span class="ml-2">{{ $patient->blood_type }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Allergies:</span>
                                    <span class="ml-2">{{ $patient->allergies ?? 'None' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Medical History:</span>
                                    <p class="mt-1">{{ $patient->medical_history ?? 'No medical history recorded' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Recent Appointments</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if($patient->appointments && $patient->appointments->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full table-auto">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-4 py-2 text-left">Date</th>
                                                <th class="px-4 py-2 text-left">Time</th>
                                                <th class="px-4 py-2 text-left">Status</th>
                                                <th class="px-4 py-2 text-left">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($patient->appointments as $appointment)
                                                <tr>
                                                    <td class="px-4 py-2">{{ $appointment->date }}</td>
                                                    <td class="px-4 py-2">{{ $appointment->time }}</td>
                                                    <td class="px-4 py-2">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $appointment->status === 'completed' ? 'green' : ($appointment->status === 'cancelled' ? 'red' : 'yellow') }}-100 text-{{ $appointment->status === 'completed' ? 'green' : ($appointment->status === 'cancelled' ? 'red' : 'yellow') }}-800">
                                                            {{ ucfirst($appointment->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <a href="{{ route('doctor.appointments.show', $appointment) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500">No recent appointments</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection