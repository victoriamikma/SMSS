<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
    'title', 'category', 'file_path', 'file_size', 'description', 'user_id'
];

public function user()
{
    return $this->belongsTo(User::class);
}
}
