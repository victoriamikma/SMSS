@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">
                            <i class="fas fa-exchange-alt"></i> New Library Transaction
                        </h2>
                        <a href="{{ route('library.transactions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Transactions
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('library.transactions.store') }}" method="POST" id="transactionForm">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="book_id" class="form-label">Book *</label>
                                <select class="form-select @error('book_id') is-invalid @enderror" id="book_id" name="book_id" required>
                                    <option value="">Select a Book</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                            {{ $book->title }} by {{ $book->author }} (ISBN: {{ $book->isbn }}, Available: {{ $book->available_copies }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('book_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="borrower_type" class="form-label">Borrower Type *</label>
                                <select class="form-select @error('borrower_type') is-invalid @enderror" id="borrower_type" name="borrower_type" required>
                                    <option value="">Select Borrower Type</option>
                                    <option value="student" {{ old('borrower_type') == 'student' ? 'selected' : '' }}>Student</option>
                                    <option value="staff" {{ old('borrower_type') == 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="external" {{ old('borrower_type') == 'external' ? 'selected' : '' }}>External</option>
                                </select>
                                @error('borrower_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="student-field" style="display: none;">
                            <div class="col-md-12">
                                <label for="student_id" class="form-label">Student *</label>
                                <select class="form-select student-search @error('student_id') is-invalid @enderror" id="student_id" name="student_id">
                                    <option value="">Select a Student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->id ?? 'N/A' }} | {{ $student->first_name }} {{ $student->last_name }} | {{ $student->class->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="staff-field" style="display: none;">
                            <div class="col-md-12">
                                <label for="staff_id" class="form-label">Staff *</label>
                                <select class="form-select staff-search @error('staff_id') is-invalid @enderror" id="staff_id" name="staff_id">
                                    <option value="">Select a Staff Member</option>
                                    @foreach($staff as $staffMember)
                                        <option value="{{ $staffMember->id }}" {{ old('staff_id') == $staffMember->id ? 'selected' : '' }}>
                                            {{ $staffMember->id ?? 'N/A' }} | {{ $staffMember->first_name }} {{ $staffMember->last_name }} | {{ $staffMember->position ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('staff_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="external-field" style="display: none;">
                            <div class="col-md-12">
                                <label for="external_borrower" class="form-label">External Borrower Name *</label>
                                <input type="text" class="form-control @error('external_borrower') is-invalid @enderror" 
                                       id="external_borrower" name="external_borrower" 
                                       value="{{ old('external_borrower') }}" 
                                       placeholder="Enter external borrower's full name">
                                @error('external_borrower')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="borrowed_date" class="form-label">Borrowed Date *</label>
                                <input type="date" class="form-control @error('borrowed_date') is-invalid @enderror" 
                                       id="borrowed_date" name="borrowed_date" 
                                       value="{{ old('borrowed_date', date('Y-m-d')) }}" required>
                                @error('borrowed_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="due_date" class="form-label">Due Date *</label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                       id="due_date" name="due_date" 
                                       value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="3" 
                                          placeholder="Any additional notes about this transaction">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Transaction
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const borrowerType = document.getElementById('borrower_type');
    const studentField = document.getElementById('student-field');
    const staffField = document.getElementById('staff-field');
    const externalField = document.getElementById('external-field');
    const studentSelect = document.getElementById('student_id');
    const staffSelect = document.getElementById('staff_id');
    const externalInput = document.getElementById('external_borrower');
    const form = document.getElementById('transactionForm');

    // Initialize Select2 for student and staff dropdowns
    function initializeSelect2() {
        // Initialize student dropdown
        if ($('.student-search').length) {
            $('.student-search').select2({
                placeholder: "Search for a student...",
                allowClear: true,
                width: '100%',
                dropdownParent: studentField,
                minimumInputLength: 1,
                theme: 'bootstrap-5'
            });
        }

        // Initialize staff dropdown
        if ($('.staff-search').length) {
            $('.staff-search').select2({
                placeholder: "Search for a staff member...",
                allowClear: true,
                width: '100%',
                dropdownParent: staffField,
                minimumInputLength: 1,
                theme: 'bootstrap-5'
            });
        }
    }

    function updateBorrowerFields() {
        // Hide all fields first
        studentField.style.display = 'none';
        staffField.style.display = 'none';
        externalField.style.display = 'none';
        
        // Remove required attributes
        studentSelect.required = false;
        staffSelect.required = false;
        externalInput.required = false;

        // Show relevant field based on selection
        if (borrowerType.value === 'student') {
            studentField.style.display = 'block';
            studentSelect.required = true;
            
            // Initialize Select2 for student dropdown when it becomes visible
            setTimeout(() => {
                if (!$('.student-search').hasClass('select2-hidden-accessible')) {
                    $('.student-search').select2({
                        placeholder: "Search for a student...",
                        allowClear: true,
                        width: '100%',
                        dropdownParent: studentField,
                        minimumInputLength: 1,
                        theme: 'bootstrap-5'
                    });
                }
            }, 100);
            
        } else if (borrowerType.value === 'staff') {
            staffField.style.display = 'block';
            staffSelect.required = true;
            
            // Initialize Select2 for staff dropdown when it becomes visible
            setTimeout(() => {
                if (!$('.staff-search').hasClass('select2-hidden-accessible')) {
                    $('.staff-search').select2({
                        placeholder: "Search for a staff member...",
                        allowClear: true,
                        width: '100%',
                        dropdownParent: staffField,
                        minimumInputLength: 1,
                        theme: 'bootstrap-5'
                    });
                }
            }, 100);
            
        } else if (borrowerType.value === 'external') {
            externalField.style.display = 'block';
            externalInput.required = true;
        }
    }

    // Initialize borrower fields
    borrowerType.addEventListener('change', updateBorrowerFields);
    updateBorrowerFields(); // Initialize on page load

    // Form validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        let errorMessage = '';

        // Check if book is selected
        const bookId = document.getElementById('book_id').value;
        if (!bookId) {
            isValid = false;
            errorMessage += 'Please select a book.\n';
        }

        // Check borrower type selection
        const borrowerTypeValue = borrowerType.value;
        if (!borrowerTypeValue) {
            isValid = false;
            errorMessage += 'Please select a borrower type.\n';
        }

        // Check specific borrower field based on type
        if (borrowerTypeValue === 'student' && !studentSelect.value) {
            isValid = false;
            errorMessage += 'Please select a student.\n';
        } else if (borrowerTypeValue === 'staff' && !staffSelect.value) {
            isValid = false;
            errorMessage += 'Please select a staff member.\n';
        } else if (borrowerTypeValue === 'external' && !externalInput.value.trim()) {
            isValid = false;
            errorMessage += 'Please enter external borrower name.\n';
        }

        // Check dates
        const borrowedDate = new Date(document.getElementById('borrowed_date').value);
        const dueDate = new Date(document.getElementById('due_date').value);
        
        if (dueDate <= borrowedDate) {
            isValid = false;
            errorMessage += 'Due date must be after borrowed date.\n';
        }

        if (!isValid) {
            e.preventDefault();
            alert('Please fix the following errors:\n' + errorMessage);
        }
    });

    // Handle form reset - destroy Select2 and reinitialize
    document.querySelector('button[type="reset"]').addEventListener('click', function() {
        setTimeout(() => {
            // Destroy Select2 instances
            if ($('.student-search').hasClass('select2-hidden-accessible')) {
                $('.student-search').select2('destroy');
            }
            if ($('.staff-search').hasClass('select2-hidden-accessible')) {
                $('.staff-search').select2('destroy');
            }
            
            updateBorrowerFields();
        }, 100);
    });

    // Focus search field when dropdown opens
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
});
</script>

<style>
.select2-container--bootstrap-5 .select2-selection {
    min-height: 38px;
    padding: 4px 8px;
}

.select2-container--bootstrap-5 .select2-selection--single {
    height: 38px;
}

.select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
    line-height: 30px;
}

.select2-container--bootstrap-5 .select2-dropdown {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
}

.select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
}

.select2-container--bootstrap-5 .select2-results__option {
    padding: 8px 12px;
}

.select2-container--bootstrap-5 .select2-results__option--highlighted {
    background-color: #0d6efd;
    color: white;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.invalid-feedback {
    display: block;
    font-size: 0.875rem;
}
</style>
@endsection