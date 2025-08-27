@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="m-0"><i class="fas fa-edit me-2"></i> Edit Expense</h4>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-info">
                        Expense edit form will be implemented here.
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Expenses
                        </a>
                        <button type="button" class="btn btn-primary" disabled>
                            <i class="fas fa-save me-1"></i> Update Expense
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection