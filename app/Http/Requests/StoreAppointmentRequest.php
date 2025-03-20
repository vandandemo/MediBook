<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;


class StoreAppointmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'status' => 'sometimes|in:scheduled,completed,cancelled,no_show'
        ];
    }

    public function messages()
    {
        return [
            'patient_id.required' => 'Please select a patient',
            'doctor_id.required' => 'Please select a doctor',
            'appointment_date.required' => 'Please select appointment date and time',
            'appointment_date.after' => 'Appointment date must be after today',
            'amount.required' => 'Please enter appointment amount',
            'amount.min' => 'Amount cannot be negative'
        ];
    }

    public function storeAppointment(StoreAppointmentRequest $request)
    {
        try {
            DB::beginTransaction();

            \Log::info('Appointment Data:', $request->validated());

            $appointment = Appointment::create($request->validated());

            DB::commit();

            return redirect()->route('admin.appointments.index')
                ->with('success', 'Appointment created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
        
            \Log::error('Appointment Creation Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to create appointment. Please try again.');
        }
    }

}