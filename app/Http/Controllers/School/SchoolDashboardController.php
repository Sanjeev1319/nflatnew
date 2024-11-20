<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

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
}
