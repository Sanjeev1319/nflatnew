<?php

use App\Http\Controllers\OTPController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\School\SchoolDashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('school.register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
				'success' => session('success')
    ]);
})->name('home');

// Route::get('school/dashboard', function () {
//     return Inertia::render('School/Dashboard');
// })->middleware(['auth:school'])->name('school.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// otp verification routes
Route::post('/send-email-otp', [OTPController::class, 'sendEmailOtp'])->name('sendEmailOtp');
Route::post('/verify-email-otp', [OTPController::class, 'verifyEmailOtp'])->name('verifyEmailOtp');
Route::post('/send-mobile-otp', [OTPController::class, 'sendMobileOtp'])->name('sendMobileOtp');
Route::post('/verify-mobile-otp', [OTPController::class, 'verifyMobileOtp'])->name('verifyMobileOtp');
Route::post('/fetch-pincode-details', [PincodeController::class, 'fetchDetailsByPincode']);



// API LIST
// 1. Student bulk upload api
// Route::post('/students/import', [SchoolDashboardController::class, 'import'])->name('studentUploadApi');
Route::post('/upload-students', [SchoolDashboardController::class, 'import'])->name('upload-students');

require __DIR__.'/auth.php';
require __DIR__.'/school.php';
