<?php

namespace App\Http\Controllers;

use App\Models\Fee; // Add this import statement
use Illuminate\Http\Request;

class FeesController extends Controller
{
    public function index()
    {
        $fees = Fee::latest()->paginate(10);
        return view('fees.index', compact('fees'));
    }
    
    // Add other necessary methods for the fees module
    public function create()
    {
        return view('fees.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'frequency' => 'required|in:one_time,monthly,termly,annual',
            'description' => 'nullable|string',
            'class_id' => 'nullable|exists:classes,id',
            'due_date' => 'nullable|date',
            'status' => 'required|in:active,inactive'
        ]);
        
        Fee::create($validated);
        
        return redirect()->route('fees.index')
            ->with('success', 'Fee structure created successfully.');
    }
    
    public function edit(Fee $fee)
    {
        return view('fees.edit', compact('fee'));
    }
    
    public function update(Request $request, Fee $fee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'frequency' => 'required|in:one_time,monthly,termly,annual',
            'description' => 'nullable|string',
            'class_id' => 'nullable|exists:classes,id',
            'due_date' => 'nullable|date',
            'status' => 'required|in:active,inactive'
        ]);
        
        $fee->update($validated);
        
        return redirect()->route('fees.index')
            ->with('success', 'Fee structure updated successfully.');
    }
    
    public function destroy(Fee $fee)
    {
        $fee->delete();
        
        return redirect()->route('fees.index')
            ->with('success', 'Fee structure deleted successfully.');
    }
}