<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
{
    $timetables = Timetable::with(['class', 'subject', 'teacher'])
                    ->orderBy('day_of_week')
                    ->orderBy('start_time')
                    ->paginate(10);
    
    return view('timetable.index', compact('timetables'));
}
    //
}
