<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
	public function quizSubmit(Request $request)
	{
		dd($request);

		Session::forget("exam_start_time");
		Session::forget("student_uuid");
		Session::forget("exam_time");
		Session::forget("quiz_start");
	}
}
