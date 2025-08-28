<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\StaffExport;
use App\Imports\StaffImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
     public function index()
    {
        $staff = Staff::all();
        $departments = Staff::distinct()->pluck('department')->filter();
        $positions = Staff::distinct()->pluck('position')->filter();

        return view('staff.index', compact('staff', 'departments', 'positions'));
    }

 public function importExport()
{
    $departments = Staff::distinct()->pluck('department')->filter();
    $positions = Staff::distinct()->pluck('position')->filter();

    return view('staff.import-export', compact('departments', 'positions'));
}

    public function export(Request $request)
    {
        $filters = $request->only(['department', 'position', 'start_date', 'end_date']);

        return Excel::download(new StaffExport($filters), 'staff_' . date('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
{
    $validator = Validator::make($request->all(), [
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->with('error', 'Invalid file format. Please upload an Excel or CSV file.');
    }

    try {
        $import = new StaffImport();
        Excel::import($import, $request->file('file'));

        $successCount = $import->getSuccessCount();
        $processedRows = $import->getProcessedRows();
        $errors = $import->getErrors();

        if ($processedRows === 0) {
            return redirect()->back()
                ->with('error', 'No valid data found in the file. Please check the format and try again.');
        }

        if (!empty($errors)) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = "Row {$error['row']}, {$error['field']}: {$error['error']} (Value: '{$error['value']}')";
            }

            $message = "Processed {$processedRows} rows. Successfully imported {$successCount} records, encountered " . count($errors) . " errors.";

            return redirect()->back()
                ->with('import_errors', $errorMessages)
                ->with('success_count', $successCount)
                ->with('error_count', count($errors))
                ->with('processed_rows', $processedRows)
                ->with('warning', $message);
        }

        return redirect()->route('staff.index')
            ->with('success', "Successfully imported {$successCount} staff members.");

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error importing staff: ' . $e->getMessage());
    }
}


public function downloadTemplate()
{
    $headers = [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];

    $filePath = storage_path('app/templates/staff_import_template.xlsx');
    $directory = dirname($filePath);

    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }

    if (!file_exists($filePath)) {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers that match what the import expects
        $headers = [
            'first_name',
            'last_name',
            'email',
            'phone',
            'position',
            'department',
            'salary',
            'hire_date'
        ];

        $sheet->fromArray([$headers], null, 'A1');

        // Set example data
        $examples = [
            ['John', 'Doe', 'john.doe@example.com', '1234567890', 'Developer', 'IT', '50000', '2024-01-15'],
            ['Jane', 'Smith', 'jane.smith@company.com', '5551234567', 'Manager', 'HR', '75000.50', '01/15/2023'],
            ['Bob', 'Johnson', 'bob@test.org', '5559876543', 'Analyst', 'Finance', '60000', '45291'] // Excel date
        ];

        $sheet->fromArray($examples, null, 'A2');

        // Add instructions in a separate sheet
        $spreadsheet->createSheet();
        $instructionSheet = $spreadsheet->setActiveSheetIndex(1);
        $instructionSheet->setTitle('Instructions');

        $instructionSheet->setCellValue('A1', 'STAFF IMPORT TEMPLATE INSTRUCTIONS');
        $instructionSheet->setCellValue('A3', 'Required Fields:');
        $instructionSheet->setCellValue('A4', '- first_name');
        $instructionSheet->setCellValue('A5', '- last_name');
        $instructionSheet->setCellValue('A6', '- email');
        $instructionSheet->setCellValue('A7', '- position');
        $instructionSheet->setCellValue('A8', '- department');
        $instructionSheet->setCellValue('A9', '- hire_date');

        $instructionSheet->setCellValue('A11', 'Optional Fields:');
        $instructionSheet->setCellValue('A12', '- phone');
        $instructionSheet->setCellValue('A13', '- salary');

        $instructionSheet->setCellValue('A15', 'Date Formats Accepted:');
        $instructionSheet->setCellValue('A16', '- YYYY-MM-DD (2024-01-15)');
        $instructionSheet->setCellValue('A17', '- MM/DD/YYYY (01/15/2024)');
        $instructionSheet->setCellValue('A18', '- Excel serial dates (45291)');
        $instructionSheet->setCellValue('A19', '- DD-MMM-YYYY (15-Jan-2024)');
        $instructionSheet->setCellValue('A20', '- DD-MM-YY (25-08-15 becomes 2015-08-25)');

        $instructionSheet->setCellValue('A22', 'Notes:');
        $instructionSheet->setCellValue('A23', '- Do not change the header names in the first row');
        $instructionSheet->setCellValue('A24', '- Phone numbers will be automatically formatted');
        $instructionSheet->setCellValue('A25', '- Salary can include currency symbols and commas ($50,000.00)');

        // Auto-size columns for both sheets
        $spreadsheet->setActiveSheetIndex(0);
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $spreadsheet->setActiveSheetIndex(1);
        $instructionSheet->getColumnDimension('A')->setAutoSize(true);

        // Style headers
        $spreadsheet->setActiveSheetIndex(0);
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E75B6']]
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Style instructions
        $instructionTitleStyle = [
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '2E75B6']]
        ];
        $instructionSheet->getStyle('A1')->applyFromArray($instructionTitleStyle);

        $spreadsheet->setActiveSheetIndex(0);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    return response()->download($filePath, 'staff_import_template.xlsx', $headers);
}

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'phone' => 'nullable|string',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'hire_date' => 'required|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Add validation
        ]);

        $data = $request->all();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $data['profile_picture'] = $imagePath;
        }

        Staff::create($data);

        return redirect()->route('staff.index')
            ->with('success', 'Staff member added successfully.');
    }

    public function show(Staff $staff)
    {
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'phone' => 'nullable|string',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'hire_date' => 'required|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Add validation
        ]);

        $data = $request->all();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($staff->profile_picture) {
                Storage::disk('public')->delete($staff->profile_picture);
            }

            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $data['profile_picture'] = $imagePath;
        }

        $staff->update($data);

        return redirect()->route('staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        // Delete profile picture if exists
        if ($staff->profile_picture) {
            Storage::disk('public')->delete($staff->profile_picture);
        }

        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }




}
