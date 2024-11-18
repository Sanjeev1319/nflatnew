<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;



class OTPController extends Controller
{
    public function sendEmailOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $otp = rand(100000, 999999);
        $request->session()->put('email_otp', $otp);
        $request->session()->put('email', $request->email);

        // Send OTP via email
        Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Email OTP Verification');
        });

        return response()->json(['message' => 'OTP sent to email successfully.']);
    }

    public function verifyEmailOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $sessionOtp = $request->session()->get('email_otp');
        $sessionEmail = $request->session()->get('email');

        if ($request->otp == $sessionOtp) {
            $request->session()->forget('email_otp');
            return response()->json(['message' => 'Email verified successfully.']);
        }

        return response()->json(['message' => 'Invalid OTP.'], 422);
    }

    public function sendMobileOtp(Request $request)
    {
        $request->validate(['mobile' => 'required|digits:10']);

        $otp = rand(100000, 999999);
        $request->session()->put('mobile_otp', $otp);
        $request->session()->put('mobile', $request->mobile);
        Log::info('Email OTP for ' . $request->email . ': ' . $otp);

        // Use an SMS service here
        // For example: Twilio, Nexmo, etc.
        // For demonstration, we're just returning the OTP
        return response()->json(['message' => 'OTP sent to mobile successfully.', 'otp' => $otp]);
    }

    public function verifyMobileOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $sessionOtp = $request->session()->get('mobile_otp');

        if ($request->otp == $sessionOtp) {
            $request->session()->forget('mobile_otp');
            return response()->json(['message' => 'Mobile verified successfully.']);
        }

        return response()->json(['message' => 'Invalid OTP.'], 422);
    }
}
