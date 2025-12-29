@extends('client.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>SmartClick Monitors</h1>
        <a href="{{ route('smartclick.create') }}" class="btn btn-primary">Create New Monitor</a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Triggers</th>
                        <th>Actions</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monitors as $monitor)
                        <tr>
                            <td>{{ $monitor->name }}</td>
                            <td>
                                <span class="badge badge-{{ $monitor->is_active ? 'success' : 'secondary' }}">
                                    {{ $monitor->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                @if($monitor->triggers->count() > 0)
                                    {{ $monitor->triggers->pluck('keyword')->implode(', ') }}
                                @else
                                    <span class="text-muted">No triggers</span>
                                @endif
                            </td>
                            <td>{{ $monitor->actions->count() }} actions</td>
                            <td>
                                <a href="{{ route('smartclick.show', $monitor) }}" class="btn btn-sm btn-info">View</a>
                                <form action="{{ route('smartclick.destroy', $monitor) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No monitors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection