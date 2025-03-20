@extends('layouts.doctor')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl">
            <div class="p-6">
                <div class="flex justify-between items-center border-b pb-4 mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Leave Request Details</h2>
                    <a href="{{ route('doctor.leaves.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to List
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Leave Information</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Type</label>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($leave->type) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Start Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->start_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">End Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->end_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Duration</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->start_date->diffInDays($leave->end_date) + 1 }} days</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Status</label>
                                <span class="mt-1 inline-flex px-2 text-xs leading-5 font-semibold rounded-full 
                                    @if($leave->status === 'approved') bg-green-100 text-green-800
                                    @elseif($leave->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Additional Details</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Reason</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->reason }}</p>
                            </div>
                            @if($leave->admin_remarks)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Admin Remarks</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->admin_remarks }}</p>
                            </div>
                            @endif
                            @if($leave->approved_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Approved At</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->approved_at->format('M d, Y H:i A') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($leave->status === 'pending')
                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('doctor.leaves.edit', $leave) }}" 
                        class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Request
                    </a>
                    <form action="{{ route('doctor.leaves.destroy', $leave) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg"
                            onclick="return confirm('Are you sure you want to delete this leave request?')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Request
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 