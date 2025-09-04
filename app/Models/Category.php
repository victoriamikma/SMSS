<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'color_code',
    ];

    /**
     * Get the books for the category.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Get the number of books in this category.
     */
    public function getBooksCountAttribute(): int
    {
        return $this->books()->count();
    }

    /**
     * Get the number of available books in this category.
     */
    public function getAvailableBooksCountAttribute(): int
    {
        return $this->books()->where('available_copies', '>', 0)->count();
    }

    /**
     * Scope a query to only include categories with books.
     */
    public function scopeWithBooks($query)
    {
        return $query->has('books');
    }

    /**
     * Get the category name with book count.
     */
    public function getNameWithCountAttribute(): string
    {
        return "{$this->name} ({$this->books_count})";
    }
}