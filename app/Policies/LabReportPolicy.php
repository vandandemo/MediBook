<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\LabReport;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabReportPolicy
{
    use HandlesAuthorization;

    public function view(Doctor $doctor, LabReport $labReport)
    {
        return $doctor->id === $labReport->doctor_id;
    }

    public function update(Doctor $doctor, LabReport $labReport)
    {
        return $doctor->id === $labReport->doctor_id;
    }

    public function delete(Doctor $doctor, LabReport $labReport)
    {
        return $doctor->id === $labReport->doctor_id;
    }
}