<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Staff;
use App\Models\Payment;
use App\Models\LibraryTransaction;
use App\Models\Attendance;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'studentCount' => Student::count(),
            'staffCount' => Staff::count(),
            'totalFees' => Payment::sum('amount'),
            'booksBorrowed' => LibraryTransaction::whereNull('returned_at')->count(),
            'attendance' => Attendance::whereDate('date', today())->first(),
            'upcomingEvents' => Event::where('start_date', '>=', today())->orderBy('start_date')->limit(3)->get(),
            'recentAbsences' => Attendance::with('student')->where('status', 'absent')->orderByDesc('date')->limit(2)->get(),
        ]);
    }
}