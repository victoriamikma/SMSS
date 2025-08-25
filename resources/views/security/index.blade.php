@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Security Dashboard</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>User Accounts</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Last Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                <td>{{ $user->last_login_at?->diffForHumans() ?? 'Never' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Recent Login Attempts</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>IP Address</th>
                                <th>Status</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loginAttempts as $attempt)
                            <tr>
                                <td>{{ $attempt->email }}</td>
                                <td>{{ $attempt->ip_address }}</td>
                                <td>
                                    <span class="badge badge-{{ $attempt->successful ? 'success' : 'danger' }}">
                                        {{ $attempt->successful ? 'Success' : 'Failed' }}
                                    </span>
                                </td>
                                <td>{{ $attempt->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection