<div id="form-group-{{ $id }}"
    class="form-group {{ $errors->has($id) ? ' has-danger' : '' }} @isset($class) {{ $class }} @endisset">
    
    @isset($separator)
        @if (is_string($separator) && !is_array($separator))
            <br />
            <h4 class="display-4 mb-0">{{ $separator }}</h4>
            <hr />
        @endif
    @endisset

    <label class="fs-6 fw-semibold form-label mt-3">{{ __($name) }}</label><br />

    <select
        @isset($multiple) multiple="multiple" @endisset
        @isset($disabled) disabled @endisset
        class="form-select"
        name="{{ $id }}@isset($multiple)[]@endisset"
        id="{{ $id }}"
    >
        @if (!isset($multiple))
            <option disabled selected value> {{ __('Select') . ' ' . __($name) }} </option>
        @endif

        @foreach ($data as $key => $item)
            @if (is_array(__($item)))
                <option value="{{ $key }}">{{ $item }}</option>
            @else
                @php
                    $selected = false;

                    // Handle old input
                    if (old($id) && (string) old($id) === (string) $key) {
                        $selected = true;
                    }
                    // Handle $value (can be object or scalar)
                    elseif (isset($value)) {
                        if (is_object($value) && isset($value->id)) {
                            $selected = strtoupper(trim($value->id)) === strtoupper(trim($key));
                        } elseif (!is_object($value)) {
                            $selected = strtoupper(trim($value)) === strtoupper(trim($key));
                        }
                    }
                    // Handle request value
                    elseif (app('request')->input($id)) {
                        $selected = strtoupper(trim(app('request')->input($id))) === strtoupper(trim($key));
                    }
                    // Handle multiple selected options
                    elseif (isset($multiple) && isset($multipleselected) && in_array($key, $multipleselected, false)) {
                        $selected = true;
                    }
                @endphp

                <option value="{{ $key }}" @if($selected) selected @endif>{{ __($item) }}</option>
            @endif
        @endforeach
    </select>

    @isset($additionalInfo)
        <small class="text-muted"><strong>{{ __($additionalInfo) }}</strong></small>
    @endisset

    @if ($errors->has($id))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($id) }}</strong>
        </span>
    @endif
</div>
