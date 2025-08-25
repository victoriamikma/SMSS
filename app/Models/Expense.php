<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
    'expense_date', 'description', 'category', 'amount', 
    'payment_method', 'status', 'receipt_path', 'notes', 'user_id'
];

public function user()
{
    return $this->belongsTo(User::class);
}
}
