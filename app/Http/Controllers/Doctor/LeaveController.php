<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        $leaves = Leave::where('doctor_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('doctor.leaves.index', compact('leaves'));
    }

    public function create()
    {
        return view('doctor.leaves.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
            'type' => 'required|in:sick,casual,annual'
        ]);

        $validated['doctor_id'] = Auth::id();
        $validated['status'] = 'pending';

        Leave::create($validated);

        return redirect()->route('doctor.leaves.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function show($id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            Log::error('Leave request not found', [
                'leave_id' => $id,
                'current_doctor_id' => Auth::id()
            ]);
            abort(404, 'Leave request not found.');
        }

        // Add debugging information
        Log::info('Attempting to view leave request', [
            'leave_id' => $leave->id,
            'leave_doctor_id' => $leave->doctor_id,
            'current_doctor_id' => Auth::id(),
            'authenticated' => Auth::check(),
            'guard' => Auth::getDefaultDriver()
        ]);

        try {
            $this->authorize('view', $leave);
            return view('doctor.leaves.show', compact('leave'));
        } catch (\Exception $e) {
            Log::error('Authorization failed for leave request', [
                'error' => $e->getMessage(),
                'leave_id' => $leave->id,
                'leave_doctor_id' => $leave->doctor_id,
                'current_doctor_id' => Auth::id()
            ]);
            abort(403, 'This action is unauthorized.');
        }
    }

    public function edit($id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            Log::error('Leave request not found', [
                'leave_id' => $id,
                'current_doctor_id' => Auth::id()
            ]);
            abort(404, 'Leave request not found.');
        }

        // Add debugging information
        Log::info('Attempting to edit leave request', [
            'leave_id' => $leave->id,
            'leave_doctor_id' => $leave->doctor_id,
            'current_doctor_id' => Auth::id(),
            'authenticated' => Auth::check(),
            'guard' => Auth::getDefaultDriver()
        ]);

        try {
            $this->authorize('update', $leave);
            return view('doctor.leaves.edit', compact('leave'));
        } catch (\Exception $e) {
            Log::error('Authorization failed for leave request edit', [
                'error' => $e->getMessage(),
                'leave_id' => $leave->id,
                'leave_doctor_id' => $leave->doctor_id,
                'current_doctor_id' => Auth::id()
            ]);
            abort(403, 'This action is unauthorized.');
        }
    }

    public function update(Request $request, $id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            Log::error('Leave request not found', [
                'leave_id' => $id,
                'current_doctor_id' => Auth::id()
            ]);
            abort(404, 'Leave request not found.');
        }

        try {
            $this->authorize('update', $leave);

            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required|string|max:500',
                'type' => 'required|in:sick,casual,annual'
            ]);

            $leave->update($validated);

            return redirect()->route('doctor.leaves.index')
                ->with('success', 'Leave request updated successfully.');
        } catch (\Exception $e) {
            Log::error('Authorization failed for leave request update', [
                'error' => $e->getMessage(),
                'leave_id' => $leave->id,
                'leave_doctor_id' => $leave->doctor_id,
                'current_doctor_id' => Auth::id()
            ]);
            abort(403, 'This action is unauthorized.');
        }
    }

    public function destroy($id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            Log::error('Leave request not found', [
                'leave_id' => $id,
                'current_doctor_id' => Auth::id()
            ]);
            abort(404, 'Leave request not found.');
        }

        try {
            $this->authorize('delete', $leave);
            
            if ($leave->status === 'approved') {
                return redirect()->route('doctor.leaves.index')
                    ->with('error', 'Cannot delete an approved leave request.');
            }

            $leave->delete();

            return redirect()->route('doctor.leaves.index')
                ->with('success', 'Leave request deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Authorization failed for leave request deletion', [
                'error' => $e->getMessage(),
                'leave_id' => $leave->id,
                'leave_doctor_id' => $leave->doctor_id,
                'current_doctor_id' => Auth::id()
            ]);
            abort(403, 'This action is unauthorized.');
        }
    }
}