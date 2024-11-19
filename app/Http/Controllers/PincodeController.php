<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pincode;
use Illuminate\Http\Request;

class PincodeController extends Controller
{
    /**
     * Fetch district, state, and area based on the pincode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchDetailsByPincode(Request $request)
    {
        // Validate the pincode input
        $validated = $request->validate([
            'pincode' => 'required|digits:6|exists:pincodes,pincode',
        ]);

        // Retrieve data from the Pincode table
        $pincodeData = Pincode::where('pincode', $request->input('pincode'))->first();

        if ($pincodeData) {
            // Fetch matching areas for the pincode
            $areas = Pincode::where('pincode', $request->input('pincode'))->distinct()->pluck('area');

            return response()->json([
                'district' => $pincodeData->district,
                'statename' => $pincodeData->statename,
                'areas' => $areas,
            ]);
        } else {
            return response()->json(['message' => 'Pincode not found.'], 404);
        }
    }
}
