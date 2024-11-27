<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pincode;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PincodeController extends Controller
{
    /**
     * Fetch details based on the pincode.
     *
     * @param string $pincode
     */
    public function getPincodeDetails(Request $request)
    {

			$pincode = $request->pincode;
      $data = Pincode::where('pincode', $pincode)->get();

			// Group the data by 'pincode', 'district', and 'state'
			$grouped = collect($data)->groupBy(function ($item) {
					return 'values';
			})->map(function ($group) {
					return [
							'pincode' => $group->first()['pincode'],
							'district' => $group->first()['district'],
							'state' => $group->first()['state'],
							'areas' => $group->pluck('area')->unique()->toArray() // Merge areas
					];
			});

			// dd($grouped->values());


			if ($grouped->isNotEmpty()) {
				// Return the data back to the registration page
				return Inertia::render('Auth/SchoolRegister', [
					'pincodeDetails' => $grouped->values()->toArray(), // Send the grouped pincode data to the page
				]);
			}

        return response()->json(['success' => false, 'message' => 'Pincode not found'], 404);
    }
}
