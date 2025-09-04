<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category_id',
        'total_copies',
        'available_copies',
        'publication_year',
        'publisher',
        'description',
        'cover_image',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publication_year' => 'integer',
        'total_copies' => 'integer',
        'available_copies' => 'integer',
    ];

    /**
     * Get the category that owns the book.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the transactions for the book.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(LibraryTransaction::class);
    }

    /**
     * Scope a query to only include available books.
     */
    public function scopeAvailable($query)
    {
        return $query->where('available_copies', '>', 0);
    }

    /**
     * Scope a query to only include popular books (borrowed at least once).
     */
    public function scopePopular($query)
    {
        return $query->has('transactions');
    }

    /**
     * Check if the book is available for borrowing.
     */
    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }

    /**
     * Get the number of times this book has been borrowed.
     */
    public function getBorrowCountAttribute(): int
    {
        return $this->transactions()->count();
    }

    /**
     * Get the active transactions for this book.
     */
    public function getActiveTransactionsAttribute()
    {
        return $this->transactions()->whereNull('returned_at')->get();
    }
}