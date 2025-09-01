<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Import Applications - SwiftSolve</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            margin-bottom: 2rem;
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
            margin: 0 auto;
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

        .alert-info {
            background-color: #E6F4FF;
            border: 1px solid #B8D9F8;
            color: #2E5AAC;
            border-radius: 12px;
            padding: 1.25rem;
        }

        .alert-info h5 {
            color: #2E5AAC;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

        .btn-outline-primary {
            border: 2px solid var(--primary-orange);
            color: var(--primary-orange);
            background: transparent;
            border-radius: 8px;
            padding: 0.85rem 2rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-outline-primary:hover {
            background: var(--primary-orange);
            color: white;
        }

        /* Upload Area Styles */
        .upload-area {
            border: 2px dashed var(--medium-gray);
            border-radius: var(--border-radius);
            padding: 3rem 2rem;
            text-align: center;
            background-color: var(--light-gray);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
        }

        .upload-area.drag-over {
            border-color: var(--primary-orange);
            background-color: var(--light-orange);
            box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.1);
        }

        .upload-area.has-file {
            border-color: var(--primary-orange);
            background-color: rgba(255, 107, 0, 0.05);
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--primary-orange);
            margin-bottom: 1rem;
        }

        .file-input {
            display: none;
        }

        .file-name {
            margin-top: 1rem;
            font-weight: 600;
            color: var(--primary-orange);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .file-requirements {
            background-color: var(--light-gray);
            border-left: 4px solid var(--primary-orange);
            padding: 1rem 1.5rem;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            margin-top: 1.5rem;
        }

        .instructions-list {
            background-color: var(--light-gray);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .instructions-list h6 {
            color: var(--primary-orange);
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .instructions-list ul {
            margin-bottom: 0;
            padding-left: 1.5rem;
        }

        .instructions-list li {
            margin-bottom: 0.5rem;
            color: var(--dark-gray);
        }

        .form-text {
            color: var(--dark-gray);
            font-size: 0.85rem;
            margin-top: 0.5rem;
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
            
            .upload-area {
                padding: 2rem 1rem;
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

        /* Progress bar */
        .progress {
            height: 8px;
            border-radius: 4px;
            margin: 1rem 0;
            background-color: var(--light-gray);
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(120deg, var(--primary-orange), var(--secondary-orange));
            transition: width 0.3s ease;
        }

        .upload-status {
            text-align: center;
            color: var(--primary-orange);
            font-weight: 600;
            margin-top: 1rem;
        }

        /* File type indicators */
        .file-type-badge {
            background-color: var(--primary-orange);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-left: 0.5rem;
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
                <i class="fas fa-file-import"></i> Bulk Import Applications
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h5><i class="fas fa-info-circle"></i> Import Instructions</h5>
                    <p class="mb-2">Download the template file, fill in your application data, and upload it here.</p>
                    <p class="mb-0"><strong>Required columns:</strong> student_name, student_email, program_code, application_date</p>
                </div>

                <form action="{{ route('applications.import.process') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label">Select Excel File</label>
                        
                        <div class="upload-area" id="uploadArea">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h5>Drag & Drop your file here</h5>
                            <p class="text-muted">or click to browse your files</p>
                            <input type="file" class="file-input" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                            <div class="file-name" id="fileName"></div>
                            <div class="progress" id="progressContainer" style="display: none;">
                                <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <div class="upload-status" id="uploadStatus"></div>
                        </div>
                        
                        @error('file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        
                        <div class="file-requirements">
                            <strong>File requirements:</strong>
                            <ul class="mb-0 mt-1">
                                <li>Accepted formats: XLSX, XLS, CSV</li>
                                <li>Maximum file size: 10MB</li>
                                <li>First row should contain column headers</li>
                                <li>Ensure data follows the template format</li>
                            </ul>
                        </div>
                    </div>

                    <div class="instructions-list">
                        <h6><i class="fas fa-lightbulb"></i> Important Notes</h6>
                        <ul>
                            <li>Ensure all required fields are filled in correctly</li>
                            <li>Dates should be in YYYY-MM-DD format</li>
                            <li>Email addresses must be valid and unique</li>
                            <li>Program codes must match existing programs in the system</li>
                            <li>Invalid records will be skipped during import</li>
                            <li>You'll receive a summary report after import completion</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('applications.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back to Applications
                        </a>
                        <div>
                            <a href="{{ route('applications.template') }}" class="btn btn-outline-primary me-2">
                                <i class="fas fa-download me-2"></i> Download Template
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitButton">
                                <i class="fas fa-upload me-2"></i> Import Applications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file');
            const fileName = document.getElementById('fileName');
            const uploadArea = document.getElementById('uploadArea');
            const submitButton = document.getElementById('submitButton');
            const importForm = document.getElementById('importForm');
            const progressBar = document.getElementById('progressBar');
            const progressContainer = document.getElementById('progressContainer');
            const uploadStatus = document.getElementById('uploadStatus');
            
            // File input change event
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    const fileExtension = file.name.split('.').pop().toUpperCase();
                    
                    fileName.innerHTML = `
                        <i class="fas fa-file-excel" style="color: #21a366;"></i>
                        ${file.name} 
                        <span class="file-type-badge">${fileExtension}</span>
                        <span style="color: var(--dark-gray); font-size: 0.9rem;">(${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
                    `;
                    
                    uploadArea.classList.add('has-file');
                    validateFile(file);
                }
            });
            
            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('drag-over');
            });
            
            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
            });
            
            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
                
                if (e.dataTransfer.files.length) {
                    const file = e.dataTransfer.files[0];
                    fileInput.files = e.dataTransfer.files;
                    
                    const fileExtension = file.name.split('.').pop().toUpperCase();
                    
                    fileName.innerHTML = `
                        <i class="fas fa-file-excel" style="color: #21a366;"></i>
                        ${file.name} 
                        <span class="file-type-badge">${fileExtension}</span>
                        <span style="color: var(--dark-gray); font-size: 0.9rem;">(${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
                    `;
                    
                    uploadArea.classList.add('has-file');
                    validateFile(file);
                }
            });
            
            // Click on upload area to trigger file input
            uploadArea.addEventListener('click', function(e) {
                // Only trigger if the click wasn't on a child element that has its own handler
                if (e.target === uploadArea || e.target.classList.contains('upload-icon') || 
                    e.target.classList.contains('fa-cloud-upload-alt')) {
                    fileInput.click();
                }
            });
            
            // Form submission
            importForm.addEventListener('submit', function(e) {
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Please select a file to import.');
                    return;
                }
                
                const file = fileInput.files[0];
                if (!validateFile(file)) {
                    e.preventDefault();
                    return;
                }
                
                // Show progress UI
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Importing...';
                progressContainer.style.display = 'block';
                uploadStatus.textContent = 'Processing your file...';
                
                // Simulate progress for better UX (real progress would come from server)
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += 5;
                    progressBar.style.width = `${progress}%`;
                    
                    if (progress >= 90) {
                        clearInterval(progressInterval);
                    }
                }, 100);
            });
            
            // File validation
            function validateFile(file) {
                const validExtensions = ['xlsx', 'xls', 'csv'];
                const maxSize = 10 * 1024 * 1024; // 10MB
                const extension = file.name.split('.').pop().toLowerCase();
                
                if (!validExtensions.includes(extension)) {
                    alert('Invalid file type. Please upload an Excel or CSV file.');
                    resetFileInput();
                    return false;
                }
                
                if (file.size > maxSize) {
                    alert('File size exceeds 10MB limit. Please upload a smaller file.');
                    resetFileInput();
                    return false;
                }
                
                return true;
            }
            
            function resetFileInput() {
                fileInput.value = '';
                fileName.textContent = '';
                uploadArea.classList.remove('has-file');
            }
            
            // Prevent drag and drop from redirecting browser
            document.addEventListener('dragover', function(e) {
                e.preventDefault();
            });
            
            document.addEventListener('drop', function(e) {
                e.preventDefault();
            });
        });
    </script>
</body>
</html>