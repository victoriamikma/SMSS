@extends('layouts.app')

@section('title', 'Subject Details - ' . $subject->name)

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('subjects.index') }}" class="breadcrumb-link">Subjects</a>
    </div>
    <div class="breadcrumb-item">
        <span>{{ $subject->name }}</span>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="page-title mb-1">{{ $subject->name }}</h2>
                    <div class="text-muted">{{ $subject->code }} • {{ $subject->teachers->count() }} teachers • {{ $subject->classes->count() }} classes</div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this subject?')">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-icon bg-primary">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-value">{{ $subject->teachers->count() }}</div>
                            <div class="stats-label">Teachers</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-icon bg-info">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-value">{{ $subject->classes->count() }}</div>
                            <div class="stats-label">Classes</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-icon bg-success">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-value">{{ $subject->code }}</div>
                            <div class="stats-label">Subject Code</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="enhanced-card">
                <div class="card-header">
                    <h4>Subject Details</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">Code:</div>
                                <div class="detail-value">{{ $subject->code }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">Name:</div>
                                <div class="detail-value">{{ $subject->name }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Description:</div>
                        <div class="detail-value">{{ $subject->description ?? 'No description provided' }}</div>
                    </div>

                    <!-- Teachers Section -->
                    <div class="detail-row">
                        <div class="detail-label mb-3">Teachers:</div>
                        <div class="detail-value">
                            @if($subject->teachers->count() > 0)
                                <div class="teachers-list">
                                    @foreach($subject->teachers as $teacher)
                                        <div class="teacher-item">
                                            <div class="staff-photo-container me-3">
                                                @if($teacher->photo)
                                                    <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}" class="staff-photo">
                                                @else
                                                    <div class="staff-photo-placeholder">
                                                        {{ substr($teacher->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="teacher-info">
                                                <div class="teacher-name">{{ $teacher->name }}</div>
                                                <div class="teacher-subject text-muted small">{{ $teacher->email }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">No teachers assigned to this subject</span>
                            @endif
                        </div>
                    </div>

                    <!-- Classes Section -->
                    <div class="detail-row">
                        <div class="detail-label">Classes:</div>
                        <div class="detail-value">
                            @if($subject->classes->count() > 0)
                                <div class="classes-container">
                                    @foreach($subject->classes as $class)
                                        <span class="class-badge">{{ $class->name }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">No classes assigned to this subject</span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Subjects
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i> Edit Subject
                            </a>
                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this subject?')">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Stats Cards */
    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--subtle-beige);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-right: 1rem;
    }

    .stats-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--deep-charcoal);
        line-height: 1;
    }

    .stats-label {
        color: var(--medium-charcoal);
        font-size: 0.9rem;
    }

    /* Teacher Items */
    .teachers-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .teacher-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        background: var(--off-white);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .teacher-item:hover {
        background: var(--light-orange);
        transform: translateX(5px);
    }

    .teacher-info {
        flex: 1;
    }

    .teacher-name {
        font-weight: 600;
        color: var(--deep-charcoal);
    }

    /* Class Badges */
    .classes-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .class-badge {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--dark-orange) 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .stats-card {
            margin-bottom: 1rem;
        }

        .teacher-item {
            flex-direction: column;
            text-align: center;
        }

        .staff-photo-container {
            margin-bottom: 0.5rem;
            margin-right: 0 !important;
        }

        .d-flex.gap-2 {
            flex-direction: column;
            gap: 0.5rem !important;
        }
    }
</style>
@endsection
