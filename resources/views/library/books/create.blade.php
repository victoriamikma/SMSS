@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">
                            <i class="fas fa-book"></i> Add New Book
                        </h2>
                        <div>
                            <a href="{{ route('library.books.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Books
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs" id="bookTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="single-tab" data-bs-toggle="tab" data-bs-target="#single" type="button" role="tab" aria-controls="single" aria-selected="true">
                                <i class="fas fa-plus"></i> Single Book
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bulk-tab" data-bs-toggle="tab" data-bs-target="#bulk" type="button" role="tab" aria-controls="bulk" aria-selected="false">
                                <i class="fas fa-upload"></i> Bulk Import
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="bookTabsContent">
                        <!-- Single Book Tab -->
                        <div class="tab-pane fade show active" id="single" role="tabpanel" aria-labelledby="single-tab">
                            <form action="{{ route('library.books.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title *</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                                   id="title" name="title" value="{{ old('title') }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="author" class="form-label">Author *</label>
                                            <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                                   id="author" name="author" value="{{ old('author') }}" required>
                                            @error('author')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="isbn" class="form-label">ISBN *</label>
                                            <input type="text" class="form-control @error('isbn') is-invalid @enderror" 
                                                   id="isbn" name="isbn" value="{{ old('isbn') }}" required>
                                            @error('isbn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Category *</label>
                                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                                    id="category_id" name="category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="total_copies" class="form-label">Total Copies *</label>
                                            <input type="number" class="form-control @error('total_copies') is-invalid @enderror" 
                                                   id="total_copies" name="total_copies" value="{{ old('total_copies', 1) }}" min="1" required>
                                            @error('total_copies')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="available_copies" class="form-label">Available Copies *</label>
                                            <input type="number" class="form-control @error('available_copies') is-invalid @enderror" 
                                                   id="available_copies" name="available_copies" value="{{ old('available_copies', 1) }}" min="0" required>
                                            @error('available_copies')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="publication_year" class="form-label">Publication Year</label>
                                            <input type="number" class="form-control @error('publication_year') is-invalid @enderror" 
                                                   id="publication_year" name="publication_year" 
                                                   value="{{ old('publication_year') }}" min="1900" max="{{ date('Y') }}">
                                            @error('publication_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="publisher" class="form-label">Publisher</label>
                                            <input type="text" class="form-control @error('publisher') is-invalid @enderror" 
                                                   id="publisher" name="publisher" value="{{ old('publisher') }}">
                                            @error('publisher')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" name="status">
                                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                <option value="lost" {{ old('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Add Book
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Bulk Import Tab -->
                        <div class="tab-pane fade" id="bulk" role="tabpanel" aria-labelledby="bulk-tab">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 
                                <strong>Bulk Import Instructions:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Download the template file to ensure proper formatting</li>
                                    <li>Supported formats: CSV, Excel (.xlsx, .xls)</li>
                                    <li>Maximum file size: 10MB</li>
                                    <li>Required columns: Title, Author, ISBN, Category ID, Total Copies</li>
                                </ul>
                            </div>

                            <form action="{{ route('library.books.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="import_file" class="form-label">Select File *</label>
                                            <input type="file" class="form-control @error('import_file') is-invalid @enderror" 
                                                   id="import_file" name="import_file" accept=".csv,.xlsx,.xls" required>
                                            @error('import_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="file_format" class="form-label">File Format *</label>
                                            <select class="form-select @error('file_format') is-invalid @enderror" 
                                                    id="file_format" name="file_format" required>
                                                <option value="csv">CSV</option>
                                                <option value="excel">Excel</option>
                                            </select>
                                            @error('file_format')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="has_headers" name="has_headers" checked>
                                        <label class="form-check-label" for="has_headers">
                                            File contains headers (first row is column names)
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="update_existing" name="update_existing">
                                        <label class="form-check-label" for="update_existing">
                                            Update existing books if ISBN matches
                                        </label>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <a href="{{ route('library.books.template') }}" class="btn btn-outline-primary me-2">
                                        <i class="fas fa-download"></i> Download Template
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-upload"></i> Import Books
                                    </button>
                                </div>
                            </form>

                            <!-- Preview Table (will be populated via JavaScript) -->
                            <div id="file-preview" class="mt-4" style="display: none;">
                                <h5>File Preview (First 5 rows)</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm" id="preview-table">
                                        <thead>
                                            <tr id="preview-headers"></tr>
                                        </thead>
                                        <tbody id="preview-body"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS (if not already included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Include SheetJS for Excel file parsing -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const importFileInput = document.getElementById('import_file');
    const filePreview = document.getElementById('file-preview');
    const previewHeaders = document.getElementById('preview-headers');
    const previewBody = document.getElementById('preview-body');
    const fileFormatSelect = document.getElementById('file_format');

    importFileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const format = fileFormatSelect.value;
        
        if (format === 'csv') {
            previewCSV(file);
        } else if (format === 'excel') {
            previewExcel(file);
        }
    });

    fileFormatSelect.addEventListener('change', function() {
        if (importFileInput.files.length > 0) {
            importFileInput.dispatchEvent(new Event('change'));
        }
    });

    function previewCSV(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const csvData = e.target.result;
            const lines = csvData.split('\n').slice(0, 6); // Get first 6 lines (header + 5 rows)
            
            displayPreview(lines);
        };
        reader.readAsText(file);
    }

    function previewExcel(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            const jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });
            
            // Get first 6 rows
            const previewData = jsonData.slice(0, 6);
            displayPreview(previewData);
        };
        reader.readAsArrayBuffer(file);
    }

    function displayPreview(data) {
        previewHeaders.innerHTML = '';
        previewBody.innerHTML = '';

        if (data.length === 0) {
            filePreview.style.display = 'none';
            return;
        }

        // Headers
        const headers = data[0];
        headers.forEach(header => {
            const th = document.createElement('th');
            th.textContent = header;
            previewHeaders.appendChild(th);
        });

        // Rows (skip header if has_headers is checked)
        const hasHeaders = document.getElementById('has_headers').checked;
        const startRow = hasHeaders ? 1 : 0;
        
        for (let i = startRow; i < Math.min(data.length, 6); i++) {
            const row = data[i];
            const tr = document.createElement('tr');
            
            row.forEach(cell => {
                const td = document.createElement('td');
                td.textContent = cell;
                tr.appendChild(td);
            });
            
            previewBody.appendChild(tr);
        }

        filePreview.style.display = 'block';
    }

    // Validate available copies doesn't exceed total copies
    const totalCopiesInput = document.getElementById('total_copies');
    const availableCopiesInput = document.getElementById('available_copies');

    totalCopiesInput.addEventListener('change', validateCopies);
    availableCopiesInput.addEventListener('change', validateCopies);

    function validateCopies() {
        const total = parseInt(totalCopiesInput.value);
        const available = parseInt(availableCopiesInput.value);
        
        if (available > total) {
            availableCopiesInput.setCustomValidity('Available copies cannot exceed total copies');
        } else {
            availableCopiesInput.setCustomValidity('');
        }
    }
});
</script>

<style>
.nav-tabs .nav-link {
    color: #6c757d;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    font-weight: 600;
}

#file-preview {
    max-height: 300px;
    overflow-y: auto;
}

#preview-table {
    font-size: 0.875rem;
}

#preview-table th, #preview-table td {
    padding: 0.5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
}
</style>
@endsection