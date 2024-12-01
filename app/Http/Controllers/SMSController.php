<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SMSController extends Controller
{
	public $otp;
	public $mobile;
	/**
	 * Create a new message instance.
	 */
	public function __construct($otp, $mobile)
	{
		$this->otp = $otp;
		$this->mobile = $mobile;
	}

	public function sendSMS()
	{
		// Account details
		$apiKey = urlencode('NTU1MDM0NmQ1NTU5NTM2Mjc5NTI1OTM0NTA2ZTQ2NGE=');

		// Message details
		// $numbers = array(918123456789, 918987654321);
		$sender = urlencode('NCFEWM');
		$message = rawurlencode('Your verification code is ' . $this->otp . ' Team NFLAT');

		// $numbers = implode(',', $numbers);
		$numbers = '91' . $this->mobile;

		// Prepare data for POST request
		$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);

		// dd($response);
	}
}
