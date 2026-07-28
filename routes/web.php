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
    Route::post('/employees/calculate-socso', [Admin\EmployeeController::class, 'calculationSocso'])->name('calculate.socso');
    Route::post('/employees/payslip', [Admin\EmployeeController::class, 'showPayslip'])->name('payslip.employee');
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

require __DIR__ . '/auth.php';
