<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description'];

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(ClassRoom::class, 'subject_class', 'subject_id', 'class_id')
                    ->withTimestamps();
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subject')
                    ->withTimestamps();
    }
}
