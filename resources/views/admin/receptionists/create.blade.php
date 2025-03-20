@extends('layouts.admin-layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-user-plus"></i> {{ isset($receptionist) ? 'Edit' : 'Create' }} Receptionist</h4>
            <a href="{{ route('admin.receptionists.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            <form action="{{ isset($receptionist) ? route('admin.receptionists.update', $receptionist->id) : route('admin.receptionists.store') }}" method="POST">
                @csrf
                @if(isset($receptionist))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <!-- Name -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-user"></i> Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $receptionist->name ?? '') }}" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $receptionist->email ?? '') }}" required>
                    </div>

                    <!-- Phone (Added) -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-phone"></i> Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $receptionist->phone ?? '') }}" required>
                    </div>

                    <!-- Employee ID -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-id-badge"></i> Employee ID</label>
                        <input type="text" name="employee_id" class="form-control" value="{{ old('employee_id', $receptionist->employee_id ?? '') }}" required>
                    </div>

                    <!-- Shift -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-clock"></i> Shift</label>
                        <select name="shift" class="form-select" required>
                            <option value="morning" {{ old('shift', $receptionist->shift ?? '') == 'morning' ? 'selected' : '' }}>Morning</option>
                            <option value="afternoon" {{ old('shift', $receptionist->shift ?? '') == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                            <option value="evening" {{ old('shift', $receptionist->shift ?? '') == 'evening' ? 'selected' : '' }}>Evening</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" name="password" class="form-control" {{ isset($receptionist) ? '' : 'required' }}>
                        @if(isset($receptionist))
                            <small class="text-muted">Leave blank if you don't want to change the password</small>
                        @endif
                    </div>

                    <!-- Active Status -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-check-circle"></i> Active Status</label>
                        <select name="active" class="form-select">
                            <option value="1" {{ old('active', $receptionist->active ?? '') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('active', $receptionist->active ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> {{ isset($receptionist) ? 'Update' : 'Create' }}
                    </button>

                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
