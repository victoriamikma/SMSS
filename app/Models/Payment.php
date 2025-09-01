<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'amount', 'payment_method', 
        'reference', 'date_paid', 'received_by','status',
    'transaction_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(Staff::class, 'received_by');
    }
}