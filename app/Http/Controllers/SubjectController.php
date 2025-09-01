<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::with('teachers', 'classes')->get();
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::all();
        $classes = ClassRoom::all();
        return view('subjects.create', compact('teachers', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects',
            'description' => 'nullable|string',
            'teachers' => 'nullable|array', // Changed from teacher_id to teachers
            'teachers.*' => 'exists:teachers,id',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:classes,id'
        ]);

        $subject = Subject::create($request->only(['name', 'code', 'description']));

        // Sync teachers (many-to-many)
        if ($request->has('teachers')) {
            $subject->teachers()->sync($request->teachers);
        }

        // Sync classes
        if ($request->has('classes')) {
            $subject->classes()->sync($request->classes);
        }

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->load('teachers', 'classes');
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $teachers = Teacher::all();
        $classes = ClassRoom::all();
        $subject->load('teachers', 'classes');
        return view('subjects.edit', compact('subject', 'teachers', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
            'teachers' => 'nullable|array', // Changed from teacher_id to teachers
            'teachers.*' => 'exists:teachers,id',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:classes,id'
        ]);

        $subject->update($request->only(['name', 'code', 'description']));

        // Sync teachers
        if ($request->has('teachers')) {
            $subject->teachers()->sync($request->teachers);
        } else {
            $subject->teachers()->detach();
        }

        // Sync classes
        if ($request->has('classes')) {
            $subject->classes()->sync($request->classes);
        } else {
            $subject->classes()->detach();
        }

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->teachers()->detach();
        $subject->classes()->detach();
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
