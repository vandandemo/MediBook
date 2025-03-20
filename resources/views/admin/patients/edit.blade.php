@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title mb-0">Edit Patient</h3>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label text-muted">Name</label>
                                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $patient->name) }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label text-muted">Email</label>
                                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $patient->email) }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label text-muted">Phone Number</label>
                                    <input type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_of_birth" class="form-label text-muted">Date of Birth</label>
                                    <input type="date" class="form-control form-control-lg @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth) }}" required>
                                    @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="blood_group" class="form-label text-muted">Blood Group</label>
                                    <select class="form-select form-select-lg @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group" required>
                                        <option value="" disabled>Select blood group</option>
                                        @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                                            <option value="{{ $group }}" {{ old('blood_group', $patient->blood_group) == $group ? 'selected' : '' }}>{{ $group }}</option>
                                        @endforeach
                                    </select>
                                    @error('blood_group') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="active" class="form-label text-muted">Status</label>
                                    <select class="form-select form-select-lg @error('active') is-invalid @enderror" id="active" name="active" required>
                                        <option value="1" {{ old('active', $patient->active) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('active', $patient->active) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address" class="form-label text-muted">Address</label>
                                    <textarea class="form-control form-control-lg @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $patient->address) }}</textarea>
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label text-muted">Password (Leave blank if not changing)</label>
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter new password (optional)">
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email_verified_at" class="form-label text-muted">Email Verified At</label>
                                    <input type="datetime-local" class="form-control form-control-lg @error('email_verified_at') is-invalid @enderror" id="email_verified_at" name="email_verified_at" value="{{ old('email_verified_at', $patient->email_verified_at) }}">
                                    @error('email_verified_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-end gap-3">
                                    <a href="{{ route('admin.patients.index') }}" class="btn btn-light btn-lg px-4">Cancel</a>
                                    <button type="submit" class="btn btn-primary btn-lg px-4">Update Patient</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
.form-label { font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; }
.form-control, .form-select { border: 1px solid #dee2e6; border-radius: 0.5rem; padding: 0.75rem 1rem; font-size: 1rem; transition: all 0.2s ease-in-out; }
.form-control:focus, .form-select:focus { border-color: #86b7fe; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }
.btn { border-radius: 0.5rem; font-weight: 500; letter-spacing: 0.5px; }
.btn-lg { padding: 0.75rem 1.5rem; }
.card { border: none; border-radius: 1rem; }
.card-header { border-top-left-radius: 1rem; border-top-right-radius: 1rem; padding: 1.25rem; }
</style>
@endsection
