<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['required', 'date_format:H:i'],
            'amount' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:scheduled,completed,cancelled,no_show'],
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Please select a patient.',
            'patient_id.exists' => 'The selected patient is invalid.',
            'doctor_id.required' => 'Please select a doctor.',
            'doctor_id.exists' => 'The selected doctor is invalid.',
            'appointment_date.required' => 'Please specify the appointment date.',
            'appointment_date.date' => 'Please provide a valid date.',
            'appointment_date.after_or_equal' => 'Appointment date must be today or a future date.',
            'scheduled_time.required' => 'Please specify the appointment time.',
            'scheduled_time.date_format' => 'Please provide a valid time in 24-hour format.',
            'amount.required' => 'Please specify the appointment amount.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.min' => 'Amount cannot be negative.',
            'status.required' => 'Please select an appointment status.',
            'status.in' => 'The selected status is invalid.',
        ];
    }
}