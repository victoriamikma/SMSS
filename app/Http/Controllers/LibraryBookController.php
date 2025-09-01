<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BooksImport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LibraryBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('category')->paginate(20);
        $categories = Category::all();
        return view('library.books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('library.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'category_id' => 'required|exists:categories,id',
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|lte:total_copies|min:0',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'publisher' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Book::create($validated);

        return redirect()->route('library.books.index')
            ->with('success', 'Book added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with(['category', 'transactions'])->findOrFail($id);
        return view('library.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        return view('library.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $id,
            'category_id' => 'required|exists:categories,id',
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|lte:total_copies|min:0',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'publisher' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $book->update($validated);

        return redirect()->route('library.books.index')
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        
        // Check if book has active transactions
        if ($book->transactions()->whereNull('returned_at')->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete book with active transactions.');
        }
        
        $book->delete();

        return redirect()->route('library.books.index')
            ->with('success', 'Book deleted successfully.');
    }
    /**
     * Show the import form for bulk book upload
     */
    public function import()
    {
        $categories = Category::all();
        return view('library.books.import', compact('categories'));
    }
     /**
     * Process the bulk import of books
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,xlsx,xls|max:10240',
            'file_format' => 'required|in:csv,excel',
            'has_headers' => 'boolean',
            'update_existing' => 'boolean'
        ]);

        try {
            $import = new BooksImport(
                $request->has('has_headers'),
                $request->has('update_existing')
            );

            Excel::import($import, $request->file('import_file'));

            $importedCount = $import->getImportedCount();
            $updatedCount = $import->getUpdatedCount();
            $skippedCount = $import->getSkippedCount();

            return redirect()->route('library.books.index')
                ->with('success', "Import completed successfully! 
                    Imported: {$importedCount}, 
                    Updated: {$updatedCount}, 
                    Skipped: {$skippedCount}");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Import failed: ' . $e->getMessage())
                ->withInput();
        }
    }
    /**
     * Download the import template file
     */
    public function downloadTemplate(): BinaryFileResponse
    {
        $templatePath = storage_path('app/templates/books_import_template.csv');
        
        // Create template directory if it doesn't exist
        if (!file_exists(dirname($templatePath))) {
            mkdir(dirname($templatePath), 0755, true);
        }

        // Create template file
        $templateContent = "Title,Author,ISBN,Category ID,Total Copies,Available Copies,Publication Year,Publisher,Status,Description\n";
        $templateContent .= "Sample Book,John Doe,978-1234567890,1,5,5,2023,Publisher Name,available,Sample description\n";
        
        file_put_contents($templatePath, $templateContent);

        return response()->download($templatePath, 'books_import_template.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}