<?php

namespace App\Http\Controllers;

use App\Models\LibraryTransaction;
use App\Models\Book;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;

class LibraryTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = LibraryTransaction::with(['book', 'student', 'staff'])
            ->latest()
            ->paginate(20);
            
        return view('library.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::where('available_copies', '>', 0)->get();
        $students = Student::all();
        $staff = Staff::all();
        
        return view('library.transactions.create', compact('books', 'students', 'staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
public function store(Request $request)
{
    $validated = $request->validate([
        'book_id' => 'required|exists:books,id',
        'borrower_type' => 'required|in:student,staff,external',
        'student_id' => 'required_if:borrower_type,student|nullable|exists:students,id',
        'staff_id' => 'required_if:borrower_type,staff|nullable|exists:staff,id',
        'external_borrower' => 'required_if:borrower_type,external|nullable|string|max:255',
        'borrowed_at' => 'required|date',
        'due_date' => 'required|date|after:borrowed_date',
        'notes' => 'nullable|string',
    ]);

    try {
        // Get the book
        $book = Book::findOrFail($validated['book_id']);
        
        // Check if book is available
        if ($book->available_copies < 1) {
            return redirect()->back()
                ->with('error', 'This book is not available for borrowing.')
                ->withInput();
        }

        // Create the transaction
        $transaction = LibraryTransaction::create([
            'book_id' => $validated['book_id'],
            'borrower_type' => $validated['borrower_type'],
            'student_id' => $validated['student_id'] ?? null,
            'staff_id' => $validated['staff_id'] ?? null,
            'external_borrower' => $validated['external_borrower'] ?? null,
            'borrowed_at' => $validated['borrowed_date'],
            'due_date' => $validated['due_date'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'borrowed'
        ]);

        // Update book available copies
        $book->decrement('available_copies');

        return redirect()->route('library.transactions.index')
            ->with('success', 'Transaction created successfully.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error creating transaction: ' . $e->getMessage())
            ->withInput();
    }
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = LibraryTransaction::with(['book', 'student', 'staff', 'book.category', 'student.class', ])->findOrFail($id);
        return view('library.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaction = LibraryTransaction::findOrFail($id);
        $books = Book::all();
        $students = Student::all();
        $staff = Staff::all();
        
        return view('library.transactions.edit', compact('transaction', 'books', 'students', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = LibraryTransaction::findOrFail($id);
        
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrower_type' => 'required|in:student,staff',
            'student_id' => 'required_if:borrower_type,student|exists:students,id',
            'staff_id' => 'required_if:borrower_type,staff|exists:staff,id',
            'borrowed_at' => 'required|date',
            'due_date' => 'required|date|after:borrowed_date',
            'returned_at' => 'nullable|date|after:borrowed_date',
        ]);

        // Handle book change
        if ($transaction->book_id != $validated['book_id']) {
            // Return old book
            $oldBook = Book::find($transaction->book_id);
            if ($oldBook && !$transaction->returned_at) {
                $oldBook->increment('available_copies');
            }
            
            // Borrow new book
            $newBook = Book::find($validated['book_id']);
            if ($newBook && !$validated['returned_at']) {
                if ($newBook->available_copies < 1) {
                    return redirect()->back()
                        ->with('error', 'The selected book is not available.')
                        ->withInput();
                }
                $newBook->decrement('available_copies');
            }
        }
        
        // Handle return status change
        if (!$transaction->returned_at && $validated['returned_at']) {
            // Book is being returned
            $book = Book::find($validated['book_id']);
            $book->increment('available_copies');
        } elseif ($transaction->returned_at && !$validated['returned_at']) {
            // Book is being un-returned
            $book = Book::find($validated['book_id']);
            if ($book->available_copies < 1) {
                return redirect()->back()
                    ->with('error', 'Cannot mark as unreturned. Book is not available.')
                    ->withInput();
            }
            $book->decrement('available_copies');
        }

        $transaction->update($validated);

        return redirect()->route('library.transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = LibraryTransaction::findOrFail($id);
        
        // If book wasn't returned, make it available again
        if (!$transaction->returned_at) {
            $book = Book::find($transaction->book_id);
            if ($book) {
                $book->increment('available_copies');
            }
        }
        
        $transaction->delete();

        return redirect()->route('library.transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
    
    /**
     * Mark a book as returned
     */
    public function returnBook(Request $request, $id)
    {
        $transaction = LibraryTransaction::findOrFail($id);
        
        if ($transaction->returned_at) {
            return response()->json([
                'success' => false,
                'message' => 'Book already returned.'
            ]);
        }
        
        $transaction->update([
            'returned_at' => now()
        ]);
        
        // Update book availability
        $book = Book::find($transaction->book_id);
        if ($book) {
            $book->increment('available_copies');
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Book marked as returned.'
        ]);
    }
}