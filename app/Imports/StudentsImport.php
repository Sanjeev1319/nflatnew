<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
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
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // Account for the heading row

            // Validate each field
            // $validator = \Validator::make($row->toArray(), [
            //   // 'uuid' => 'required|string|unique:students,uuid|max:255', // Ensure UUID is unique and not empty
						// 	'name' => 'required|string|max:255', // Name is required and should not exceed 255 characters
						// 	'class' => 'required|integer', // Class is required and limited to 10 characters (adjust as needed)
						// 	'section' => 'required|string|max:10', // Section is required and limited to 10 characters
						// 	'dob' => 'required|date|before:today', // Date of birth must be a valid date before today
						// 	'gender' => ['required', Rule::in(['male', 'female', 'other'])], // Gender is required and must be one of the specified values
						// 	'parent_name' => 'required|string|max:255', // Parent's name is required and should not exceed 255 characters
						// 	'parent_email' => 'nullable|email|max:255', // Parent's email is optional but must be valid
						// 	'parent_mobile' => 'nullable|digits:10', // Parent's mobile number is optional but must be 10 digits
						// 	// 'password' => 'required|string|min:8|max:255', // Password is required, with a minimum length of 8 characters
            // ]);

						// Validate each field
            $validator = \Validator::make($row->toArray(), [
                'name' => 'required|string|max:255', // Name is required and should not exceed 255 characters

                'section' => 'required|string|max:10', // Section is required and limited to 10 characters
                'dob' => 'required|date|before:today', // Date of birth must be a valid date before today
                'gender' => ['required', Rule::in(['male', 'female', 'other'])], // Gender is required and must be one of the specified values
                'parent_name' => 'required|string|max:255', // Parent's name is required and should not exceed 255 characters
                'parent_email' => 'nullable|email|max:255', // Parent's email is optional but must be valid
                'parent_mobile' => 'nullable|digits:10', // Parent's mobile number is optional but must be 10 digits
								'class' => 'required', // Class is required and should be an integer
            ]);

            if ($validator->fails()) {
                // $this->errors[] = "Row {$rowNumber}: " . implode(', ', $validator->errors()->all());
								$this->errors[] = [
                    'row' => $rowNumber,
                    'errors' => $validator->errors()->all(),
                    'data' => $row,
                ];
            } else {
                // Insert valid data into the database
                Student::create([
										'password' => str::random(8),
        						'uuid' => strtoupper(Str::random(10)),
                    'student_name'=> $row['name'],
										'student_class'=> $row['class'],
										'student_section'=> $row['section'],
										'date_of_birth'=> $row['dob'],
										'gender'=> $row['gender'],
										'parent_name'=> $row['parent_name'],
										'parent_email_id'=> $row['parent_email'],
										'parent_mobile_number'=> $row['parent_mobile'],
                ]);
            }
        }
    }
}
