@extends('layouts.app')

@section('title', 'Subjects Management')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <span>Subjects Management</span>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="enhanced-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Subjects Management</h4>
                    <a href="{{ route('subjects.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add New Subject
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="enhanced-table">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Teachers</th>
                                    <th>Classes</th>
                                    <th class="action-cell">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->code }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>
                                        @foreach($subject->teachers as $teacher)
                                            <span class="position-badge">{{ $teacher->name }}</span>
                                        @endforeach
                                        @if($subject->teachers->count() === 0)
                                            <span class="text-muted">Not assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach($subject->classes as $class)
                                            <span class="badge bg-secondary">{{ $class->name }}</span>
                                        @endforeach
                                        @if($subject->classes->count() === 0)
                                            <span class="text-muted">None</span>
                                        @endif
                                    </td>
                                    <td class="action-cell">
                                        <a href="{{ route('subjects.show', $subject) }}" class="action-icon action-icon-view" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('subjects.edit', $subject) }}" class="action-icon action-icon-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-icon action-icon-delete border-0 bg-transparent" title="Delete" onclick="return confirm('Are you sure you want to delete this subject?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($subjects->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No subjects found. <a href="{{ route('subjects.create') }}">Create your first subject</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
