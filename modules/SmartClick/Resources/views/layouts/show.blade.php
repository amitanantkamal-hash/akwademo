@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Monitor: {{ $monitor->name }}</h1>
        <div>
            <a href="{{ route('smartclick.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <h3>Triggers</h3>
        </div>
        <div class="card-body">
            @if($monitor->triggers->count() > 0)
                <p>{{ $monitor->triggers->pluck('keyword')->implode(', ') }}</p>
            @else
                <p class="text-muted">No triggers defined</p>
            @endif
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <h3>Actions</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Delay (minutes)</th>
                        <th>Order</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monitor->actions as $action)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $action->action_type)) }}</td>
                            <td>{{ $action->action_value }}</td>
                            <td>{{ $action->delay_minutes }}</td>
                            <td>{{ $action->order }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3>Apply to Contacts</h3>
        </div>
        <div class="card-body">
            <form id="apply-form">
                @csrf
                <div class="form-group">
                    <label for="contacts">Select Contacts</label>
                    <select name="contacts[]" id="contacts" class="form-control" multiple required>
                        <!-- This would be populated with your contacts -->
                        @foreach(Contact::where('subscribed', 1)->get() as $contact)
                            <option value="{{ $contact->id }}">{{ $contact->name }} ({{ $contact->phone }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn btn-primary" onclick="applyMonitor()">Apply Monitor</button>
            </form>
        </div>
    </div>
</div>

<script>
function applyMonitor() {
    const formData = new FormData(document.getElementById('apply-form'));
    const contactIds = Array.from(document.getElementById('contacts').selectedOptions).map(opt => opt.value);
    
    fetch('{{ route('smartclick.apply', $monitor) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ contacts: contactIds })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}
</script>
@endsection