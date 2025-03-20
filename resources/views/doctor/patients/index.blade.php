@extends('layouts.doctor')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-xl p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Patient List</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Name</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Email</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Phone</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $patient)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-4 px-6 text-gray-800">{{ $patient->name }}</td>
                                <td class="py-4 px-6 text-gray-800">{{ $patient->email }}</td>
                                <td class="py-4 px-6 text-gray-800">{{ $patient->phone }}</td>
                                <td class="py-4 px-6">
                                    <a href="{{ route('doctor.patients.show', $patient) }}" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition shadow-md hover:shadow-lg">
                                        <i class="bi bi-eye mr-2"></i> View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">No patients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($patients->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $patients->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
