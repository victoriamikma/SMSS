<?php

namespace App\Imports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Staff([
            'name' => $row['name'],
            'role' => $row['role'],
            'gender' => $row['gender'],
            'contact' => $row['contact'],
            'salary' => $row['salary'],
            'bank_account' => $row['bank_account'],
            'bank_name' => $row['bank_name'],
            'nssf_number' => $row['nssf_number'] ?? null,
            'tin_number' => $row['tin_number'] ?? null,
        ]);
    }
}