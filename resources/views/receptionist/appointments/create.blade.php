<x-receptionist-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg rounded-3 border-0">
                    <div class="card-header bg-gradient-primary text-black py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title h4 mb-0 fw-bold">Create New Appointment</h3>
                            <a href="{{ route('receptionist.appointments.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('receptionist.appointments.store') }}" method="POST">
                            @csrf
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="patient_id" class="form-label">Patient</label>
                                        @if($patients->isEmpty())
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle me-2"></i>No patients found. Please register a patient first.
                                            </div>
                                        @endif
                                        <select name="patient_id" id="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                                            <option value="">Select Patient</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                    {{ $patient->name }} ({{ $patient->phone ?? 'No phone' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('patient_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-2">
                                            <a href="{{ route('receptionist.patients.create') }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-user-plus me-1"></i>Register New Patient
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="doctor_id" class="form-label">Doctor</label>
                                        <select name="doctor_id" id="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                                            <option value="">Select Doctor</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $selectedDoctorId) == $doctor->id ? 'selected' : '' }}>
                                                    {{ $doctor->name }} - {{ $doctor->specialization->name ?? 'General' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('doctor_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment_date" class="form-label">Appointment Date</label>
                                        <input type="date" name="appointment_date" id="appointment_date" 
                                            class="form-control @error('appointment_date') is-invalid @enderror"
                                            value="{{ old('appointment_date') }}" required>
                                        @error('appointment_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment_time" class="form-label">Appointment Time</label>
                                        <input type="time" name="appointment_time" id="appointment_time" 
                                            class="form-control @error('appointment_time') is-invalid @enderror"
                                            value="{{ old('appointment_time') }}" required>
                                        @error('appointment_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="reason" class="form-label">Reason for Visit</label>
                                        <textarea name="reason" id="reason" rows="3" 
                                            class="form-control @error('reason') is-invalid @enderror"
                                            required>{{ old('reason') }}</textarea>
                                        @error('reason')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Create Appointment
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-receptionist-layout> 