<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    return view('reports.index', [
        'studentCount' => \App\Models\Student::count(),
        'staffCount' => \App\Models\Staff::count(),
        'totalFees' => \App\Models\Payment::sum('amount'),
        'attendanceStats' => \App\Models\Attendance::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
