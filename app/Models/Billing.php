<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'invoice_number', 'amount', 'status', 'billing_date'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
