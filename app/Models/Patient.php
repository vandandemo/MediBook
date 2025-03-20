<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'patient';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'date_of_birth',
        'blood_group',
        'gender',
        'provider',
        'provider_id',
        'email_verified_at',
        'active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date:Y-m-d',
        'active' => 'boolean',
    ];

    protected $attributes = [
        'active' => true,
        'phone' => null,
        'address' => null,
        'date_of_birth' => null,
        'blood_group' => null,
        'gender' => null,
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}