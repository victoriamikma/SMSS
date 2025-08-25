<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'name',
        'role',
        'gender',
        'contact',
        'salary',
        'bank_account',
        'bank_name',
        'nssf_number',
        'tin_number',
        'last_payment'
    ];

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}