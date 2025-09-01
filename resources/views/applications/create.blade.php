<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Application - SwiftSolve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/css/tom-select.bootstrap5.min.css">
    <style>
        :root {
            --primary-orange: #FF6B00;
            --secondary-orange: #FF8C00;
            --light-orange: #FFE4CC;
            --dark-orange: #E55D00;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
            --medium-gray: #E0E0E0;
            --dark-gray: #555555;
            --text-dark: #222222;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --border-radius: 12px;
            --card-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFF5EB 0%, #FFEDDE 100%);
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }

        .navbar {
            background: linear-gradient(120deg, var(--primary-orange), var(--secondary-orange));
            box-shadow: var(--shadow);
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .main-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            background: var(--white);
        }

        .card-header {
            background: linear-gradient(120deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            font-weight: 600;
            font-size: 1.3rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: var(--primary-orange);
        }

        .form-control, .form-select {
            border: 2px solid var(--medium-gray);
            border-radius: 8px;
            padding: 0.85rem 1.25rem;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 0, 0.25);
        }

        .input-group-text {
            background-color: var(--light-orange);
            border: 2px solid var(--medium-gray);
            border-right: none;
            color: var(--primary-orange);
            font-weight: 500;
        }

        .input-group .form-control {
            border-left: none;
        }

        .form-text {
            color: var(--dark-gray);
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(120deg, var(--primary-orange), var(--secondary-orange));
            border: none;
            border-radius: 8px;
            padding: 0.85rem 2rem;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.4);
            background: linear-gradient(120deg, var(--secondary-orange), var(--primary-orange));
        }

        .btn-secondary {
            background: var(--light-gray);
            border: none;
            color: var(--dark-gray);
            border-radius: 8px;
            padding: 0.85rem 2rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            background: var(--medium-gray);
            color: var(--text-dark);
        }

        .invalid-feedback {
            color: #dc3545;
            font-weight: 500;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .invalid-feedback::before {
            content: "⚠";
            font-weight: bold;
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid:focus, .form-select.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .footer {
            text-align: center;
            margin-top: 3rem;
            color: var(--dark-gray);
            font-size: 0.9rem;
            padding: 1.5rem;
        }

        /* Custom file input styling */
        .form-control[type="file"] {
            padding: 0.85rem 1.25rem;
        }

        .form-control[type="file"]::file-selector-button {
            background: var(--light-orange);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            margin-right: 1rem;
            color: var(--primary-orange);
            font-weight: 500;
            transition: var(--transition);
        }

        .form-control[type="file"]::file-selector-button:hover {
            background: var(--primary-orange);
            color: white;
        }

        /* Custom styling for select dropdown */
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23FF6B00' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px 12px;
        }

        /* Tom Select Customization */
        .ts-control {
            border: 2px solid var(--medium-gray) !important;
            border-radius: 8px !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.95rem !important;
        }

        .ts-control:focus {
            border-color: var(--primary-orange) !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 0, 0.25) !important;
        }

        .ts-dropdown {
            border: 2px solid var(--primary-orange) !important;
            border-top: none !important;
            border-radius: 0 0 8px 8px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .ts-dropdown .option {
            padding: 0.75rem 1rem !important;
        }

        .ts-dropdown .active {
            background-color: var(--light-orange) !important;
            color: var(--primary-orange) !important;
        }

        .ts-dropdown .selected {
            background-color: var(--primary-orange) !important;
            color: white !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.75rem;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
            }
            
            .card-header {
                font-size: 1.1rem;
                padding: 1.25rem;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            animation: fadeIn 0.5s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-orange);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-orange);
        }
        
        /* Form section styling */
        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--light-orange);
        }
        
        .form-section:last-of-type {
            border-bottom: none;
            margin-bottom: 1rem;
        }
        
        .section-title {
            color: var(--primary-orange);
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Custom input for manual entry */
        .manual-input-toggle {
            color: var(--primary-orange);
            text-decoration: none;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            cursor: pointer;
        }

        .manual-input-toggle:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-graduation-cap me-2"></i>
                SwiftSolve Academy
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('applications.index') }}">
                    <i class="fas fa-arrow-left me-1"></i> Back to Applications
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-alt"></i> Create New Application
            </div>
            <div class="card-body">
                <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-section">
                        <h5 class="section-title"><i class="fas fa-user-graduate"></i> Student Information</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="student_search" class="form-label">
                                    <i class="fas fa-user"></i> Search Student
                                </label>
                                <select id="student_search" name="student_id" class="form-select" required>
                                    <option value="">Type to search students...</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }} ({{ $student->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="program_search" class="form-label">
                                    <i class="fas fa-book"></i> Program/Course
                                </label>
                                <select id="program_search" name="program_id" class="form-select" required>
                                    <option value="">Type to search or add program...</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                            {{ $program->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <a href="#" class="manual-input-toggle" id="toggleProgramInput">
                                    <i class="fas fa-plus-circle"></i> Can't find your program? Add it manually
                                </a>
                                <div id="manualProgramInput" class="mt-2" style="display: none;">
                                    <input type="text" class="form-control" id="new_program_name" name="new_program_name" placeholder="Enter new program name">
                                    <div class="form-text">Enter the name of a new program if it's not in the list</div>
                                </div>
                                @error('program_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h5 class="section-title"><i class="fas fa-info-circle"></i> Application Details</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="application_date" class="form-label">
                                    <i class="fas fa-calendar"></i> Application Date
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" class="form-control @error('application_date') is-invalid @enderror" 
                                        id="application_date" name="application_date" value="{{ old('application_date', date('Y-m-d')) }}" required>
                                </div>
                                @error('application_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="status" class="form-label">
                                    <i class="fas fa-tasks"></i> Status
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h5 class="section-title"><i class="fas fa-paperclip"></i> Additional Information</h5>
                        <div class="mb-4">
                            <label for="documents" class="form-label">
                                <i class="fas fa-file-upload"></i> Supporting Documents (Optional)
                            </label>
                            <input type="file" class="form-control @error('documents') is-invalid @enderror" 
                                id="documents" name="documents" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i> Accepted formats: PDF, DOC, DOCX, JPG, PNG. Max size: 5MB
                            </div>
                            @error('documents')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="form-label">
                                <i class="fas fa-sticky-note"></i> Notes (Optional)
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" 
                                name="notes" rows="4" placeholder="Add any additional notes about this application">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4 pt-3">
                        <a href="{{ route('applications.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i> Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© 2023 SwiftSolve Academy. All rights reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize student search
            const studentSearch = new TomSelect('#student_search', {
                valueField: 'id',
                labelField: 'name',
                searchField: ['name', 'email'],
                create: false,
                maxOptions: 10,
                render: {
                    option: function(data, escape) {
                        return `
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-semibold">${escape(data.name)}</span>
                                    <br>
                                    <small class="text-muted">${escape(data.email)}</small>
                                </div>
                                <span class="badge bg-orange">Student</span>
                            </div>
                        `;
                    },
                    item: function(data, escape) {
                        return `<div>${escape(data.name)} (${escape(data.email)})</div>`;
                    }
                }
            });

            // Initialize program search with create option
            const programSearch = new TomSelect('#program_search', {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                create: function(input, callback) {
                    callback({
                        id: 'new_' + Date.now(),
                        name: input,
                        isNew: true
                    });
                },
                maxOptions: 10,
                render: {
                    option: function(data, escape) {
                        if (data.isNew) {
                            return `<div><i class="fas fa-plus me-2"></i> Create new: <strong>${escape(data.name)}</strong></div>`;
                        }
                        return `<div>${escape(data.name)}</div>`;
                    },
                    item: function(data, escape) {
                        return `<div>${escape(data.name)}</div>`;
                    }
                },
                onInitialize: function() {
                    // Add existing programs
                    const programs = @json($programs->map(fn($program) => ['id' => $program->id, 'name' => $program->name]));
                    programs.forEach(program => {
                        this.addOption(program);
                    });
                    
                    // Set initial value if exists
                    @if(old('program_id'))
                        this.setValue(@json(old('program_id')));
                    @endif
                }
            });

            // Toggle manual program input
            document.getElementById('toggleProgramInput').addEventListener('click', function(e) {
                e.preventDefault();
                const manualInput = document.getElementById('manualProgramInput');
                if (manualInput.style.display === 'none') {
                    manualInput.style.display = 'block';
                    programSearch.disable();
                } else {
                    manualInput.style.display = 'none';
                    programSearch.enable();
                }
            });

            // Form validation for manual program input
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const programSelect = document.getElementById('program_search');
                const manualInput = document.getElementById('new_program_name');
                
                // If manual input is visible and has value, clear the program select
                if (manualInput.style.display !== 'none' && manualInput.value.trim() !== '') {
                    programSelect.value = '';
                }
            });

            // Validate file size before upload
            const fileInput = document.getElementById('documents');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file && file.size > 5 * 1024 * 1024) { // 5MB limit
                        alert('File size must be less than 5MB');
                        this.value = '';
                    }
                });
            }

            // Add subtle animation to form elements on focus
            const formControls = document.querySelectorAll('.form-control, .form-select, .ts-control');
            
            formControls.forEach(control => {
                control.addEventListener('focus', function() {
                    this.parentElement.classList.add('shadow-sm');
                });
                
                control.addEventListener('blur', function() {
                    this.parentElement.classList.remove('shadow-sm');
                });
            });
        });
    </script>
</body>
</html>