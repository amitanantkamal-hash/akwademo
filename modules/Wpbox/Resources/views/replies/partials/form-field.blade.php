<!-- resources/views/partials/form-field.blade.php -->
@if(isset($field['separator']))
<div class="col-12">
    <hr>
    <h5>{{ $field['separator'] }}</h5>
</div>
@endif

<div class="{{ $field['class'] ?? 'col-md-6' }} form-group">
    <label for="{{ $field['id'] }}">{{ $field['name'] }}</label>
    
    @if($field['ftype'] == 'input')
        <input type="text" 
               class="form-control" 
               id="{{ $field['id'] }}" 
               name="{{ $field['id'] }}" 
               value="{{ $field['value'] ?? '' }}" 
               placeholder="{{ $field['placeholder'] ?? '' }}"
               {{ $field['required'] ? 'required' : '' }}>
    
    @elseif($field['ftype'] == 'textarea')
        <textarea class="form-control" 
                  id="{{ $field['id'] }}" 
                  name="{{ $field['id'] }}" 
                  rows="3"
                  placeholder="{{ $field['placeholder'] ?? '' }}"
                  {{ $field['required'] ? 'required' : '' }}>{{ $field['value'] ?? '' }}</textarea>
    
    @elseif($field['ftype'] == 'select')
        <select class="form-control" 
                id="{{ $field['id'] }}" 
                name="{{ $field['id'] }}"
                {{ $field['required'] ? 'required' : '' }}>
            <option value="">{{ $field['placeholder'] ?? 'Select' }}</option>
            @foreach($field['data'] as $key => $value)
                <option value="{{ $key }}" {{ isset($field['value']) && $field['value'] == $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    @endif
    
    @if(isset($field['additionalInfo']))
        <small class="form-text text-muted">{{ $field['additionalInfo'] }}</small>
    @endif
</div>