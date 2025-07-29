<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // render the Blade that hosts your React/Radix admin dashboard
        return view('admin.dashboard');
    }
}
