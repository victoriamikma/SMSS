@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="float-left">Exam Schedule</h3>
                    <div class="float-right">
                        <a href="{{ route('exams.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Exam
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
                                    <th>Exam Name</th>
                                    <th>Subject</th>
                                    <th>Class</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($exams as $exam)
                                    <tr>
                                        <td>{{ $exam->id }}</td>
                                        <td>{{ $exam->name }}</td>
                                        <td>{{ $exam->subject->name }}</td>
                                        <td>{{ $exam->class->name }}</td>
                                        <td>{{ $exam->date->format('M d, Y') }}</td>
                                        <td>{{ $exam->start_time }}</td>
                                        <td>{{ $exam->end_time }}</td>
                                        <td>
                                            <a href="{{ route('exams.edit', $exam->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" class="d-inline">
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
                                        <td colspan="8" class="text-center">No exams scheduled yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $exams->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection