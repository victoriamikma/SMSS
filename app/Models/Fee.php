<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'frequency',
        'description',
        'class_id',
        'due_date',
        'status'
    ];

    public function class()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
}