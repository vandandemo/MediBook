<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InsuranceClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'insurance_provider',
        'policy_number',
        'claim_number',
        'amount_claimed',
        'amount_approved',
        'status',
        'submission_date',
        'approval_date',
        'rejection_reason',
        'documents',
        'notes'
    ];

    protected $casts = [
        'amount_claimed' => 'decimal:2',
        'amount_approved' => 'decimal:2',
        'submission_date' => 'datetime',
        'approval_date' => 'datetime',
        'documents' => 'array'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getClaimCoverage(): float
    {
        if ($this->amount_claimed > 0) {
            return ($this->amount_approved / $this->amount_claimed) * 100;
        }
        return 0;
    }
}