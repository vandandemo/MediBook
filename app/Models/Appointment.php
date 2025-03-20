<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'scheduled_time',
        'status',
        'amount',
        'notes'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'amount' => 'decimal:2',
        'scheduled_time' => 'datetime'
    ];

    protected function setScheduledTimeAttribute($value)
    {
        if ($value) {
            $this->attributes['scheduled_time'] = date('Y-m-d H:i:s', strtotime($this->appointment_date . ' ' . $value));
        }
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}