<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\LabReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        $doctor_id = Auth::id();

        // Get appointments statistics
        $appointmentsStats = Appointment::where('doctor_id', $doctor_id)
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(CASE WHEN status = "completed" THEN 1 END) as completed'),
                DB::raw('COUNT(CASE WHEN status = "cancelled" THEN 1 END) as cancelled'),
                DB::raw('COUNT(CASE WHEN status = "pending" THEN 1 END) as pending')
            )
            ->first();

        // Get monthly appointments count
        $monthlyAppointments = Appointment::where('doctor_id', $doctor_id)
            ->whereYear('appointment_date', now()->year)
            ->select(
                DB::raw('MONTH(appointment_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->get();

        // Get patient demographics
        $patientDemographics = Patient::whereHas('appointments', function($query) use ($doctor_id) {
                $query->where('doctor_id', $doctor_id);
            })
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('AVG(TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE())) as avg_age'),
                DB::raw('COUNT(CASE WHEN gender = "male" THEN 1 END) as male_count'),
                DB::raw('COUNT(CASE WHEN gender = "female" THEN 1 END) as female_count')
            )
            ->first();

        // Get prescription statistics
        $prescriptionStats = Prescription::where('doctor_id', $doctor_id)
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(DISTINCT patient_id) as unique_patients')
            )
            ->first();

        // Get lab report statistics
        $labReportStats = LabReport::where('doctor_id', $doctor_id)
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(CASE WHEN status = "completed" THEN 1 END) as completed'),
                DB::raw('COUNT(CASE WHEN status = "pending" THEN 1 END) as pending')
            )
            ->first();

        return view('doctor.analytics.index', compact(
            'appointmentsStats',
            'monthlyAppointments',
            'patientDemographics',
            'prescriptionStats',
            'labReportStats'
        ));
    }
}