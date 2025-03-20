@extends('layouts.admin-layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-user-edit"></i> Edit Receptionist</h4>
            <a href="{{ route('admin.receptionists.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.receptionists.update', $receptionist->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- ID (Read-Only) -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-key"></i> ID</label>
                        <input type="text" class="form-control" value="{{ $receptionist->id }}" readonly>
                    </div>

                    <!-- Name -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-user"></i> Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $receptionist->name) }}" required>
                        @error('name') 
                            <div class="text-danger">{{ $message }}</div> 
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $receptionist->email) }}" required>
                        @error('email') 
                            <div class="text-danger">{{ $message }}</div> 
                        @enderror
                    </div>

                    <!-- Phone Number (Added) -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-phone"></i> Phone</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone', $receptionist->phone) }}" required>
                        @error('phone') 
                            <div class="text-danger">{{ $message }}</div> 
                        @enderror
                    </div>

                    <!-- Employee ID -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-id-badge"></i> Employee ID</label>
                        <input type="text" name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" 
                               value="{{ old('employee_id', $receptionist->employee_id) }}" required>
                        @error('employee_id') 
                            <div class="text-danger">{{ $message }}</div> 
                        @enderror
                    </div>

                    <!-- Shift -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-clock"></i> Shift</label>
                        <select name="shift" class="form-select @error('shift') is-invalid @enderror" required>
                            <option value="morning" {{ $receptionist->shift == 'morning' ? 'selected' : '' }}>Morning</option>
                            <option value="afternoon" {{ $receptionist->shift == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                            <option value="evening" {{ $receptionist->shift == 'evening' ? 'selected' : '' }}>Evening</option>
                        </select>
                        @error('shift') 
                            <div class="text-danger">{{ $message }}</div> 
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-lock"></i> New Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        <small class="text-muted">Leave blank if you don't want to change the password</small>
                        @error('password') 
                            <div class="text-danger">{{ $message }}</div> 
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-toggle-on"></i> Status</label>
                        <select name="active" class="form-select @error('active') is-invalid @enderror" required>
                            <option value="1" {{ $receptionist->active ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$receptionist->active ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('active') 
                            <div class="text-danger">{{ $message }}</div> 
                        @enderror
                    </div>

                    <!-- Created At -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-calendar-plus"></i> Created At</label>
                        <input type="text" class="form-control" value="{{ $receptionist->created_at->format('Y-m-d H:i:s') }}" readonly>
                    </div>

                    <!-- Updated At -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-calendar-check"></i> Updated At</label>
                        <input type="text" class="form-control" value="{{ $receptionist->updated_at->format('Y-m-d H:i:s') }}" readonly>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save Changes
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
