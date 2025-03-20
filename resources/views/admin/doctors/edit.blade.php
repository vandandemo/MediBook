@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid px-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
            {{ __('Edit Doctor') }}
        </h2>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form method="POST" action="{{ route('admin.doctors.update', $doctor) }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $doctor->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $doctor->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <x-input-label for="phone_number" :value="__('Phone Number')" />
                                <x-text-input id="phone_number" name="phone_number" type="tel" class="mt-1 block w-full" :value="old('phone_number', $doctor->phone_number)" required />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>

                            <!-- Specialization -->
                            <div>
                                <x-input-label for="specialization_id" :value="__('Specialization')" />
                                <select id="specialization_id" name="specialization_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($specializations as $specialization)
                                        <option value="{{ $specialization->id }}" {{ $doctor->specialization_id == $specialization->id ? 'selected' : '' }}>
                                            {{ $specialization->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('specialization_id')" class="mt-2" />
                            </div>

                            <!-- Department -->
                            <div>
                                <x-input-label for="department_id" :value="__('Department')" />
                                <select id="department_id" name="department_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $doctor->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                            </div>

                            <!-- License Number -->
                            <div>
                                <x-input-label for="license_number" :value="__('License Number')" />
                                <x-text-input id="license_number" name="license_number" type="text" class="mt-1 block w-full" :value="old('license_number', $doctor->license_number)" required />
                                <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
                            </div>

                            <!-- Sequence Number -->
                            <div>
                                <x-input-label for="sequence_number" :value="__('Sequence Number')" />
                                <x-text-input id="sequence_number" name="sequence_number" type="text" class="mt-1 block w-full" :value="old('sequence_number', $doctor->sequence_number)" required />
                                <x-input-error :messages="$errors->get('sequence_number')" class="mt-2" />
                            </div>

                            <!-- Old ID -->
                            <div>
                                <x-input-label for="old_id" :value="__('Old ID')" />
                                <x-text-input id="old_id" name="old_id" type="text" class="mt-1 block w-full" :value="old('old_id', $doctor->old_id)" />
                                <x-input-error :messages="$errors->get('old_id')" class="mt-2" />
                            </div>

                            <!-- Email Verified At -->
                            <div>
                                <x-input-label for="email_verified_at" :value="__('Email Verified At')" />
                                <x-text-input id="email_verified_at" name="email_verified_at" type="datetime-local" class="mt-1 block w-full"
                                    :value="old('email_verified_at', $doctor->email_verified_at ? $doctor->email_verified_at->format('Y-m-d\TH:i') : '')" />
                                <x-input-error :messages="$errors->get('email_verified_at')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="active" :value="__('Status')" />
                                <select id="active" name="active" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="1" {{ $doctor->active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$doctor->active ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-input-error :messages="$errors->get('active')" class="mt-2" />
                            </div>

                            <!-- Created At -->
                            <div>
                                <x-input-label for="created_at" :value="__('Created At')" />
                                <x-text-input id="created_at" name="created_at" type="text" class="mt-1 block w-full bg-gray-200" value="{{ $doctor->created_at->format('M d, Y h:i A') }}" disabled />
                            </div>

                            <!-- Updated At -->
                            <div>
                                <x-input-label for="updated_at" :value="__('Updated At')" />
                                <x-text-input id="updated_at" name="updated_at" type="text" class="mt-1 block w-full bg-gray-200" value="{{ $doctor->updated_at->format('M d, Y h:i A') }}" disabled />
                            </div>

                            <!-- Buttons -->
                            <div class="flex items-center justify-between mt-4">
                                <a href="{{ route('admin.doctors.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Back to List') }}
                                </a>
                                <x-primary-button class="ml-4">
                                    {{ __('Update Doctor') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
