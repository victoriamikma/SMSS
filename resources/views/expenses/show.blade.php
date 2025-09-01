@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="m-0"><i class="fas fa-eye me-2"></i> View Expense</h4>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-info">
                        Expense details view will be implemented here.
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Expenses
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection