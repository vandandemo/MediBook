@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid px-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
            {{ __('Add New Doctor') }}
        </h2>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form method="POST" action="{{ route('admin.doctors.store') }}" class="space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email') }}" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="phone_number" :value="__('Phone Number')" />
                                <x-text-input id="phone_number" name="phone_number" type="tel" class="mt-1 block w-full" value="{{ old('phone_number') }}" required />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="specialization_id" :value="__('Specialization')" />
                                <select id="specialization_id" name="specialization_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Specialization</option>
                                    @foreach($specializations as $specialization)
                                        <option value="{{ $specialization->id }}" {{ old('specialization_id') == $specialization->id ? 'selected' : '' }}>
                                            {{ $specialization->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('specialization_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="department_id" :value="__('Department')" />
                                <select id="department_id" name="department_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="license_number" :value="__('License Number')" />
                                <x-text-input id="license_number" name="license_number" type="text" class="mt-1 block w-full" value="{{ old('license_number') }}" required />
                                <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="sequence_number" :value="__('Sequence Number')" />
                                <x-text-input id="sequence_number" name="sequence_number" type="text" class="mt-1 block w-full" value="{{ old('sequence_number') }}" />
                                <x-input-error :messages="$errors->get('sequence_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="old_id" :value="__('Old ID (Optional)')" />
                                <x-text-input id="old_id" name="old_id" type="text" class="mt-1 block w-full" value="{{ old('old_id') }}" />
                                <x-input-error :messages="$errors->get('old_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="active" :value="__('Status')" />
                                <select id="active" name="active" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="1" {{ old('active', 1) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('active', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-input-error :messages="$errors->get('active')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email_verified_at" :value="__('Email Verified At')" />
                                <x-text-input id="email_verified_at" name="email_verified_at" type="datetime-local" class="mt-1 block w-full" value="{{ old('email_verified_at') }}" />
                                <x-input-error :messages="$errors->get('email_verified_at')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Create Doctor') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
