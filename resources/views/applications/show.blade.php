{{-- resources/views/applications/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #FF8C00 0%, #FFA500 100%); color: white;">
                    <h4 class="m-0"><i class="fas fa-file-alt me-2"></i> Application Details</h4>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Student Information</h5>
                            <div class="d-flex align-items-center mb-3">
                                <div class="student-avatar me-3">
                                    {{ substr($application->student->name, 0, 1) }}
                                </div>
                                <div>
                                    <strong>{{ $application->student->name }}</strong><br>
                                    <small class="text-muted">{{ $application->student->email }}</small>
                                </div>
                            </div>
                            <p><strong>Phone:</strong> {{ $application->student->phone ?? 'N/A' }}</p>
                            <p><strong>Date of Birth:</strong> {{ $application->student->date_of_birth?->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Application Details</h5>
                            <p><strong>Program:</strong> <span class="program-badge">{{ $application->program->name }}</span></p>
                            <p><strong>Application Date:</strong> {{ $application->application_date->format('M d, Y') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="status-badge 
                                    @if($application->status == 'pending') badge-warning
                                    @elseif($application->status == 'approved') badge-success
                                    @else badge-danger @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($application->notes)
                    <div class="mb-4">
                        <h5>Notes</h5>
                        <div class="alert alert-info">
                            {{ $application->notes }}
                        </div>
                    </div>
                    @endif

                    @if($application->documents)
                    <div class="mb-4">
                        <h5>Documents</h5>
                        <a href="{{ $application->document_url }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-download me-1"></i> Download Document
                        </a>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('applications.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                        <div>
                            <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('applications.destroy', $application->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this application?')">
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
@endsection