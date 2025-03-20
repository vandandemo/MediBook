@extends('layouts.doctor')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-xl p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h2 class="text-2xl font-bold text-gray-800">My Appointments</h2>
            </div>

            @if (session('status'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Date & Time</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Patient Name</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Status</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-4 px-6 text-gray-800">
                                    {{ $appointment->appointment_date ? $appointment->appointment_date->format('M d, Y h:i A') : 'Not scheduled' }}
                                </td>
                                <td class="py-4 px-6 text-gray-800">{{ $appointment->patient->name }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        @if($appointment->status == 'completed') bg-green-100 text-green-800
                                        @elseif($appointment->status == 'cancelled') bg-red-100 text-red-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <a href="{{ route('doctor.appointments.show', $appointment->id) }}" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition shadow-md hover:shadow-lg">
                                        <i class="bi bi-eye mr-2"></i> View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">No appointments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($appointments->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $appointments->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
