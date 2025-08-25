<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    public function class()
{
    return $this->belongsTo(ClassGroup::class, 'class_id');
}

public function subject()
{
    return $this->belongsTo(Subject::class);
}

public function teacher()
{
    return $this->belongsTo(User::class, 'teacher_id');
}
    //
}
