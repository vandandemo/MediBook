<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LabReport;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LabReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        $labReports = LabReport::where('doctor_id', Auth::id())->latest()->paginate(10);
        return view('doctor.lab-reports.index', compact('labReports'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('doctor.lab-reports.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'test_type' => 'required|string|max:255',
            'test_date' => 'required|date',
            'results' => 'required|string',
            'comments' => 'nullable|string',
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $validated['doctor_id'] = Auth::id();

        LabReport::create($validated);

        return redirect()->route('doctor.lab-reports.index')
            ->with('success', 'Lab report created successfully.');
    }

    public function show(LabReport $labReport)
    {
        $this->authorize('view', $labReport);
        return view('doctor.lab-reports.show', compact('labReport'));
    }

    public function edit(LabReport $labReport)
    {
        $this->authorize('update', $labReport);
        return view('doctor.lab-reports.edit', compact('labReport'));
    }

    public function update(Request $request, LabReport $labReport)
    {
        $this->authorize('update', $labReport);

        $validated = $request->validate([
            'test_type' => 'required|string|max:255',
            'test_date' => 'required|date',
            'results' => 'required|string',
            'comments' => 'nullable|string',
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $labReport->update($validated);

        return redirect()->route('doctor.lab-reports.index')
            ->with('success', 'Lab report updated successfully.');
    }

    public function destroy(LabReport $labReport)
    {
        $this->authorize('delete', $labReport);
        
        $labReport->delete();

        return redirect()->route('doctor.lab-reports.index')
            ->with('success', 'Lab report deleted successfully.');
    }

    public function download(LabReport $labReport)
    {
        $this->authorize('view', $labReport);

        if ($labReport->status !== 'completed') {
            return back()->with('error', 'Only completed lab reports can be downloaded.');
        }

        $pdf = PDF::loadView('doctor.lab-reports.pdf', compact('labReport'));
        
        $filename = 'lab-report-' . $labReport->report_number . '.pdf';
        
        return $pdf->download($filename);
    }
}