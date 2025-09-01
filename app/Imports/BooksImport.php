<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class BooksImport implements ToCollection, WithHeadingRow
{
    private $hasHeaders;
    private $updateExisting;
    private $importedCount = 0;
    private $updatedCount = 0;
    private $skippedCount = 0;

    public function __construct($hasHeaders = true, $updateExisting = false)
    {
        $this->hasHeaders = $hasHeaders;
        $this->updateExisting = $updateExisting;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip empty rows
            if (empty(array_filter($row->toArray()))) {
                continue;
            }

            // Map row data based on headers or positions
            $data = $this->mapRowData($row);

            // Validate the data
            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'isbn' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'total_copies' => 'required|integer|min:1',
                'available_copies' => 'required|integer|lte:total_copies|min:0',
                'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
                'publisher' => 'nullable|string|max:255',
                'status' => 'nullable|in:available,maintenance,lost',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $this->skippedCount++;
                continue;
            }

            // Check if book exists by ISBN
            $existingBook = Book::where('isbn', $data['isbn'])->first();

            if ($existingBook && $this->updateExisting) {
                // Update existing book
                $existingBook->update($data);
                $this->updatedCount++;
            } elseif (!$existingBook) {
                // Create new book
                Book::create($data);
                $this->importedCount++;
            } else {
                $this->skippedCount++;
            }
        }
    }

    private function mapRowData($row)
    {
        if ($this->hasHeaders) {
            return [
                'title' => $row['title'] ?? $row['Title'] ?? null,
                'author' => $row['author'] ?? $row['Author'] ?? null,
                'isbn' => $row['isbn'] ?? $row['ISBN'] ?? null,
                'category_id' => $row['category_id'] ?? $row['category_id'] ?? $row['category'] ?? null,
                'total_copies' => $row['total_copies'] ?? $row['total_copies'] ?? $row['total_copies'] ?? 1,
                'available_copies' => $row['available_copies'] ?? $row['available_copies'] ?? $row['available_copies'] ?? 1,
                'publication_year' => $row['publication_year'] ?? $row['publication_year'] ?? $row['year'] ?? null,
                'publisher' => $row['publisher'] ?? $row['Publisher'] ?? null,
                'status' => $row['status'] ?? $row['Status'] ?? 'available',
                'description' => $row['description'] ?? $row['Description'] ?? null,
            ];
        }

        // For files without headers (position-based)
        return [
            'title' => $row[0] ?? null,
            'author' => $row[1] ?? null,
            'isbn' => $row[2] ?? null,
            'category_id' => $row[3] ?? null,
            'total_copies' => $row[4] ?? 1,
            'available_copies' => $row[5] ?? 1,
            'publication_year' => $row[6] ?? null,
            'publisher' => $row[7] ?? null,
            'status' => $row[8] ?? 'available',
            'description' => $row[9] ?? null,
        ];
    }

    public function getImportedCount()
    {
        return $this->importedCount;
    }

    public function getUpdatedCount()
    {
        return $this->updatedCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }
}