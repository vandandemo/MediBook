<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_id',
        'test_type',
        'test_date',
        'results',
        'comments',
        'status'
    ];

    protected $casts = [
        'test_date' => 'date',
        'report_date' => 'datetime',
        'is_critical' => 'boolean',
        'is_viewed_by_doctor' => 'boolean',
        'is_viewed_by_patient' => 'boolean'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}