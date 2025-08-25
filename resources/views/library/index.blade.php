@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Library Management</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Book</th>
                <th>Student</th>
                <th>Borrowed Date</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->book->title }}</td>
                <td>{{ $transaction->student->name }}</td>
                <td>{{ $transaction->borrowed_date->format('Y-m-d') }}</td>
                <td>{{ $transaction->due_date->format('Y-m-d') }}</td>
                <td>{{ $transaction->returned_at ? 'Returned' : 'Borrowed' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection