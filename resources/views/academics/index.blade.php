@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Academic Management</h1>
        <div class="row">
            <!-- Add this card for Subject Management -->
            <div class="col-md-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-book fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Subject Management</h5>
                        <p class="card-text">Manage subjects, assign teachers and classes</p>
                        <a href="{{ route('subjects.index') }}" class="btn btn-primary">Go to Subjects</a>
                    </div>
                </div>
            </div>
            <!-- Keep your existing content here -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <p>Other academic content goes here</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
