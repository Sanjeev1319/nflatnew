<?php

use App\Http\Controllers\School\SchoolDashboardController;
use App\Http\Controllers\School\SchoolLoginController;
use App\Http\Controllers\School\SchoolRegisterController;
use App\Http\Middleware\AuthSchoolMiddleware;
use App\Http\Middleware\GuestSchoolMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(GuestSchoolMiddleware::class)->prefix('school')->name('school.')->group(function () {
	Route::get('register', [SchoolRegisterController::class, 'create'])
		->name('register');

	Route::post('register', [SchoolRegisterController::class, 'store']);

	Route::get('login', [SchoolLoginController::class, 'create'])
		->name('login');

	Route::post('login', [SchoolLoginController::class, 'store']);
});

Route::middleware(AuthSchoolMiddleware::class)->prefix('school')->name('school.')->group(function () {

	Route::post('logout', [SchoolLoginController::class, 'destroy'])->name('logout');

	Route::get('dashboard', [SchoolDashboardController::class, 'index'])->name('dashboard');

	Route::get('student_register', [SchoolDashboardController::class, 'studentRegister'])->name('studentRegister');
	Route::post('student_register', [SchoolDashboardController::class, 'studentRegisterStore']);

	Route::get('student_bulk_register', [SchoolDashboardController::class, 'studentBulkRegister'])->name('studentBulkRegister');

	Route::get('student_list', [SchoolDashboardController::class, 'studentList'])->name('studentList');
});
