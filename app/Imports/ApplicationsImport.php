<?php
// app/Imports/ApplicationsImport.php
namespace App\Imports;

use App\Models\Application;
use App\Models\Student;
use App\Models\Program;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class ApplicationsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Find or create student
        $student = Student::firstOrCreate(
            ['email' => $row['student_email']],
            [
                'name' => $row['student_name'],
                'phone' => $row['student_phone'] ?? null,
            ]
        );

        // Find program
        $program = Program::where('code', $row['program_code'])->first();

        if (!$program) {
            throw new \Exception("Program with code {$row['program_code']} not found");
        }

        return new Application([
            'student_id' => $student->id,
            'program_id' => $program->id,
            'application_date' => Carbon::parse($row['application_date']),
            'status' => $row['status'] ?? 'pending',
            'notes' => $row['notes'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'student_email' => 'required|email',
            'student_name' => 'required|string',
            'program_code' => 'required|exists:programs,code',
            'application_date' => 'required|date',
            'status' => 'nullable|in:pending,approved,rejected',
        ];
    }
}