<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkShiftController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('work-shifts', WorkShiftController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('users', UserController::class);
    Route::get('/face-scan', [AttendanceController::class, 'faceScan'])
    ->name('face-scan');

    Route::post('/face-scan/check-in', [AttendanceController::class, 'checkIn'])
        ->name('face-scan.check-in');

    Route::post('/face-scan/check-out', [AttendanceController::class, 'checkOut'])
        ->name('face-scan.check-out');

    Route::get('/attendance-reports', [AttendanceController::class, 'report'])
    ->name('attendance-reports.index');

    Route::get('/attendance-reports/export', [AttendanceController::class, 'exportReport'])
    ->name('attendance-reports.export');

    Route::get('/employees/{employee}/face-register', [EmployeeController::class, 'faceRegister'])
    ->name('employees.face-register');

    Route::post('/employees/{employee}/face-register', [EmployeeController::class, 'saveFaceDescriptor'])
        ->name('employees.face-register.save');
    
    Route::get('/face-recognition/descriptors', [AttendanceController::class, 'descriptors'])
    ->name('face-recognition.descriptors');

    Route::post('/face-recognition/check', [AttendanceController::class, 'faceRecognitionCheck'])
    ->name('face-recognition.check');

    Route::get('/dashboard/realtime-data', [DashboardController::class, 'realtimeData'])
    ->name('dashboard.realtime-data');

    Route::get('/attendance-reports/export-pdf', [AttendanceController::class, 'exportPdf'])
    ->name('attendance-reports.export-pdf');
});
require __DIR__.'/auth.php';
