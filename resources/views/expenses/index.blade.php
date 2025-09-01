<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Management Module</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-orange: #FF7700;
            --orange-light: #FF9838;
            --orange-dark: #E05D00;
            --orange-gradient: linear-gradient(135deg, #FF7700 0%, #FF9838 100%);
            --orange-subtle: #FFF5EB;
            --success-green: #28a745;
            --info-blue: #17a2b8;
            --purple: #6f42c1;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 2rem;
        }
        
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(255, 119, 0, 0.15);
            overflow: hidden;
        }
        
        .card-header {
            background: var(--orange-gradient);
            color: white;
            border-bottom: none;
            padding: 1.2rem 1.5rem;
            border-radius: 15px 15px 0 0 !important;
        }
        
        .btn-primary {
            background: var(--orange-gradient);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-primary:hover {
            background: var(--primary-orange);
            box-shadow: 0 4px 12px rgba(255, 119, 0, 0.3);
        }
        
        .btn-success {
            background-color: var(--success-green);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-info {
            background-color: var(--info-blue);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-purple {
            background-color: var(--purple);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-purple:hover {
            background-color: #5a32a8;
            color: white;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-orange);
            color: var(--primary-orange);
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-orange);
            color: white;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 0.25rem rgba(255, 119, 0, 0.25);
        }
        
        .alert-info {
            background-color: var(--orange-subtle);
            border-color: var(--orange-light);
            color: var(--orange-dark);
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .form-text {
            color: #6c757d;
            font-size: 0.85rem;
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.85rem;
        }
        
        .expense-summary {
            background: var(--orange-subtle);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .expense-chart {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }
        
        .expense-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .expense-table th {
            background-color: var(--orange-subtle);
            color: var(--primary-orange);
            font-weight: 600;
        }
        
        .expense-status {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-pending {
            background-color: #FFF0D9;
            color: #E5A500;
        }
        
        .status-approved {
            background-color: #E6F4EE;
            color: #0A8158;
        }
        
        .status-rejected {
            background-color: #FCE8E6;
            color: #D92D20;
        }
        
        .category-badge {
            background-color: var(--orange-subtle);
            color: var(--primary-orange);
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .document-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .document-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .tab-content {
            padding: 1.5rem 0;
        }
        
        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-orange);
            border-bottom: 3px solid var(--primary-orange);
            border-top: none;
            border-left: none;
            border-right: none;
            background: transparent;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
        }
        
        .stats-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-orange);
        }
        
        .stats-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stats-label {
            color: #6c757d;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
            }
            
            .btn-group {
                width: 100%;
            }
            
            .btn-group .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 119, 0, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary-orange);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Expense Module Index Page -->
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h3 class="m-0"><i class="fas fa-receipt me-2"></i> Expense Management</h3>
                            <div class="d-flex header-actions">
                                <a href="#" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#createExpenseModal">
                                    <i class="fas fa-plus-circle me-1"></i> New Expense
                                </a>
                                <a href="#" class="btn btn-purple me-2" id="reportsBtn">
                                    <i class="fas fa-chart-pie me-1"></i> Reports
                                </a>
                                <div class="import-export-container">
                                    <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                                        <i class="fas fa-file-import me-1"></i> Import
                                    </button>
                                    <button class="btn btn-info" id="exportBtn">
                                        <i class="fas fa-file-export me-1"></i> Export
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Expense Summary Cards -->
                        <div class="row mb-4" id="summaryCards">
                            <div class="col-md-4 mb-3">
                                <div class="stats-card">
                                    <div class="stats-icon">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <div class="stats-value text-primary" id="totalExpenses">$0.00</div>
                                    <div class="stats-label">Total Expenses</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="stats-card">
                                    <div class="stats-icon">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <div class="stats-value text-success" id="staffPayments">$0.00</div>
                                    <div class="stats-label">Staff Payments</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="stats-card">
                                    <div class="stats-icon">
                                        <i class="fas fa-calculator"></i>
                                    </div>
                                    <div class="stats-value text-info" id="grandTotal">$0.00</div>
                                    <div class="stats-label">Grand Total</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Filters -->
                        <div class="filter-section mb-4">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="periodFilter" class="form-label">Period</label>
                                        <select class="form-select" id="periodFilter">
                                            <option value="">All Time</option>
                                            <option value="term1">Term 1 (Jan - Apr)</option>
                                            <option value="term2">Term 2 (May - Aug)</option>
                                            <option value="term3">Term 3 (Sep - Dec)</option>
                                            <option value="month">This Month</option>
                                            <option value="quarter">This Quarter</option>
                                            <option value="year">This Year</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="statusFilter" class="form-label">Status</label>
                                        <select class="form-select" id="statusFilter">
                                            <option value="">All Statuses</option>
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="categoryFilter" class="form-label">Category</label>
                                        <select class="form-select" id="categoryFilter">
                                            <option value="">All Categories</option>
                                            <option value="office_supplies">Office Supplies</option>
                                            <option value="travel">Travel</option>
                                            <option value="utilities">Utilities</option>
                                            <option value="equipment">Equipment</option>
                                            <option value="staff_payments">Staff Payments</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="searchInput" class="form-label">Search Expenses</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="searchInput" 
                                                placeholder="Search by description, amount...">
                                            <button class="input-group-text" id="searchBtn"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button class="btn btn-primary me-2 w-50" id="applyFiltersBtn">Apply Filters</button>
                                    <button class="btn btn-outline-secondary w-50" id="resetFiltersBtn">Reset</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tabs for different views -->
                        <ul class="nav nav-tabs" id="expenseTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab">Expense List</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="charts-tab" data-bs-toggle="tab" data-bs-target="#charts" type="button" role="tab">Charts & Analytics</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">Document Storage</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="expenseTabsContent">
                            <!-- Expense List Tab -->
                            <div class="tab-pane fade show active" id="list" role="tabpanel">
                                <!-- Expenses Table -->
                                <div class="table-responsive expense-table mt-3">
                                    <table class="table table-hover" id="expensesTable">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Submitted By</th>
                                                <th style="width: 120px; text-align: center;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="expensesTableBody">
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="loading-spinner"></div>
                                                    <p class="mt-2">Loading expenses...</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                <nav aria-label="Expenses pagination" class="mt-4">
                                    <ul class="pagination justify-content-center" id="paginationContainer">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            
                            <!-- Charts & Analytics Tab -->
                            <div class="tab-pane fade" id="charts" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="expense-chart">
                                            <h4 class="mb-3">Expenses by Category</h4>
                                            <div class="chart-container">
                                                <canvas id="categoryChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="expense-chart">
                                            <h4 class="mb-3">Monthly Expenses Trend</h4>
                                            <div class="chart-container">
                                                <canvas id="monthlyTrendChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="expense-chart">
                                            <h4 class="mb-3">Term-wise Comparison</h4>
                                            <div class="chart-container">
                                                <canvas id="termComparisonChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Document Storage Tab -->
                            <div class="tab-pane fade" id="documents" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4>Expense Documentation</h4>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadDocumentModal">
                                        <i class="fas fa-upload me-1"></i> Upload Document
                                    </button>
                                </div>
                                
                                <div class="row" id="documentsContainer">
                                    <div class="col-12 text-center py-4">
                                        <div class="loading-spinner mx-auto"></div>
                                        <p class="mt-2">Loading documents...</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <p class="text-muted m-0" id="documentsCount">Showing 0 of 0 documents</p>
                                    <nav aria-label="Document pagination">
                                        <ul class="pagination m-0" id="documentsPagination">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Expense Modal -->
    <div class="modal fade" id="createExpenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="expenseForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="expenseDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="expenseDate" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="expenseCategory" class="form-label">Category</label>
                                <select class="form-select" id="expenseCategory" required>
                                    <option value="">Select Category</option>
                                    <option value="office_supplies">Office Supplies</option>
                                    <option value="travel">Travel</option>
                                    <option value="utilities">Utilities</option>
                                    <option value="equipment">Equipment</option>
                                    <option value="staff_payments">Staff Payments</option>
                                    <option value="software">Software</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="expenseDescription" class="form-label">Description</label>
                                <input type="text" class="form-control" id="expenseDescription" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="expenseAmount" class="form-label">Amount ($)</label>
                                <input type="number" step="0.01" class="form-control" id="expenseAmount" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="expenseStatus" class="form-label">Status</label>
                                <select class="form-select" id="expenseStatus" required>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="expenseSubmittedBy" class="form-label">Submitted By</label>
                                <input type="text" class="form-control" id="expenseSubmittedBy" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="expenseReceipt" class="form-label">Receipt (Optional)</label>
                                <input class="form-control" type="file" id="expenseReceipt">
                                <div class="form-text">Max file size: 5MB. Supported formats: PDF, JPG, PNG</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveExpenseBtn">Save Expense</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Document Modal -->
    <div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="documentUploadForm">
                        <div class="mb-3">
                            <label for="documentTitle" class="form-label">Document Title</label>
                            <input type="text" class="form-control" id="documentTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentCategory" class="form-label">Category</label>
                            <select class="form-select" id="documentCategory" required>
                                <option value="">Select Category</option>
                                <option value="receipts">Receipts</option>
                                <option value="invoices">Invoices</option>
                                <option value="reports">Reports</option>
                                <option value="payroll">Payroll</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="documentFile" class="form-label">Select File</label>
                            <input class="form-control" type="file" id="documentFile" required>
                            <div class="form-text">Max file size: 10MB. Supported formats: PDF, JPG, PNG, ZIP, XLSX, DOCX</div>
                        </div>
                        <div class="mb-3">
                            <label for="documentDescription" class="form-label">Description (Optional)</label>
                            <textarea class="form-control" id="documentDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="uploadDocumentBtn">Upload Document</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Expenses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="importForm">
                        <div class="mb-3">
                            <label for="importFile" class="form-label">Select CSV File</label>
                            <input class="form-control" type="file" id="importFile" accept=".csv" required>
                            <div class="form-text">Download the <a href="#" id="templateLink">template file</a> for correct formatting</div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="overwriteData">
                            <label class="form-check-label" for="overwriteData">
                                Overwrite existing data
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="importBtn">Import</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Global variables
        let expenses = [];
        let documents = [];
        let currentPage = 1;
        const itemsPerPage = 10;
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Initialize charts
        let categoryChart, trendChart, termChart;
        
        document.addEventListener('DOMContentLoaded', function() {
            // Load initial data
            loadExpenses();
            loadDocuments();
            updateSummaryCards();
            initCharts();
            
            // Set up event listeners
            document.getElementById('applyFiltersBtn').addEventListener('click', applyFilters);
            document.getElementById('resetFiltersBtn').addEventListener('click', resetFilters);
            document.getElementById('searchBtn').addEventListener('click', searchExpenses);
            document.getElementById('saveExpenseBtn').addEventListener('click', saveExpense);
            document.getElementById('uploadDocumentBtn').addEventListener('click', uploadDocument);
            document.getElementById('exportBtn').addEventListener('click', exportExpenses);
            document.getElementById('importBtn').addEventListener('click', importExpenses);
            document.getElementById('reportsBtn').addEventListener('click', generateReports);
            
            // Set today's date as default for expense date
            document.getElementById('expenseDate').valueAsDate = new Date();
        });
        
        // Load expenses from the database
        function loadExpenses() {
            // In a real application, this would be an API call to your backend
            // Simulating API call with setTimeout
            setTimeout(() => {
                // Sample data - in a real app, this would come from your database
                expenses = [
                    { id: 1, date: '2025-08-25', description: 'Office printer paper', category: 'office_supplies', amount: 85.50, status: 'approved', submittedBy: 'John Smith' },
                    { id: 2, date: '2025-08-24', description: 'Teacher salary - August', category: 'staff_payments', amount: 2500.00, status: 'approved', submittedBy: 'HR Department' },
                    { id: 3, date: '2025-08-22', description: 'Software subscription', category: 'software', amount: 299.00, status: 'approved', submittedBy: 'IT Department' },
                    { id: 4, date: '2025-08-20', description: 'Flight to conference', category: 'travel', amount: 450.00, status: 'rejected', submittedBy: 'Michael Brown' },
                    { id: 5, date: '2025-08-18', description: 'Administrative staff salary', category: 'staff_payments', amount: 3200.00, status: 'approved', submittedBy: 'HR Department' },
                    { id: 6, date: '2025-08-15', description: 'Internet bill', category: 'utilities', amount: 120.00, status: 'approved', submittedBy: 'Admin Office' },
                    { id: 7, date: '2025-08-10', description: 'New computer', category: 'equipment', amount: 1250.00, status: 'pending', submittedBy: 'IT Department' },
                    { id: 8, date: '2025-08-05', description: 'Classroom materials', category: 'office_supplies', amount: 350.00, status: 'approved', submittedBy: 'Sarah Johnson' },
                    { id: 9, date: '2025-08-01', description: 'Cleaning services', category: 'other', amount: 500.00, status: 'approved', submittedBy: 'Facilities Management' },
                    { id: 10, date: '2025-07-28', description: 'Textbooks', category: 'other', amount: 1200.00, status: 'approved', submittedBy: 'Academic Department' }
                ];
                
                renderExpensesTable();
                updateSummaryCards();
                updateCharts();
            }, 1000);
        }
        
        // Load documents from the database
        function loadDocuments() {
            // In a real application, this would be an API call to your backend
            setTimeout(() => {
                // Sample data
                documents = [
                    { id: 1, title: 'Q2 Expense Report', category: 'reports', size: '2.4 MB', type: 'pdf' },
                    { id: 2, title: 'August Receipts', category: 'receipts', size: '5.7 MB', type: 'zip' },
                    { id: 3, title: 'Staff Payment Records', category: 'payroll', size: '1.2 MB', type: 'xlsx' }
                ];
                
                renderDocuments();
            }, 800);
        }
        
        // Render expenses table
        function renderExpensesTable() {
            const tbody = document.getElementById('expensesTableBody');
            tbody.innerHTML = '';
            
            if (expenses.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <p>No expenses found</p>
                        </td>
                    </tr>
                `;
                return;
            }
            
            // Apply pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, expenses.length);
            const paginatedExpenses = expenses.slice(startIndex, endIndex);
            
            // Render expenses
            paginatedExpenses.forEach(expense => {
                const statusClass = `status-${expense.status}`;
                const statusText = expense.status.charAt(0).toUpperCase() + expense.status.slice(1);
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${formatDate(expense.date)}</td>
                    <td>${expense.description}</td>
                    <td><span class="category-badge">${formatCategory(expense.category)}</span></td>
                    <td>$${expense.amount.toFixed(2)}</td>
                    <td><span class="expense-status ${statusClass}">${statusText}</span></td>
                    <td>${expense.submittedBy}</td>
                    <td class="action-buttons">
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-sm btn-info me-1 view-expense" data-id="${expense.id}" data-bs-toggle="tooltip" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-primary me-1 edit-expense" data-id="${expense.id}" data-bs-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger delete-expense" data-id="${expense.id}" data-bs-toggle="tooltip" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });
            
            // Update pagination
            updatePagination();
            
            // Add event listeners to action buttons
            document.querySelectorAll('.view-expense').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    viewExpense(btn.dataset.id);
                });
            });
            
            document.querySelectorAll('.edit-expense').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    editExpense(btn.dataset.id);
                });
            });
            
            document.querySelectorAll('.delete-expense').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    deleteExpense(btn.dataset.id);
                });
            });
        }
        
        // Render documents
        function renderDocuments() {
            const container = document.getElementById('documentsContainer');
            container.innerHTML = '';
            
            if (documents.length === 0) {
                container.innerHTML = `
                    <div class="col-12 text-center py-4">
                        <i class="fas fa-file-upload fa-2x text-muted mb-2"></i>
                        <p>No documents uploaded yet</p>
                    </div>
                `;
                return;
            }
            
            documents.forEach(doc => {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-3';
                
                const badgeClass = doc.category === 'reports' ? 'bg-success' : 
                                 doc.category === 'receipts' ? 'bg-info' : 
                                 doc.category === 'payroll' ? 'bg-warning text-dark' : 'bg-secondary';
                
                const iconClass = doc.type === 'pdf' ? 'fa-file-pdf' :
                                doc.type === 'zip' ? 'fa-file-archive' :
                                doc.type === 'xlsx' ? 'fa-file-excel' : 'fa-file';
                
                col.innerHTML = `
                    <div class="document-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1">${doc.title}</h5>
                                <p class="text-muted mb-1">${doc.type.toUpperCase()} • ${doc.size}</p>
                                <span class="badge ${badgeClass}">${doc.category.charAt(0).toUpperCase() + doc.category.slice(1)}</span>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item download-doc" href="#" data-id="${doc.id}"><i class="fas fa-download me-2"></i>Download</a></li>
                                    <li><a class="dropdown-item share-doc" href="#" data-id="${doc.id}"><i class="fas fa-share me-2"></i>Share</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger delete-doc" href="#" data-id="${doc.id}"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(col);
            });
            
            // Update documents count
            document.getElementById('documentsCount').textContent = `Showing ${documents.length} of ${documents.length} documents`;
            
            // Add event listeners to document actions
            document.querySelectorAll('.download-doc').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    downloadDocument(btn.dataset.id);
                });
            });
            
            document.querySelectorAll('.delete-doc').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    deleteDocument(btn.dataset.id);
                });
            });
        }
        
        // Update summary cards with real data
        function updateSummaryCards() {
            if (expenses.length === 0) return;
            
            const totalExpenses = expenses.reduce((sum, expense) => sum + expense.amount, 0);
            const staffPayments = expenses
                .filter(expense => expense.category === 'staff_payments')
                .reduce((sum, expense) => sum + expense.amount, 0);
            
            document.getElementById('totalExpenses').textContent = `$${totalExpenses.toFixed(2)}`;
            document.getElementById('staffPayments').textContent = `$${staffPayments.toFixed(2)}`;
            document.getElementById('grandTotal').textContent = `$${totalExpenses.toFixed(2)}`;
        }
        
        // Initialize charts
        function initCharts() {
            // Category Pie Chart
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            categoryChart = new Chart(categoryCtx, {
                type: 'pie',
                data: {
                    labels: ['Staff Payments', 'Office Supplies', 'Software', 'Travel', 'Equipment', 'Utilities', 'Other'],
                    datasets: [{
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
            
            // Monthly Trend Chart
            const trendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
            trendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                    datasets: [{
                        label: 'Total Expenses',
                        data: [0, 0, 0, 0, 0, 0, 0, 0],
                        borderColor: '#FF7700',
                        tension: 0.3,
                        fill: true,
                        backgroundColor: 'rgba(255, 119, 0, 0.1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Term Comparison Chart
            const termCtx = document.getElementById('termComparisonChart').getContext('2d');
            termChart = new Chart(termCtx, {
                type: 'bar',
                data: {
                    labels: ['Term 1', 'Term 2', 'Term 3'],
                    datasets: [
                        {
                            label: 'Staff Payments',
                            data: [0, 0, 0],
                            backgroundColor: '#FF6384'
                        },
                        {
                            label: 'Operational Expenses',
                            data: [0, 0, 0],
                            backgroundColor: '#36A2EB'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
        
        // Update charts with real data
        function updateCharts() {
            if (expenses.length === 0) return;
            
            // Calculate category totals
            const categoryTotals = {
                staff_payments: 0,
                office_supplies: 0,
                software: 0,
                travel: 0,
                equipment: 0,
                utilities: 0,
                other: 0
            };
            
            expenses.forEach(expense => {
                if (categoryTotals.hasOwnProperty(expense.category)) {
                    categoryTotals[expense.category] += expense.amount;
                } else {
                    categoryTotals.other += expense.amount;
                }
            });
            
            // Update category chart
            categoryChart.data.datasets[0].data = [
                categoryTotals.staff_payments,
                categoryTotals.office_supplies,
                categoryTotals.software,
                categoryTotals.travel,
                categoryTotals.equipment,
                categoryTotals.utilities,
                categoryTotals.other
            ];
            categoryChart.update();
            
            // Update trend chart (simplified for demo)
            trendChart.data.datasets[0].data = [3200, 4500, 3800, 5100, 4200, 5900, 6300, 5800];
            trendChart.update();
            
            // Update term comparison chart (simplified for demo)
            termChart.data.datasets[0].data = [12500, 13200, 14500];
            termChart.data.datasets[1].data = [8500, 9200, 7800];
            termChart.update();
        }
        
        // Apply filters to expenses
        function applyFilters() {
            const period = document.getElementById('periodFilter').value;
            const status = document.getElementById('statusFilter').value;
            const category = document.getElementById('categoryFilter').value;
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            // In a real application, this would be an API call with filter parameters
            // For this demo, we'll filter the client-side data
            let filteredExpenses = [...expenses];
            
            if (status) {
                filteredExpenses = filteredExpenses.filter(expense => expense.status === status);
            }
            
            if (category) {
                filteredExpenses = filteredExpenses.filter(expense => expense.category === category);
            }
            
            if (searchTerm) {
                filteredExpenses = filteredExpenses.filter(expense => 
                    expense.description.toLowerCase().includes(searchTerm) ||
                    expense.submittedBy.toLowerCase().includes(searchTerm) ||
                    expense.amount.toString().includes(searchTerm)
                );
            }
            
            // For period filtering, we would need to implement date logic
            // This is simplified for the demo
            
            expenses = filteredExpenses;
            currentPage = 1;
            renderExpensesTable();
            updateSummaryCards();
            updateCharts();
        }
        
        // Reset filters
        function resetFilters() {
            document.getElementById('periodFilter').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('categoryFilter').value = '';
            document.getElementById('searchInput').value = '';
            
            // Reload all expenses
            loadExpenses();
        }
        
        // Search expenses
        function searchExpenses() {
            applyFilters();
        }
        
        // Save new expense
        function saveExpense() {
            const date = document.getElementById('expenseDate').value;
            const category = document.getElementById('expenseCategory').value;
            const description = document.getElementById('expenseDescription').value;
            const amount = parseFloat(document.getElementById('expenseAmount').value);
            const status = document.getElementById('expenseStatus').value;
            const submittedBy = document.getElementById('expenseSubmittedBy').value;
            
            if (!date || !category || !description || isNaN(amount) || !submittedBy) {
                alert('Please fill in all required fields');
                return;
            }
            
            // In a real application, this would be an API call to save to the database
            const newExpense = {
                id: expenses.length > 0 ? Math.max(...expenses.map(e => e.id)) + 1 : 1,
                date,
                description,
                category,
                amount,
                status,
                submittedBy
            };
            
            expenses.unshift(newExpense);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('createExpenseModal'));
            modal.hide();
            
            // Reset form
            document.getElementById('expenseForm').reset();
            document.getElementById('expenseDate').valueAsDate = new Date();
            
            // Update UI
            renderExpensesTable();
            updateSummaryCards();
            updateCharts();
            
            alert('Expense added successfully!');
        }
        
        // View expense details
        function viewExpense(id) {
            const expense = expenses.find(e => e.id === parseInt(id));
            if (expense) {
                alert(`Expense Details:\n\nDate: ${formatDate(expense.date)}\nDescription: ${expense.description}\nCategory: ${formatCategory(expense.category)}\nAmount: $${expense.amount.toFixed(2)}\nStatus: ${expense.status}\nSubmitted By: ${expense.submittedBy}`);
            }
        }
        
        // Edit expense
        function editExpense(id) {
            const expense = expenses.find(e => e.id === parseInt(id));
            if (expense) {
                // In a real application, this would open an edit modal with the expense data
                alert(`Edit functionality would open for expense: ${expense.description}`);
            }
        }
        
        // Delete expense
        function deleteExpense(id) {
            if (confirm('Are you sure you want to delete this expense?')) {
                expenses = expenses.filter(e => e.id !== parseInt(id));
                renderExpensesTable();
                updateSummaryCards();
                updateCharts();
                alert('Expense deleted successfully!');
            }
        }
        
        // Upload document
        function uploadDocument() {
            const title = document.getElementById('documentTitle').value;
            const category = document.getElementById('documentCategory').value;
            const fileInput = document.getElementById('documentFile');
            
            if (!title || !category || !fileInput.files[0]) {
                alert('Please fill in all required fields');
                return;
            }
            
            const file = fileInput.files[0];
            const fileSize = (file.size / (1024 * 1024)).toFixed(1); // MB
            const fileType = file.name.split('.').pop().toLowerCase();
            
            // In a real application, this would upload the file to a server
            const newDocument = {
                id: documents.length > 0 ? Math.max(...documents.map(d => d.id)) + 1 : 1,
                title,
                category,
                size: `${fileSize} MB`,
                type: fileType
            };
            
            documents.unshift(newDocument);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('uploadDocumentModal'));
            modal.hide();
            
            // Reset form
            document.getElementById('documentUploadForm').reset();
            
            // Update UI
            renderDocuments();
            
            alert('Document uploaded successfully!');
        }
        
        // Download document
        function downloadDocument(id) {
            const doc = documents.find(d => d.id === parseInt(id));
            if (doc) {
                alert(`Download functionality would initiate for: ${doc.title}`);
            }
        }
        
        // Delete document
        function deleteDocument(id) {
            if (confirm('Are you sure you want to delete this document?')) {
                documents = documents.filter(d => d.id !== parseInt(id));
                renderDocuments();
                alert('Document deleted successfully!');
            }
        }
        
        // Export expenses
        function exportExpenses() {
            // In a real application, this would generate a CSV or Excel file
            alert('Export functionality would generate a file with all expense data.');
        }
        
        // Import expenses
        function importExpenses() {
            const fileInput = document.getElementById('importFile');
            
            if (!fileInput.files[0]) {
                alert('Please select a file to import');
                return;
            }
            
            // In a real application, this would process the CSV file
            alert('Import functionality would process the selected file and add expenses to the database.');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
            modal.hide();
            
            // Reset form
            document.getElementById('importForm').reset();
        }
        
        // Generate reports
        function generateReports() {
            alert('Report generation would create detailed expense reports.');
        }
        
        // Update pagination
        function updatePagination() {
            const totalPages = Math.ceil(expenses.length / itemsPerPage);
            const paginationContainer = document.getElementById('paginationContainer');
            
            if (totalPages <= 1) {
                paginationContainer.innerHTML = '';
                return;
            }
            
            let paginationHTML = `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
                </li>
            `;
            
            for (let i = 1; i <= totalPages; i++) {
                paginationHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            }
            
            paginationHTML += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
                </li>
            `;
            
            paginationContainer.innerHTML = paginationHTML;
            
            // Add event listeners to pagination links
            paginationContainer.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (link.dataset.page) {
                        currentPage = parseInt(link.dataset.page);
                        renderExpensesTable();
                    }
                });
            });
        }
        
        // Helper function to format date
        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString(undefined, options);
        }
        
        // Helper function to format category
        function formatCategory(category) {
            return category.split('_').map(word => 
                word.charAt(0).toUpperCase() + word.slice(1)
            ).join(' ');
        }
    </script>
</body>
</html>