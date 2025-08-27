<?php

namespace App\Imports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class StaffImport implements ToCollection, WithHeadingRow
{
    private $errors = [];
    private $successCount = 0;
    private $processedRows = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;

            // Skip empty rows
            if ($this->isEmptyRow($row)) {
                continue;
            }

            $this->processedRows++;

            try {
                // Clean and validate data
                $cleanedData = $this->cleanAndValidateRow($row, $rowNumber);

                // If there are validation errors, skip this row
                if (isset($cleanedData['_errors']) && !empty($cleanedData['_errors'])) {
                    $this->errors = array_merge($this->errors, $cleanedData['_errors']);
                    continue;
                }

                // Check for duplicate email
                if (Staff::where('email', $cleanedData['email'])->exists()) {
                    $this->errors[] = [
                        'row' => $rowNumber,
                        'field' => 'email',
                        'value' => $cleanedData['email'],
                        'error' => 'Email already exists in the system'
                    ];
                    continue;
                }

                // Create staff member
                Staff::create($cleanedData);
                $this->successCount++;

            } catch (\Exception $e) {
                $this->errors[] = [
                    'row' => $rowNumber,
                    'field' => 'general',
                    'value' => 'N/A',
                    'error' => $e->getMessage()
                ];
            }
        }
    }

    private function cleanAndValidateRow($row, $rowNumber)
    {
        $errors = [];
        $cleanedData = [];

        // Convert row to array and handle the header format
        $rowArray = $row->toArray();

        // Extract values with proper header name handling - ADD MORE HEADER VARIATIONS
        $firstName = $rowArray['first_name'] ?? $rowArray['first name'] ?? $rowArray['firstname'] ?? $rowArray['First Name'] ?? null;
        $lastName = $rowArray['last_name'] ?? $rowArray['last name'] ?? $rowArray['lastname'] ?? $rowArray['Last Name'] ?? null;
        $email = $rowArray['email'] ?? $rowArray['Email'] ?? null;
        $phone = $rowArray['phone'] ?? $rowArray['Phone'] ?? null;
        $position = $rowArray['position'] ?? $rowArray['Position'] ?? null;
        $department = $rowArray['department'] ?? $rowArray['Department'] ?? null;
        $salary = $rowArray['salary'] ?? $rowArray['Salary'] ?? 0;

        // Handle the hire date column with multiple possible header formats
        $hireDate = $rowArray['hire_date'] ?? $rowArray['hire date'] ?? $rowArray['hiredate'] ??
                   $rowArray['hire_date (yyyy-mm-dd)'] ?? $rowArray['hire date (yyyy-mm-dd)'] ??
                   $rowArray['Hire Date'] ?? $rowArray['Hire Date (YYYY-MM-DD)'] ?? null;

        // Validate and clean each field
        $cleanedData['first_name'] = $this->validateRequired($firstName, 'first_name', 'First Name', $rowNumber, $errors);
        $cleanedData['last_name'] = $this->validateRequired($lastName, 'last_name', 'Last Name', $rowNumber, $errors);
        $cleanedData['email'] = $this->validateEmail($email, $rowNumber, $errors);
        $cleanedData['phone'] = $this->cleanPhone($phone);
        $cleanedData['position'] = $this->validateRequired($position, 'position', 'Position', $rowNumber, $errors);
        $cleanedData['department'] = $this->validateRequired($department, 'department', 'Department', $rowNumber, $errors);
        $cleanedData['salary'] = $this->cleanSalary($salary);
        $cleanedData['hire_date'] = $this->validateDate($hireDate, $rowNumber, $errors);

        if (!empty($errors)) {
            $cleanedData['_errors'] = $errors;
        }

        return $cleanedData;
    }

    private function validateRequired($value, $field, $fieldName, $rowNumber, &$errors)
    {
        $value = $this->cleanString($value);

        if (empty($value)) {
            $errors[] = [
                'row' => $rowNumber,
                'field' => $field,
                'value' => $value,
                'error' => "$fieldName is required"
            ];
            return null;
        }

        if (strlen($value) > 255) {
            $errors[] = [
                'row' => $rowNumber,
                'field' => $field,
                'value' => $value,
                'error' => "$fieldName must not exceed 255 characters"
            ];
            return null;
        }

        return Str::title($value);
    }

    private function validateEmail($value, $rowNumber, &$errors)
    {
        $value = $this->cleanString($value);

        if (empty($value)) {
            $errors[] = [
                'row' => $rowNumber,
                'field' => 'email',
                'value' => $value,
                'error' => 'Email is required'
            ];
            return null;
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors[] = [
                'row' => $rowNumber,
                'field' => 'email',
                'value' => $value,
                'error' => 'Invalid email format'
            ];
            return null;
        }

        return strtolower($value);
    }

    private function validateDate($value, $rowNumber, &$errors)
    {
        $value = $this->cleanString($value);

        if (empty($value)) {
            $errors[] = [
                'row' => $rowNumber,
                'field' => 'hire_date',
                'value' => $value,
                'error' => 'Hire date is required'
            ];
            return null;
        }

        try {
            // Handle Excel serial dates
            if (is_numeric($value)) {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->format('Y-m-d');
            }

            // Handle string dates
            $date = $this->parseDateString($value);
            if ($date) {
                return $date->format('Y-m-d');
            }

            throw new \Exception("Unrecognized date format: " . $value);

        } catch (\Exception $e) {
            $errors[] = [
                'row' => $rowNumber,
                'field' => 'hire_date',
                'value' => $value,
                'error' => 'Invalid date format. Use YYYY-MM-DD, MM/DD/YYYY, or similar formats'
            ];
            return null;
        }
    }

    private function parseDateString($value)
    {
        if (empty($value)) return null;

        $value = trim($value);

        // Try to detect and fix common date format issues
        // Handle dates like "25-8-15" (day-month-year)
        if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{2,4})$/', $value, $matches)) {
            $day = (int)$matches[1];
            $month = (int)$matches[2];
            $year = (int)$matches[3];

            // Fix 2-digit years
            if ($year < 100) {
                $year = $year < 50 ? 2000 + $year : 1900 + $year;
            }

            try {
                return Carbon::createFromDate($year, $month, $day);
            } catch (\Exception $e) {
                // Continue to try other formats
            }
        }

        // Try common date formats
        $formats = [
            'Y-m-d', 'm/d/Y', 'd/m/Y', 'Y/m/d', 'd-M-Y', 'd M Y', 'M d Y', 'Ymd',
            'Y-m-d H:i:s', 'm/d/Y H:i:s', 'd-m-Y', 'm-d-Y', 'd.m.Y', 'm.d.Y',
            'd/m/y', 'm/d/y', 'y-m-d'
        ];

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);
                if ($date !== false) {
                    return $date;
                }
            } catch (\Exception $e) {
                // Continue to next format
            }
        }

        // Try natural parsing as last resort
        try {
            $date = Carbon::parse($value);
            if ($date->isValid()) {
                return $date;
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    private function cleanString($value)
    {
        if ($value === null) return '';
        if (is_numeric($value)) return (string)$value;
        if (is_bool($value)) return $value ? '1' : '0';
        return trim($value);
    }

    private function cleanPhone($value)
    {
        $value = $this->cleanString($value);
        if (empty($value)) return null;

        // Remove all non-numeric characters
        $cleanNumber = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cleanNumber) === 10) {
            return '(' . substr($cleanNumber, 0, 3) . ') ' . substr($cleanNumber, 3, 3) . '-' . substr($cleanNumber, 6);
        }

        return $value;
    }

    private function cleanSalary($value)
    {
        if (empty($value)) return 0;

        if (is_numeric($value)) {
            return floatval($value);
        }

        $value = $this->cleanString($value);

        // Remove currency symbols and commas
        $cleanValue = preg_replace('/[^\d.]/', '', $value);

        return floatval($cleanValue);
    }

    private function isEmptyRow($row)
    {
        $rowData = $row->toArray();

        // Check if all values are empty
        foreach ($rowData as $value) {
            if (!empty($value) && $value !== '' && $value !== ' ' && !empty(trim($value))) {
                return false;
            }
        }

        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getProcessedRows()
    {
        return $this->processedRows;
    }
}
