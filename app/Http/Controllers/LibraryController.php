<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LibraryTransaction;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksTemplateExport;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get stats for the dashboard
        $totalBooks = Book::count();
        $borrowedBooks = LibraryTransaction::whereNull('returned_at')->count();
        
        $overdueBooks = LibraryTransaction::whereNull('returned_at')
            ->where('due_date', '<', now())
            ->count();
            
        $totalCategories = Category::count();
        
        // Get recent transactions
        $recentTransactions = LibraryTransaction::with(['book', 'student', 'staff'])
            ->latest()
            ->take(10)
            ->paginate();
            
        // Get popular books (most borrowed)
        $popularBooks = Book::with('category')
            ->withCount('transactions')
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get();
            
        // Get categories for search filter
        $categories = Category::all();
        
        // Get recent activities
        $recentActivities = ActivityLog::where('loggable_type', 'like', '%Library%')
            ->latest()
            ->take(5)
            ->get();

        return view('library.index', compact(
            'totalBooks',
            'borrowedBooks',
            'overdueBooks',
            'totalCategories',
            'recentTransactions',
            'popularBooks',
            'categories',
            'recentActivities'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
     /**
     * Download Excel template file
     */
    public function downloadExcelTemplate(): BinaryFileResponse
    {
        return Excel::download(new BooksTemplateExport(), 'books_import_template.xlsx');
    }
    
    /**
     * Search for books and transactions
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $category = $request->input('category');
        $status = $request->input('status');
        
        // Build search query for books
        $books = Book::query();
        
        if ($query) {
            $books->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('author', 'like', "%{$query}%")
                  ->orWhere('isbn', 'like', "%{$query}%");
            });
        }
        
        if ($category) {
            $books->where('category_id', $category);
        }
        
        if ($status === 'available') {
            $books->where('available_copies', '>', 0);
        } elseif ($status === 'borrowed') {
            $books->where('available_copies', '<=', 0);
        }
        
        $results = $books->with('category')->get();
        
        return view('library.search', compact('results', 'query'));
    }
}