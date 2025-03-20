<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        try {
            $leaves = Leave::with(['doctorStaff', 'receptionistStaff', 'doctor'])
                ->latest()
                ->paginate(10);
            return view('admin.leaves.index', compact('leaves'));
        } catch (\Exception $e) {
            Log::error('Error loading leaves: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading leave requests.');
        }
    }

    public function show(Leave $leave)
    {
        try {
            $leave->load(['doctorStaff', 'receptionistStaff', 'doctor']);
            return view('admin.leaves.show', compact('leave'));
        } catch (\Exception $e) {
            Log::error('Error loading leave details: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading leave details.');
        }
    }

    public function updateStatus(Request $request, Leave $leave)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_remarks' => 'nullable|string|max:255',
        ]);

        try {
            Log::info('Updating leave request status', [
                'leave_id' => $leave->id,
                'old_status' => $leave->status,
                'new_status' => $request->status
            ]);

            $leave->update([
                'status' => $request->status,
                'admin_remarks' => $request->admin_remarks,
                'reviewed_at' => now()
            ]);

            return redirect()
                ->route('admin.leaves.show', $leave)
                ->with('success', 'Leave request status has been updated successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to update leave request status', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update leave request status. Please try again.');
        }
    }
} 