<?php

namespace App\Imports;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public $errors = [];

    /**
     * Process each row in the collection.
     */
    public function collection(Collection $rows)
    {
			$school_uuid = auth('school')->user()->school_uuid;
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // Account for the heading row

						// Assuming $row['dob'] is the number from Excel, e.g., 40313
						if (is_numeric($row['dob'])) {
								try {
										// Convert Excel serial date number to a Carbon instance
										$dob = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['dob'] - 2); // Subtract 2 due to Excel's date offset
										$formattedDob = $dob->format('d-m-Y'); // Format to DD-MM-YYYY
										$row['dob'] = $formattedDob; // Update the row with the formatted date
								} catch (\Exception $e) {
										// Handle the error if the date conversion fails
										$this->errors[] = [
												'row' => $rowNumber,
												'errors' => ['Invalid Excel date format'],
												'data' => $row,
										];
										continue; // Skip this row if the date conversion fails
								}
						}

						// Validate each field
            $validator = Validator::make($row->toArray(), [
                'name' => 'required|string|max:255', // Name is required and should not exceed 255 characters
                'section' => 'required|string|max:10', // Section is required and limited to 10 characters
                'dob' => 'required|date|before:today', // Date of birth must be a valid date before today
                'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])], // Gender is required and must be one of the specified values
                'parent_name' => 'required|string|max:255', // Parent's name is required and should not exceed 255 characters
                'parent_email' => 'nullable|email|max:255', // Parent's email is optional but must be valid
                'parent_mobile' => 'nullable|digits:10', // Parent's mobile number is optional but must be 10 digits
								'class' => 'required', // Class is required and should be an integer
            ]);

            if ($validator->fails()) {
                // Add validation errors
                $this->errors[] = [
                    'row' => $rowNumber,
                    'errors' => $validator->errors()->all(),
                    'data' => $row,
                ];
            } else {
                // Check for duplicate entry
                $duplicate = Student::where('school_uuid', $school_uuid)
										->where('student_name', $row['name'])
                    ->where('student_class', $row['class'])
                    ->where('student_section', $row['section'])
                    ->where('date_of_birth', Carbon::createFromFormat('d-m-Y', $row['dob'])->format('Y-m-d'))
                    ->where('gender', $row['gender'])
                    ->where('parent_name', $row['parent_name'])
                    ->exists();

                if ($duplicate) {
                    $this->errors[] = [
                        'row' => $rowNumber-1,
                        'errors' => ['Duplicate entry found for student: ' . $row['name']],
                        'data' => $row,
                    ];
                } else {

									// Fetch the last student with UUID
									$lastStudent = Student::latest('student_uuid')->first(); // Assuming 'uuid' is the column storing the UUIDs

									// Extract the numeric part from the last UUID (e.g., 'UUID-10001')
									$lastNumber = $lastStudent ? (int) substr($lastStudent->student_uuid,0) : 10000;  // Default to 10000 if no student exists

									// Increment the number
									$newNumber = $lastNumber + 1;

									// Generate the new UUID (e.g., UUID-10001, UUID-10002, ...)
									$newUuid = $newNumber;

									$password = strtoupper(Str::random(8));

                    // Insert valid data into the database
                    Student::create([
                        'password' => $password,
												'student_uuid' => $newUuid,
												'school_uuid' => $school_uuid,
                        'student_name' => $row['name'],
                        'student_class' => $row['class'],
                        'student_section' => $row['section'],
                        'date_of_birth' => Carbon::createFromFormat('d-m-Y', $row['dob'])->format('Y-m-d'),
                        'gender' => $row['gender'],
                        'parent_name' => $row['parent_name'],
                        'parent_email_id' => $row['parent_email'],
                        'parent_mobile_number' => $row['parent_mobile'],
                    ]);
                }
            }
        }
    }
}
