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


// otp verification routes
Route::post('/send-email-otp', [OTPController::class, 'sendEmailOtp'])->name('sendEmailOtp');
Route::post('/verify-email-otp', [OTPController::class, 'verifyEmailOtp'])->name('verifyEmailOtp');
Route::post('/send-mobile-otp', [OTPController::class, 'sendMobileOtp'])->name('sendMobileOtp');
Route::post('/verify-mobile-otp', [OTPController::class, 'verifyMobileOtp'])->name('verifyMobileOtp');



// API LIST
// 1. Student bulk upload api
// Route::post('/students/import', [SchoolDashboardController::class, 'import'])->name('studentUploadApi');
Route::post('/upload-students', [SchoolDashboardController::class, 'import'])->name('upload-students');
Route::post('/pincode', [PincodeController::class, 'getPincodeDetails'])->name("getPincodeDetails");


// require __DIR__.'/auth.php';
require __DIR__.'/school.php';
require __DIR__.'/student.php';
