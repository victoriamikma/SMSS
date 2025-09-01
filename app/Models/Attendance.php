<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'student_id', 'status', 
        'days_absent', 'previous_day_percentage',
        'present_count', 'total_students'
    ];

    // In Attendance.php model
public function student()
{
    return $this->belongsTo(Student::class);
}

public function staff()
{
    return $this->belongsTo(Staff::class);
}
}