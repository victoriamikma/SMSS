{{-- resources/views/calendar/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Event Details: {{ $event->name }}</div>

                <div class="card-body">
                    <div class="event-detail-item mb-4">
                        <div class="event-detail-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="event-detail-content">
                            <div class="event-detail-label">Date & Time</div>
                            <div class="event-detail-value">
                                {{ $event->start_date->format('l, F j, Y') }}
                                @if($event->start_date->format('H:i') !== '00:00')
                                    • {{ $event->start_date->format('g:i A') }}
                                    @if($event->end_date)
                                        - {{ $event->end_date->format('g:i A') }}
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($event->location)
                    <div class="event-detail-item mb-4">
                        <div class="event-detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="event-detail-content">
                            <div class="event-detail-label">Location</div>
                            <div class="event-detail-value">{{ $event->location }}</div>
                        </div>
                    </div>
                    @endif

                    @if($event->description)
                    <div class="event-detail-item mb-4">
                        <div class="event-detail-icon">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div class="event-detail-content">
                            <div class="event-detail-label">Description</div>
                            <div class="event-detail-value">{{ $event->description }}</div>
                        </div>
                    </div>
                    @endif

                    <div class="event-detail-item mb-4">
                        <div class="event-detail-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="event-detail-content">
                            <div class="event-detail-label">Event Type</div>
                            <div class="event-detail-value">
                                <span class="badge" style="background-color: {{ App\Http\Controllers\CalendarController::getEventColor($event->type) }}; color: white;">
                                    {{ ucfirst($event->type) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="event-detail-item mb-4">
                        <div class="event-detail-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="event-detail-content">
                            <div class="event-detail-label">Visibility</div>
                            <div class="event-detail-value">
                                {{ $event->is_public ? 'Public (visible to everyone)' : 'Private' }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('calendar.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Calendar
                        </a>
                        <div>
                            <a href="{{ route('calendar.edit', $event->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Edit Event
                            </a>
                            <form action="{{ route('calendar.destroy', $event->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">
                                    <i class="fas fa-trash me-1"></i> Delete Event
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection