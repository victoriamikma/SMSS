@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">
                            <i class="fas fa-book"></i> Book Details
                        </h2>
                        <div>
                            <a href="{{ route('library.books.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Books
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Book Information -->
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Book Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Title:</label>
                                                <p class="form-control-plaintext">{{ $book->title }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Author:</label>
                                                <p class="form-control-plaintext">{{ $book->author }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">ISBN:</label>
                                                <p class="form-control-plaintext">{{ $book->isbn }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Category:</label>
                                                <p class="form-control-plaintext">
                                                    {{ $book->category->name ?? 'Uncategorized' }}
                                                    @if($book->category && $book->category->color_code)
                                                        <span class="badge" style="background-color: {{ $book->category->color_code ?? '#6c757d' }}; color: white;">
                                                            {{ $book->category->name }}
                                                        </span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Total Copies:</label>
                                                <p class="form-control-plaintext">{{ $book->total_copies }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Available Copies:</label>
                                                <p class="form-control-plaintext">{{ $book->available_copies }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Status:</label>
                                                <p class="form-control-plaintext">
                                                    <span class="badge bg-{{ $book->status == 'available' ? 'success' : ($book->status == 'maintenance' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($book->status) }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Publication Year:</label>
                                                <p class="form-control-plaintext">{{ $book->publication_year ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Publisher:</label>
                                                <p class="form-control-plaintext">{{ $book->publisher ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Description:</label>
                                        <div class="border rounded p-3 bg-light">
                                            {{ $book->description ?? 'No description available.' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions & Statistics -->
                        <div class="col-md-4">
                            <!-- Action Buttons -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('library.books.edit', $book->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit Book
                                        </a>
                                        <form action="{{ route('library.books.destroy', $book->id) }}" method="POST" class="d-grid">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">
                                                <i class="fas fa-trash"></i> Delete Book
                                            </button>
                                        </form>
                                        <a href="{{ route('library.transactions.create') }}?book_id={{ $book->id }}" class="btn btn-success">
                                            <i class="fas fa-exchange-alt"></i> Issue Book
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Statistics</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Borrowed Copies:</label>
                                        <p class="form-control-plaintext">{{ $book->total_copies - $book->available_copies }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Availability Rate:</label>
                                        <div class="progress mb-2">
                                            @php
                                                $availabilityRate = $book->total_copies > 0 ? ($book->available_copies / $book->total_copies) * 100 : 0;
                                                $progressClass = $availabilityRate >= 50 ? 'bg-success' : ($availabilityRate >= 25 ? 'bg-warning' : 'bg-danger');
                                            @endphp
                                            <div class="progress-bar {{ $progressClass }}" role="progressbar" 
                                                 style="width: {{ $availabilityRate }}%" 
                                                 aria-valuenow="{{ $availabilityRate }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ round($availabilityRate) }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Total Transactions:</label>
                                        <p class="form-control-plaintext">{{ $book->transactions->count() }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Active Loans:</label>
                                        <p class="form-control-plaintext">
                                            {{ $book->transactions->whereNull('returned_at')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction History -->
                    <div class="card mt-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Transaction History</h5>
                        </div>
                        <div class="card-body">
                            @if($book->transactions->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Borrower</th>
                                                <th>Issued Date</th>
                                                <th>Due Date</th>
                                                <th>Returned Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($book->transactions as $transaction)
                                                <tr>
                                                    <td>{{ $transaction->borrower_name ?? 'Unknown' }}</td>
                                                    <td>{{ $transaction->issued_at->format('M d, Y') }}</td>
                                                    <td>{{ $transaction->due_date->format('M d, Y') }}</td>
                                                    <td>
                                                        @if($transaction->returned_at)
                                                            {{ $transaction->returned_at->format('M d, Y') }}
                                                        @else
                                                            <span class="text-muted">Not returned</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($transaction->returned_at)
                                                            <span class="badge bg-success">Returned</span>
                                                        @elseif($transaction->due_date->isPast())
                                                            <span class="badge bg-danger">Overdue</span>
                                                        @else
                                                            <span class="badge bg-warning">Active</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('library.transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-history fa-3x mb-3"></i>
                                    <p>No transaction history found for this book.</p>
                                </div>
                            @endif
                        </div>
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

.progress {
    height: 20px;
}

.badge {
    font-size: 0.75em;
}
</style>
@endsection