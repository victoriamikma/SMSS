<?php
// app/Http/Controllers/ApplicationsController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Student;
use App\Models\Program;
use App\Imports\ApplicationsImport;
use App\Exports\ApplicationsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Application::with('student', 'program')
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('program_id') && $request->program_id != '') {
            $query->where('program_id', $request->program_id);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('program', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $applications = $query->paginate(10);

        return view('applications.index', [
            'applications' => $applications,
            'programs' => Program::all(),
            'filters' => $request->only(['status', 'program_id', 'search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('applications.create', [
            'students' => Student::orderBy('name')->get(),
            'programs' => Program::where('is_active', true)->orderBy('name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'program_id' => 'required|exists:programs,id',
            'application_date' => 'required|date',
            'status' => 'required|in:pending,approved,rejected',
            'documents' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'notes' => 'nullable|string'
        ]);

        // Check for duplicate application
        $existingApplication = Application::where('student_id', $validated['student_id'])
            ->where('program_id', $validated['program_id'])
            ->first();

        if ($existingApplication) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This student has already applied for this program.');
        }

        if ($request->hasFile('documents')) {
            $path = $request->file('documents')->store('application_documents', 'public');
            $validated['documents'] = $path;
        }

        Application::create($validated);

        return redirect()->route('applications.index')
            ->with('success', 'Application submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = Application::with('student', 'program')->findOrFail($id);
        
        return view('applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $application = Application::findOrFail($id);
        $students = Student::orderBy('name')->get();
        $programs = Program::where('is_active', true)->orderBy('name')->get();
        
        return view('applications.edit', compact('application', 'students', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = Application::findOrFail($id);
        
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'program_id' => 'required|exists:programs,id',
            'application_date' => 'required|date',
            'status' => 'required|in:pending,approved,rejected',
            'documents' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'notes' => 'nullable|string'
        ]);

        // Check for duplicate application (excluding current one)
        $existingApplication = Application::where('student_id', $validated['student_id'])
            ->where('program_id', $validated['program_id'])
            ->where('id', '!=', $id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This student has already applied for this program.');
        }

        if ($request->hasFile('documents')) {
            // Delete old document if exists
            if ($application->documents) {
                Storage::disk('public')->delete($application->documents);
            }
            
            $path = $request->file('documents')->store('application_documents', 'public');
            $validated['documents'] = $path;
        }

        $application->update($validated);

        return redirect()->route('applications.index')
            ->with('success', 'Application updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $application = Application::findOrFail($id);
        
        // Delete associated document
        if ($application->documents) {
            Storage::disk('public')->delete($application->documents);
        }
        
        $application->delete();

        return redirect()->route('applications.index')
            ->with('success', 'Application deleted successfully!');
    }
    
    /**
     * Show bulk import form
     */
    public function showImportForm()
    {
        return view('applications.import');
    }
    
    /**
     * Process bulk import
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);
        
        try {
            Excel::import(new ApplicationsImport, $request->file('file'));
            
            return redirect()->route('applications.index')
                ->with('success', 'Applications imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing applications: ' . $e->getMessage());
        }
    }
    
    /**
     * Download template for bulk import
     */
    public function downloadTemplate()
    {
        $filePath = storage_path('app/templates/applications_import_template.xlsx');
        
        // Create directory if it doesn't exist
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }
        
        if (!file_exists($filePath)) {
            // Create template if it doesn't exist
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            $headers = ['student_name', 'student_email', 'student_phone', 'program_code', 'application_date', 'status', 'notes'];
            $sheet->fromArray($headers, null, 'A1');
            
            // Add example data
            $exampleData = [
                'John Doe',
                'john.doe@example.com',
                '+1234567890',
                'CS101',
                '2023-10-15',
                'pending',
                'Excellent candidate'
            ];
            $sheet->fromArray($exampleData, null, 'A2');
            
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($filePath);
        }
        
        return response()->download($filePath);
    }
    
    /**
     * Update application status via AJAX
     */
    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);
        
        $application->update(['status' => $request->status]);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Application status updated successfully!'
            ]);
        }
        
        return redirect()->back()
            ->with('success', 'Application status updated successfully!');
    }
    
    /**
     * Export applications
     */
    public function export(Request $request)
    {
        $filters = $request->only(['status', 'program_id']);
        
        return Excel::download(new ApplicationsExport($filters), 'applications_' . date('Y-m-d') . '.xlsx');
    }
    
    /**
     * Get application statistics
     */
    public function getStats()
    {
        $stats = [
            'total' => Application::count(),
            'pending' => Application::where('status', 'pending')->count(),
            'approved' => Application::where('status', 'approved')->count(),
            'rejected' => Application::where('status', 'rejected')->count(),
        ];
        
        return response()->json($stats);
    }
}