<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Mail\SchoolRegistrationMail;
use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class SchoolRegister extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/SchoolRegister');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        dd($request->all());
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_email' => 'required|email|unique:schools,school_email|max:255',
            'school_mobile' => 'required|string|regex:/^([0-9]{10})$/|unique:schools,school_mobile', // 10 digit mobile number
            'incharge_name' => 'required|string|max:255',
            'incharge_email' => 'nullable|email|max:255',
            'incharge_mobile' => 'nullable|string|regex:/^([0-9]{10})$/', // 10 digit mobile number
            'principal_name' => 'required|string|max:255',
            'principal_email' => 'nullable|email|max:255',
            'principal_mobile' => 'nullable|string|regex:/^([0-9]{10})$/', // 10 digit mobile number
            'school_address_line_1' => 'required|string|max:255',
            'school_area' => 'nullable|string|max:255',
            'school_pincode' => 'required|string|regex:/^\d{6}$/', // Assuming 6-digit pincode
            'school_district' => 'required|string|max:255',
            'school_state' => 'required|string|max:255',
        ]);

        // Generate a random 8-character alphanumeric password
        $randomPassword = str::random(8);


        // Create a new user record in the database
        $school = School::create([
            'school_name' => $request->school_name,
            'school_email' => $request->school_email,
            'school_mobile' => $request->school_mobile,
            'incharge_name' => $request->incharge_name,
            'incharge_email' => $request->incharge_email,
            'incharge_mobile' => $request->incharge_mobile,
            'principal_name' => $request->principal_name,
            'principal_email' => $request->principal_email,
            'principal_mobile' => $request->principal_mobile,
            'school_address_line_1' => $request->school_address_line_1,
            'school_area' => $request->school_area,
            'school_pincode' => $request->school_pincode,
            'school_district' => $request->school_district,
            'school_state' => $request->school_state,
            'password' => Hash::make($randomPassword),  // Save the hashed password in the database
        ]);

        // Send confirmation email to the school email
        Mail::to($school->school_email)->send(new SchoolRegistrationMail($randomPassword));

        return response()->json(['message' => 'School created successfully! A confirmation email has been sent.', 'data' => $school]);

        // event(new Registered($user));

        // Auth::login($user);

        // return redirect(route('dashboard', absolute: false));
    }
}
