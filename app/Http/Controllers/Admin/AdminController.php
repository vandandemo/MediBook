<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Receptionist;
use App\Models\User;
use App\Models\Cashier;
use App\Models\Invoice;
use App\Http\Requests\Admin\StoreAppointmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function logout(Request $request)
    {
        try {
            \Log::info('Admin logout attempt', [
                'admin_id' => auth()->id(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            auth('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            \Log::info('Admin logged out successfully');

            return redirect()->route('admin.login');
        } catch (\Exception $e) {
            \Log::error('Admin logout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Logout failed. Please try again.');
        }
    }

    public function dashboard()
    {
        // Get hospital statistics
        $stats = [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'total_appointments' => Appointment::count(),
            'total_revenue' => Appointment::sum('amount'),
            'recent_appointments' => Appointment::with(['patient', 'doctor'])
                ->latest()
                ->take(5)
                ->get(),
            'monthly_revenue' => Appointment::whereMonth('created_at', Carbon::now()->month)
                ->sum('amount'),
            'daily_appointments' => Appointment::whereDate('appointment_date', Carbon::today())
                ->count()
        ];

        // Get recent activities
        $recent_activities = DB::table('activity_log')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_activities'));
    }

    public function show(Doctor $doctor)
    {
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $specializations = DB::table('specializations')->get();
        $departments = \App\Models\Department::all();
        return view('admin.doctors.edit', compact('doctor', 'specializations', 'departments'));
    }

    public function receptionistManagement()
    {
        $receptionists = Receptionist::paginate(10);
        return view('admin.receptionists.index', compact('receptionists'));
    }

    public function cashierManagement()
    {
        $cashiers = Cashier::paginate(10);
        return view('admin.cashiers.index', compact('cashiers'));
    }

    public function userManagement()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function doctorManagement()
    {
        $doctors = Doctor::with('specialization', 'department')->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function patientManagement()
    {
        $patients = Patient::with('appointments')->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    public function showReceptionist(Receptionist $receptionist)
    {
        return view('admin.receptionists.show', compact('receptionist'));
    }

    public function appointmentManagement()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->latest()
            ->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function createAppointment()
    {
        $doctors = Doctor::all();
        $patients = Patient::all();
        return view('admin.appointments.create', compact('doctors', 'patients'));
    }

    public function storeAppointment(StoreAppointmentRequest $request)
    {
        try {
            DB::beginTransaction();

            // Log the appointment creation attempt
            \Log::info('Attempting to create new appointment', [
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'appointment_date' => $request->appointment_date
            ]);

            $appointment = Appointment::create($request->validated());

            // Log successful appointment creation
            \Log::info('Appointment created successfully', [
                'appointment_id' => $appointment->id,
                'data' => $appointment->toArray()
            ]);

            // Create invoice for the appointment
            $invoice = Invoice::create([
                'patient_id' => $appointment->patient_id,
                'appointment_id' => $appointment->id,
                'amount' => $appointment->amount,
                'status' => 'pending',
                'due_date' => now()->addDays(30),
                'payment_method' => null,
                'notes' => 'Automatically generated invoice for appointment'
            ]);

            // Log invoice creation
            \Log::info('Invoice created for appointment', [
                'invoice_id' => $invoice->id,
                'appointment_id' => $appointment->id
            ]);

            DB::commit();

            return redirect()->route('admin.appointments.index')
                ->with('success', 'Appointment created successfully with invoice');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            \Log::warning('Validation failed during appointment creation', [
                'errors' => $e->errors()
            ]);
            
            return back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to create appointment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Failed to create appointment. Please try again.');
        }
    }

    public function reports()
    {
        $yearly_revenue = Appointment::selectRaw('YEAR(created_at) as year, SUM(amount) as total')
            ->groupBy('year')
            ->get();

        $monthly_revenue = Appointment::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->get();

        $appointment_stats = Appointment::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        return view('admin.reports.index', compact('yearly_revenue', 'monthly_revenue', 'appointment_stats'));
    }

    public function generateReport(Request $request)
    {
        $type = $request->type;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        $data = [];
        switch($type) {
            case 'financial':
                $data = Appointment::whereBetween('created_at', [$start_date, $end_date])
                    ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
                    ->groupBy('date')
                    ->get();
                break;
            case 'appointments':
                $data = Appointment::whereBetween('appointment_date', [$start_date, $end_date])
                    ->selectRaw('DATE(appointment_date) as date, COUNT(*) as total')
                    ->groupBy('date')
                    ->get();
                break;
            case 'patients':
                $data = Patient::whereBetween('created_at', [$start_date, $end_date])
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                    ->groupBy('date')
                    ->get();
                break;
        }

        return response()->json($data);
    }

    public function storeCashier(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:cashiers',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'employee_id' => 'required|string|max:255|unique:cashiers',
            'shift' => 'required|string|in:morning,afternoon,evening'
        ]);

        $cashier = Cashier::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'employee_id' => $validated['employee_id'],
            'shift' => $validated['shift'],
            'active' => true
        ]);

        return redirect()->route('admin.cashiers.index')
            ->with('success', 'Cashier created successfully');
    }

    public function create()
    {
        $specializations = \App\Models\Specialization::all();
        $departments = \App\Models\Department::all();
        return view('admin.doctors.create', compact('departments','specializations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:doctors',
            'phone_number' => 'required|string|max:20|unique:doctors',
            'password' => 'required|string|min:8|confirmed',
            'specialization_id' => 'required|exists:specializations,id',
            'department_id' => 'required|exists:departments,id',
            'license_number' => 'required|string|max:255|unique:doctors',
            'email_verified_at' => 'nullable|date',
            'active' => 'sometimes|boolean'
        ]);

        $doctor = Doctor::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => bcrypt($validated['password']),
            'specialization_id' => $validated['specialization_id'],
            'department_id' => $validated['department_id'],
            'license_number' => $validated['license_number'],
            'email_verified_at' => $validated['email_verified_at'] ?? null,
            'active' => $request->has('active') ? $request->active : true
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor created successfully.');
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'specialization_id' => 'required|exists:specializations,id',
            'department_id' => 'required|exists:departments,id',
            'license_number' => 'required|string|unique:doctors,license_number,' . $doctor->id,
            'phone_number' => 'required|string|max:20',
            'active' => 'required|boolean'
        ]);

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor updated successfully');
    }

    public function editAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function showAppointment($id)
{
    // Fetch the appointment with related patient and doctor details
    $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($id);

    return view('admin.appointments.show', compact('appointment'));
}

public function storeReceptionist(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:receptionists,email',
            'employee_id' => 'required|string|unique:receptionists,employee_id',
            'shift' => 'required|string|max:50',
        ]);

        $validated['password'] = Hash::make('password123'); // Default password

        $receptionist = Receptionist::create($validated);

        return redirect()->route('admin.receptionists.index')
            ->with('success', 'Receptionist created successfully.');
    }

    public function createCashier()
    {
        return view('admin.cashiers.create');
    }

    public function showCashier($id)
    {
        $cashier = Cashier::findOrFail($id);
        return view('admin.cashiers.show', compact('cashier'));
    }

    public function editCashier($id)
    {
        $cashier = Cashier::findOrFail($id);
        return view('admin.cashiers.edit', compact('cashier'));
    }

    public function updateCashier(Request $request, $id)
    {
        $cashier = Cashier::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:cashiers,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'active' => 'required|boolean'
        ]);

        $cashier->update($validated);

        return redirect()->route('admin.cashiers.index')
            ->with('success', 'Cashier updated successfully');
    }

    public function editReceptionist($id)
{
    $receptionist = Receptionist::findOrFail($id);
    return view('admin.receptionists.edit', compact('receptionist'));
}

public function updateReceptionist(Request $request, $id)
{
    $receptionist = Receptionist::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:receptionists,email,' . $id,
        'employee_id' => 'required|string|unique:receptionists,employee_id,' . $id,
        'shift' => 'required|string|in:morning,afternoon,evening',
        'active' => 'required|boolean',
        'password' => 'nullable|min:6',
    ]);

    // Fix: Use `$validated` instead of `$validatedData`
    if ($request->filled('password')) {
        $validated['password'] = bcrypt($request->password);
    } else {
        unset($validated['password']); // Don't update password if not provided
    }

    $receptionist->update($validated);

    return redirect()->route('admin.receptionists.index')
        ->with('success', 'Receptionist updated successfully.');
}


    public function updateAppointment(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $appointment = Appointment::findOrFail($id);

            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'required|exists:doctors,id',
                'appointment_date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'status' => 'required|in:scheduled,completed,cancelled',
                'notes' => 'nullable|string',
                'amount' => 'required|numeric|min:0'
            ]);

            // Log the update attempt
            \Log::info('Attempting to update appointment', [
                'appointment_id' => $id,
                'old_data' => $appointment->toArray(),
                'new_data' => $validated
            ]);

            $appointment->update($validated);

            // Update associated invoice if it exists
            if ($appointment->invoice) {
                $appointment->invoice->update([
                    'amount' => $validated['amount'],
                    'updated_at' => now()
                ]);
                \Log::info('Updated associated invoice', [
                    'invoice_id' => $appointment->invoice->id,
                    'new_amount' => $validated['amount']
                ]);
            }

            DB::commit();

            session()->flash('success', 'Appointment updated successfully');
            return redirect()->route('admin.appointments.index');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            \Log::error('Appointment not found', ['id' => $id]);
            session()->flash('error', 'Appointment not found.');
            return back()->withInput();

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            \Log::warning('Validation failed during appointment update', [
                'errors' => $e->errors(),
                'appointment_id' => $id
            ]);
            return back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Unexpected error during appointment update', [
                'appointment_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'An error occurred while updating the appointment. Please try again.');
            return back()->withInput();
        }
    }

    public function destroyAppointment(Appointment $appointment)
    {
        try {
            DB::beginTransaction();

            // Check if appointment exists
            if (!$appointment) {
                throw new \Exception('Appointment not found');
            }

            // Delete associated invoice if exists
            if ($appointment->invoice) {
                $appointment->invoice->delete();
            }

            // Delete the appointment
            $result = $appointment->delete();

            if (!$result) {
                throw new \Exception('Failed to delete appointment');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Appointment deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete appointment: ' . $e->getMessage()
            ], 500);
        }
    }

}