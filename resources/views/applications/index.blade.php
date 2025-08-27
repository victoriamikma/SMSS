<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Applications Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-orange: #FF7700;
            --orange-light: #FF9838;
            --orange-dark: #E05D00;
            --orange-gradient: linear-gradient(135deg, #FF7700 0%, #FF9838 100%);
            --orange-subtle: #FFF5EB;
            --success-green: #28a745;
            --info-blue: #17a2b8;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 2rem;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(255, 119, 0, 0.15);
            overflow: hidden;
        }
        
        .card-header {
            background: var(--orange-gradient);
            color: white;
            border-bottom: none;
            padding: 1.2rem 1.5rem;
        }
        
        .btn-primary {
            background: var(--orange-gradient);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-primary:hover {
            background: var(--primary-orange);
            box-shadow: 0 4px 12px rgba(255, 119, 0, 0.3);
        }
        
        .btn-success {
            background-color: var(--success-green);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-info {
            background-color: var(--info-blue);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-light {
            background-color: white;
            border: 1px solid var(--primary-orange);
            color: var(--primary-orange);
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-light:hover {
            background-color: var(--orange-subtle);
            color: var(--orange-dark);
        }
        
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(255, 119, 0, 0.15);
            border: 1px solid var(--orange-light);
        }
        
        .dropdown-item:hover {
            background-color: var(--orange-subtle);
            color: var(--primary-orange);
        }
        
        .filter-section {
            background-color: var(--orange-subtle);
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 0.25rem rgba(255, 119, 0, 0.25);
        }
        
        .student-avatar {
            width: 40px;
            height: 40px;
            background: var(--orange-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .program-badge {
            background-color: var(--orange-subtle);
            color: var(--primary-orange);
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .badge-warning {
            background-color: #FFF0D9;
            color: #E5A500;
        }
        
        .badge-success {
            background-color: #E6F4EE;
            color: #0A8158;
        }
        
        .badge-danger {
            background-color: #FCE8E6;
            color: #D92D20;
        }
        
        .action-buttons .btn {
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        
        .btn-info {
            background-color: #E6F0FF;
            color: #2E5AAC;
            border: none;
        }
        
        .btn-info:hover {
            background-color: #D4E3FC;
        }
        
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #DEDEDE;
            margin-bottom: 1rem;
        }
        
        .pagination .page-link {
            color: var(--primary-orange);
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
        }
        
        .card-footer {
            background-color: var(--orange-subtle);
            border-top: 1px solid rgba(255, 119, 0, 0.15);
        }
        
        table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        thead th {
            background-color: var(--orange-subtle);
            color: var(--primary-orange);
            font-weight: 600;
            border-bottom: 2px solid var(--primary-orange);
            padding: 1rem 0.75rem;
        }
        
        tbody tr {
            transition: all 0.2s ease;
        }
        
        tbody tr:hover {
            background-color: rgba(255, 119, 0, 0.05);
            transform: translateY(-2px);
        }
        
        tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }
        
        .text-truncate {
            max-width: 150px;
        }
        
        .import-export-container {
            display: flex;
            gap: 10px;
            margin-left: 10px;
        }
        
        @media (max-width: 768px) {
            .import-export-container {
                margin-top: 10px;
                margin-left: 0;
                width: 100%;
            }
            
            .header-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="m-0"><i class="fas fa-file-alt me-2"></i> Student Applications Management</h3>
                        <div class="d-flex header-actions">
                            <a href="{{ route('applications.create') }}" class="btn btn-light">
                                <i class="fas fa-plus-circle me-1"></i> New Application
                            </a>
                            <div class="import-export-container">
                                <a href="{{ route('applications.import') }}" class="btn btn-success">
                                    <i class="fas fa-file-import me-1"></i> Import
                                </a>
                                <a href="{{ route('applications.export', $filters ?? []) }}" class="btn btn-info">
                                    <i class="fas fa-file-export me-1"></i> Export
                                </a>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-cogs me-1"></i> More
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('applications.template') }}"><i class="fas fa-download me-1"></i> Download Template</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filters -->
                    <div class="filter-section">
                        <form method="GET" action="{{ route('applications.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="statusFilter" class="form-label">Filter by Status</label>
                                        <select class="form-select" id="statusFilter" name="status">
                                            <option value="">All Statuses</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="programFilter" class="form-label">Filter by Program</label>
                                        <select class="form-select" id="programFilter" name="program_id">
                                            <option value="">All Programs</option>
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>
                                                    {{ $program->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="searchInput" class="form-label">Search Applications</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="searchInput" name="search" 
                                                value="{{ request('search') }}" placeholder="Search by student name, program...">
                                            <button type="submit" class="input-group-text"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Applications Table -->
                    <div class="table-responsive">
                        <table class="table table-hover" id="applicationsTable">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 20%;">Student</th>
                                    <th style="width: 20%;">Program</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 15%;">Applied On</th>
                                    <th style="width: 20%;">Notes</th>
                                    <th style="width: 10%; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $application)
                                    <tr>
                                        <td>{{ $application->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="student-avatar me-3">
                                                    {{ substr($application->student->name, 0, 1) }}
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold">{{ $application->student->name }}</span>
                                                    <span class="text-muted small">{{ $application->student->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="program-badge">{{ $application->program->name }}</span>
                                        </td>
                                        <td>
                                            <span class="status-badge 
                                                @if($application->status == 'pending') badge-warning
                                                @elseif($application->status == 'approved') badge-success
                                                @else badge-danger @endif">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $application->application_date->format('M d, Y') }}</td>
                                        <td>
                                            @if($application->notes)
                                                <span class="d-inline-block text-truncate" style="max-width: 150px;" 
                                                    data-bs-toggle="tooltip" title="{{ $application->notes }}">
                                                    {{ $application->notes }}
                                                </span>
                                            @else
                                                <span class="text-muted">No notes</span>
                                            @endif
                                        </td>
                                        <td class="action-buttons">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('applications.show', $application->id) }}" class="btn btn-sm btn-info me-1" data-bs-toggle="tooltip" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('applications.destroy', $application->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this application?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-file-alt"></i>
                                                <h4>No applications found</h4>
                                                <p>There are no applications matching your criteria.</p>
                                                <a href="{{ route('applications.create') }}" class="btn btn-primary mt-2">
                                                    <i class="fas fa-plus-circle me-1"></i> Create New Application
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    {{ $applications->links() }}
                </div>
                
                <div class="card-footer py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">Showing <strong>{{ $applications->firstItem() ?? 0 }}-{{ $applications->lastItem() ?? 0 }}</strong> of <strong>{{ $applications->total() }}</strong> applications</span>
                        </div>
                        <div>
                            <span class="text-muted">Last updated: {{ now()->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Add some interactivity to the filter form
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('statusFilter');
        const programFilter = document.getElementById('programFilter');
        const searchInput = document.getElementById('searchInput');
        
        // Auto-submit form when filters change (optional)
        [statusFilter, programFilter].forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
        
        // Add a clear filters button dynamically
        const filterForm = document.querySelector('.filter-section form');
        const clearButton = document.createElement('button');
        clearButton.type = 'button';
        clearButton.className = 'btn btn-outline-secondary mt-3';
        clearButton.innerHTML = '<i class="fas fa-times me-1"></i> Clear Filters';
        clearButton.addEventListener('click', function() {
            statusFilter.value = '';
            programFilter.value = '';
            searchInput.value = '';
            filterForm.submit();
        });
        
        filterForm.appendChild(clearButton);
    });
</script>
</body>
</html>