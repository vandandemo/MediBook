@extends('layouts.doctor')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Leave Request</h1>
        <a href="{{ route('doctor.leaves.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Cancel
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('doctor.leaves.update', $leave->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Leave Type</label>
                <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="sick" {{ $leave->type === 'sick' ? 'selected' : '' }}>Sick Leave</option>
                    <option value="casual" {{ $leave->type === 'casual' ? 'selected' : '' }}>Casual Leave</option>
                    <option value="annual" {{ $leave->type === 'annual' ? 'selected' : '' }}>Annual Leave</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" 
                           value="{{ $leave->start_date->format('Y-m-d') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           required>
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" id="end_date" 
                           value="{{ $leave->end_date->format('Y-m-d') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           required>
                </div>
            </div>

            <div class="mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                <textarea name="reason" id="reason" rows="4" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          required>{{ $leave->reason }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                    Update Leave Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 