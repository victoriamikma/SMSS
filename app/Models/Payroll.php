<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'staff_id',
        'period',
        'basic_salary',
        'allowances',
        'deductions',
        'net_pay',
        'payment_date',
        'status',
        'payment_method'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}