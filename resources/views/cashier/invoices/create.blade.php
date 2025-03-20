@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title h4 mb-0 fw-bold">Create New Invoice</h3>
                <a href="{{ route('cashier.invoices.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Back to Invoices
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('cashier.invoices.store') }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="border-start border-primary border-4 ps-3">Patient Information</h5>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="patient_id" class="form-label">Select Patient</label>
                        <select class="form-select @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id" required>
                            <option value="">-- Select Patient --</option>
                            @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', request('patient_id')) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }} (ID: {{ $patient->patient_id }})
                            </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="appointment_id" class="form-label">Select Appointment</label>
                        <select class="form-select @error('appointment_id') is-invalid @enderror" name="appointment_id" id="appointment_id" required>
                            <option value="">-- Select Appointment --</option>
                            @foreach($pendingAppointments as $appointment)
                            <option value="{{ $appointment->id }}" 
                                {{ old('appointment_id', request('appointment_id')) == $appointment->id ? 'selected' : '' }}
                                data-patient="{{ $appointment->patient_id }}">
                                {{ $appointment->patient->name }} - Dr. {{ $appointment->doctor->name }} 
                                ({{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y h:i A') }})
                            </option>
                            @endforeach
                        </select>
                        @error('appointment_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="border-start border-primary border-4 ps-3">Invoice Details</h5>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">₱</span>
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                name="amount" id="amount" value="{{ old('amount') }}" required>
                        </div>
                        @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                            name="due_date" id="due_date" value="{{ old('due_date', now()->addDays(30)->format('Y-m-d')) }}" required>
                        @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                            name="description" id="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cashier.invoices.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Invoice</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const patientSelect = document.getElementById('patient_id');
        const appointmentSelect = document.getElementById('appointment_id');
        
        // Filter appointments based on selected patient
        patientSelect.addEventListener('change', function() {
            const selectedPatientId = this.value;
            
            // Reset appointment dropdown
            for (let option of appointmentSelect.options) {
                if (option.value === '') {
                    continue; // Skip the placeholder
                }
                
                const appointmentPatientId = option.getAttribute('data-patient');
                
                if (selectedPatientId === '' || appointmentPatientId === selectedPatientId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }
            
            // Reset the appointment selection
            appointmentSelect.value = '';
        });
        
        // Set patient based on appointment selection
        appointmentSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (this.value !== '') {
                const patientId = selectedOption.getAttribute('data-patient');
                patientSelect.value = patientId;
            }
        });
        
        // Initial filter if appointment is pre-selected
        if (appointmentSelect.value !== '') {
            const selectedOption = appointmentSelect.options[appointmentSelect.selectedIndex];
            const patientId = selectedOption.getAttribute('data-patient');
            patientSelect.value = patientId;
        }
    });
</script>
@endpush 