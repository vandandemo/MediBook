<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:cashier');
    }

    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
        
        return view('cashier.appointments.index', compact('appointments'));
    }

    public function today()
    {
        $today = Carbon::today();
        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_date')
            ->paginate(10);
        
        return view('cashier.appointments.today', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'invoice']);
        return view('cashier.appointments.show', compact('appointment'));
    }
} 