<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ClassRoomController;
// use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\MessagingController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\LibraryBookController;
use App\Http\Controllers\LibraryTransactionController;

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

    // Staff routes
    Route::prefix('staff')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/{staff}', [StaffController::class, 'show'])->name('staff.show');
        Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::put('/{staff}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');

        // Import/Export routes
      Route::get('/staff/import-export', [StaffController::class, 'importExport'])
     ->name('staff.import-export')
     ->middleware('auth');

Route::get('/staff/export', [StaffController::class, 'export'])
     ->name('staff.export')
     ->middleware('auth');

Route::post('/staff/import', [StaffController::class, 'import'])
     ->name('staff.import')
     ->middleware('auth');

Route::get('/staff/template', [StaffController::class, 'downloadTemplate'])
     ->name('staff.template')
     ->middleware('auth');
    });

    // Applications routes
    Route::resource('applications', ApplicationsController::class);
    Route::get('applications/import', [ApplicationsController::class, 'showImportForm'])->name('applications.import');
    Route::post('applications/import', [ApplicationsController::class, 'import'])->name('applications.import.process');
    Route::get('applications/template', [ApplicationsController::class, 'downloadTemplate'])->name('applications.template');
    Route::get('applications/export', [ApplicationsController::class, 'export'])->name('applications.export');
    Route::post('applications/{id}/status', [ApplicationsController::class, 'updateStatus'])->name('applications.status');
    Route::get('applications/stats', [ApplicationsController::class, 'getStats'])->name('applications.stats');

    // Calendar routes
    Route::resource('calendar', CalendarController::class);
    Route::get('/calendar/api/events', [CalendarController::class, 'api'])->name('calendar.api');

    // Simple module index routes
    Route::get('/academics', [AcademicController::class, 'index'])->name('academics.index');
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
    Route::get('/messaging', [MessagingController::class, 'index'])->name('messaging.index');
     Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable.index');
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/parents', [ParentController::class, 'index'])->name('parents.index');
    Route::get('/transport', [TransportController::class, 'index'])->name('transport.index');
    Route::get('/health', [HealthController::class, 'index'])->name('health.index');

    // Expenses routes
    Route::resource('expenses', ExpenseController::class);
    Route::get('/expenses/import', [ExpenseController::class, 'import'])->name('expenses.import');
    Route::get('/expenses/export', [ExpenseController::class, 'export'])->name('expenses.export');
    Route::get('/expenses/reports', [ExpenseController::class, 'reports'])->name('expenses.reports');

    // Fees routes
    Route::resource('fees', FeesController::class);

    // Library routes
Route::prefix('library')->name('library.')->group(function () {
    Route::get('/', [LibraryController::class, 'index'])->name('index');
    Route::get('/search', [LibraryController::class, 'search'])->name('search');
    
    // Books routes
    Route::prefix('books')->name('books.')->group(function () {
        Route::get('/', [LibraryBookController::class, 'index'])->name('index');
        Route::get('/create', [LibraryBookController::class, 'create'])->name('create');
        Route::post('/', [LibraryBookController::class, 'store'])->name('store');
        Route::get('/{book}', [LibraryBookController::class, 'show'])->name('show');
        Route::get('/{book}/edit', [LibraryBookController::class, 'edit'])->name('edit');
        Route::put('/{book}', [LibraryBookController::class, 'update'])->name('update');
        Route::delete('/{book}', [LibraryBookController::class, 'destroy'])->name('destroy');
        
        // Bulk import routes
        Route::get('/import', [LibraryBookController::class, 'import'])->name('import');
        Route::post('/import', [LibraryBookController::class, 'processImport'])->name('import.process');
        Route::get('/template', [LibraryBookController::class, 'downloadTemplate'])->name('template');
    });
    
    // Transactions routes
    Route::resource('transactions', LibraryTransactionController::class);
    Route::post('transactions/{id}/return', [LibraryTransactionController::class, 'returnBook'])
        ->name('transactions.return');
});

    // Other resource routes (only if you have the full CRUD implemented)
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('class-rooms', ClassRoomController::class);
}); // <-- This closes the auth middleware group

require __DIR__.'/auth.php';
