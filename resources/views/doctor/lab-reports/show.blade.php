@extends('layouts.doctor')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Lab Report Details</h2>
                    <a href="{{ route('doctor.lab-reports.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Reports
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Patient Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Patient Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Name:</span>
                                <span class="font-medium">{{ $labReport->patient->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Report Number:</span>
                                <span class="font-medium">{{ $labReport->report_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date Created:</span>
                                <span class="font-medium">{{ $labReport->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Test Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Test Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Test Type:</span>
                                <span class="font-medium">{{ $labReport->test_type }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($labReport->status == 'completed') bg-green-100 text-green-800
                                    @elseif($labReport->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($labReport->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Test Results -->
                    <div class="bg-gray-50 p-6 rounded-lg md:col-span-2">
                        <h3 class="text-lg font-semibold mb-4">Test Results</h3>
                        <div class="prose max-w-none">
                            {!! $labReport->results !!}
                        </div>
                    </div>

                    <!-- Doctor's Comments -->
                    <div class="bg-gray-50 p-6 rounded-lg md:col-span-2">
                        <h3 class="text-lg font-semibold mb-4">Doctor's Comments</h3>
                        <div class="prose max-w-none">
                            {!! $labReport->comments !!}
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex justify-end space-x-4">
                    @if($labReport->status == 'completed')
                        <a href="{{ route('doctor.lab-reports.download', $labReport->id) }}" 
                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Download Report
                        </a>
                    @endif
                    @if($labReport->status == 'pending')
                        <a href="{{ route('doctor.lab-reports.edit', $labReport->id) }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Report
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection