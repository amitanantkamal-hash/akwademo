@extends('client.app')

@section('content')
<div class="container">
    <h1>Create SmartClick Monitor</h1>
    
    <form action="{{ route('smartclick.store') }}" method="POST" id="monitor-form">
        @csrf
        
        <div class="form-group">
            <label for="name">Monitor Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="triggers">Trigger Keywords (comma separated)</label>
            <input type="text" name="triggers" id="triggers" class="form-control" 
                   placeholder="hi, hello, ready to click, stop promotions">
            <small class="form-text text-muted">
                These keywords will trigger this monitor when received via WhatsApp
            </small>
        </div>
        
        <div id="actions-container">
            <h3>Actions</h3>
            <button type="button" class="btn btn-secondary mb-3" id="add-action">Add Action</button>
            
            <div class="action-template d-none">
                <div class="card mb-3 action-item">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <select name="actions[][type]" class="form-control action-type" required>
                                    <option value="">Select Action Type</option>
                                    <option value="add_tags">Add Tags</option>
                                    <option value="remove_tags">Remove Tags</option>
                                    <option value="add_groups">Add to Groups</option>
                                    <option value="remove_groups">Remove from Groups</option>
                                    <option value="custom_field">Add Custom Field</option>
                                    <option value="whatsapp">Send WhatsApp</option>
                                </select>
                            </div>
                            <div class="col-md-5 action-value-container">
                                <input type="text" name="actions[][value]" class="form-control action-value" placeholder="Value" required>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="actions[][delay]" class="form-control" placeholder="Delay (minutes)" min="0" value="0">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="actions[][order]" class="form-control" placeholder="Order" value="0">
                                <button type="button" class="btn btn-danger btn-sm mt-1 remove-action">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Monitor</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let actionIndex = 0;
    const container = document.getElementById('actions-container');
    const addButton = document.getElementById('add-action');
    const template = document.querySelector('.action-template');
    
    // Function to create value field based on action type
    function createValueField(type, currentValue = '') {
        let html = '';
        
        switch(type) {
            case 'add_tags':
            case 'remove_tags':
                html = `<input type="text" name="actions[][value]" class="form-control action-value" 
                    placeholder="Comma-separated tags" value="${currentValue}" required>`;
                break;
                
            case 'add_groups':
            case 'remove_groups':
                html = `<select name="actions[][value]" class="form-control action-value" required>
                    <option value="">Select Group</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>`;
                break;
                
            case 'whatsapp':
                html = `<select name="actions[][value]" class="form-control action-value" required>
                    <option value="">Select Template</option>
                    <option value="welcome">Welcome Template</option>
                    <option value="follow_up">Follow-up Template</option>
                    <option value="promotion">Promotion Template</option>
                    <!-- Add more templates as needed -->
                </select>`;
                break;
                
            default:
                html = `<input type="text" name="actions[][value]" class="form-control action-value" 
                    placeholder="Value" value="${currentValue}" required>`;
        }
        
        return html;
    }
    
    // Add new action
    addButton.addEventListener('click', function() {
        const newAction = template.cloneNode(true);
        newAction.classList.remove('d-none');
        newAction.classList.remove('action-template');
        
        // Update names with index
        const inputs = newAction.querySelectorAll('input, select');
        inputs.forEach(input => {
            const name = input.getAttribute('name').replace('[]', `[${actionIndex}]`);
            input.setAttribute('name', name);
        });
        
        // Add remove functionality
        newAction.querySelector('.remove-action').addEventListener('click', function() {
            this.closest('.action-item').remove();
        });
        
        // Add change listener for action type
        const actionTypeSelect = newAction.querySelector('.action-type');
        actionTypeSelect.addEventListener('change', function() {
            const valueContainer = this.closest('.row').querySelector('.action-value-container');
            valueContainer.innerHTML = createValueField(this.value);
        });
        
        container.insertBefore(newAction, addButton.parentNode);
        actionIndex++;
    });
    
    // Add initial action
    addButton.click();
});
</script>
@endsection