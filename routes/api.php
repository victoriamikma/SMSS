<?php use App\Http\Controllers\StaffController;

Route::prefix('staff')->group(function () {
    Route::get('/', [StaffController::class, 'index']);
    Route::post('/', [StaffController::class, 'storeStaff']);
    Route::put('/{staff}', [StaffController::class, 'updateStaff']);
    Route::delete('/{staff}', [StaffController::class, 'destroy']);
    Route::post('/payroll', [StaffController::class, 'processPayroll']);
    Route::get('/payroll', [StaffController::class, 'getPayroll']);
    Route::get('/stats', [StaffController::class, 'getStats']);
});