<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboard;
use App\Http\Controllers\Patient\DashboardController as PatientDashboard;
use App\Http\Controllers\Receptionist\DashboardController as ReceptionistDashboard;
use App\Http\Controllers\Cashier\DashboardController as CashierDashboard;
use App\Http\Controllers\Admin\ReceptionistController;
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Log;

Route::get('/log-test', function () {
    \Log::info('Log test working');
    return 'Check the logs!';
});

// Login Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);

// Welcome page routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about.us');

Route::get('/appointments/create', function () {
    return redirect()->route('login');
})->name('appointments.create');

// Admin Routes
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/doctors', [\App\Http\Controllers\Admin\AdminController::class, 'doctorManagement'])->name('admin.doctors.index');
    Route::get('/admin/doctors/create', [\App\Http\Controllers\Admin\AdminController::class, 'create'])->name('admin.doctors.create');
    Route::get('/admin/doctors/{doctor}', [\App\Http\Controllers\Admin\AdminController::class, 'show'])->name('admin.doctors.show');
    Route::post('/admin/doctors', [\App\Http\Controllers\Admin\AdminController::class, 'store'])->name('admin.doctors.store');
    Route::get('/admin/doctors/{doctor}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'edit'])->name('admin.doctors.edit');
    Route::put('/admin/doctors/{doctor}', [\App\Http\Controllers\Admin\AdminController::class, 'update'])->name('admin.doctors.update');
    Route::delete('/admin/doctors/{doctor}', [\App\Http\Controllers\Admin\AdminController::class, 'destroy'])->name('admin.doctors.destroy');
    Route::resource('admin/patients', \App\Http\Controllers\Admin\PatientController::class, ['as' => 'admin']);
    
    Route::resource('/admin/appointments', \App\Http\Controllers\Admin\AppointmentController::class);
    Route::get('/admin/appointments', [\App\Http\Controllers\Admin\AdminController::class, 'appointmentManagement'])->name('admin.appointments.index');
    Route::get('/admin/appointments/create', [\App\Http\Controllers\Admin\AdminController::class, 'createAppointment'])->name('admin.appointments.create');
    Route::post('/admin/appointments', [\App\Http\Controllers\Admin\AdminController::class, 'storeAppointment'])->name('admin.appointments.store');
    //Route::get('/admin/appointments/{appointment}', [\App\Http\Controllers\Admin\AdminController::class, 'showAppointment'])->name('admin.appointments.show');
    Route::get('/admin/appointments/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'showAppointment'])->name('admin.appointments.show');
    //Route::get('/admin/appointments/{appointment}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editAppointment'])->name('admin.appointments.edit');
    Route::get('/admin/appointments/{id}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editAppointment'])->name('admin.appointments.edit');
    Route::put('/admin/appointments/{appointment}', [\App\Http\Controllers\Admin\AdminController::class, 'updateAppointment'])->name('admin.appointments.update');
    Route::delete('/admin/appointments/{appointment}', [\App\Http\Controllers\Admin\AdminController::class, 'destroyAppointment'])->name('admin.appointments.destroy');
    
    Route::get('/admin/receptionists', [\App\Http\Controllers\Admin\AdminController::class, 'receptionistManagement'])->name('admin.receptionists.index');
    Route::get('/admin/receptionists/create', [\App\Http\Controllers\Admin\AdminController::class, 'createReceptionist'])->name('admin.receptionists.create');
    Route::post('/admin/receptionists', [\App\Http\Controllers\Admin\AdminController::class, 'storeReceptionist'])->name('admin.receptionists.store');
    Route::get('/admin/receptionists/{receptionist}', [\App\Http\Controllers\Admin\AdminController::class, 'showReceptionist'])->name('admin.receptionists.show');
    Route::get('/admin/receptionists/{receptionist}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editReceptionist'])->name('admin.receptionists.edit');
    Route::put('/admin/receptionists/{receptionist}', [\App\Http\Controllers\Admin\AdminController::class, 'updateReceptionist'])->name('admin.receptionists.update');
    Route::delete('/admin/receptionists/{receptionist}', [\App\Http\Controllers\Admin\AdminController::class, 'destroyReceptionist'])->name('admin.receptionists.destroy');
    Route::get('/admin/receptionists', [\App\Http\Controllers\Admin\ReceptionistController::class, 'index'])->name('admin.receptionists.index');
    Route::get('/admin/receptionists/create', [\App\Http\Controllers\Admin\ReceptionistController::class, 'create'])->name('admin.receptionists.create');
    Route::post('/admin/receptionists', [\App\Http\Controllers\Admin\AdminController::class, 'storeReceptionist'])->name('admin.receptionists.store');
    
    Route::get('/admin/cashiers', [\App\Http\Controllers\Admin\AdminController::class, 'cashierManagement'])->name('admin.cashiers.index');
    Route::get('/admin/cashiers/create', [\App\Http\Controllers\Admin\AdminController::class, 'createCashier'])->name('admin.cashiers.create');
    Route::post('/admin/cashiers', [\App\Http\Controllers\Admin\AdminController::class, 'storeCashier'])->name('admin.cashiers.store');
    Route::get('/admin/cashiers/{cashier}', [\App\Http\Controllers\Admin\AdminController::class, 'showCashier'])->name('admin.cashiers.show');
    Route::get('/admin/cashiers/{cashier}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editCashier'])->name('admin.cashiers.edit');
    Route::put('/admin/cashiers/{cashier}', [\App\Http\Controllers\Admin\AdminController::class, 'updateCashier'])->name('admin.cashiers.update');
    Route::delete('/admin/cashiers/{cashier}', [\App\Http\Controllers\Admin\AdminController::class, 'destroyCashier'])->name('admin.cashiers.destroy');

    // Invoice Management Routes
    Route::get('/admin/invoices', [\App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('admin.invoices.index');
    Route::get('/admin/invoices/create', [\App\Http\Controllers\Admin\InvoiceController::class, 'create'])->name('admin.invoices.create');
    Route::post('/admin/invoices', [\App\Http\Controllers\Admin\InvoiceController::class, 'store'])->name('admin.invoices.store');
    Route::get('/admin/invoices/{invoice}', [\App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('admin.invoices.show');
    Route::get('/admin/invoices/{invoice}/edit', [\App\Http\Controllers\Admin\InvoiceController::class, 'edit'])->name('admin.invoices.edit');
    Route::put('/admin/invoices/{invoice}', [\App\Http\Controllers\Admin\InvoiceController::class, 'update'])->name('admin.invoices.update');
    Route::delete('/admin/invoices/{invoice}', [\App\Http\Controllers\Admin\InvoiceController::class, 'destroy'])->name('admin.invoices.destroy');
    Route::get('/admin/invoices/{invoice}/print', [\App\Http\Controllers\Admin\InvoiceController::class, 'print'])->name('admin.invoices.print');
    Route::resource('admin/insurance-claims', \App\Http\Controllers\Admin\InvoiceController::class, ['as' => 'admin']);


    // Reports & Analytics Routes
    Route::get('/admin/reports', [\App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/financial', [\App\Http\Controllers\Admin\ReportsController::class, 'financialReport'])->name('admin.reports.financial');
    Route::get('/admin/reports/appointments', [\App\Http\Controllers\Admin\ReportsController::class, 'appointmentReport'])->name('admin.reports.appointments');
    Route::get('/admin/reports/staff', [\App\Http\Controllers\Admin\ReportsController::class, 'staffReport'])->name('admin.reports.staff');
    Route::get('/admin/reports/export', [\App\Http\Controllers\Admin\ReportsController::class, 'exportReport'])->name('admin.reports.export');

    // Billing Management Routes
    Route::get('/admin/billing', [\App\Http\Controllers\Admin\BillingController::class, 'index'])->name('admin.billing.index');
    Route::get('/admin/billing/create', [\App\Http\Controllers\Admin\BillingController::class, 'create'])->name('admin.billing.create');
    Route::post('/admin/billing', [\App\Http\Controllers\Admin\BillingController::class, 'store'])->name('admin.billing.store');
    Route::get('/admin/billing/{billing}', [\App\Http\Controllers\Admin\BillingController::class, 'show'])->name('admin.billing.show');
    Route::get('/admin/billing/{billing}/edit', [\App\Http\Controllers\Admin\BillingController::class, 'edit'])->name('admin.billing.edit');
    Route::put('/admin/billing/{billing}', [\App\Http\Controllers\Admin\BillingController::class, 'update'])->name('admin.billing.update');
    Route::delete('/admin/billing/{billing}', [\App\Http\Controllers\Admin\BillingController::class, 'destroy'])->name('admin.billing.destroy');


    Route::post('/admin/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
    
    // Admin Profile Routes
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

    // Leave Management Routes
    Route::get('/admin/leaves', [App\Http\Controllers\Admin\LeaveController::class, 'index'])->name('admin.leaves.index');
    Route::get('/admin/leaves/{leave}', [App\Http\Controllers\Admin\LeaveController::class, 'show'])->name('admin.leaves.show');
    Route::patch('/admin/leaves/{leave}/status', [App\Http\Controllers\Admin\LeaveController::class, 'updateStatus'])->name('admin.leaves.update-status');
});

// Doctor Routes
Route::middleware(['auth:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('doctor.dashboard');
    
    // Appointment Management
    Route::get('/doctor/appointments', [\App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('doctor.appointments');
    Route::get('/doctor/appointments/{appointment}', [\App\Http\Controllers\Doctor\AppointmentController::class, 'show'])->name('doctor.appointments.show');
    Route::put('/doctor/appointments/{appointment}', [\App\Http\Controllers\Doctor\AppointmentController::class, 'update'])->name('doctor.appointments.update');
    
    // Patient Management
    Route::get('/doctor/patients', [\App\Http\Controllers\Doctor\PatientController::class, 'index'])->name('doctor.patients.index');
    Route::get('/doctor/patients/{patient}', [\App\Http\Controllers\Doctor\PatientController::class, 'show'])->name('doctor.patients.show');
    
    // Prescription Management
    Route::resource('doctor/prescriptions', \App\Http\Controllers\Doctor\PrescriptionController::class, ['as' => 'doctor']);
    Route::get('doctor/prescriptions/{prescription}/print', [\App\Http\Controllers\Doctor\PrescriptionController::class, 'print'])->name('doctor.prescriptions.print');
    
    // Lab Reports
    Route::resource('doctor/lab-reports', \App\Http\Controllers\Doctor\LabReportController::class, ['as' => 'doctor']);
    Route::get('doctor/lab-reports/{labReport}/download', [\App\Http\Controllers\Doctor\LabReportController::class, 'download'])->name('doctor.lab-reports.download');
    
    // Schedule Management
    Route::get('/doctor/schedule', [\App\Http\Controllers\Doctor\ScheduleController::class, 'index'])->name('doctor.schedule');
    Route::get('/doctor/schedule/edit', [\App\Http\Controllers\Doctor\ScheduleController::class, 'edit'])->name('doctor.schedule.edit');
    Route::post('/doctor/schedule', [\App\Http\Controllers\Doctor\ScheduleController::class, 'store'])->name('doctor.schedule.store');
    Route::put('/doctor/schedule/{schedule}', [\App\Http\Controllers\Doctor\ScheduleController::class, 'update'])->name('doctor.schedule.update');
    Route::delete('/doctor/schedule/{schedule}', [\App\Http\Controllers\Doctor\ScheduleController::class, 'destroy'])->name('doctor.schedule.destroy');
    
    // Leave Management
    Route::resource('doctor/leaves', \App\Http\Controllers\Doctor\LeaveController::class, ['as' => 'doctor']);
    
    // Doctor Logout Route
    Route::post('/doctor/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('doctor.logout');
    
    // Analytics & Reports
    Route::get('/doctor/analytics', [\App\Http\Controllers\Doctor\AnalyticsController::class, 'index'])->name('doctor.analytics.index');
    Route::get('/doctor/reports', [\App\Http\Controllers\Doctor\ReportController::class, 'index'])->name('doctor.reports.index');
    Route::get('/doctor/reports/generate', [\App\Http\Controllers\Doctor\ReportController::class, 'generate'])->name('doctor.reports.generate');
    
    // Profile Management
    Route::get('/doctor/profile', [ProfileController::class, 'edit'])->name('doctor.profile.edit');
    Route::patch('/doctor/profile', [ProfileController::class, 'update'])->name('doctor.profile.update');
    Route::delete('/doctor/profile', [ProfileController::class, 'destroy'])->name('doctor.profile.destroy');
});

// Patient Routes
Route::middleware(['auth:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientDashboard::class, 'index'])->name('patient.dashboard');
});

// Receptionist Routes
Route::middleware(['auth:receptionist', 'verified'])->group(function () {
    // Dashboard
    Route::get('/receptionist/dashboard', [ReceptionistDashboard::class, 'index'])
        ->name('receptionist.dashboard')
        ->middleware('auth.session');
    
    // Patient Management
    Route::get('/receptionist/patients', [\App\Http\Controllers\Receptionist\PatientController::class, 'index'])
        ->name('receptionist.patients.index')
        ->middleware('auth.session');
    Route::get('/receptionist/patients/create', [\App\Http\Controllers\Receptionist\PatientController::class, 'create'])->name('receptionist.patients.create');
    Route::post('/receptionist/patients', [\App\Http\Controllers\Receptionist\PatientController::class, 'store'])->name('receptionist.patients.store');
    Route::get('/receptionist/patients/{id}', [\App\Http\Controllers\Receptionist\PatientController::class, 'show'])->name('receptionist.patients.show');
    Route::get('/receptionist/patients/{id}/edit', [\App\Http\Controllers\Receptionist\PatientController::class, 'edit'])->name('receptionist.patients.edit');
    Route::put('/receptionist/patients/{id}', [\App\Http\Controllers\Receptionist\PatientController::class, 'update'])->name('receptionist.patients.update');
    Route::get('/receptionist/patients/search', [\App\Http\Controllers\Receptionist\PatientController::class, 'search'])->name('receptionist.patients.search');
    
    // Appointment Management
    Route::get('/receptionist/appointments', [\App\Http\Controllers\Receptionist\AppointmentController::class, 'index'])->name('receptionist.appointments.index');
    Route::get('/receptionist/appointments/create', [\App\Http\Controllers\Receptionist\AppointmentController::class, 'create'])->name('receptionist.appointments.create');
    Route::post('/receptionist/appointments', [\App\Http\Controllers\Receptionist\AppointmentController::class, 'store'])->name('receptionist.appointments.store');
    Route::get('/receptionist/appointments/{id}', [\App\Http\Controllers\Receptionist\AppointmentController::class, 'show'])->name('receptionist.appointments.show');
    Route::get('/receptionist/appointments/{id}/edit', [\App\Http\Controllers\Receptionist\AppointmentController::class, 'edit'])->name('receptionist.appointments.edit');
    Route::put('/receptionist/appointments/{id}', [\App\Http\Controllers\Receptionist\AppointmentController::class, 'update'])->name('receptionist.appointments.update');
    Route::delete('/receptionist/appointments/{id}', [\App\Http\Controllers\Receptionist\AppointmentController::class, 'destroy'])->name('receptionist.appointments.destroy');
    Route::get('/receptionist/today-appointments', [\App\Http\Controllers\Receptionist\AppointmentController::class, 'todayAppointments'])->name('receptionist.appointments.today');
    Route::post('/receptionist/appointments/{id}/check-in', [\App\Http\Controllers\Receptionist\AppointmentController::class, 'checkIn'])->name('receptionist.appointments.check-in');
    
    // Billing Management
    Route::get('/receptionist/billing', [\App\Http\Controllers\Receptionist\BillingController::class, 'index'])->name('receptionist.billing.index');
    Route::get('/receptionist/billing/create', [\App\Http\Controllers\Receptionist\BillingController::class, 'create'])->name('receptionist.billing.create');
    Route::post('/receptionist/billing', [\App\Http\Controllers\Receptionist\BillingController::class, 'store'])->name('receptionist.billing.store');
    Route::get('/receptionist/billing/{id}', [\App\Http\Controllers\Receptionist\BillingController::class, 'show'])->name('receptionist.billing.show');
    Route::get('/receptionist/billing/{id}/edit', [\App\Http\Controllers\Receptionist\BillingController::class, 'edit'])->name('receptionist.billing.edit');
    Route::put('/receptionist/billing/{id}', [\App\Http\Controllers\Receptionist\BillingController::class, 'update'])->name('receptionist.billing.update');
    Route::post('/receptionist/billing/{id}/payment', [\App\Http\Controllers\Receptionist\BillingController::class, 'recordPayment'])->name('receptionist.billing.payment');
    Route::get('/receptionist/billing/{id}/print', [\App\Http\Controllers\Receptionist\BillingController::class, 'printInvoice'])->name('receptionist.billing.print');
    
    // Profile Management
    Route::get('/receptionist/profile', [ProfileController::class, 'edit'])->name('receptionist.profile.edit');
    Route::patch('/receptionist/profile', [ProfileController::class, 'update'])->name('receptionist.profile.update');
    
    // Logout Route
    Route::post('/receptionist/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('receptionist.logout');

    // Leave Management Routes
    Route::get('/receptionist/leaves', [App\Http\Controllers\Receptionist\LeaveController::class, 'index'])->name('receptionist.leaves.index');
    Route::get('/receptionist/leaves/create', [App\Http\Controllers\Receptionist\LeaveController::class, 'create'])->name('receptionist.leaves.create');
    Route::post('/receptionist/leaves', [App\Http\Controllers\Receptionist\LeaveController::class, 'store'])->name('receptionist.leaves.store');
    Route::get('/receptionist/leaves/{leave}', [App\Http\Controllers\Receptionist\LeaveController::class, 'show'])->name('receptionist.leaves.show');
    Route::patch('/receptionist/leaves/{leave}/cancel', [App\Http\Controllers\Receptionist\LeaveController::class, 'cancel'])->name('receptionist.leaves.cancel');
});

// Cashier Routes
Route::middleware(['auth:cashier'])->group(function () {
    Route::get('/cashier/dashboard', [CashierDashboard::class, 'index'])->name('cashier.dashboard');
    
    // Profile Management
    Route::get('/cashier/profile', [ProfileController::class, 'edit'])->name('cashier.profile.edit');
    Route::patch('/cashier/profile', [ProfileController::class, 'update'])->name('cashier.profile.update');
    Route::delete('/cashier/profile', [ProfileController::class, 'destroy'])->name('cashier.profile.destroy');
    
    // Reports & Analytics
    Route::get('/cashier/reports', [\App\Http\Controllers\Cashier\ReportController::class, 'index'])->name('cashier.reports.index');
    Route::get('/cashier/reports/transactions', [\App\Http\Controllers\Cashier\ReportController::class, 'transactions'])->name('cashier.reports.transactions');
    Route::get('/cashier/reports/payments', [\App\Http\Controllers\Cashier\ReportController::class, 'payments'])->name('cashier.reports.payments');
    Route::get('/cashier/reports/generate', [\App\Http\Controllers\Cashier\ReportController::class, 'generate'])->name('cashier.reports.generate');
    
    // Transaction Management
    Route::get('/cashier/transactions', [\App\Http\Controllers\Cashier\TransactionController::class, 'index'])->name('cashier.transactions.index');
    Route::get('/cashier/transactions/create', [\App\Http\Controllers\Cashier\TransactionController::class, 'create'])->name('cashier.transactions.create');
    Route::post('/cashier/transactions', [\App\Http\Controllers\Cashier\TransactionController::class, 'store'])->name('cashier.transactions.store');
    Route::get('/cashier/transactions/{transaction}', [\App\Http\Controllers\Cashier\TransactionController::class, 'show'])->name('cashier.transactions.show');
    Route::get('/cashier/transactions/{transaction}/print-receipt', [\App\Http\Controllers\Cashier\TransactionController::class, 'printReceipt'])->name('cashier.transactions.print-receipt');
    
    // Invoice Management
    Route::get('/cashier/invoices', [\App\Http\Controllers\Cashier\InvoiceController::class, 'index'])->name('cashier.invoices.index');
    Route::get('/cashier/invoices/create', [\App\Http\Controllers\Cashier\InvoiceController::class, 'create'])->name('cashier.invoices.create');
    Route::post('/cashier/invoices', [\App\Http\Controllers\Cashier\InvoiceController::class, 'store'])->name('cashier.invoices.store');
    Route::get('/cashier/invoices/{invoice}', [\App\Http\Controllers\Cashier\InvoiceController::class, 'show'])->name('cashier.invoices.show');
    Route::get('/cashier/invoices/{invoice}/edit', [\App\Http\Controllers\Cashier\InvoiceController::class, 'edit'])->name('cashier.invoices.edit');
    Route::put('/cashier/invoices/{invoice}', [\App\Http\Controllers\Cashier\InvoiceController::class, 'update'])->name('cashier.invoices.update');
    Route::delete('/cashier/invoices/{invoice}', [\App\Http\Controllers\Cashier\InvoiceController::class, 'destroy'])->name('cashier.invoices.destroy');
    Route::get('/cashier/invoices/{invoice}/print', [\App\Http\Controllers\Cashier\InvoiceController::class, 'print'])->name('cashier.invoices.print');
    
    // Payment Processing
    Route::get('/cashier/payments', [\App\Http\Controllers\Cashier\PaymentController::class, 'index'])->name('cashier.payments.index');
    Route::get('/cashier/payments/create', [\App\Http\Controllers\Cashier\PaymentController::class, 'create'])->name('cashier.payments.create');
    Route::post('/cashier/payments', [\App\Http\Controllers\Cashier\PaymentController::class, 'store'])->name('cashier.payments.store');
    Route::get('/cashier/payments/{payment}', [\App\Http\Controllers\Cashier\PaymentController::class, 'show'])->name('cashier.payments.show');
    Route::get('/cashier/payments/{payment}/receipt', [\App\Http\Controllers\Cashier\PaymentController::class, 'printReceipt'])->name('cashier.payments.receipt');
    
    // Patient Search
    Route::get('/cashier/patients', [\App\Http\Controllers\Cashier\PatientController::class, 'index'])->name('cashier.patients.index');
    Route::get('/cashier/patients/search', [\App\Http\Controllers\Cashier\PatientController::class, 'search'])->name('cashier.patients.search');
    Route::get('/cashier/patients/{patient}', [\App\Http\Controllers\Cashier\PatientController::class, 'show'])->name('cashier.patients.show');
    
    // Appointment Management
    Route::get('/cashier/appointments', [\App\Http\Controllers\Cashier\AppointmentController::class, 'index'])->name('cashier.appointments.index');
    Route::get('/cashier/appointments/today', [\App\Http\Controllers\Cashier\AppointmentController::class, 'today'])->name('cashier.appointments.today');
    Route::get('/cashier/appointments/{appointment}', [\App\Http\Controllers\Cashier\AppointmentController::class, 'show'])->name('cashier.appointments.show');
    
    // Logout Route
    Route::post('/cashier/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('cashier.logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-doctor-auth', function () {
    $credentials = [
        'email' => 'doctor@hospital.com',
        'password' => 'doctor123'
    ];

    if (Auth::guard('doctor')->attempt($credentials)) {
        $doctor = Auth::guard('doctor')->user();
        return [
            'success' => true,
            'message' => 'Authentication successful',
            'doctor' => [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'email' => $doctor->email,
                'specialization_id' => $doctor->specialization_id,
                'department_id' => $doctor->department_id,
                'license_number' => $doctor->license_number,
                'active' => $doctor->active
            ]
        ];
    }

    return [
        'success' => false,
        'message' => 'Authentication failed',
        'doctor_exists' => \App\Models\Doctor::where('email', 'doctor@hospital.com')->exists(),
        'password_check' => Hash::check('doctor123', \App\Models\Doctor::where('email', 'doctor@hospital.com')->first()->password ?? '')
    ];
});

Route::get('/medical-advice', function () {
    return view('medical-advice');
})->name('medical.advice');

Route::get('/emergency-help', function () {
    return view('emergency-help');
})->name('emergency.help');

Route::get('/trusted-treatment', function () {
    return view('trusted-treatment');
})->name('trusted.treatment');

Route::get('/research-professional', function () {
    return view('research-professional');
})->name('research.professional');

Route::get('/crutches', function () {
    return view('crutches');
})->name('crutches');

Route::get('/xray', function () {
    return view('xray');
})->name('xray');

Route::get('/pulmonary', function () {
    return view('pulmonary');
})->name('pulmonary');

Route::get('/cardiology', function () {
    return view('cardiology');
})->name('cardiology');

Route::get('/dental-care', function () {
    return view('dental-care');
})->name('dental.care');

Route::get('/neurology', function () {
    return view('neurology');
})->name('neurology');

Route::get('/medical', function () {
    return view('medical');
})->name('medical');

Route::get('/orthopedic', function () {
    return view('orthopedic');
})->name('orthopedic');

Route::get('/blood-bank', function () {
    return view('blood-bank');
})->name('blood.bank');

Route::get('/surgical', function () {
    return view('surgical');
})->name('surgical');

Route::get('/nursing', function () {
    return view('nursing');
})->name('nursing');

Route::get('/psychiatry', function () {
    return view('psychiatry');
})->name('psychiatry');

// Social Login Routes
Route::get('auth/{provider}', [App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToProvider'])
    ->name('social.login');
Route::get('auth/{provider}/callback', [App\Http\Controllers\Auth\SocialAuthController::class, 'handleProviderCallback'])
    ->name('social.callback');

require __DIR__.'/auth.php';


