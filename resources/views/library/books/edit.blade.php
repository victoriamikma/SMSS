@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">
                            <i class="fas fa-edit"></i> Edit Book
                        </h2>
                        <div>
                            <a href="{{ route('library.books.show', $book->id) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <a href="{{ route('library.books.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Books
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('library.books.update', $book->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $book->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="author" class="form-label">Author *</label>
                                    <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                           id="author" name="author" value="{{ old('author', $book->author) }}" required>
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
                                           id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" required>
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
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
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
                                           id="total_copies" name="total_copies" 
                                           value="{{ old('total_copies', $book->total_copies) }}" min="1" required>
                                    @error('total_copies')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="available_copies" class="form-label">Available Copies *</label>
                                    <input type="number" class="form-control @error('available_copies') is-invalid @enderror" 
                                           id="available_copies" name="available_copies" 
                                           value="{{ old('available_copies', $book->available_copies) }}" min="0" required>
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
                                           value="{{ old('publication_year', $book->publication_year) }}" 
                                           min="1900" max="{{ date('Y') }}">
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
                                           id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}">
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
                                        <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="maintenance" {{ old('status', $book->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="lost" {{ old('status', $book->status) == 'lost' ? 'selected' : '' }}>Lost</option>
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
                                      id="description" name="description" rows="4">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Book
                            </button>
                        </div>
                    </form>

                    <!-- Additional Information -->
                    <div class="mt-5 pt-4 border-top">
                        <h5 class="mb-3">Book Statistics</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Total Copies</h6>
                                        <h3 class="text-primary">{{ $book->total_copies }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Available</h6>
                                        <h3 class="text-success">{{ $book->available_copies }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Borrowed</h6>
                                        <h3 class="text-warning">{{ $book->total_copies - $book->available_copies }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Transactions</h6>
                                        <h3 class="text-info">{{ $book->transactions_count ?? 0 }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

    // Initial validation
    validateCopies();
});

function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        document.querySelector('form').reset();
    }
}
</script>

<style>
.card.bg-light {
    background-color: #f8f9fa !important;
    border: 1px solid #dee2e6;
}

.card-title {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.text-primary { color: #0d6efd !important; }
.text-success { color: #198754 !important; }
.text-warning { color: #ffc107 !important; }
.text-info { color: #0dcaf0 !important; }

.invalid-feedback {
    display: block;
}

.form-label {
    font-weight: 500;
    color: #495057;
}
</style>
@endsection