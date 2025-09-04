@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">
                            <i class="fas fa-upload"></i> Bulk Import Books
                        </h2>
                        <div>
                            <a href="{{ route('library.books.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Books
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Bulk Import Instructions:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Download the template file to ensure proper formatting</li>
                            <li>Supported formats: CSV, Excel (.xlsx, .xls)</li>
                            <li>Maximum file size: 10MB</li>
                            <li>Required columns: Title, Author, ISBN, Category ID, Total Copies</li>
                            <li>Optional columns: Available Copies, Publication Year, Publisher, Status, Description</li>
                        </ul>
                    </div>

                    <form action="{{ route('library.books.import.process') }}" method="POST" enctype="multipart/form-data">
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

                    <!-- Categories Reference -->
                    <div class="mt-5">
                        <h5>Available Categories</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Category ID</th>
                                        <th>Category Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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