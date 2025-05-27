<?php

use App\Http\Controllers\ProfileController;
use App\Models\Extra;
use App\Models\ExtraRegistration;
use App\Http\Controllers\ExtraController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExtraRegistrationController;
use App\Http\Controllers\AttendanceReportController;

Route::get('/', function () {
    return view('welkam');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('extras', ExtraController::class);
    Route::resource('registrations', ExtraRegistrationController::class)
         ->only(['index','store','destroy']);
    Route::resource('extras.attendances', AttendanceReportController::class)
         ->parameters(['attendances' => 'attendance'])
         ->shallow(); 
    Route::get('attendances/{attendance}/pdf', 
        [AttendanceReportController::class, 'pdf'])
        ->name('attendances.pdf');
});

require __DIR__.'/auth.php';
