<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'staff_type',
        'staff_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'admin_remarks',
        'reviewed_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'reviewed_at' => 'datetime'
    ];

    /**
     * Get the staff member associated with the leave.
     * This is a helper method to get the staff regardless of type.
     */
    public function staff()
    {
        if ($this->staff_type === 'doctor') {
            return $this->doctorStaff;
        } elseif ($this->staff_type === 'receptionist') {
            return $this->receptionistStaff;
        }
        
        return null;
    }

    /**
     * Get the doctor if staff type is doctor
     */
    public function doctorStaff(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'staff_id');
    }

    /**
     * Get the receptionist if staff type is receptionist
     */
    public function receptionistStaff(): BelongsTo
    {
        return $this->belongsTo(Receptionist::class, 'staff_id');
    }

    /**
     * Legacy relationship for doctor_id field
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }
}