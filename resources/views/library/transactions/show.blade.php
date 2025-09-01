@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">
                            <i class="fas fa-exchange-alt"></i> Transaction Details
                        </h2>
                        <div>
                            <a href="{{ route('library.transactions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Transactions
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Transaction Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Transaction Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Transaction ID:</label>
                                        <p class="form-control-plaintext">#{{ $transaction->id }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status:</label>
                                        <p class="form-control-plaintext">
                                            @if($transaction->returned_at)
                                                <span class="badge bg-success">Returned</span>
                                            @elseif($transaction->due_date && $transaction->due_date < now())
                                                <span class="badge bg-danger">Overdue</span>
                                            @else
                                                <span class="badge bg-warning">Borrowed</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Borrowed Date:</label>
                                        <p class="form-control-plaintext">
                                            @if($transaction->issued_at)
                                                {{ $transaction->issued_at->format('M d, Y') }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Due Date:</label>
                                        <p class="form-control-plaintext">
                                            @if($transaction->due_date)
                                                {{ $transaction->due_date->format('M d, Y') }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($transaction->returned_at)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Returned Date:</label>
                                        <p class="form-control-plaintext">
                                            {{ $transaction->returned_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Days Borrowed:</label>
                                        <p class="form-control-plaintext">
                                            {{ $transaction->issued_at->diffInDays($transaction->returned_at) }} days
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Book Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Book Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Book Title:</label>
                                        <p class="form-control-plaintext">
                                            @if($transaction->book)
                                                {{ $transaction->book->title }}
                                            @else
                                                <span class="text-muted">Book deleted</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Author:</label>
                                        <p class="form-control-plaintext">
                                            @if($transaction->book)
                                                {{ $transaction->book->author }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">ISBN:</label>
                                        <p class="form-control-plaintext">
                                            @if($transaction->book)
                                                {{ $transaction->book->isbn }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Category:</label>
                                        <p class="form-control-plaintext">
                                            @if($transaction->book && $transaction->book->category)
                                                {{ $transaction->book->category->name }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Borrower Information -->
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
                                                {{ $transaction->student->first_name }} {{ $transaction->student->last_name }}
                                            @elseif($transaction->borrower_type === 'staff' && $transaction->staff)
                                                {{ $transaction->staff->first_name }} {{ $transaction->staff->last_name }}
                                            @elseif($transaction->borrower_type === 'external')
                                                {{ $transaction->external_borrower }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($transaction->borrower_type === 'student' && $transaction->student)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Student ID:</label>
                                        <p class="form-control-plaintext">{{ $transaction->student->id }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Class:</label>
                                        <p class="form-control-plaintext">
                                            {{ $transaction->student->class->name ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($transaction->borrower_type === 'staff' && $transaction->staff)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Staff ID:</label>
                                        <p class="form-control-plaintext">{{ $transaction->staff->id }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Position:</label>
                                        <p class="form-control-plaintext">
                                            {{ $transaction->staff->position ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($transaction->notes)
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Notes</h5>
                        </div>
                        <div class="card-body">
                            <p class="form-control-plaintext">{{ $transaction->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if(!$transaction->returned_at)
                            <form action="{{ route('library.transactions.return', $transaction->id) }}" method="POST" class="me-md-2">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Mark this book as returned?')">
                                    <i class="fas fa-check"></i> Mark as Returned
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('library.transactions.edit', $transaction->id) }}" class="btn btn-primary me-md-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        
                        <form action="{{ route('library.transactions.destroy', $transaction->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this transaction?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

.badge {
    font-size: 0.875em;
}

.btn {
    min-width: 120px;
}
</style>
@endsection