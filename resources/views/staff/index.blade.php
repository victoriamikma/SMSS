@extends('layouts.app')

@section('title', 'Staff Management')
@section('breadcrumb')
    <div class="breadcrumb-item">
        <span class="breadcrumb-link">Staff Management</span>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="page-title">Staff Management</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('staff.create') }}" class="btn btn-primary btn-enhanced">
                <i class="fas fa-plus"></i> Add New Staff
            </a>
            <a href="{{ route('staff.import-export') }}" class="btn btn-info btn-enhanced me-2">
    <i class="fas fa-file-import"></i> Import/Export
</a>
        </div>




</div>
    </div>

    <div class="content-container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="enhanced-table">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Hire Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $member)
                    <tr>
                        <td>
                            @if($member->profile_picture)
                                <img src="{{ asset('storage/' . $member->profile_picture) }}"
                                     alt="Profile Picture"
                                     class="profile-thumbnail">
                            @else
                                <div class="no-image-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                        <td>{{ $member->position }}</td>
                        <td>{{ $member->department }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->phone ?? 'N/A' }}</td>
                        <td>{{ $member->hire_date->format('M d, Y') }}</td>
                        <td class="action-cell">
                            <a href="{{ route('staff.show', $member->id) }}" class="action-icon action-icon-view">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('staff.edit', $member->id) }}" class="action-icon action-icon-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('staff.destroy', $member->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-icon action-icon-delete border-0 bg-transparent" onclick="return confirm('Are you sure you want to delete this staff member?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($staff->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <p class="text-muted">No staff members found. Add your first staff member to get started.</p>
                <a href="{{ route('staff.create') }}" class="btn btn-primary btn-enhanced mt-2">
                    <i class="fas fa-plus"></i> Add Staff Member
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    .profile-thumbnail {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #eaeaea;
    }

    .no-image-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #eaeaea;
    }

    .no-image-placeholder i {
        color: #999;
        font-size: 20px;
    }

    .enhanced-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 0.9em;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }

    .enhanced-table thead tr {
        background-color: #f8f9fa;
        color: #495057;
        text-align: left;
        font-weight: bold;
    }

    .enhanced-table th,
    .enhanced-table td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    .enhanced-table tbody tr {
        border-bottom: 1px solid #eaeaea;
    }

    .enhanced-table tbody tr:last-of-type {
        border-bottom: 2px solid #f8f9fa;
    }

    .enhanced-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .action-cell {
        white-space: nowrap;
    }

    .action-icon {
        display: inline-block;
        padding: 5px;
        margin: 0 3px;
        border-radius: 4px;
        color: #6c757d;
        transition: all 0.3s;
    }

    .action-icon-view:hover {
        color: #17a2b8;
        background-color: rgba(23, 162, 184, 0.1);
    }

    .action-icon-edit:hover {
        color: #ffc107;
        background-color: rgba(255, 193, 7, 0.1);
    }

    .action-icon-delete:hover {
        color: #dc3545;
        background-color: rgba(220, 53, 69, 0.1);
    }

    .btn-enhanced {
        border-radius: 6px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .content-container {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .page-title {
        color: #343a40;
        font-weight: 700;
    }
</style>
@endsection
