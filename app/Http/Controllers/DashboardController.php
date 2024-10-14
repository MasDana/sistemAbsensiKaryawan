<?php

namespace App\Http\Controllers;

use App\Models\Attendance;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
        // return view('dashboard')->with(['attendance' => Attendance::all()]);
    }

    public function employee()
    {
        return view("sesi/employeeDashboard");
    }
}
