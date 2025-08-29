@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-6">
            <h1 class="mb-0">
                <i class="fas fa-exchange-alt"></i> Library Transactions
            </h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('library.transactions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Transaction
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Borrower</th>
                            <th>Borrowed Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>
                                @if($transaction->book)
                                    {{ $transaction->book->title }}
                                @else
                                    <span class="text-muted">Book deleted</span>
                                @endif
                            </td>
                            <td>
                                @if($transaction->borrower_type === 'student' && $transaction->student)
                                    {{ $transaction->student->first_name }} {{ $transaction->student->last_name }} (Student)
                                @elseif($transaction->borrower_type === 'staff' && $transaction->staff)
                                    {{ $transaction->staff->first_name }} {{ $transaction->staff->last_name }} (Staff)
                                @elseif($transaction->borrower_type === 'external' && $transaction->external_borrower)
                                    {{ $transaction->external_borrower }} (External)
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($transaction->issued_at)
                                    {{ $transaction->issued_at->format('M d, Y') }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($transaction->due_date)
                                    {{ $transaction->due_date->format('M d, Y') }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($transaction->returned_at)
                                    <span class="badge bg-success">Returned</span>
                                @elseif($transaction->due_date && $transaction->due_date < now())
                                    <span class="badge bg-danger">Overdue</span>
                                @else
                                    <span class="badge bg-warning">Borrowed</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('library.transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(!$transaction->returned_at)
                                    <form action="{{ route('library.transactions.return', $transaction->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark this book as returned?')">
                                            <i class="fas fa-check"></i> Return
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No transactions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection