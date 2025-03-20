@extends('layouts.receptionist-layout')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Leave Request Details</h2>
                    <a href="{{ route('receptionist.leaves.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Back to List
                    </a>
                </div>

                <div class="bg-white dark:bg-gray-700 shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Leave Type</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 capitalize">{{ $leave->type }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                <dd class="mt-1 text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($leave->status === 'approved') bg-green-100 text-green-800
                                        @elseif($leave->status === 'rejected') bg-red-100 text-red-800
                                        @elseif($leave->status === 'cancelled') bg-gray-100 text-gray-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($leave->status) }}
                                    </span>
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Start Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $leave->start_date->format('M d, Y') }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">End Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $leave->end_date->format('M d, Y') }}</dd>
                            </div>

                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Reason</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $leave->reason }}</dd>
                            </div>

                            @if($leave->admin_remarks)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Admin Remarks</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $leave->admin_remarks }}</dd>
                            </div>
                            @endif

                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Submitted At</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $leave->created_at->format('M d, Y H:i A') }}</dd>
                            </div>

                            @if($leave->reviewed_at)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Reviewed At</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $leave->reviewed_at->format('M d, Y H:i A') }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    @if($leave->status === 'pending')
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-600 text-right sm:px-6">
                        <form action="{{ route('receptionist.leaves.cancel', $leave) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to cancel this leave request?')">
                                Cancel Request
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 