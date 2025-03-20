<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:receptionist');
    }

    public function index()
    {
        $leaves = Leave::where('staff_type', 'receptionist')
            ->where('staff_id', Auth::guard('receptionist')->id())
            ->latest()
            ->paginate(10);

        return view('receptionist.leaves.index', compact('leaves'));
    }

    public function create()
    {
        return view('receptionist.leaves.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:sick,casual,annual',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
        ]);

        $leave = new Leave();
        $leave->staff_type = 'receptionist';
        $leave->staff_id = Auth::guard('receptionist')->id();
        $leave->doctor_id = null;
        $leave->type = $request->type;
        $leave->start_date = $request->start_date;
        $leave->end_date = $request->end_date;
        $leave->reason = $request->reason;
        $leave->status = 'pending';
        $leave->save();

        return redirect()->route('receptionist.leaves.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function show(Leave $leave)
    {
        if ($leave->staff_type !== 'receptionist' || $leave->staff_id !== Auth::guard('receptionist')->id()) {
            abort(403);
        }

        return view('receptionist.leaves.show', compact('leave'));
    }

    public function cancel(Leave $leave)
    {
        if ($leave->staff_type !== 'receptionist' || 
            $leave->staff_id !== Auth::guard('receptionist')->id() || 
            $leave->status !== 'pending') {
            abort(403);
        }

        $leave->status = 'cancelled';
        $leave->save();

        return redirect()->route('receptionist.leaves.index')
            ->with('success', 'Leave request cancelled successfully.');
    }
} 