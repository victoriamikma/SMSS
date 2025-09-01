<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $table = 'parents'; // Still use 'parents' table name

    public function students()
    {
        return $this->belongsToMany(Student::class, 'parent_student')
                   ->withPivot('relationship');
    }
}