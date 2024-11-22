<?php

namespace App\Http\Controllers\Student;

use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentListResource;
use App\Models\Student;
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
    public function studentInstruction()
    {
        return Inertia::render('Student/Instructions', [
            'success' => session('success'),
						'route' => session('route'),
        ]);
    }


		/**
     * Display the individual student registration form.
     */
    public function studentRegister()
    {

			// Fetch data from the NFLATCategory table without a model
    	$categories = DB::table('nflatcategories')->get(); // You can use ->get(), ->pluck(), etc., as per your needs

			return Inertia::render('School/StudentRegister', [
					'nflatCategories' => $categories,
					'success' => session('success'),
			]);
    }

		/**
     * Display the submit the form.
     */
    public function studentRegisterStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:10',
            'dob' => 'required|date|before:today',
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'parent_name' => 'required|string|max:255',
            'parent_email' => 'nullable|email|max:255',
            'parent_mobile' => 'nullable|digits:10',
            'class' => 'required|integer',
        ]);

				// Check for duplicates based on name, section, dob, gender, and parent_name
				$duplicate = Student::where('student_name', $request->name)
						->where('student_section', $request->section)
						->where('student_class', $request->class)
						->where('date_of_birth', $request->dob)
						->where('gender', $request->gender)
						->where('parent_name', $request->parent_name)
						->exists();  // Use exists() to check if any record matches the given criteria

				// If a duplicate is found, return an error
				if ($duplicate) {
						return back()->withInput()->withErrors([
								'name' => 'A student with the same details already exists.',
						]);
				}

					// Fetch the last student with UUID
   				$lastStudent = Student::latest('student_uuid')->first(); // Assuming 'uuid' is the column storing the UUIDs

					// Extract the numeric part from the last UUID (e.g., 'UUID-10001')
    			$lastNumber = $lastStudent ? (int) substr($lastStudent->student_uuid,0) : 10001;  // Default to 10000 if no student exists

					// Increment the number
					$newNumber = $lastNumber + 1;

					// Generate the new UUID (e.g., UUID-10001, UUID-10002, ...)
					$newUuid = $newNumber;

					$password = base64_encode(strtoupper(Str::random(8)));
					// dd($password);

		$school_uuid = auth('school')->user()->school_uuid;

					Student::create([
						'student_uuid' => $newUuid,
						'school_uuid' => $school_uuid,
						'student_name' => $request->name,
						'student_class' => $request->class,
						'student_section' => $request->section,
						'date_of_birth' => $request->dob,
						'gender' => $request->gender,
						'parent_name' => $request->parent_name,
						'parent_email_id' => $request->parent_email,
						'parent_mobile_number' => $request->parent_mobile,
						'pass' => $password,
          ]);

					return redirect()->route('school.dashboard')->with('success','Student registered successfully.');

    }


		/**
     * Display the bulk student registration form.
     */
    public function studentBulkRegister()
    {
        return Inertia::render('School/StudentBulkRegister', [
            'status' => session('status'),
						'import_errors' => session('import_errors', []), // Pass errors if available
        		'success_message' => session('success_message'), // Pass success message if available
        ]);
    }


		/*
		 * Import Method for excel bulk registration of students
		 */
		public function import(Request $request)
		{
				$request->validate([
						'file' => 'required|mimes:xlsx,csv|max:2048',
				]);

				// dd($request);
				// Ensure a file is uploaded
				$file = $request->file('file');
				if (!$file) {
						return back()->withErrors(['file' => 'No file uploaded']);
				}

				$import = new StudentsImport();
				Excel::import($import, $request->file('file'));

				if (!empty($import->errors)) {
						// Return errors as a response to the frontend
						return back()->with([
								'import_errors' => $import->errors,
						]);
				}

				return redirect()->route('school.dashboard')->with([
						'success' => 'Students registered successfully!',
						'route' => route('school.studentList')
				]);
		}



		/**
     * Display the student lists.
     */
    public function studentList()
    {
			$students = Student::query()->paginate(20);
			$studentCount = Student::query()->count();

			// Store the previous URL in the session
      // session(['previousUrl' => url()->previous()]);

			return Inertia::render('School/StudentList', [
				'success' => session('success'),
				'students'=> StudentListResource::collection($students),
				'studentCount' => $studentCount,
			]);
    }

}
