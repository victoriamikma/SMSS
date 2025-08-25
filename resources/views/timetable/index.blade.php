@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="float-left">Class Timetable</h3>
                    <div class="float-right">
                        <a href="{{ route('timetable.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Schedule
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Room</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($timetables as $timetable)
                                    <tr>
                                        <td>{{ ucfirst($timetable->day_of_week) }}</td>
                                        <td>
                                            {{ date('h:i A', strtotime($timetable->start_time)) }} - 
                                            {{ date('h:i A', strtotime($timetable->end_time)) }}
                                        </td>
                                        <td>{{ $timetable->class->name }}</td>
                                        <td>{{ $timetable->subject->name }}</td>
                                        <td>{{ $timetable->teacher->name }}</td>
                                        <td>{{ $timetable->room }}</td>
                                        <td>
                                            <a href="{{ route('timetable.edit', $timetable->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('timetable.destroy', $timetable->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No timetable entries found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $timetables->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection