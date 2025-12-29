@isset($separator)
    <h4 id="sep{{ $id }}" class="display-4 mb-0">
        {{ __($separator) }}
    </h4>
@endisset
<div id="form-group-{{ $id }}" class="form-group{{ $errors->has($id) ? ' has-danger' : '' }} w-100 d-flex flex-row align-items-center">
    <div class="position-relative w-md-400px me-md-2 ">
        <i class="ki-outline ki-magnifier fs-3 text-gray-500 position-absolute top-50 translate-middle ms-6"></i>
        <input @isset($changevue) @change="{{ $changevue }}" ref="{{ $id }}" @endisset
            @isset($onvuechange) @input="{{ $onvuechange }}" ref="{{ $id }}" @endisset
            @isset($accept) accept="{{ $accept }}" @endisset
            step="{{ isset($step) ? $step : '.01' }}"
            @isset($min) min="{{ $min }}" @endisset
            @isset($max) max="{{ $max }}" @endisset
            type="{{ isset($type) ? $type : 'text' }}" name="{{ $id }}" id="{{ $id }}"
            class="form-control form-control-solid ps-10 w-100 @isset($editclass) {{ $editclass }} @endisset  {{ $errors->has($id) ? ' is-invalid' : '' }}"
            placeholder="{{ __('Search') }}"
            value="{{ old($id) ? old($id) : (isset($value) ? $value : (app('request')->input($id) ? app('request')->input($id) : null)) }}"
            <?php if ($required) {
                echo 'required';
            } ?>>
    </div>
    @if ($errors->has($id))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($id) }}</strong>
        </span>
    @endif
</div>
