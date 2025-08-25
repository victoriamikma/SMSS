<!-- @php
    // Fallback values in case controller doesn't pass the variables
    $staffCount = $staffCount ?? 0;
    $totalSalary = $totalSalary ?? 0;
    $lastProcessed = $lastProcessed ?? null;
    $staff = $staff ?? collect([]);
@endphp -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwiftSolve Staff Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Orange Theme Variables */
        :root {
            --primary-orange: #FF6B00;
            --dark-orange: #E55D00;
            --light-orange: #FFA040;
            --lighter-orange: #FFD1A0;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
            --medium-gray: #E0E0E0;
            --dark-gray: #333333;
            --success: #4CAF50;
            --danger: #F44336;
            --warning: #FFC107;
            --info: #2196F3;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', sans-serif;
            color: var(--dark-gray);
        }
        
        /* Navigation */
        .navbar {
            background: linear-gradient(90deg, var(--primary-orange) 0%, var(--dark-orange) 100%);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .card-header {
            background-color: var(--white);
            border-bottom: 1px solid var(--medium-gray);
            padding: 1rem 1.35rem;
            font-weight: 700;
        }
        
        /* Buttons */
        .btn-primary {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
        }
        
        .btn-primary:hover {
            background-color: var(--dark-orange);
            border-color: var(--dark-orange);
        }
        
        .btn-outline-primary {
            color: var(--primary-orange);
            border-color: var(--primary-orange);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-orange);
            color: var(--white);
        }
        
        /* Stats Cards */
        .stat-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            height: 100%;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #FFE4CC;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-orange);
            font-size: 1.25rem;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 0.4em 0.8em;
            border-radius: 0.35rem;
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .bg-active {
            background-color: rgba(28, 200, 138, 0.2);
            color: var(--success);
        }
        
        /* Tables */
        .table th {
            border-top: none;
            font-weight: 700;
            color: var(--dark-gray);
            background-color: var(--light-gray);
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(255, 107, 0, 0.05);
        }
        
        /* Tabs */
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--medium-gray);
            padding-bottom: 10px;
        }
        
        .tabs button {
            padding: 10px 20px;
            background: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            color: #555;
            transition: all 0.2s;
        }
        
        .tabs button.active {
            background-color: var(--primary-orange);
            color: var(--white);
        }
        
        .tabs button:hover:not(.active) {
            background-color: var(--light-gray);
        }
        
        /* Action Buttons */
        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .btn-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            background-color: transparent;
            color: #555;
            transition: all 0.2s;
        }
        
        .btn-icon:hover {
            background-color: var(--light-gray);
        }
        
        .btn-icon.edit {
            color: var(--info);
        }
        
        .btn-icon.delete {
            color: var(--danger);
        }
        
        .btn-icon.payment {
            color: var(--success);
        }
        
        /* Page Title */
        .page-title {
            color: var(--dark-gray);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }
        
        .page-title i {
            color: var(--primary-orange);
        }
        
        /* Contact Links */
        .contact-link {
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--dark-gray);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .contact-link:hover {
            color: var(--primary-orange);
        }
        
        /* Search Box */
        .search-box {
            position: relative;
            flex: 1;
            min-width: 250px;
            margin-right: 15px;
        }
        
        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 35px;
            border: 1px solid var(--medium-gray);
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }
        
        /* Modal Styles */
        .modal-header {
            background-color: var(--light-gray);
            border-bottom: 1px solid var(--medium-gray);
        }
        
        .modal-title {
            color: var(--primary-orange);
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--medium-gray);
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        /* Tab Content */
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Report Cards */
        .report-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .report-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .report-card h3 {
            margin-bottom: 15px;
            color: var(--dark-gray);
            border-bottom: 1px solid var(--medium-gray);
            padding-bottom: 10px;
        }
        
        /* Real-time notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background-color: var(--success);
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1050;
            display: none;
            animation: slideIn 0.3s ease;
        }
        
        .notification.error {
            background-color: var(--danger);
        }
        
        @keyframes slideIn {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        /* Loading indicator */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,107,0,0.3);
            border-radius: 50%;
            border-top-color: var(--primary-orange);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Import/Export Section */
        .import-export {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Real-time notification -->
    <div class="notification" id="notification"></div>

    <div class="container">
        <h1 class="page-title"><i class="fas fa-user"></i> Staff & Payroll Management</h1>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Staff</h3>
                        <p id="total-staff">{{ $staffCount }}</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Monthly Payroll</h3>
                        <p id="monthly-payroll">UGX {{ number_format($totalSalary) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Last Processed</h3>
                        <p id="last-processed">{{ $lastProcessed ?? 'None' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Pending Updates</h3>
                        <p id="pending-updates">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="tabs">
            <button class="active" data-tab="staff">
                <i class="fas fa-user"></i> Staff
            </button>
            <button data-tab="payroll">
                <i class="fas fa-dollar-sign"></i> Payroll
            </button>
            <button data-tab="reports">
                <i class="fas fa-print"></i> Reports
            </button>
        </div>

        <!-- Import/Export Buttons -->
        <div class="import-export">
            <button class="btn btn-outline-primary" id="importBtn">
                <i class="fas fa-file-import"></i> Import Staff
            </button>
            <button class="btn btn-outline-primary" id="exportBtn">
                <i class="fas fa-file-export"></i> Export Staff
            </button>
            <button class="btn btn-outline-primary" id="downloadTemplateBtn">
                <i class="fas fa-download"></i> Download Template
            </button>
        </div>

        <!-- Search and Actions -->
        <div class="d-flex justify-content-between mb-4 flex-wrap gap-3">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="search-input" placeholder="Search staff...">
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary" id="add-staff-btn">
                    <i class="fas fa-plus"></i> Add Staff
                </button>
                <button class="btn btn-outline-primary" id="refresh-data">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>

        <!-- Staff Tab -->
        <div class="tab-content active" id="staff-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Staff Members</h6>
                    <span id="staff-count">{{ $staffCount }} staff members</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="staffTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Staff ID</th>
                                    <th>Role</th>
                                    <th>Contact</th>
                                    <th>Salary</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="staff-table-body">
                                @forelse($staff as $member)
                                <tr data-id="{{ $member->id }}">
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->id }}</td>
                                    <td>{{ $member->role }}</td>
                                    <td>{{ $member->contact }}</td>
                                    <td>UGX {{ number_format($member->salary) }}</td>
                                    <td><span class="status-badge bg-active">Active</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon edit" data-id="{{ $member->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon delete" data-id="{{ $member->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <button class="btn-icon payment" data-id="{{ $member->id }}">
                                                <i class="fas fa-dollar-sign"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        No staff members found. <a href="#" id="add-first-staff">Add the first staff member</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payroll Tab -->
        <div class="tab-content" id="payroll-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payroll Records</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="payrollTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Period</th>
                                    <th>Staff Member</th>
                                    <th>Basic Salary</th>
                                    <th>Allowances</th>
                                    <th>Deductions</th>
                                    <th>Net Pay</th>
                                    <th>Payment Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="payroll-table-body">
                                <!-- Payroll data will be populated here -->
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        No payroll records found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Tab -->
        <div class="tab-content" id="reports-tab">
            <div class="report-cards">
                <div class="report-card">
                    <h3>Monthly Payroll Summary</h3>
                    <div class="report-content">
                        <p>Total Staff: <span id="report-total-staff">{{ $staffCount }}</span></p>
                        <p>Total Salary: <span id="report-total-salary">UGX {{ number_format($totalSalary) }}</span></p>
                        <p>Last Processed: <span id="report-last-processed">{{ $lastProcessed ?? 'None' }}</span></p>
                    </div>
                    <button class="btn btn-primary" id="download-payroll-report">
                        <i class="fas fa-download"></i> Download Report
                    </button>
                </div>

                <div class="report-card">
                    <h3>NSSF Deductions</h3>
                    <div class="report-content">
                        <p>Total Deducted: <span id="report-nssf-deductions">UGX {{ number_format($totalSalary * 0.05) }}</span></p>
                        <p>Staff Count: <span id="report-staff-count">{{ $staffCount }}</span></p>
                    </div>
                    <button class="btn btn-primary" id="download-nssf-report">
                        <i class="fas fa-download"></i> Download Report
                    </button>
                </div>

                <div class="report-card">
                    <h3>Tax (PAYE) Report</h3>
                    <div class="report-content">
                        <p>Estimated PAYE: <span id="report-paye">UGX {{ number_format($totalSalary > 1000000 ? ($totalSalary - 1000000) * 0.1 : 0) }}</span></p>
                    </div>
                    <button class="btn btn-primary" id="download-paye-report">
                        <i class="fas fa-download"></i> Download Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStaffModalLabel">Add New Staff Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="staffForm">
                        <input type="hidden" id="staffId">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="form-group">
                                <label for="role" class="form-label">Role *</label>
                                <input type="text" class="form-control" id="role" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="gender" class="form-label">Gender *</label>
                                <select class="form-select" id="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="contact" class="form-label">Contact *</label>
                                <input type="tel" class="form-control" id="contact" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="salary" class="form-label">Salary (UGX) *</label>
                                <input type="number" class="form-control" id="salary" required>
                            </div>
                            <div class="form-group">
                                <label for="bank_name" class="form-label">Bank Name *</label>
                                <input type="text" class="form-control" id="bank_name" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="bank_account" class="form-label">Bank Account Number *</label>
                                <input type="text" class="form-control" id="bank_account" required>
                            </div>
                            <div class="form-group">
                                <label for="last_payment" class="form-label">Last Payment Date</label>
                                <input type="date" class="form-control" id="last_payment">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nssf_number" class="form-label">NSSF Number</label>
                                <input type="text" class="form-control" id="nssf_number">
                            </div>
                            <div class="form-group">
                                <label for="tin_number" class="form-label">TIN Number</label>
                                <input type="text" class="form-control" id="tin_number">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveStaffBtn">
                        <span id="save-button-text">Save Staff Member</span>
                        <span id="save-button-loading" class="loading" style="display: none;"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="importFile" class="form-label">Select Excel/CSV File</label>
                        <input type="file" class="form-control" id="importFile" accept=".xlsx,.csv">
                    </div>
                    <div class="mt-3">
                        <p class="small text-muted">Download the template file to ensure proper formatting.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="processImport">
                        <span id="import-button-text">Import</span>
                        <span id="import-button-loading" class="loading" style="display: none;"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 mt-5 text-muted">
        <p>© 2025 SwiftSolve Staff Management System</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Initialize the application
        $(document).ready(function() {
            // Tab switching
            $('.tabs button').click(function() {
                const tab = $(this).data('tab');
                $('.tabs button').removeClass('active');
                $(this).addClass('active');
                
                $('.tab-content').removeClass('active');
                $(`#${tab}-tab`).addClass('active');
                
                $('#search-input').attr('placeholder', `Search ${tab}...`);
            });

            // Add staff button
            $('#add-staff-btn').click(function() {
                setupAddStaffHandler();
                $('#addStaffModal').modal('show');
            });

            // Refresh data button
            $('#refresh-data').click(function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-sync-alt fa-spin"></i> Refreshing...');
                
                // Refresh the page
                setTimeout(function() {
                    location.reload();
                }, 1000);
            });

            // Save staff button
            $('#saveStaffBtn').click(function() {
                const form = document.getElementById('staffForm');
                if (form.checkValidity()) {
                    saveStaffMember();
                } else {
                    form.reportValidity();
                }
            });
            
            // Search functionality
            $('#search-input').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $('#staff-table-body tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Import functionality
            $('#importBtn').click(function() {
                $('#importModal').modal('show');
            });

            // Process import
            $('#processImport').click(function() {
                const fileInput = $('#importFile')[0];
                if (fileInput.files.length === 0) {
                    showNotification('Please select a file to import', 'error');
                    return;
                }

                showNotification('Import feature will be implemented soon', 'info');
                $('#importModal').modal('hide');
            });

            // Export functionality
            $('#exportBtn').click(function() {
                showNotification('Export feature will be implemented soon', 'info');
            });

            // Download template
            $('#downloadTemplateBtn').click(function() {
                showNotification('Template download will be implemented soon', 'info');
            });

            // Report download buttons
            $('#download-payroll-report, #download-nssf-report, #download-paye-report').click(function() {
                showNotification('Report download feature will be implemented soon', 'info');
            });

            // Edit staff button handlers
            $('.btn-icon.edit').click(function() {
                const id = $(this).data('id');
                showNotification('Edit feature will be implemented soon for staff ID: ' + id, 'info');
            });
            
            $('.btn-icon.delete').click(function() {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this staff member?')) {
                    showNotification('Delete feature will be implemented soon for staff ID: ' + id, 'info');
                }
            });
            
            $('.btn-icon.payment').click(function() {
                const id = $(this).data('id');
                showNotification('Payment processing will be implemented soon for staff ID: ' + id, 'info');
            });
        });

        // Save new staff member
        function saveStaffMember() {
            // Show loading state
            $('#save-button-text').hide();
            $('#save-button-loading').show();
            $('#saveStaffBtn').prop('disabled', true);
            
            // Simulate API call
            setTimeout(function() {
                showNotification('Staff member added successfully (demo)', 'success');
                $('#addStaffModal').modal('hide');
                
                // Reset loading state
                $('#save-button-text').show();
                $('#save-button-loading').hide();
                $('#saveStaffBtn').prop('disabled', false);
            }, 1500);
        }

        // Setup add staff handler
        function setupAddStaffHandler() {
            $('#addStaffModalLabel').text('Add New Staff Member');
            $('#save-button-text').text('Save Staff Member');
            $('#staffForm')[0].reset();
            $('#staffId').val('');
            
            $('#saveStaffBtn').off('click').click(function() {
                const form = document.getElementById('staffForm');
                if (form.checkValidity()) {
                    saveStaffMember();
                } else {
                    form.reportValidity();
                }
            });
        }

        // Show notification
        function showNotification(message, type = 'success') {
            const notification = $('#notification');
            notification.removeClass('error');
            
            if (type === 'error') {
                notification.addClass('error');
            }
            
            notification.text(message).fadeIn();
            
            setTimeout(function() {
                notification.fadeOut();
            }, 3000);
        }
    </script>
</body>
</html>