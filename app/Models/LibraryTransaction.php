<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'borrower_type',
        'student_id',
        'staff_id',
        'external_borrower',
        'borrowed_at',
        'due_date',
        'returned_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
        'fine_amount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    
     public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function scopeBorrowed($query)
    {
        return $query->whereNull('returned_at');
    }

    public function scopeReturned($query)
    {
        return $query->whereNotNull('returned_at');
    }

    public function scopeOverdue($query)
    {
        return $query->whereNull('returned_at')
                    ->where('due_date', '<', now());
    }

    public function isOverdue(): bool
    {
        return is_null($this->returned_at) && $this->due_date < now();
    }

    public function calculateFine($dailyFineRate = 100): float
    {
        if ($this->returned_at || !$this->isOverdue()) {
            return 0;
        }

        $daysOverdue = now()->diffInDays($this->due_date);
        return $daysOverdue * $dailyFineRate;
    }
}