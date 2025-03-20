@extends('layouts.doctor')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Edit Prescription</h2>
                    <a href="{{ route('doctor.prescriptions.show', $prescription) }}" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                        Cancel
                    </a>
                </div>

                <form action="{{ route('doctor.prescriptions.update', $prescription) }}" method="POST" id="prescriptionForm">
                    @csrf
                    @method('PUT')
                    
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
                                            <option value="{{ $patient->id }}" {{ $prescription->patient_id == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->name }} - {{ $patient->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis</label>
                                    <textarea name="diagnosis" id="diagnosis" rows="2" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $prescription->diagnosis }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Prescription Details -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Prescription Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                                    <textarea name="notes" id="notes" rows="2"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $prescription->notes }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Medicine Selection -->
                    <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-700">Prescribed Medicines</h3>
                            <button type="button" id="addMedicine" 
                                class="bg-blue-500 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md">
                                Add Medicine
                            </button>
                        </div>
                        <div id="medicineList">
                            @foreach($prescription->medicines as $index => $medicine)
                            <div class="medicine-item grid grid-cols-1 md:grid-cols-6 gap-4 mb-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Medicine</label>
                                    <select name="medicines[]" required class="medicine-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Medicine</option>
                                        @foreach($medicines as $med)
                                            <option value="{{ $med->id }}" 
                                                {{ $medicine->id == $med->id ? 'selected' : '' }}
                                                data-generic="{{ $med->generic_name }}"
                                                data-strength="{{ $med->strength }}"
                                                data-form="{{ $med->dosage_form }}">
                                                {{ $med->name }} ({{ $med->strength }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dosage</label>
                                    <input type="text" name="dosages[]" required placeholder="1-0-1"
                                        value="{{ $medicine->pivot->dosage }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Duration</label>
                                    <input type="text" name="durations[]" required placeholder="7 days"
                                        value="{{ $medicine->pivot->duration }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Instructions</label>
                                    <input type="text" name="instructions[]" placeholder="Take after meals"
                                        value="{{ $medicine->pivot->instructions }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                @if(!$loop->first)
                                <div class="flex items-end">
                                    <button type="button" class="remove-medicine text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="submit" name="action" value="save" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Prescription
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

    // Template for new medicine row
    function getMedicineTemplate() {
        const medicines = {!! json_encode($medicines) !!};
        const options = medicines.map(med => `
            <option value="${med.id}" 
                data-generic="${med.generic_name}"
                data-strength="${med.strength}"
                data-form="${med.dosage_form}">
                ${med.name} (${med.strength})
            </option>
        `).join('');

        return `
            <div class="medicine-item grid grid-cols-1 md:grid-cols-6 gap-4 mb-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Medicine</label>
                    <select name="medicines[]" required class="medicine-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Medicine</option>
                        ${options}
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
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Instructions</label>
                    <input type="text" name="instructions[]" placeholder="Take after meals"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="flex items-end">
                    <button type="button" class="remove-medicine text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        `;
    }

    // Add new medicine row
    addMedicineBtn.addEventListener('click', function() {
        const template = getMedicineTemplate();
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = template;
        medicineList.appendChild(tempDiv.firstElementChild);
    });

    // Remove medicine row
    medicineList.addEventListener('click', function(e) {
        if (e.target.closest('.remove-medicine')) {
            e.target.closest('.medicine-item').remove();
        }
    });
});
</script>
@endpush

@endsection 