<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class QuizController extends Controller
{
	public function quizSubmit(Request $request)
	{

		$student_uuid = $request->student_uuid;
		$answers = json_encode($request->answers);
		$exam_endtime = Carbon::now();

		DB::table("quiz_logs")
			->where("student_uuid", $student_uuid)
			->update(['answers'=> $answers,'exam_end'=> $exam_endtime]);

		Session::forget("exam_start_time");
		Session::forget("student_uuid");
		Session::forget("exam_time");
		Session::forget("quiz_start");

		return redirect()->route("student.index");
	}

}
