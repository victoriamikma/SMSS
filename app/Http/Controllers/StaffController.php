<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Payroll;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Get staff count
            $staffCount = Staff::count();
            
            // Calculate total monthly salary
            $totalSalary = Staff::sum('salary');
            
            // Get last processed payroll date
            $lastProcessed = Payroll::latest('payment_date')->value('payment_date');
            if ($lastProcessed) {
                $lastProcessed = Carbon::parse($lastProcessed)->format('M d, Y');
            }
            
            // Get all staff members
            $staff = Staff::orderBy('name')->get();
            
            return view('staff.index', compact('staffCount', 'totalSalary', 'lastProcessed', 'staff'));
            
        } catch (\Exception $e) {
            // Fallback in case of database errors
            return view('staff.index', [
                'staffCount' => 0,
                'totalSalary' => 0,
                'lastProcessed' => null,
                'staff' => collect([])
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'contact' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'bank_name' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'last_payment' => 'nullable|date',
            'nssf_number' => 'nullable|string|max:255',
            'tin_number' => 'nullable|string|max:255',
        ]);

        try {
            $staff = Staff::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Staff member added successfully',
                'data' => $staff
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding staff member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        return response()->json([
            'success' => true,
            'data' => $staff
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'contact' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'bank_name' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'last_payment' => 'nullable|date',
            'nssf_number' => 'nullable|string|max:255',
            'tin_number' => 'nullable|string|max:255',
        ]);

        try {
            $staff->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Staff member updated successfully',
                'data' => $staff
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating staff member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        try {
            $staff->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Staff member deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting staff member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process payroll for staff members
     */
    public function processPayroll(Request $request)
    {
        try {
            $staffMembers = Staff::all();
            $processed = [];
            
            foreach ($staffMembers as $staff) {
                // Calculate payroll (basic implementation)
                $basicSalary = $staff->salary;
                $allowances = 0;
                $deductions = $basicSalary * 0.05; // 5% for NSSF
                $netPay = $basicSalary + $allowances - $deductions;
                
                $payroll = Payroll::create([
                    'staff_id' => $staff->id,
                    'period' => now()->format('Y-m'),
                    'basic_salary' => $basicSalary,
                    'allowances' => $allowances,
                    'deductions' => $deductions,
                    'net_pay' => $netPay,
                    'payment_date' => now(),
                    'status' => 'processed'
                ]);
                
                $processed[] = $payroll;
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Payroll processed successfully',
                'data' => $processed
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing payroll: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payroll records
     */
    public function getPayrollRecords()
    {
        try {
            $payrolls = Payroll::with('staff')
                ->orderBy('payment_date', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $payrolls
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching payroll records: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search staff members
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('q');
        
        try {
            $staff = Staff::where('name', 'like', "%{$searchTerm}%")
                ->orWhere('role', 'like', "%{$searchTerm}%")
                ->orWhere('contact', 'like', "%{$searchTerm}%")
                ->orWhere('id', 'like', "%{$searchTerm}%")
                ->orderBy('name')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $staff
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching staff: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Import staff from CSV/Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls'
        ]);
        
        try {
            // In a real application, you would process the file here
            // This is a placeholder implementation
            
            return response()->json([
                'success' => true,
                'message' => 'Staff import will be processed. This is a demo message.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error importing staff: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export staff data
     */
    public function export()
    {
        try {
            $staff = Staff::all();
            
            // In a real application, you would generate a CSV or Excel file here
            // This is a placeholder implementation
            
            return response()->json([
                'success' => true,
                'message' => 'Staff export will be generated. This is a demo message.',
                'data' => $staff
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error exporting staff: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate reports
     */
    public function reports()
    {
        try {
            $staffCount = Staff::count();
            $totalSalary = Staff::sum('salary');
            $lastProcessed = Payroll::latest('payment_date')->value('payment_date');
            
            // Calculate NSSF deductions (5% of salary)
            $nssfDeductions = $totalSalary * 0.05;
            
            // Calculate PAYE (simplified calculation)
            $paye = 0;
            if ($totalSalary > 1000000) {
                $paye = ($totalSalary - 1000000) * 0.1;
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'staff_count' => $staffCount,
                    'total_salary' => $totalSalary,
                    'last_processed' => $lastProcessed,
                    'nssf_deductions' => $nssfDeductions,
                    'paye' => $paye
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating reports: ' . $e->getMessage()
            ], 500);
        }
    }
}