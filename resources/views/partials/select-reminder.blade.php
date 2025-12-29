<div class="col-md-6">
<div id="form-group-{{ $id }}" class="form-group {{ $errors->has($id) ? ' has-danger' : '' }} mt-2 mt-sm-2 ms-sm-0 mt-md-2 ms-md-0 mt-lg-2 ms-lg-0 mt-xl-2 ms-xl-0 w-100">
    @isset($separator)
        @if (is_string($separator) && !is_array($separator))
            <h4 class="display-4 mb-0">{{ $separator }}</h4>
        @endif
    @endisset
    
    <label class="fs-6 form-label fw-bold text-gray-900 ">{{ __($name) }}</label><br />
    <div class="d-flex flex-row justify-content-between align-items-center w-100 ">
        <select @isset($multiple) multiple=" {{ 'multiple' }}"   @endisset
            @isset($disabled) {{ 'disabled' }} @endisset
            class="form-select form-select-solid w-100 "  data-control="select2"
            name="{{ $id }}" id="{{ $id }}">
            @if (!isset($multiple))
                <option disabled selected value> {{ __('Select') . ' ' . __($name) }} </option>
            @endif
            @foreach ($data as $key => $item)
                @if (is_array(__($item)))
                    <option value="{{ $key }}">{{ $item }}</option>
                @else
                    @if (old($id) && old($id) . '' == $key . '')
                        <option selected value="{{ $key }}">{{ __($item) }}</option>
                    @elseif (isset($value) && trim(strtoupper($value . '')) == trim(strtoupper($key . '')))
                        <option selected value="{{ $key }}">{{ __($item) }}</option>
                    @elseif (app('request')->input($id) && strtoupper(app('request')->input($id) . '') == strtoupper($key . ''))
                        <option selected value="{{ $key }}">{{ __($item) }}</option>
                    @elseif (isset($multiple) && isset($multipleselected) && in_array($key, $multipleselected, false))
                        <option selected value="{{ $key }}">{{ __($item) }}</option>
                    @else
                        <option value="{{ $key }}">{{ __($item) }}</option>
                    @endif
                @endif
            @endforeach
        </select>
        @isset($additionalInfo)
            <a class="ms-2 me-0 me-sm-0 me-md-0 me-lg-0 me-xl-0" href="{{ $additionalInfo }}"> {!! $additionalInfoLabel !!}</a>
        @endisset
    </div>
    @if ($errors->has($id))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($id) }}</strong>
        </span>
    @endif
</div>
</div>
