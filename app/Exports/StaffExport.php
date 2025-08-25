<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StaffExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Staff::select('name', 'role', 'gender', 'contact', 'salary', 'bank_account', 'bank_name', 'nssf_number', 'tin_number')->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Role',
            'Gender',
            'Contact',
            'Salary',
            'Bank Account',
            'Bank Name',
            'NSSF Number',
            'TIN Number'
        ];
    }
}