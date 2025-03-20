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

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        return view('doctor.reports.index');
    }

    public function generate(Request $request)
    {
        $doctor_id = Auth::id();
        $reportType = $request->input('report_type', 'appointments');
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now());

        $data = [];
        switch($reportType) {
            case 'appointments':
                $data = $this->generateAppointmentReport($doctor_id, $startDate, $endDate);
                break;
            case 'patients':
                $data = $this->generatePatientReport($doctor_id, $startDate, $endDate);
                break;
            case 'prescriptions':
                $data = $this->generatePrescriptionReport($doctor_id, $startDate, $endDate);
                break;
            case 'lab_reports':
                $data = $this->generateLabReport($doctor_id, $startDate, $endDate);
                break;
        }

        return view('doctor.reports.show', compact('data', 'reportType', 'startDate', 'endDate'));
    }

    private function generateAppointmentReport($doctor_id, $startDate, $endDate)
    {
        return Appointment::where('doctor_id', $doctor_id)
            ->whereBetween('appointment_date', [$startDate, $endDate])
            ->select(
                'appointment_date',
                'status',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed'),
                DB::raw('SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled')
            )
            ->groupBy('appointment_date', 'status')
            ->get();
    }

    private function generatePatientReport($doctor_id, $startDate, $endDate)
    {
        return Patient::whereHas('appointments', function($query) use ($doctor_id, $startDate, $endDate) {
                $query->where('doctor_id', $doctor_id)
                    ->whereBetween('appointment_date', [$startDate, $endDate]);
            })
            ->with(['appointments' => function($query) use ($doctor_id) {
                $query->where('doctor_id', $doctor_id);
            }])
            ->get();
    }

    private function generatePrescriptionReport($doctor_id, $startDate, $endDate)
    {
        return Prescription::where('doctor_id', $doctor_id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('patient')
            ->get()
            ->groupBy(function($prescription) {
                return $prescription->created_at->format('Y-m-d');
            });
    }

    private function generateLabReport($doctor_id, $startDate, $endDate)
    {
        return LabReport::where('doctor_id', $doctor_id)
            ->whereBetween('test_date', [$startDate, $endDate])
            ->with('patient')
            ->get()
            ->groupBy(function($report) {
                return $report->test_date->format('Y-m-d');
            });
    }
}