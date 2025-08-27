<?php

// app/Http/Controllers/CalendarController.php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Event::where('is_public', true)->get();
        return view('calendar.index', compact('events'));
    }

    public function create()
    {
        return view('calendar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'type' => 'required|in:exam,holiday,meeting,anniversary,other',
            'is_public' => 'boolean'
        ]);

        Event::create($validated);

        return redirect()->route('calendar.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('calendar.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('calendar.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'type' => 'required|in:exam,holiday,meeting,anniversary,other',
            'is_public' => 'boolean'
        ]);

        $event->update($validated);

        return redirect()->route('calendar.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('calendar.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function api()
    {
        $events = Event::select('id', 'name', 'start_date as start', 'end_date as end', 'type', 'location', 'description')
            ->where('is_public', true)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->name,
                    'start' => $event->start,
                    'end' => $event->end,
                    'type' => $event->type,
                    'location' => $event->location,
                    'description' => $event->description,
                    'color' => $this->getEventColor($event->type)
                ];
            });

        return response()->json($events);
    }

  
public static function getEventColor($type)
{
    $colors = [
        'academic' => '#3498db',
        'holiday' => '#e74c3c',
        'event' => '#2ecc71',
        'meeting' => '#f39c12',
        'exam' => '#9b59b6',
    ];
    
    return $colors[strtolower($type)] ?? '#95a5a6';
}
}