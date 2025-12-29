{{-- Brij Mohan Negi Update --}}
@isset($separator)
    <br />
    <h4 id="sep{{ $id }}" class="display-4 mb-0">{{ __($separator) }}</h4>
    <hr />
@endisset

<div id="form-group-{{ $id }}"
    class="form-group{{ $errors->has($id) ? ' has-danger' : '' }}  @isset($class) {{ $class }} @endisset mb-3">
    @if (!(isset($type) && $type == 'hidden'))
        <label
            class="form-label @isset($labelclass) ? {{ $labelclass }} : '' @endisset">{{ __($name) }}</label>
    @endif
    <div class="input-group">
        @isset($prepend)
            <div class="input-group-prepend"><span class="input-group-text">{{ $prepend }}</span></div>
        @endisset

        <input @isset($changevue) @change="{{ $changevue }}" ref="{{ $id }}" @endisset
            @isset($onvuechange) @input="{{ $onvuechange }}" ref="{{ $id }}" @endisset
            @isset($accept) accept="{{ $accept }}" @endisset
            step="{{ isset($step) ? $step : '.01' }}"
            @isset($min) min="{{ $min }}" @endisset
            @isset($max) max="{{ $max }}" @endisset
            type="{{ isset($type) ? $type : 'text' }}" name="{{ $id }}" id="{{ $id }}"
            class="form-control form-control-solid @isset($classselect) {{ $classselect }}@endisset @isset($editclass) {{ $editclass }} @endisset  {{ $errors->has($id) ? ' is-invalid' : '' }}"
            placeholder="{{ __($placeholder) }}"
            value="{{ old($id) ? old($id) : (isset($value) ? $value : (app('request')->input($id) ? app('request')->input($id) : null)) }}"
            @if (isset($required) && $required) required @endif>
    </div>
    @if ($errors->has($id))
        <div class="invalid-feedback">
            {{ $errors->first($id) }}
        </div>
    @endif



    @isset($additionalInfo)
        <small class="form-text text-muted">{{ __($additionalInfo) }}</small>
    @endisset

    {{-- @isset($editclass)
        <script type="text/javascript">
            $(function() {
                $(".{{ $editclass }}").tagsinput("refresh");
            });
        </script>
    @endisset --}}

</div>
