@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="float-left">Transport Management</h3>
                    <div class="float-right">
                        <a href="{{ route('transport.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Transport
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Route</th>
                                    <th>Vehicle</th>
                                    <th>Driver</th>
                                    <th>Schedule</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transports as $transport)
                                    <tr>
                                        <td>{{ $transport->id }}</td>
                                        <td>{{ $transport->route }}</td>
                                        <td>{{ $transport->vehicle->name }}</td>
                                        <td>{{ $transport->driver->name }}</td>
                                        <td>{{ $transport->schedule }}</td>
                                        <td>
                                            <span class="badge badge-{{ $transport->status === 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($transport->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('transport.edit', $transport->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('transport.destroy', $transport->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No transport records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $transports->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection