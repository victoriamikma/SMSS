@extends('layouts.app')

@section('title', 'Staff Import/Export')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('staff.index') }}" class="breadcrumb-link">Staff</a>
    </div>
    <div class="breadcrumb-item">
        <span class="breadcrumb-link">Import/Export</span>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="page-title">Staff Import/Export</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('staff.index') }}" class="btn btn-secondary btn-enhanced">
                <i class="fas fa-arrow-left"></i> Back to Staff
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Import Errors -->
    @if(session('import_errors'))
        <div class="card mb-4 enhanced-card">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Import Errors ({{ session('error_count') }} errors)
                </h5>
            </div>
            <div class="card-body">
                @if(session('success_count') > 0)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Successfully imported {{ session('success_count') }} records.
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th width="10%">Row</th>
                                <th width="20%">Field</th>
                                <th width="30%">Value</th>
                                <th width="40%">Error</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(session('import_errors') as $error)
                                <tr>
                                    <td class="text-danger fw-bold">{{ explode(',', $error)[0] }}</td>
                                    <td>{{ explode(':', $error)[0] }}</td>
                                    <td>{{ explode('(', $error)[1] ?? 'N/A' }}</td>
                                    <td class="text-danger">{{ explode(':', $error)[1] ?? $error }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <a href="{{ route('staff.template') }}" class="btn btn-primary btn-enhanced">
                        <i class="fas fa-download me-2"></i>Download Template
                    </a>
                    <button onclick="window.location.reload()" class="btn btn-secondary btn-enhanced">
                        <i class="fas fa-sync me-2"></i>Try Again
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <!-- Export Card -->
        <div class="col-md-6 mb-4">
            <div class="card enhanced-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-download me-2"></i>Export Staff</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('staff.export') }}" method="GET">
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select" id="department" name="department">
                                <option value="">All Departments</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <select class="form-select" id="position" name="position">
                                <option value="">All Positions</option>
                                @foreach($positions as $pos)
                                    <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>{{ $pos }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Hire Date From</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Hire Date To</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-enhanced">
                            <i class="fas fa-download me-2"></i>Export to Excel
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import Card -->
        <div class="col-md-6 mb-4">
            <div class="card enhanced-card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-upload me-2"></i>Import Staff</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 text-end">
                        <a href="{{ route('staff.template') }}" class="btn btn-primary btn-enhanced">
                            <i class="fas fa-download me-2"></i>Download Template
                        </a>
                    </div>

                    <form action="{{ route('staff.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Select Excel File</label>
                            <input class="form-control" type="file" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                            @error('file')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Required columns:</strong> First Name, Last Name, Email, Position, Department, Hire Date<br>
                            <strong>Optional:</strong> Phone, Salary<br>
                            <a href="{{ route('staff.template') }}" class="alert-link">Download template</a> for the correct format.
                        </div>
                        <button type="submit" class="btn btn-success w-100 btn-enhanced" id="importBtn">
                            <i class="fas fa-upload me-2"></i>Import Staff
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const importForm = document.getElementById('importForm');
        const importBtn = document.getElementById('importBtn');

        if (importForm) {
            importForm.addEventListener('submit', function(e) {
                const fileInput = document.getElementById('file');

                if (fileInput.files.length > 0) {
                    importBtn.disabled = true;
                    importBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Importing...';
                }
            });
        }

        // Set default date values if not already set
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');

        if (startDate && !startDate.value) {
            // Set default to 30 days ago
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
            startDate.value = thirtyDaysAgo.toISOString().split('T')[0];
        }

        if (endDate && !endDate.value) {
            // Set default to today
            endDate.value = new Date().toISOString().split('T')[0];
        }
    });
</script>
@endpush
