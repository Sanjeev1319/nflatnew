<?php

namespace App\Http\Controllers\Student;

use App\Http\Resources\StudentResource;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentListResource;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;  // Make sure you import the Excel facade correctly
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display the login view.
     */
    public function studentInstruction(Student $student)
    {
			$allowAttempt = true;

			$student_details = $student::where("student_uuid", Auth::guard('student')->user()->student_uuid)->first();

			// general Settings
			$general_settings = DB::table('general_settings')->get();
			$maxAttempts = $general_settings->where('setting', 'max_attmpts')->pluck('value')->first();

			// quiz logs
			$quiz_logs = DB::table('quiz_logs')->where('student_uuid',Auth::guard('student')->user()->student_uuid)->first();

			if($student_details->allowed_attempts !== null) {
				$maxAttempts = $student_details->allowed_attempts;
			}

			if($quiz_logs !== null) {
				if($quiz_logs->attempt >= $maxAttempts) {
					$allowAttempt = false;
				}
			}

			// dd($students);
			return Inertia::render('Student/Instructions', [
				'success' => session('success'),
				'studentData' => new StudentResource($student_details),
				'route' => session('route'),
				'allowAttempt' => $allowAttempt,
			]);
    }


		/**
     * prepare for the test make necessary arrangements.
     */
		public function startExamStore(Request $request, Student $student) {
			$validate = $request->validate([
				'terms' => 'accepted',
			], [
        'terms.accepted' => 'You must accept the terms and conditions before starting the exam.',
    	]);

			// get the general settings
			$general_settings = DB::table('general_settings')->get();

			// set the basic details
			$student_uuid = Auth::guard('student')->user()->student_uuid;
			$examStartTime = Carbon::now();

			// quiz logs
			$quiz_log = DB::table('quiz_logs')->where('student_uuid', $student_uuid)->first();

			if ($quiz_log) {
        // If record exists, increment the attempt value
        DB::table('quiz_logs')
            ->where('student_uuid', $student_uuid)
            ->update([
                'attempt' => $quiz_log->attempt + 1,
                'exam_start' => $examStartTime, // Optional: Update exam start time
            ]);
    } else {
        // If no record exists, create a new one with attempt = 1
        DB::table('quiz_logs')->insert([
            'student_uuid' => $student_uuid,
            'exam_start' => $examStartTime,
            'attempt' => 1,
        ]);
    }


			// Set the session or pass the start time
    	session(['exam_start' => $examStartTime]);

			return redirect()->route('student.startExam', [
				'student_uuid'=> $student_uuid,
				// 'exam_start' => session($examStartTime)
			]);
		}


		/**
     * Start the exam.
     */
		public function startExam(Request $request, Student $student) {

			$examTime = DB::table('general_setting');
			dd(session('exam_start'));
		}

}
