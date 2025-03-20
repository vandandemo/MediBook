@extends('layouts.doctor')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Prescription Details</h2>
                    <div class="flex space-x-4">
                        <a href="{{ route('doctor.prescriptions.print', $prescription) }}" target="_blank" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print Prescription
                        </a>
                        <a href="{{ route('doctor.prescriptions.index') }}" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Patient Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Patient Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm text-gray-600">Name:</label>
                                <p class="font-medium">{{ $prescription->patient->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Age:</label>
                                <p class="font-medium">{{ $prescription->patient->age }} years</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Contact:</label>
                                <p class="font-medium">{{ $prescription->patient->phone }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Email:</label>
                                <p class="font-medium">{{ $prescription->patient->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Prescription Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Prescription Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm text-gray-600">Date:</label>
                                <p class="font-medium">{{ $prescription->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Prescription ID:</label>
                                <p class="font-medium">#{{ $prescription->id }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Status:</label>
                                <span class="px-3 py-1 text-sm rounded-full 
                                    @if($prescription->status === 'active') bg-green-100 text-green-800
                                    @elseif($prescription->status === 'completed') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($prescription->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diagnosis -->
                <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Diagnosis</h3>
                    <p class="text-gray-800">{{ $prescription->diagnosis }}</p>
                </div>

                <!-- Prescribed Medicines -->
                <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Prescribed Medicines</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicine</th>
                                    <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage</th>
                                    <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                    <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($prescription->medicines as $medicine)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $medicine->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $medicine->strength }} - {{ $medicine->dosage_form }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $medicine->pivot->dosage }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $medicine->pivot->duration }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $medicine->pivot->instructions }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($prescription->notes)
                    <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Additional Notes</h3>
                        <p class="text-gray-800">{{ $prescription->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 