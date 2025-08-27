<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'admission_number', 'class_id', 
        'date_of_birth', 'gender', 'parent_name', 'parent_phone'
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function applications()
{
    return $this->hasMany(Application::class);
}
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function libraryTransactions()
    {
        return $this->hasMany(LibraryTransaction::class);
    }
    public function parents()
{
    return $this->belongsToMany(Parent::class, 'parent_student')
               ->withPivot('relationship');
}
}