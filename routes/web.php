<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('teachers', TeacherController::class);
    Route::resource('students', StudentController::class);
});

Route::middleware('auth')->group(function () {
    // 1. Profile Management (Default Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Student & Subject
    Route::resource('subjects', SubjectController::class);

    // 3. Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/take/{subject}', [AttendanceController::class, 'create'])->name('attendance.take');
    Route::post('/attendance/store/{subject}', [AttendanceController::class, 'store'])->name('attendance.store');
});

require __DIR__.'/auth.php';
