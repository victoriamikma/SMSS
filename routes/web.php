<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\ExpenseController; 

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    
    // Staff routes - FIXED: Removed duplicate routes
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::post('/staff', [StaffController::class, 'storeStaff'])->name('staff.store');
    Route::put('/staff/{staff}', [StaffController::class, 'updateStaff'])->name('staff.update');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
    
    // Import/Export routes
    Route::post('/staff/import', [StaffController::class, 'import'])->name('staff.import');
    Route::get('/staff/export', [StaffController::class, 'export'])->name('staff.export');
    Route::get('/staff/template', [StaffController::class, 'downloadTemplate'])->name('staff.template');
   
    // Payroll routes
    Route::post('/process-payroll', [StaffController::class, 'processPayroll'])->name('staff.processPayroll');
    Route::get('/staff-for-payroll', [StaffController::class, 'getStaffForPayroll'])->name('staff.forPayroll');
    Route::get('/payroll-records', [StaffController::class, 'getPayroll'])->name('staff.payrollRecords');
    Route::get('/payroll-stats', [StaffController::class, 'getStats'])->name('staff.payrollStats');

    // Applications routes
    Route::get('applications/import', [ApplicationsController::class, 'showImportForm'])->name('applications.import');
    Route::post('applications/import', [ApplicationsController::class, 'import'])->name('applications.import.process');
    Route::get('applications/template', [ApplicationsController::class, 'downloadTemplate'])->name('applications.template');
    Route::get('applications/export', [ApplicationsController::class, 'export'])->name('applications.export');
    Route::post('applications/{id}/status', [ApplicationsController::class, 'updateStatus'])->name('applications.status');
    // additions
    Route::get('applications/import', [ApplicationsController::class, 'showImportForm'])->name('applications.import');
    Route::post('applications/import', [ApplicationsController::class, 'import'])->name('applications.import.process');
    Route::get('applications/template', [ApplicationsController::class, 'downloadTemplate'])->name('applications.template');
    Route::get('applications/export', [ApplicationsController::class, 'export'])->name('applications.export');
    Route::post('applications/{id}/status', [ApplicationsController::class, 'updateStatus'])->name('applications.status');
    Route::get('applications/stats', [ApplicationsController::class, 'getStats'])->name('applications.stats');

    // Resource route should be at the end
    Route::resource('applications', ApplicationsController::class);
    
    // Calendar routes
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/create', [CalendarController::class, 'create'])->name('calendar.create');
    Route::post('/calendar', [CalendarController::class, 'store'])->name('calendar.store');
    Route::get('/calendar/{event}', [CalendarController::class, 'show'])->name('calendar.show');
    Route::get('/calendar/{event}/edit', [CalendarController::class, 'edit'])->name('calendar.edit');
    Route::put('/calendar/{event}', [CalendarController::class, 'update'])->name('calendar.update');
    Route::delete('/calendar/{event}', [CalendarController::class, 'destroy'])->name('calendar.destroy');
    Route::get('/calendar/api/events', [CalendarController::class, 'api'])->name('calendar.api');
    
    Route::get('/academics', [AcademicController::class, 'index'])->name('academics.index');
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    
    // Expenses routes - FIXED: Added the missing reports route
    Route::resource('expenses', ExpenseController::class);
    Route::get('/expenses/import', [ExpenseController::class, 'import'])->name('expenses.import');
    Route::get('/expenses/export', [ExpenseController::class, 'export'])->name('expenses.export');
    Route::get('/expenses/reports', [ExpenseController::class, 'reports'])->name('expenses.reports'); // Added this line
    
    // Resource Routes
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('class-rooms', ClassRoomController::class);
    Route::resource('attendances', AttendanceController::class);
    
    Route::resource('library', LibraryController::class);
    // Route::resource('calendar', CalendarController::class);
    Route::resource('reports', ReportsController::class);
    Route::resource('security', SecurityController::class);
    Route::resource('applications', ApplicationsController::class);
    Route::resource('fees', FeesController::class);
    Route::resource('messaging', MessagingController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('timetable', TimetableController::class);
    Route::resource('exams', ExamController::class);
    Route::resource('parents', ParentController::class);
    Route::resource('transport', TransportController::class);
    Route::resource('health', HealthController::class);
    
    // Fees routes
    Route::resource('fees', FeesController::class);
});  

require __DIR__.'/auth.php';