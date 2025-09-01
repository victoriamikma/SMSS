<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassRoom extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'classes';

    protected $fillable = ['name', 'description', 'teacher_id', 'is_active'];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'subject_class', 'class_id', 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
