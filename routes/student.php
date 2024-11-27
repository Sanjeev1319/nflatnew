<?php

use App\Http\Controllers\QuizController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\StudentLoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:student')->name('student.')->group(function () {
	Route::get('take-a-test', [StudentLoginController::class, 'create'])
		->name('login');

	Route::post('take-a-test', [StudentLoginController::class, 'store']);

	// Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
	//     ->name('password.request');

	// Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
	//     ->name('password.email');

	// Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
	//     ->name('password.reset');

	// Route::post('reset-password', [NewPasswordController::class, 'store'])
	//     ->name('password.store');
});

Route::middleware('auth:student')->prefix('take-a-test')->name('student.')->group(function () {

	Route::get('logout', [StudentLoginController::class, 'destroy'])->name('logout');

	Route::get('instructions', [StudentController::class, 'studentInstruction'])->name('instructions');

	Route::post('start', [StudentController::class, 'startExamStore'])->name('startExam');

	Route::get('start', [StudentController::class, 'startExam'])->name('startExam');

	Route::post('quizSubmit', [QuizController::class, 'quizSubmit'])->name('quiz.submit');


	// Apply the QuizTimerMiddleware only to the startExam routes
	// Route::middleware(\App\Http\Middleware\QuizTimerMiddleware::class)->group(function () {
	// 	Route::get('start', [StudentController::class, 'startExam'])->name('startExam');
	// });
});
