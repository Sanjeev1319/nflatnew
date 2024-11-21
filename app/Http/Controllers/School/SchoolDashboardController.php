<?php

namespace App\Http\Controllers\School;

use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;  // Make sure you import the Excel facade correctly

class SchoolDashboardController extends Controller
{
    /**
     * Display the login view.
     */
    public function index()
    {
        return Inertia::render('School/Dashboard', [
            'status' => session('status'),
        ]);
    }


		/**
     * Display the individual student registration form.
     */
    public function studentRegister()
    {
        return Inertia::render('School/StudentRegister', [
            'status' => session('status'),
        ]);
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

				$import = new StudentsImport();
				Excel::import($import, $request->file('file'));

				if (!empty($import->errors)) {
						// Return errors as a response to the frontend
						return back()->with([
								'import_errors' => $import->errors,
						]);
				}

				return back()->with([
						'success_message' => 'File imported successfully!',
				]);
		}

}
