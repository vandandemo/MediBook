@extends('layouts.admin-layout')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-indigo-800">Patient Details</h2>
                        <a href="{{ route('admin.patients.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to List
                        </a>
                    </div>

                    <div class="bg-white shadow-md overflow-hidden sm:rounded-lg border border-indigo-100">
                        <div class="px-6 py-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Name -->
                                <div class="info-box bg-gradient-to-br from-blue-50 to-indigo-50">
                                    <dt>Name</dt>
                                    <dd>{{ $patient->name }}</dd>
                                </div>

                                <!-- Email -->
                                <div class="info-box bg-gradient-to-br from-purple-50 to-pink-50">
                                    <dt>Email</dt>
                                    <dd>{{ $patient->email }}</dd>
                                </div>

                                <!-- Email Verified At -->
                                <div class="info-box bg-gradient-to-br from-gray-50 to-blue-50">
                                    <dt>Email Verified At</dt>
                                    <dd>{{ $patient->email_verified_at ? $patient->email_verified_at->format('Y-m-d H:i:s') : 'Not Verified' }}</dd>
                                </div>

                                <!-- Phone -->
                                <div class="info-box bg-gradient-to-br from-green-50 to-teal-50">
                                    <dt>Phone</dt>
                                    <dd>{{ $patient->phone }}</dd>
                                </div>

                                <!-- Blood Group -->
                                <div class="info-box bg-gradient-to-br from-red-50 to-orange-50">
                                    <dt>Blood Group</dt>
                                    <dd>{{ $patient->blood_group }}</dd>
                                </div>

                                <!-- Date of Birth -->
                                <div class="info-box bg-gradient-to-br from-yellow-50 to-amber-50">
                                    <dt>Date of Birth</dt>
                                    <dd>{{ $patient->date_of_birth->format('Y-m-d') }}</dd>
                                </div>

                                <!-- Address -->
                                <div class="info-box bg-gradient-to-br from-gray-100 to-gray-50 col-span-2">
                                    <dt>Address</dt>
                                    <dd>{{ $patient->address }}</dd>
                                </div>

                                <!-- Created At -->
                                <div class="info-box bg-gradient-to-br from-gray-50 to-indigo-50">
                                    <dt>Created At</dt>
                                    <dd>{{ $patient->created_at->format('Y-m-d H:i:s') }}</dd>
                                </div>

                                <!-- Updated At -->
                                <div class="info-box bg-gradient-to-br from-gray-50 to-green-50">
                                    <dt>Updated At</dt>
                                    <dd>{{ $patient->updated_at->format('Y-m-d H:i:s') }}</dd>
                                </div>

                                <!-- Status -->
                                <div class="info-box bg-gradient-to-br from-gray-50 to-blue-50">
                                    <dt>Status</dt>
                                    <dd>
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $patient->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $patient->active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('admin.patients.edit', $patient) }}" class="btn-edit">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Patient
                        </a>
                        <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this patient?')">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Patient
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
    .info-box {
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    .info-box dt {
        font-size: 0.875rem;
        font-weight: 600;
        color: #4A5568;
        margin-bottom: 0.5rem;
    }
    .info-box dd {
        font-size: 1.125rem;
        font-weight: 500;
        color: #1A202C;
    }
    .btn-edit {
        background: linear-gradient(to right, #10B981, #047857);
        color: white;
        font-weight: bold;
        padding: 12px 24px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease-in-out;
    }
    .btn-edit:hover {
        background: linear-gradient(to right, #059669, #065F46);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .btn-delete {
        background: linear-gradient(to right, #EF4444, #B91C1C);
        color: white;
        font-weight: bold;
        padding: 12px 24px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease-in-out;
    }
    .btn-delete:hover {
        background: linear-gradient(to right, #DC2626, #991B1B);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
