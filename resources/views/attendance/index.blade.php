@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="float-left">Attendance Records</h3>
                    <div class="float-right">
                        <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Attendance
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
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Person</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->id }}</td>
                                        <td>{{ $attendance->date->format('M d, Y') }}</td>
                                        <td>
                                            @if($attendance->student_id)
                                                {{ $attendance->student->name }}
                                            @elseif($attendance->staff_id)
                                                {{ $attendance->staff->name }}
                                            @endif
                                        </td>
                                        <td>{{ $attendance->student_id ? 'Student' : 'Staff' }}</td>
                                        <td>
                                            <span class="badge badge-{{ 
                                                $attendance->status === 'present' ? 'success' : 
                                                ($attendance->status === 'late' ? 'warning' : 'danger') 
                                            }}">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $attendance->time_in }}</td>
                                        <td>{{ $attendance->time_out ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="d-inline">
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
                                        <td colspan="8" class="text-center">No attendance records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $attendances->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection