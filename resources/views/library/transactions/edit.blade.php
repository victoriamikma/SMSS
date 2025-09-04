@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">
                            <i class="fas fa-edit"></i> Edit Transaction
                        </h2>
                        <div>
                            <a href="{{ route('library.transactions.show', $transaction->id) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <a href="{{ route('library.transactions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Transactions
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('library.transactions.update', $transaction->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Transaction Information -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Transaction Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="issued_at" class="form-label">Borrowed Date *</label>
                                        <input type="date" class="form-control @error('issued_at') is-invalid @enderror" 
                                               id="issued_at" name="issued_at" 
                                               value="{{ old('issued_at', $transaction->issued_at ? $transaction->issued_at->format('Y-m-d') : '') }}" required>
                                        @error('issued_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="due_date" class="form-label">Due Date *</label>
                                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                               id="due_date" name="due_date" 
                                               value="{{ old('due_date', $transaction->due_date ? $transaction->due_date->format('Y-m-d') : '') }}" required>
                                        @error('due_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                @if($transaction->returned_at)
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="returned_at" class="form-label">Returned Date</label>
                                        <input type="date" class="form-control @error('returned_at') is-invalid @enderror" 
                                               id="returned_at" name="returned_at" 
                                               value="{{ old('returned_at', $transaction->returned_at ? $transaction->returned_at->format('Y-m-d') : '') }}">
                                        @error('returned_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Book Information (Read-only) -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Book Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Book:</label>
                                            <p class="form-control-plaintext">
                                                @if($transaction->book)
                                                    {{ $transaction->book->title }} by {{ $transaction->book->author }} (ISBN: {{ $transaction->book->isbn }})
                                                @else
                                                    <span class="text-muted">Book deleted</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Borrower Information (Read-only) -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Borrower Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Borrower Type:</label>
                                            <p class="form-control-plaintext text-capitalize">
                                                {{ $transaction->borrower_type }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Borrower Name:</label>
                                            <p class="form-control-plaintext">
                                                @if($transaction->borrower_type === 'student' && $transaction->student)
                                                    {{ $transaction->student->first_name }} {{ $transaction->student->last_name }} (Student)
                                                @elseif($transaction->borrower_type === 'staff' && $transaction->staff)
                                                    {{ $transaction->staff->first_name }} {{ $transaction->staff->last_name }} (Staff)
                                                @elseif($transaction->borrower_type === 'external')
                                                    {{ $transaction->external_borrower }} (External)
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Notes</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3" 
                                              placeholder="Any additional notes about this transaction">{{ old('notes', $transaction->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status">
                                        <option value="borrowed" {{ old('status', $transaction->status) == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                                        <option value="returned" {{ old('status', $transaction->status) == 'returned' ? 'selected' : '' }}>Returned</option>
                                        <option value="overdue" {{ old('status', $transaction->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Transaction
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date validation
    const issuedDateInput = document.getElementById('issued_at');
    const dueDateInput = document.getElementById('due_date');
    const returnedDateInput = document.getElementById('returned_at');

    function validateDates() {
        const issuedDate = new Date(issuedDateInput.value);
        const dueDate = new Date(dueDateInput.value);
        const returnedDate = returnedDateInput ? new Date(returnedDateInput.value) : null;

        if (dueDate <= issuedDate) {
            dueDateInput.setCustomValidity('Due date must be after borrowed date');
        } else {
            dueDateInput.setCustomValidity('');
        }

        if (returnedDate && returnedDate < issuedDate) {
            returnedDateInput.setCustomValidity('Returned date cannot be before borrowed date');
        } else if (returnedDateInput) {
            returnedDateInput.setCustomValidity('');
        }
    }

    issuedDateInput.addEventListener('change', validateDates);
    dueDateInput.addEventListener('change', validateDates);
    if (returnedDateInput) {
        returnedDateInput.addEventListener('change', validateDates);
    }

    // Initial validation
    validateDates();
});
</script>

<style>
.form-control-plaintext {
    padding: 0.375rem 0;
    margin-bottom: 0;
    line-height: 1.5;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
}

.card-header.bg-light {
    background-color: #f8f9fa !important;
}

.btn {
    min-width: 120px;
}
</style>
@endsection