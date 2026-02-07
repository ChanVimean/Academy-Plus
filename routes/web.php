<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // 1. Profile Management (Default Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Student Management
    // CRUD: index, create, store, edit, update, destroy
    Route::resource('students', StudentController::class);

    // 3. Subject (Class) Management
    Route::resource('subjects', SubjectController::class);

    // 4. Attendance Logic
    // Custom route to open the sheet for a specific class
    Route::get('/attendance/take/{subject}', [AttendanceController::class, 'create'])
        ->name('attendance.take');

    // Resource for viewing history (index) and saving records (store)
    Route::resource('attendance', AttendanceController::class)->only(['index', 'store']);
});

require __DIR__.'/auth.php';
