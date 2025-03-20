<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'generic_name',
        'brand',
        'category',
        'description',
        'unit_price',
        'stock_quantity',
        'unit',
        'requires_prescription',
        'active'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'requires_prescription' => 'boolean',
        'active' => 'boolean'
    ];

    /**
     * Get the prescriptions that include this medicine.
     */
    public function prescriptions(): BelongsToMany
    {
        return $this->belongsToMany(Prescription::class, 'prescription_medicines')
            ->withPivot(['dosage', 'duration', 'instructions'])
            ->withTimestamps();
    }
} 