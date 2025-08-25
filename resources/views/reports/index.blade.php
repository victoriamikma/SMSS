@extends('layouts.app')

@section('content')
<div class="container">
    <h1>School Reports</h1>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Students</h5>
                    <p class="display-4">{{ $studentCount }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Staff</h5>
                    <p class="display-4">{{ $staffCount }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Fees</h5>
                    <p class="display-4">{{ number_format($totalFees, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            <h3>Attendance Statistics</h3>
        </div>
        <div class="card-body">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('attendanceChart');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($attendanceStats->pluck('status')),
            datasets: [{
                data: @json($attendanceStats->pluck('count')),
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e'
                ]
            }]
        }
    });
</script>
@endpush
@endsection