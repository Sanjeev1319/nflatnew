<?php

use App\Http\Controllers\OTPController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('school.register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// otp verification routes
Route::post('/send-email-otp', [OTPController::class, 'sendEmailOtp']);
Route::post('/verify-email-otp', [OTPController::class, 'verifyEmailOtp']);
Route::post('/send-mobile-otp', [OTPController::class, 'sendMobileOtp']);
Route::post('/verify-mobile-otp', [OTPController::class, 'verifyMobileOtp']);


require __DIR__.'/auth.php';
require __DIR__.'/school.php';