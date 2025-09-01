<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'subject_specialization', 'joining_date'];

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject')
                    ->withTimestamps();
    }

    // If you have classes relationship (optional)
    public function classes()
    {
        return $this->hasMany(ClassRoom::class, 'teacher_id');
    }
}
