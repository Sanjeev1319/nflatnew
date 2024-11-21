<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
          $table->id();
					$table->string('uuid')->unique();
					$table->string('student_name'); // Student's name
					$table->string('student_class'); // Class
					$table->string('student_section'); // Section
					$table->date('date_of_birth'); // Date of birth
					$table->enum('gender', ['male', 'female', 'other']); // Gender
					$table->string('parent_name'); // Parent's name
					$table->string('parent_email_id')->nullable(); // Parent's email ID
					$table->string('parent_mobile_number')->nullable(); // Parent's mobile number
					$table->string('password'); // Password for student login
					$table->integer('attempts')->nullable(); // attempted to start the exam
					$table->integer('allowed_attempts')->nullable(); // if null will check from general settings else check from here
					$table->datetime('last_login')->nullable(); // Date of birth
					$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
