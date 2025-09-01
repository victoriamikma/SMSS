@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Library Management - {{ config('app.name', 'SwiftSolve School System') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-orange: #FF6B00;
            --secondary-orange: #FF8C00;
            --light-orange: #FFE4CC;
            --white: #FFFFFF;
            --black: #222222;
            --light-gray: #F5F5F5;
            --medium-gray: #E0E0E0;
            --dark-gray: #555555;
            --success-green: #4CAF50;
            --warning-red: #F44336;
            --info-blue: #2196F3;
            --purple: #9C27B0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .library-dashboard {
            min-height: 100vh;
            background-color: var(--light-gray);
        }

        /* Header */
        .dashboard-header {
            background-color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-left h1 {
            font-size: 1.5rem;
            color: var(--black);
        }

        .swift {
            color: var(--primary-orange);
            font-weight: 700;
        }

        .solve {
            color: var(--black);
            font-weight: 700;
        }

        .header-left p {
            color: var(--black);
            opacity: 0.7;
            font-size: 0.9rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            padding-right: 1.5rem;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .settings-icon {
            position: absolute;
            right: 0;
            color: var(--dark-gray);
            cursor: pointer;
        }

        /* Page Header */
        .page-header {
            padding: 1.5rem 2rem;
            background-color: var(--white);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 1.8rem;
            color: var(--black);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .page-title i {
            color: var(--purple);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.7rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary-orange);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--secondary-orange);
        }

        .btn-secondary {
            background-color: var(--light-gray);
            color: var(--black);
            border: 1px solid var(--medium-gray);
        }

        .btn-secondary:hover {
            background-color: var(--medium-gray);
        }

        /* Quick Stats */
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
            padding: 0 2rem 1.5rem;
        }

        .stat-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .stat-icon.books {
            background-color: var(--purple);
        }

        .stat-icon.borrowed {
            background-color: var(--info-blue);
        }

        .stat-icon.overdue {
            background-color: var(--warning-red);
        }

        .stat-icon.categories {
            background-color: var(--success-green);
        }

        .stat-info h3 {
            font-size: 1rem;
            color: var(--black);
            opacity: 0.8;
            margin-bottom: 0.3rem;
        }

        .stat-info p {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--black);
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 0 2rem 2rem;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }

        /* Main Content */
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* Table Styles */
        .card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.2rem;
            color: var(--black);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .view-all {
            color: var(--primary-orange);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid var(--medium-gray);
        }

        th {
            font-weight: 600;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        tbody tr:hover {
            background-color: var(--light-gray);
        }

        .status {
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-borrowed {
            background-color: var(--light-orange);
            color: var(--primary-orange);
        }

        .status-returned {
            background-color: #E8F5E9;
            color: var(--success-green);
        }

        .status-overdue {
            background-color: #FFEBEE;
            color: var(--warning-red);
        }

        .action-cell {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            border: none;
        }

        .btn-return {
            background-color: var(--success-green);
            color: white;
        }

        .btn-view {
            background-color: var(--info-blue);
            color: white;
        }

        /* Right Sidebar */
        .right-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* Search Box */
        .search-box {
            background-color: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .search-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-size: 0.9rem;
            color: var(--dark-gray);
        }

        .form-group input, .form-group select {
            padding: 0.7rem;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .search-btn {
            background-color: var(--primary-orange);
            color: white;
            border: none;
            padding: 0.7rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        /* Recent Activities */
        .recent-activities {
            background-color: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .recent-activities h2 {
            color: var(--black);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--medium-gray);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-text {
            font-size: 0.9rem;
            color: var(--black);
            margin-bottom: 0.3rem;
        }

        .activity-time {
            font-size: 0.8rem;
            color: var(--dark-gray);
        }

        /* Footer */
        .dashboard-footer {
            background-color: var(--white);
            padding: 1rem;
            text-align: center;
            font-size: 0.8rem;
            color: var(--black);
            opacity: 0.7;
            border-top: 1px solid var(--medium-gray);
            margin-top: 2rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
            gap: 0.5rem;
        }

        .pagination-link {
            padding: 0.5rem 0.8rem;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            color: var(--dark-gray);
            text-decoration: none;
        }

        .pagination-link.active {
            background-color: var(--primary-orange);
            color: white;
            border-color: var(--primary-orange);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--dark-gray);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--medium-gray);
        }
    </style>
</head>
<body class="library-dashboard">
    <!-- Header -->
    <!-- <header class="dashboard-header">
        <div class="header-left">
            <h1>
                <span class="swift">SWIFT</span>
                <span class="solve">SOLVE</span> SCHOOL SYSTEM
            </h1>
            <p>Kampala, Uganda | +256 702 064 779</p>
        </div>
        <div class="header-right">
            <div class="user-profile">
                <img src="{{ Auth::user()->profile_photo_url ?? 'https://via.placeholder.com/40' }}" alt="User" />
                <span>{{ Auth::user()->name }}</span>
                <a href="{{ route('profile.show') }}" class="settings-icon">
                    <i class="fas fa-cog"></i>
                </a>
            </div>
        </div>
    </header> -->

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-book-open"></i> Library Management
        </h1>
        <div class="action-buttons">
            <a href="{{ route('library.transactions.create') }}" class="btn btn-primary">
                <i class="fas fa-exchange-alt"></i> New Transaction
            </a>
            <a href="{{ route('library.books.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Book
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats">
        <div class="stat-card">
            <div class="stat-icon books">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <h3>Total Books</h3>
                <p>{{ number_format($totalBooks) }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon borrowed">
                <i class="fas fa-hand-holding"></i>
            </div>
            <div class="stat-info">
                <h3>Books Borrowed</h3>
                <p>{{ number_format($borrowedBooks) }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon overdue">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="stat-info">
                <h3>Overdue Books</h3>
                <p>{{ number_format($overdueBooks) }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon categories">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-info">
                <h3>Categories</h3>
                <p>{{ number_format($totalCategories) }}</p>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Recent Transactions -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-exchange-alt"></i> Recent Transactions
                    </h2>
                    <a href="{{ route('library.transactions.index') }}" class="view-all">View All</a>
                </div>
                <div class="table-responsive">
                    <table>
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
                            @forelse($recentTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->book->title }}</td>
                                <td>
                                    @if($transaction->student)
                                        {{ $transaction->student->name }}
                                    @elseif($transaction->staff)
                                        {{ $transaction->staff->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $transaction->borrowed_at->format('M d, Y') }}</td>
                                <td>{{ $transaction->due_date->format('M d, Y') }}</td>
                                <td>
                                    @if($transaction->returned_at)
                                        <span class="status status-returned">Returned</span>
                                    @elseif($transaction->due_date < now())
                                        <span class="status status-overdue">Overdue</span>
                                    @else
                                        <span class="status status-borrowed">Borrowed</span>
                                    @endif
                                </td>
                                <td class="action-cell">
                                    @if(!$transaction->returned_at)
                                        <button class="action-btn btn-return" data-id="{{ $transaction->id }}">
                                            <i class="fas fa-undo"></i> Return
                                        </button>
                                    @endif
                                    <button class="action-btn btn-view" data-id="{{ $transaction->id }}">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fas fa-exchange-alt"></i>
                                    <p>No transactions found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($recentTransactions->hasPages())
                <div class="pagination">
                    {{ $recentTransactions->links() }}
                </div>
                @endif
            </div>

            <!-- Popular Books -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-chart-line"></i> Most Popular Books
                    </h2>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Total Borrows</th>
                                <th>Availability</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($popularBooks as $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->category->name ?? 'Uncategorized' }}</td>
                                <td>{{ $book->borrow_count }}</td>
                                <td>
                                    @if($book->available_copies > 0)
                                        <span style="color: var(--success-green);">Available ({{ $book->available_copies }})</span>
                                    @else
                                        <span style="color: var(--warning-red);">Out of Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="fas fa-book"></i>
                                    <p>No books data available</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="right-sidebar">
            <!-- Search Box -->
            <div class="search-box">
                <h2>
                    <i class="fas fa-search"></i> Quick Search
                </h2>
                <form class="search-form" action="{{ route('library.search') }}" method="GET">
                    <div class="form-group">
                        <label for="search">Search Books</label>
                        <input type="text" id="search" name="q" placeholder="Title, author, or ISBN">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Availability</label>
                        <select id="status" name="status">
                            <option value="">All</option>
                            <option value="available">Available</option>
                            <option value="borrowed">Borrowed</option>
                        </select>
                    </div>
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>

            <!-- Recent Activities -->
            <div class="recent-activities">
                <h2>
                    <i class="fas fa-history"></i> Recent Activities
                </h2>
                <ul class="activity-list">
                    @forelse($recentActivities as $activity)
                    <li class="activity-item">
                        <p class="activity-text">{{ $activity->description }}</p>
                        <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                    </li>
                    @empty
                    <li class="activity-item">
                        <p class="activity-text">No recent activities</p>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="dashboard-footer">
        <p>© {{ date('Y') }} Swift Solve Tech Solutions | hello@swiftsolvetech.ug</p>
        <p>Library Module | System Version: 1.0.0</p>
    </footer>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    
    <script>
        // Handle return book action
        document.querySelectorAll('.btn-return').forEach(button => {
            button.addEventListener('click', function() {
                const transactionId = this.getAttribute('data-id');
                if (confirm('Mark this book as returned?')) {
                    fetch(`/library/transactions/${transactionId}/return`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while processing your request.');
                    });
                }
            });
        });

        // Handle view transaction action
        document.querySelectorAll('.btn-view').forEach(button => {
            button.addEventListener('click', function() {
                const transactionId = this.getAttribute('data-id');
                window.location.href = `/library/transactions/${transactionId}`;
            });
        });
    </script>
</body>
</html>
@endsection