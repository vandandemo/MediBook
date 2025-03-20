<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('doctor_id', Auth::id())
            ->orderBy('day_of_week', 'asc')
            ->get()
            ->keyBy('day_of_week');

        $leaves = Leave::where('doctor_id', Auth::id())
            ->where('end_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->get();

        // Get appointment statistics
        $totalAppointments = Auth::user()->appointments()
            ->whereMonth('appointment_date', Carbon::now()->month)
            ->count();

        $completedAppointments = Auth::user()->appointments()
            ->whereMonth('appointment_date', Carbon::now()->month)
            ->where('status', 'completed')
            ->count();

        $upcomingAppointments = Auth::user()->appointments()
            ->where('appointment_date', '>=', now())
            ->where('appointment_date', '<=', now()->addDays(7))
            ->where('status', 'scheduled')
            ->count();

        $cancelledAppointments = Auth::user()->appointments()
            ->whereMonth('appointment_date', Carbon::now()->month)
            ->where('status', 'cancelled')
            ->count();

        return view('doctor.schedule', compact(
            'schedules', 
            'leaves', 
            'totalAppointments', 
            'completedAppointments', 
            'upcomingAppointments', 
            'cancelledAppointments'
        ));
    }

    public function store(Request $request)
    {
        Log::info('Attempting to store schedule', [
            'doctor_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        try {
            $validated = $request->validate([
                'schedule' => 'required|array',
                'schedule.*.day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'schedule.*.start_time' => 'required|date_format:H:i',
                'schedule.*.end_time' => [
                    'required',
                    'date_format:H:i',
                    function ($attribute, $value, $fail) use ($request) {
                        $index = explode('.', $attribute)[1];
                        $startTime = $request->input("schedule.{$index}.start_time");
                        
                        // Allow equal times only if both are "00:00" (non-working day)
                        if ($startTime === '00:00' && $value === '00:00') {
                            return;
                        }
                        
                        // Otherwise, end time must be after start time
                        if ($value <= $startTime) {
                            $fail('The end time must be after start time.');
                        }
                    }
                ],
                'schedule.*.max_appointments' => 'required|integer|min:1',
                'schedule.*.location' => 'nullable|string|max:255',
                'schedule.*.consultation_type' => 'required|in:in-person,virtual,both'
            ]);

            Log::info('Schedule validation passed', [
                'doctor_id' => Auth::id(),
                'validated_data' => $validated
            ]);

            // Delete existing schedules for the doctor
            $deletedCount = Schedule::where('doctor_id', Auth::id())->delete();
            Log::info('Deleted existing schedules', [
                'doctor_id' => Auth::id(),
                'deleted_count' => $deletedCount
            ]);

            // Create new schedules
            $createdSchedules = [];
            foreach ($request->schedule as $daySchedule) {
                $schedule = Schedule::create([
                    'doctor_id' => Auth::id(),
                    'day_of_week' => $daySchedule['day'],
                    'start_time' => $daySchedule['start_time'],
                    'end_time' => $daySchedule['end_time'],
                    'max_appointments' => $daySchedule['max_appointments'],
                    'is_available' => true,
                    'location' => $daySchedule['location'] ?? null,
                    'consultation_type' => $daySchedule['consultation_type']
                ]);
                $createdSchedules[] = $schedule->id;
            }

            Log::info('Created new schedules', [
                'doctor_id' => Auth::id(),
                'created_schedule_ids' => $createdSchedules
            ]);

            return redirect()->route('doctor.schedule')
                ->with('success', 'Schedule updated successfully');

        } catch (\Exception $e) {
            Log::error('Failed to store schedule', [
                'doctor_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update schedule. Please try again.');
        }
    }

    public function edit()
    {
        // Add logging for debugging
        Log::info('Attempting to access schedule edit page', [
            'doctor_id' => Auth::id(),
            'authenticated' => Auth::check(),
            'guard' => Auth::getDefaultDriver()
        ]);

        $schedules = Schedule::where('doctor_id', Auth::id())
            ->orderBy('day_of_week', 'asc')
            ->get()
            ->keyBy('day_of_week');

        // Log the retrieved schedules
        Log::info('Retrieved schedules for edit', [
            'doctor_id' => Auth::id(),
            'schedule_count' => $schedules->count(),
            'days_with_schedules' => $schedules->keys()->toArray()
        ]);

        return view('doctor.schedule.edit', compact('schedules'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        // Ensure the doctor can only update their own schedule
        if ($schedule->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_appointments' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
            'consultation_type' => 'required|in:in-person,virtual,both'
        ]);

        $schedule->update($request->only([
            'start_time',
            'end_time',
            'max_appointments',
            'location',
            'consultation_type'
        ]));

        return redirect()->route('doctor.schedule')
            ->with('success', 'Schedule updated successfully');
    }

    public function destroy(Schedule $schedule)
    {
        // Ensure the doctor can only delete their own schedule
        if ($schedule->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $schedule->delete();

        return redirect()->route('doctor.schedule')
            ->with('success', 'Schedule deleted successfully');
    }
}