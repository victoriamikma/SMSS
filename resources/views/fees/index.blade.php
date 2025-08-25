<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees Management - SwiftSolve School System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-gray);
        }
        
        /* Header Styles */
        header {
            background-color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Button Styles */
        .btn-primary {
            background-color: var(--primary-orange);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary:hover {
            background-color: var(--dark-orange);
        }
        
        .btn-secondary {
            background-color: var(--medium-gray);
            color: var(--dark-gray);
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-secondary:hover {
            background-color: #D0D0D0;
        }
        
        .btn-success {
            background-color: var(--success);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-success:hover {
            background-color: #3d8b40;
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            padding: 1rem;
            text-align: left;
            color: var(--primary-orange);
            font-weight: 600;
            background-color: var(--lighter-orange);
        }
        
        td {
            padding: 1rem;
            border-bottom: 1px solid var(--medium-gray);
        }
        
        /* Status Badges */
        .status-badge {
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            font-size: 0.8rem;
            color: white;
        }
        
        .status-active {
            background-color: var(--success);
        }
        
        .status-inactive {
            background-color: var(--danger);
        }
        
        /* Action Buttons */
        .btn-action {
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 0.5rem;
        }
        
        .btn-edit {
            background-color: var(--info);
            color: white;
        }
        
        .btn-delete {
            background-color: var(--danger);
            color: white;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
            background-color: var(--white);
            margin: 5% auto;
            padding: 2rem;
            border-radius: 8px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--medium-gray);
        }
        
        .modal-title {
            color: var(--primary-orange);
            font-size: 1.5rem;
            margin: 0;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: var(--dark-gray);
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-gray);
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            font-family: inherit;
        }
        
        .form-row {
            display: flex;
            gap: 1rem;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--medium-gray);
        }
        
        /* Notification */
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
        }
        
        .notification.error {
            background-color: var(--danger);
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
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div>
            <h1 style="font-size: 1.5rem; color: #222222;">
                <span style="color: #FF6B00; font-weight: 700;">SWIFT</span>
                <span style="color: #222222; font-weight: 700;">SOLVE</span> SCHOOL SYSTEM
            </h1>
            <p style="color: #222222; opacity: 0.7; font-size: 0.9rem;">Kampala, Uganda | +256 702 064 779</p>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="https://via.placeholder.com/40" alt="User" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
            <span>Admin User</span>
            <a href="#" style="color: #555555;">
                <i class="fas fa-cog"></i>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <div style="display: flex; min-height: calc(100vh - 130px);">
        <!-- Sidebar -->
        <aside style="width: 250px; background-color: #FFFFFF; padding: 1.5rem; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);">
            <h2 style="color: #222222; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-money-bill-wave"></i> Fees Management
            </h2>
            <nav>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 0.5rem;">
                        <a href="#" style="display: block; padding: 0.8rem 1rem; background-color: #FFE4CC; color: #FF6B00; text-decoration: none; border-radius: 6px; font-weight: 500;">
                            <i class="fas fa-list"></i> Fee Structures
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="#" style="display: block; padding: 0.8rem 1rem; color: #555555; text-decoration: none; border-radius: 6px;">
                            <i class="fas fa-money-check"></i> Fee Collection
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="#" style="display: block; padding: 0.8rem 1rem; color: #555555; text-decoration: none; border-radius: 6px;">
                            <i class="fas fa-file-invoice-dollar"></i> Invoices
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="#" style="display: block; padding: 0.8rem 1rem; color: #555555; text-decoration: none; border-radius: 6px;">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="#" style="display: block; padding: 0.8rem 1rem; color: #555555; text-decoration: none; border-radius: 6px;">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Content Area -->
        <main style="flex: 1; padding: 1.5rem;">
            <!-- Page Header -->
            <div style="background-color: #FFFFFF; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="color: #222222; margin: 0;">Fee Structures</h2>
                    <button class="btn-primary" id="addFeeBtn">
                        <i class="fas fa-plus"></i> Add New Fee Structure
                    </button>
                </div>
                <p style="color: #555555; margin-top: 0.5rem;">Manage all fee structures for different classes and programs</p>
            </div>

            <!-- Import/Export Section -->
            <div class="import-export">
                <button class="btn-secondary" id="importBtn">
                    <i class="fas fa-file-import"></i> Import Fees
                </button>
                <button class="btn-success" id="exportBtn">
                    <i class="fas fa-file-export"></i> Export Fees
                </button>
                <button class="btn-secondary" id="downloadTemplateBtn">
                    <i class="fas fa-download"></i> Download Template
                </button>
            </div>

            <!-- Filters and Search -->
            <div style="background-color: #FFFFFF; border-radius: 8px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <div style="position: relative; flex: 1;">
                    <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #555555;"></i>
                    <input type="text" id="searchInput" placeholder="Search fee structures..." style="width: 100%; padding: 0.6rem 1rem 0.6rem 2.5rem; border: 1px solid #E0E0E0; border-radius: 6px;">
                </div>
                <select id="classFilter" style="padding: 0.6rem; border: 1px solid #E0E0E0; border-radius: 6px;">
                    <option value="">All Classes</option>
                    <option value="Primary 1">Primary 1</option>
                    <option value="Primary 2">Primary 2</option>
                    <option value="Secondary 1">Secondary 1</option>
                </select>
                <select id="statusFilter" style="padding: 0.6rem; border: 1px solid #E0E0E0; border-radius: 6px;">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <!-- Fee Structures Table -->
            <div style="background-color: #FFFFFF; border-radius: 8px; padding: 1.5rem; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);">
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Fee Name</th>
                                <th>Class/Program</th>
                                <th>Amount (UGX)</th>
                                <th>Frequency</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="feeTableBody">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                    <div style="color: #555555;" id="paginationInfo">
                        Showing 0 to 0 of 0 entries
                    </div>
                    <div style="display: flex; gap: 0.5rem;" id="paginationControls">
                        <button class="btn-primary" id="prevPageBtn" disabled>
                            Previous
                        </button>
                        <button class="btn-primary" id="nextPageBtn" disabled>
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer style="background-color: #FFFFFF; padding: 1rem; text-align: center; font-size: 0.8rem; color: #222222; opacity: 0.7; border-top: 1px solid #E0E0E0;">
        <p>© 2023 Swift Solve Tech Solutions | hello@swiftsolvetech.ug</p>
        <p>System Version: 1.0.0 | Last Updated: 20/11/2023</p>
    </footer>

    <!-- Add/Edit Fee Modal -->
    <div id="feeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Add Fee Structure</h2>
                <span class="close">&times;</span>
            </div>
            <form id="feeForm">
                <input type="hidden" id="feeId">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Fee Name *</label>
                        <input type="text" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="class">Class/Program *</label>
                        <select id="class" required>
                            <option value="">Select Class/Program</option>
                            <option value="Primary 1">Primary 1</option>
                            <option value="Primary 2">Primary 2</option>
                            <option value="Primary 3">Primary 3</option>
                            <option value="Primary 4">Primary 4</option>
                            <option value="Primary 5">Primary 5</option>
                            <option value="Primary 6">Primary 6</option>
                            <option value="Primary 7">Primary 7</option>
                            <option value="Secondary 1">Secondary 1</option>
                            <option value="Secondary 2">Secondary 2</option>
                            <option value="Secondary 3">Secondary 3</option>
                            <option value="Secondary 4">Secondary 4</option>
                            <option value="All Classes">All Classes</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="amount">Amount (UGX) *</label>
                        <input type="number" id="amount" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="frequency">Frequency *</label>
                        <select id="frequency" required>
                            <option value="">Select Frequency</option>
                            <option value="Termly">Termly</option>
                            <option value="Annual">Annual</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Per Exam">Per Exam</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="dueDate">Due Date *</label>
                        <input type="text" id="dueDate" placeholder="e.g., 15th of Month" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" required>
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" rows="3"></textarea>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="cancelBtn">Cancel</button>
                <button type="button" class="btn-primary" id="saveFeeBtn">
                    <span id="saveButtonText">Save Fee Structure</span>
                    <span id="saveButtonLoading" class="loading" style="display: none;"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Import Fee Structures</h2>
                <span class="close">&times;</span>
            </div>
            <div class="form-group">
                <label for="importFile">Select Excel/CSV File</label>
                <input type="file" id="importFile" accept=".xlsx,.csv">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="cancelImportBtn">Cancel</button>
                <button type="button" class="btn-primary" id="processImportBtn">
                    <span id="importButtonText">Import</span>
                    <span id="importButtonLoading" class="loading" style="display: none;"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // API endpoints
        const API_BASE = '/fees';
        const API = {
            index: `${API_BASE}`,
            store: `${API_BASE}`,
            update: (id) => `${API_BASE}/${id}`,
            destroy: (id) => `${API_BASE}/${id}`,
            show: (id) => `${API_BASE}/${id}`,
            import: `${API_BASE}/import`,
            export: `${API_BASE}/export`,
            template: `${API_BASE}/template`
        };

        // Global variables
        let currentPage = 1;
        let perPage = 10;
        let totalFees = 0;
        let allFees = [];

        // Initialize the application
        $(document).ready(function() {
            // Load initial data
            loadFeesData();
            
            // Add fee button
            $('#addFeeBtn').click(function() {
                setupAddFeeHandler();
                $('#feeModal').show();
            });
            
            // Close modals
            $('.close, #cancelBtn, #cancelImportBtn').click(function() {
                $('#feeModal, #importModal').hide();
            });
            
            // Save fee button
            $('#saveFeeBtn').click(function() {
                const form = document.getElementById('feeForm');
                if (form.checkValidity()) {
                    saveFee();
                } else {
                    form.reportValidity();
                }
            });
            
            // Import functionality
            $('#importBtn').click(function() {
                $('#importModal').show();
            });
            
            $('#processImportBtn').click(function() {
                const fileInput = $('#importFile')[0];
                if (fileInput.files.length === 0) {
                    showNotification('Please select a file to import', 'error');
                    return;
                }
                
                processImport(fileInput.files[0]);
            });
            
            // Export functionality
            $('#exportBtn').click(function() {
                exportFees();
            });
            
            // Download template
            $('#downloadTemplateBtn').click(function() {
                downloadTemplate();
            });
            
            // Search functionality
            $('#searchInput').on('keyup', function() {
                filterFees();
            });
            
            // Filter functionality
            $('#classFilter, #statusFilter').change(function() {
                filterFees();
            });
            
            // Pagination
            $('#prevPageBtn').click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderFeesTable();
                }
            });
            
            $('#nextPageBtn').click(function() {
                const totalPages = Math.ceil(totalFees / perPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderFeesTable();
                }
            });
        });
        
        // Load fees data from API
        function loadFeesData() {
            $.ajax({
                url: API.index,
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    allFees = response.data || response;
                    totalFees = allFees.length;
                    renderFeesTable();
                    updatePaginationInfo();
                },
                error: function(xhr) {
                    showNotification('Error loading fees data: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
                }
            });
        }
        
        // Render fees table
        function renderFeesTable() {
            const tableBody = $('#feeTableBody');
            tableBody.empty();
            
            // Apply filters
            let filteredFees = filterFeesData(allFees);
            
            // Apply pagination
            const startIndex = (currentPage - 1) * perPage;
            const endIndex = Math.min(startIndex + perPage, filteredFees.length);
            const paginatedFees = filteredFees.slice(startIndex, endIndex);
            
            if (paginatedFees.length === 0) {
                tableBody.append(`
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: #555555;">
                            No fee structures found
                        </td>
                    </tr>
                `);
                return;
            }
            
            paginatedFees.forEach(fee => {
                const row = `
                    <tr data-id="${fee.id}">
                        <td>${fee.name}</td>
                        <td>${fee.class || 'N/A'}</td>
                        <td>UGX ${fee.amount ? Number(fee.amount).toLocaleString() : '0'}</td>
                        <td>${fee.frequency || 'N/A'}</td>
                        <td>${fee.due_date || 'N/A'}</td>
                        <td>
                            <span class="status-badge ${fee.status === 'active' ? 'status-active' : 'status-inactive'}">
                                ${fee.status === 'active' ? 'Active' : 'Inactive'}
                            </span>
                        </td>
                        <td>
                            <button class="btn-action btn-edit" data-id="${fee.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action btn-delete" data-id="${fee.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
            
            // Add event listeners
            $('.btn-edit').click(function() {
                const id = $(this).data('id');
                editFee(id);
            });
            
            $('.btn-delete').click(function() {
                const id = $(this).data('id');
                deleteFee(id);
            });
            
            updatePaginationInfo();
        }
        
        // Filter fees data
        function filterFeesData(fees) {
            const searchTerm = $('#searchInput').val().toLowerCase();
            const classFilter = $('#classFilter').val();
            const statusFilter = $('#statusFilter').val();
            
            return fees.filter(fee => {
                const matchesSearch = !searchTerm || 
                    fee.name.toLowerCase().includes(searchTerm) ||
                    (fee.class && fee.class.toLowerCase().includes(searchTerm)) ||
                    (fee.description && fee.description.toLowerCase().includes(searchTerm));
                
                const matchesClass = !classFilter || fee.class === classFilter;
                const matchesStatus = !statusFilter || fee.status === statusFilter;
                
                return matchesSearch && matchesClass && matchesStatus;
            });
        }
        
        // Apply filters and re-render table
        function filterFees() {
            currentPage = 1; // Reset to first page when filtering
            renderFeesTable();
        }
        
        // Update pagination info
        function updatePaginationInfo() {
            const filteredFees = filterFeesData(allFees);
            const totalFiltered = filteredFees.length;
            const totalPages = Math.ceil(totalFiltered / perPage);
            const startIndex = (currentPage - 1) * perPage + 1;
            const endIndex = Math.min(startIndex + perPage - 1, totalFiltered);
            
            $('#paginationInfo').text(`Showing ${startIndex} to ${endIndex} of ${totalFiltered} entries`);
            
            // Enable/disable pagination buttons
            $('#prevPageBtn').prop('disabled', currentPage <= 1);
            $('#nextPageBtn').prop('disabled', currentPage >= totalPages);
        }
        
        // Setup add fee handler
        function setupAddFeeHandler() {
            $('#modalTitle').text('Add Fee Structure');
            $('#saveButtonText').text('Save Fee Structure');
            $('#feeForm')[0].reset();
            $('#feeId').val('');
            
            $('#saveFeeBtn').off('click').click(function() {
                const form = document.getElementById('feeForm');
                if (form.checkValidity()) {
                    saveFee();
                } else {
                    form.reportValidity();
                }
            });
        }
        
        // Save fee (create or update)
        function saveFee() {
            const formData = {
                name: $('#name').val(),
                class: $('#class').val(),
                amount: parseFloat($('#amount').val()),
                frequency: $('#frequency').val(),
                due_date: $('#dueDate').val(),
                status: $('#status').val(),
                description: $('#description').val()
            };
            
            const feeId = $('#feeId').val();
            const url = feeId ? API.update(feeId) : API.store;
            const method = feeId ? 'PUT' : 'POST';
            
            // Show loading state
            $('#saveButtonText').hide();
            $('#saveButtonLoading').show();
            $('#saveFeeBtn').prop('disabled', true);
            
            $.ajax({
                url: url,
                type: method,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Refresh table
                    loadFeesData();
                    
                    // Close modal and show notification
                    $('#feeModal').hide();
                    showNotification(`Fee structure ${feeId ? 'updated' : 'added'} successfully`, 'success');
                },
                error: function(xhr) {
                    showNotification('Error saving fee: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
                },
                complete: function() {
                    $('#saveButtonText').show();
                    $('#saveButtonLoading').hide();
                    $('#saveFeeBtn').prop('disabled', false);
                }
            });
        }
        
        // Edit fee
        function editFee(id) {
            $.ajax({
                url: API.show(id),
                type: 'GET',
                success: function(fee) {
                    // Populate the form with fee data
                    $('#feeId').val(fee.id);
                    $('#name').val(fee.name);
                    $('#class').val(fee.class);
                    $('#amount').val(fee.amount);
                    $('#frequency').val(fee.frequency);
                    $('#dueDate').val(fee.due_date);
                    $('#status').val(fee.status);
                    $('#description').val(fee.description);
                    
                    // Change modal title and button text
                    $('#modalTitle').text('Edit Fee Structure');
                    $('#saveButtonText').text('Update Fee Structure');
                    
                    // Show the modal
                    $('#feeModal').show();
                    
                    // Change save handler to update instead of create
                    $('#saveFeeBtn').off('click').click(function() {
                        const form = document.getElementById('feeForm');
                        if (form.checkValidity()) {
                            saveFee();
                        } else {
                            form.reportValidity();
                        }
                    });
                },
                error: function(xhr) {
                    showNotification('Error loading fee: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
                }
            });
        }
        
        // Delete fee
        function deleteFee(id) {
            if (confirm('Are you sure you want to delete this fee structure?')) {
                $.ajax({
                    url: API.destroy(id),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Refresh table
                        loadFeesData();
                        showNotification('Fee structure deleted successfully', 'success');
                    },
                    error: function(xhr) {
                        showNotification('Error deleting fee: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
                    }
                });
            }
        }
        
        // Process import
        function processImport(file) {
            const formData = new FormData();
            formData.append('file', file);
            
            $('#importButtonText').hide();
            $('#importButtonLoading').show();
            $('#processImportBtn').prop('disabled', true);
            
            $.ajax({
                url: API.import,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    showNotification('Fees imported successfully', 'success');
                    $('#importModal').hide();
                    loadFeesData();
                },
                error: function(xhr) {
                    showNotification('Error importing fees: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
                },
                complete: function() {
                    $('#importButtonText').show();
                    $('#importButtonLoading').hide();
                    $('#processImportBtn').prop('disabled', false);
                }
            });
        }
        
        // Export fees
        function exportFees() {
            window.location.href = API.export;
        }
        
        // Download template
        function downloadTemplate() {
            window.location.href = API.template;
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