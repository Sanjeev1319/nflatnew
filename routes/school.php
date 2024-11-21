<?php

use App\Http\Controllers\School\SchoolDashboardController;
use App\Http\Controllers\School\SchoolLoginController;
use App\Http\Controllers\School\SchoolRegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->prefix('school')->name('school.')->group(function () {
    Route::get('register', [SchoolRegisterController::class, 'create'])
        ->name('register');

    Route::post('register', [SchoolRegisterController::class, 'store']);

    Route::get('login', [SchoolLoginController::class, 'create'])
        ->name('login');

    Route::post('login', [SchoolLoginController::class, 'store']);

    // Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    //     ->name('password.request');

    // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    //     ->name('password.email');

    // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    //     ->name('password.reset');

    // Route::post('reset-password', [NewPasswordController::class, 'store'])
    //     ->name('password.store');
});

Route::middleware('auth:school')->prefix('school')->name('school.')->group(function () {

	Route::post('logout', [SchoolLoginController::class, 'destroy'])->name('logout');

	Route::get('dashboard', [SchoolDashboardController::class, 'index'])->name('dashboard');

	Route::get('student_register', [SchoolDashboardController::class, 'studentRegister'])->name('studentRegister');

	Route::get('student_bulk_register', [SchoolDashboardController::class, 'studentBulkRegister'])->name('studentBulkRegister');

    // Route::get('verify-email', EmailVerificationPromptController::class)
    //     ->name('verification.notice');

    // Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    //     ->middleware(['signed', 'throttle:6,1'])
    //     ->name('verification.verify');

    // Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //     ->middleware('throttle:6,1')
    //     ->name('verification.send');

    // Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    //     ->name('password.confirm');

    // Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Route::put('password', [PasswordController::class, 'update'])->name('password.update');

	// API List
	// Route::post('/api/students/import', [SchoolDashboardController::class, 'import'])->name('studentUploadApi');

});

