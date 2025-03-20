@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Cashier Details</h1>
        <a href="{{ route('admin.cashiers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow-md flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <!-- Cashier Details Card -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">Basic Information</h2>
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-500 text-white flex items-center justify-center rounded-full">
                        <i class="fas fa-user text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200">{{ $cashier->name }}</h3>
                        <p class="text-gray-500 dark:text-gray-400">Cashier</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div class="border-b dark:border-gray-700 pb-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Employee ID</p>
                        <p class="text-gray-700 dark:text-gray-200">{{ $cashier->employee_id }}</p>
                    </div>

                    <div class="border-b dark:border-gray-700 pb-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                        <p class="text-gray-700 dark:text-gray-200">{{ $cashier->email }}</p>
                    </div>

                    <div class="border-b dark:border-gray-700 pb-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                        <p class="text-gray-700 dark:text-gray-200">{{ $cashier->phone }}</p>
                    </div>

                    <div class="border-b dark:border-gray-700 pb-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Address</p>
                        <p class="text-gray-700 dark:text-gray-200">{{ $cashier->address }}</p>
                    </div>

                    <div class="border-b dark:border-gray-700 pb-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                        <span class="px-3 py-1 text-sm rounded-full {{ $cashier->active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                            {{ $cashier->active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">Account Information</h2>
                
                <div class="grid grid-cols-1 gap-4">
                    <div class="border-b dark:border-gray-700 pb-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Shift</p>
                        <p class="text-gray-700 dark:text-gray-200 capitalize">{{ $cashier->shift }}</p>
                    </div>

                    <div class="border-b dark:border-gray-700 pb-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Created At</p>
                        <p class="text-gray-700 dark:text-gray-200">{{ $cashier->created_at->format('F d, Y') }}</p>
                    </div>

                    <div class="border-b dark:border-gray-700 pb-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                        <p class="text-gray-700 dark:text-gray-200">{{ $cashier->updated_at->format('F d, Y') }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 mt-6">
                    <a href="{{ route('admin.cashiers.edit', $cashier) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md flex items-center gap-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
