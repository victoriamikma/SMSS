<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
{
    $exams = Exam::with(['subject', 'class'])
                ->latest()
                ->paginate(10);
    
    return view('exams.index', compact('exams'));
}
    //
}
