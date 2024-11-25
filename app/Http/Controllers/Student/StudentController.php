<?php

namespace App\Http\Controllers\Student;

use App\Http\Resources\StudentResource;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentListResource;
use App\Models\Student;
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
			$student_details = $student::where("student_uuid", Auth::guard('student')->user()->student_uuid)->first();
			// dd($students);
			return Inertia::render('Student/Instructions', [
				'success' => session('success'),
				'studentData' => new StudentResource($student_details),
				'route' => session('route'),
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

			dd($validate);
		}

}
