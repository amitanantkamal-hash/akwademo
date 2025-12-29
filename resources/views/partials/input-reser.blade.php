@isset($separator)
    <h4 id="sep{{ $id }}" class="display-4 mb-0">
        {{ __($separator) }}
    </h4>
@endisset
<div class="col-md-4">
<div id="form-group-{{ $id }}" class="form-group{{ $errors->has($id) ? ' has-danger' : '' }} mt-2 mt-sm-2 ms-sm-0 mt-md-2 ms-md-0 mt-lg-2 ms-lg-0 mt-xl-2 ms-xl-0 w-100">
    @if (!(isset($type) && $type == 'hidden'))
        <label class="fs-6 form-label fw-bold text-gray-900" for="{{ $id }}">
            {{ __($name) }}
            @isset($link)
                <a target="_blank" href="{{ $link }}">{{ $linkName }}</a>
            @endisset
        </label>
    @endif
    <div class="input-group w-100">
        @isset($prepend)
            <div class="input-group-prepend">
                <span class="input-group-text">{{ $prepend }}</span>
            </div>
        @endisset
        <input @isset($changevue) @change="{{ $changevue }}" ref="{{ $id }}" @endisset
            @isset($onvuechange) @input="{{ $onvuechange }}" ref="{{ $id }}" @endisset
            @isset($accept) accept="{{ $accept }}" @endisset
            step="{{ isset($step) ? $step : '.01' }}"
            @isset($min) min="{{ $min }}" @endisset
            @isset($max) max="{{ $max }}" @endisset
            type="{{ isset($type) ? $type : 'text' }}" name="{{ $id }}" id="{{ $id }}"
            class="form-control form-control-solid w-100 @isset($editclass) {{ $editclass }} @endisset  {{ $errors->has($id) ? ' is-invalid' : '' }}"
            placeholder="{{ __($placeholder) }}"
            value="{{ old($id) ? old($id) : (isset($value) ? $value : (app('request')->input($id) ? app('request')->input($id) : null)) }}"
            <?php if ($required) {
                echo 'required';
            } ?>>

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
</div>
