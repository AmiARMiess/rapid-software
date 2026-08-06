<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Employee;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Admin ONLY route
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'showDashboard'])->name('dashboard');

    Route::get('/employees', [Admin\EmployeeController::class, 'showEmployee'])->name('employees');
    Route::get('/employees/create', [Admin\EmployeeController::class, 'showCreateEmployee'])->name('create.employee');
    Route::get('/employees/datatable', [Admin\EmployeeController::class, 'employeeDatatable'])->name('datatable.employee');

    // Route::get('/employees/calculate-socso', [Admin\EmployeeController::class, 'calculationSocso'])->name('calculate.socso');
    Route::get('/employees/payslip', [Admin\EmployeeController::class, 'showPayslip'])->name('payslip.employee');

    Route::get('/departments', [Admin\DepartmentController::class, 'showDepartment'])->name('departments');
    Route::get('/departments/create', [Admin\DepartmentController::class, 'showCreateDepartment'])->name('show_create.department');
    Route::post('/departments/create-department', [Admin\DepartmentController::class, 'createDepartment'])->name('create.department');
    Route::get('/departments/view/{department_id}', [Admin\DepartmentController::class, 'showViewDepartment'])->name('view.department');
    Route::get('/departments/print/{department_id}', [Admin\DepartmentController::class, 'printDepartment'])->name('print.department');
    Route::get('/departments/edit/{department_id}', [Admin\DepartmentController::class, 'showEditDepartment'])->name('edit.department');
    Route::post('/departments/edit/', [Admin\DepartmentController::class, 'updateDepartment'])->name('update.department');
    Route::delete('/departments/delete/{department_id}', [Admin\DepartmentController::class, 'deleteDepartment'])->name('delete.department');
    Route::get('/departments/datatable', [Admin\DepartmentController::class, 'departmentDatatable'])->name('datatable.department');

    Route::get('/positions', [Admin\PositionController::class, 'showPosition'])->name('positions');
    Route::get('/positions/create', [Admin\PositionController::class, 'showCreatePosition'])->name('show_create.position');
    Route::post('/positions/create-position', [Admin\PositionController::class, 'createPosition'])->name('create.position');
    Route::get('/positions/view/{position_id}', [Admin\PositionController::class, 'showViewPosition'])->name('view.position');
    Route::get('/positions/edit/{position_id}', [Admin\PositionController::class, 'showEditPosition'])->name('edit.position');
    Route::post('/positions/edit', [Admin\PositionController::class, 'updatePosition'])->name('update.position');
    Route::delete('/positions/delete/{position_id}', [Admin\PositionController::class, 'deletePosition'])->name('delete.position');
    Route::get('/positions/datatable', [Admin\PositionController::class, 'positionDatatable'])->name('datatable.position');

    Route::get('/leave', [Admin\LeaveController::class, 'showLeave'])->name('leave');
    Route::get('/leave/create', [Admin\LeaveController::class, 'showCreateLeave'])->name('create.leave');

    Route::get('/claims', [Admin\ClaimController::class, 'showClaim'])->name('claims');
    Route::get('/claims/create', [Admin\ClaimController::class, 'showCreateClaim'])->name('create.claim');

    Route::get('/attendance', [Admin\AttendanceController::class, 'showAttendance'])->name('attendance');
    Route::get('/attendance/create', [Admin\AttendanceController::class, 'showCreateAttendance'])->name('create.attendance');
});

// Employee ONLY route
Route::middleware(['auth', 'verified', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {

    Route::get('/dashboard', [Employee\DashboardController::class, 'showDashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
