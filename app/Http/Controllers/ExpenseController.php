<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('expenses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Add your store logic here
        // Validate and store the expense
        return redirect()->route('expenses.index')->with('success', 'Expense created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Show logic here
        return view('expenses.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Edit logic here
        return view('expenses.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Update logic here
        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Delete logic here
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully!');
    }

    /**
     * Show import form
     */
    public function import()
    {
        return view('expenses.import');
    }

    /**
     * Export expenses
     */
    public function export()
    {
        // Export logic here
        return response()->download('path/to/export/file.csv');
    }
}