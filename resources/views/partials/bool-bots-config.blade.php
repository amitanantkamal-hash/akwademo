@isset($separator)
    <br />
    <h4 id="sep{{ $id }}" class="display-4 mb-0">{{ __($separator) }}</h4>
    <hr />
@endisset
<div class="form-group{{ $errors->has($id) ? ' has-danger' : '' }}">

    @if (isset($link) && !(isset($type) && $type == 'hidden'))
        <label class="fs-6 form-label fw-bold text-gray-900"
            for="{{ $id }}">{{ __($name) }}@isset($link)
            <a target="_blank" href="{{ $link }}">{{ $linkName }}</a>
        @endisset
    </label>
@endif

<div class="form-check form-switch form-check-custom form-check-solid d-flex align-items-center">
    <input type='hidden' value='false' name="{{ $id }}" id="{{ $id }}hid">
    <input value="true" @if (isset($value) && ($value == 'true' || $value . '' == '1')) checked @endif type="checkbox"
        class="form-check-input" name="{{ $id }}" id="{{ $id }}">
    <label class="fs-6 form-label text-gray-900 ms-4" for="{{ $id }}">{{ __($name) }}</label>
</div>
@isset($additionalInfo)
    <small class="text-muted"><strong>{{ __($additionalInfo) }}</strong></small>
@endisset
@if ($errors->has($id))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first($id) }}</strong>
    </span>
@endif
</div>
