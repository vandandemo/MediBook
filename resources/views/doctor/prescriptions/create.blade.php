@extends('layouts.doctor')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Create Prescription</h2>
                    <a href="{{ route('doctor.prescriptions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">Back to List</a>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('doctor.prescriptions.store') }}" method="POST" id="prescriptionForm">
                    @csrf
                    @if(isset($appointmentId))
                        <input type="hidden" name="appointment_id" value="{{ $appointmentId }}">
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Patient Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Patient Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="patient_id" class="block text-sm font-medium text-gray-700">Select Patient</label>
                                    <select name="patient_id" id="patient_id" required 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Patient</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->name }} - {{ $patient->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis</label>
                                    <textarea name="diagnosis" id="diagnosis" rows="2" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Prescription Details -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Prescription Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="prescription_date" class="block text-sm font-medium text-gray-700">Date</label>
                                    <input type="date" name="prescription_date" id="prescription_date" required
                                        value="{{ date('Y-m-d') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                                    <textarea name="notes" id="notes" rows="2"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Medicine Selection -->
                    <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Prescribed Medicines</h3>
                        <div id="medicineList">
                            <div class="medicine-item grid grid-cols-1 md:grid-cols-6 gap-4 mb-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Medicine</label>
                                    <select name="medicines[]" required class="medicine-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Medicine</option>
                                        @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->id }}" 
                                                data-generic="{{ $medicine->generic_name }}"
                                                data-strength="{{ $medicine->strength }}"
                                                data-form="{{ $medicine->dosage_form }}">
                                                {{ $medicine->name }} ({{ $medicine->strength }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dosage</label>
                                    <input type="text" name="dosages[]" required placeholder="1-0-1"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Duration</label>
                                    <input type="text" name="durations[]" required placeholder="7 days"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Instructions</label>
                                    <input type="text" name="instructions[]" placeholder="After meals"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div class="flex items-end">
                                    <button type="button" class="remove-medicine text-red-600 hover:text-red-800 mt-1" style="display: none;">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" id="addMedicine" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Medicine
                        </button>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="submit" name="action" value="save" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm">
                            Save Prescription
                        </button>
                        <button type="submit" name="action" value="save_and_print" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm">
                            Save & Print
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const medicineList = document.getElementById('medicineList');
    const addMedicineBtn = document.getElementById('addMedicine');
    
    // Add new medicine row
    addMedicineBtn.addEventListener('click', function() {
        const medicineItem = medicineList.querySelector('.medicine-item').cloneNode(true);
        
        // Clear values
        medicineItem.querySelectorAll('input, select').forEach(input => {
            input.value = '';
        });
        
        // Show remove button
        medicineItem.querySelector('.remove-medicine').style.display = 'block';
        
        medicineList.appendChild(medicineItem);
        
        // Add remove functionality
        medicineItem.querySelector('.remove-medicine').addEventListener('click', function() {
            medicineItem.remove();
        });
    });
    
    // Show remove button for all but first medicine item
    document.querySelectorAll('.medicine-item:not(:first-child) .remove-medicine').forEach(btn => {
        btn.style.display = 'block';
    });
    
    // Remove medicine row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-medicine')) {
            e.target.closest('.medicine-item').remove();
        }
    });
});
</script>
@endpush

@endsection