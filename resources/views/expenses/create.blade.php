<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Expense - SwiftSolve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-orange: #FF6B00;
            --secondary-orange: #FF8C00;
            --light-orange: #FFE4CC;
            --dark-orange: #E55D00;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
            --medium-gray: #E0E0E0;
            --dark-gray: #555555;
            --text-dark: #222222;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --border-radius: 12px;
            --card-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFF5EB 0%, #FFEDDE 100%);
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }

        .navbar {
            background: linear-gradient(120deg, var(--primary-orange), var(--secondary-orange));
            box-shadow: var(--shadow);
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .main-container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            background: var(--white);
        }

        .card-header {
            background: linear-gradient(120deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            font-weight: 600;
            font-size: 1.3rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: var(--primary-orange);
            width: 20px;
            text-align: center;
        }

        .form-control, .form-select {
            border: 2px solid var(--medium-gray);
            border-radius: 8px;
            padding: 0.85rem 1.25rem;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 0, 0.25);
            transform: translateY(-2px);
        }

        .input-group-text {
            background-color: var(--light-orange);
            border: 2px solid var(--medium-gray);
            border-right: none;
            color: var(--primary-orange);
            font-weight: 500;
        }

        .input-group .form-control {
            border-left: none;
        }

        .btn-primary {
            background: linear-gradient(120deg, var(--primary-orange), var(--secondary-orange));
            border: none;
            border-radius: 8px;
            padding: 0.85rem 2rem;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.4);
            background: linear-gradient(120deg, var(--secondary-orange), var(--primary-orange));
        }

        .btn-secondary {
            background: var(--light-gray);
            border: none;
            color: var(--dark-gray);
            border-radius: 8px;
            padding: 0.85rem 2rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            background: var(--medium-gray);
            color: var(--text-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .invalid-feedback {
            color: #dc3545;
            font-weight: 500;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid:focus, .form-select.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .footer {
            text-align: center;
            margin-top: 3rem;
            color: var(--dark-gray);
            font-size: 0.9rem;
            padding: 1.5rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.75rem;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
            }
            
            .card-header {
                font-size: 1.1rem;
                padding: 1.25rem;
            }
        }

        /* Form section styling */
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            background: var(--white);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            border-left: 4px solid var(--primary-orange);
        }
        
        .form-section:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }
        
        .section-title {
            color: var(--primary-orange);
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--light-orange);
        }

        /* Status badges */
        .status-preview {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-left: 1rem;
        }
        
        .status-preview.pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-preview.approved {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-preview.rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-preview.paid {
            background-color: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-graduation-cap me-2"></i>
                SwiftSolve Academy
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('expenses.index') }}">
                    <i class="fas fa-arrow-left me-1"></i> Back to Expenses
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-receipt"></i> Create New Expense
            </div>
            <div class="card-body">
                <form action="{{ route('expenses.store') }}" method="POST" id="expenseForm">
                    @csrf
                    
                    <div class="form-section">
                        <h5 class="section-title"><i class="fas fa-info-circle"></i> Expense Details</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="title" class="form-label">
                                    <i class="fas fa-tag"></i> Expense Title *
                                </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required
                                       placeholder="Enter expense title">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="amount" class="form-label">
                                    <i class="fas fa-dollar-sign"></i> Amount *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                           id="amount" name="amount" value="{{ old('amount') }}" required
                                           placeholder="0.00">
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="category" class="form-label">
                                    <i class="fas fa-folder"></i> Category *
                                </label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="salaries" {{ old('category') == 'salaries' ? 'selected' : '' }}>Salaries</option>
                                    <option value="utilities" {{ old('category') == 'utilities' ? 'selected' : '' }}>Utilities</option>
                                    <option value="supplies" {{ old('category') == 'supplies' ? 'selected' : '' }}>Supplies</option>
                                    <option value="maintenance" {{ old('category') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="transportation" {{ old('category') == 'transportation' ? 'selected' : '' }}>Transportation</option>
                                    <option value="training" {{ old('category') == 'training' ? 'selected' : '' }}>Training</option>
                                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="date" class="form-label">
                                    <i class="fas fa-calendar"></i> Date *
                                </label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                       id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="section-title"><i class="fas fa-credit-card"></i> Payment Information</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="payment_method" class="form-label">
                                    <i class="fas fa-wallet"></i> Payment Method
                                </label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" 
                                        id="payment_method" name="payment_method">
                                    <option value="">Select Payment Method</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                    <option value="mobile_money" {{ old('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="status" class="form-label">
                                    <i class="fas fa-check-circle"></i> Status
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                                <div id="statusPreview" class="status-preview pending">
                                    <i class="fas fa-clock"></i> Pending
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="section-title"><i class="fas fa-file-alt"></i> Additional Information</h5>
                        <div class="mb-4">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left"></i> Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Enter expense description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="form-label">
                                <i class="fas fa-sticky-note"></i> Notes
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="2" 
                                      placeholder="Additional notes (optional)">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4 pt-3">
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Save Expense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© 2023 SwiftSolve Academy. All rights reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set today's date as default
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').value = today;

            // Status preview update
            const statusSelect = document.getElementById('status');
            const statusPreview = document.getElementById('statusPreview');
            
            statusSelect.addEventListener('change', function() {
                statusPreview.className = 'status-preview ' + this.value;
                
                if (this.value === 'pending') {
                    statusPreview.innerHTML = '<i class="fas fa-clock"></i> Pending';
                } else if (this.value === 'approved') {
                    statusPreview.innerHTML = '<i class="fas fa-check-circle"></i> Approved';
                } else if (this.value === 'rejected') {
                    statusPreview.innerHTML = '<i class="fas fa-times-circle"></i> Rejected';
                } else if (this.value === 'paid') {
                    statusPreview.innerHTML = '<i class="fas fa-check-circle"></i> Paid';
                }
            });

            // Form validation
            const form = document.getElementById('expenseForm');
            form.addEventListener('submit', function(e) {
                // Basic validation - you can add more specific validation here
                const amount = document.getElementById('amount').value;
                if (amount <= 0) {
                    e.preventDefault();
                    alert('Amount must be greater than 0');
                    return false;
                }
            });
        });
    </script>
</body>
</html>