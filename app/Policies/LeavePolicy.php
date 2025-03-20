<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\Leave;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeavePolicy
{
    use HandlesAuthorization;

    public function view(Doctor $doctor, Leave $leave)
    {
        return $doctor->id === $leave->doctor_id;
    }

    public function update(Doctor $doctor, Leave $leave)
    {
        return $doctor->id === $leave->doctor_id && $leave->status === 'pending';
    }

    public function delete(Doctor $doctor, Leave $leave)
    {
        return $doctor->id === $leave->doctor_id && $leave->status === 'pending';
    }
} 