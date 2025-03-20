<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_id',
        'diagnosis',
        'medications',
        'instructions',
        'notes',
        'status',
        'valid_until',
        'is_sent_to_pharmacy'
    ];

    protected $casts = [
        'valid_until' => 'date',
        'prescription_date' => 'date',
        'is_sent_to_pharmacy' => 'boolean',
    ];

    /**
     * Get the doctor that wrote the prescription.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the patient this prescription is for.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the appointment associated with this prescription.
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'prescription_medicines')
            ->using(PrescriptionMedicine::class)
            ->withPivot(['dosage', 'duration', 'instructions'])
            ->withTimestamps();
    }
}