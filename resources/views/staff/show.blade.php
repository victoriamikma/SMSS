@extends('layouts.app')

@section('title', 'Staff Details')
@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('staff.index') }}" class="breadcrumb-link">Staff Management</a>
    </div>
    <div class="breadcrumb-item">
        <span class="breadcrumb-link">Staff Details</span>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card enhanced-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Staff Details</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-primary btn-enhanced">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('staff.index') }}" class="btn btn-secondary btn-enhanced">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="profile-display-section text-center">
                                @if($staff->profile_picture)
                                    <img src="{{ asset('storage/' . $staff->profile_picture) }}"
                                         alt="Profile Picture"
                                         class="profile-detail-image mb-3">
                                @else
                                    <div class="no-image-detail mb-3">
                                        <i class="fas fa-user fa-4x"></i>
                                    </div>
                                @endif
                                <h3 class="profile-name">{{ $staff->first_name }} {{ $staff->last_name }}</h3>
                                <p class="text-muted profile-position">{{ $staff->position }} • {{ $staff->department }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="details-container">
                        <h5 class="details-section-title">Personal Information</h5>

                        <div class="row detail-row">
                            <div class="col-md-4 detail-label">Full Name:</div>
                            <div class="col-md-8 detail-value">{{ $staff->first_name }} {{ $staff->last_name }}</div>
                        </div>

                        <div class="row detail-row">
                            <div class="col-md-4 detail-label">Email:</div>
                            <div class="col-md-8 detail-value">{{ $staff->email }}</div>
                        </div>

                        <div class="row detail-row">
                            <div class="col-md-4 detail-label">Phone:</div>
                            <div class="col-md-8 detail-value">{{ $staff->phone ?? 'N/A' }}</div>
                        </div>

                        <h5 class="details-section-title mt-4">Employment Information</h5>

                        <div class="row detail-row">
                            <div class="col-md-4 detail-label">Position:</div>
                            <div class="col-md-8 detail-value">{{ $staff->position }}</div>
                        </div>

                        <div class="row detail-row">
                            <div class="col-md-4 detail-label">Department:</div>
                            <div class="col-md-8 detail-value">{{ $staff->department }}</div>
                        </div>

                        <div class="row detail-row">
                            <div class="col-md-4 detail-label">Salary:</div>
                            <div class="col-md-8 detail-value">
                                @if($staff->salary)
                                    {{ number_format($staff->salary) }} UGX
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>

                        <div class="row detail-row">
                            <div class="col-md-4 detail-label">Hire Date:</div>
                            <div class="col-md-8 detail-value">{{ $staff->hire_date->format('F d, Y') }}</div>
                        </div>

                        <div class="row detail-row">
                            <div class="col-md-4 detail-label">Employment Duration:</div>
                            <div class="col-md-8 detail-value">{{ $staff->hire_date->diffForHumans() }} ({{ $staff->hire_date->diffInYears(now()) }} years)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-detail-image {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #eaeaea;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .no-image-detail {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: #f0f0f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #eaeaea;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .no-image-detail i {
        color: #999;
    }

    .profile-display-section {
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .profile-name {
        color: #343a40;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .profile-position {
        font-size: 1.1rem;
        margin-bottom: 0;
    }

    .details-container {
        padding: 0 20px;
    }

    .details-section-title {
        color: #495057;
        font-weight: 600;
        padding-bottom: 8px;
        border-bottom: 2px solid #dee2e6;
        margin-bottom: 20px;
    }

    .detail-row {
        margin-bottom: 15px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f1f1;
    }

    .detail-label {
        font-weight: 600;
        color: #495057;
    }

    .detail-value {
        color: #6c757d;
    }

    .enhanced-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 20px 25px;
    }

    .btn-enhanced {
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-enhanced:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
</style>
@endsection
