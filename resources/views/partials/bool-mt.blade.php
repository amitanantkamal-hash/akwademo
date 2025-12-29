@isset($separator)
    <div class="mb-8 text-center">
        <!--begin::Title-->
        <h1 id="sep{{ $id }}" class="mb-3">{{ __($separator) }}</h1>
        <!--end::Title-->
    </div>
@endisset
@if ($id == 'custom[agent_enable]' || ($id == 'custom[translation_enabled]' || $id == 'custom[enable_voiceflow]'))
    <div></div>
@else
    <div
        class="form-group{{ $errors->has($id) ? ' has-danger' : '' }}  @isset($class) {{ $class }} @endisset">

        @if (isset($link) && !(isset($type) && $type == 'hidden'))
            <label class="form-control-label" for="{{ $id }}">{{ __($name) }}
                @isset($link)
                    <a target="_blank" href="{{ $link }}">{{ $linkName }}</a>
                @endisset
            </label>
        @endif

        <label class="form-check form-check-custom form-check-solid me-10 mt-2">
            <input type='hidden' value='false' name="{{ $id }}" id="{{ $id }}hid">
            <input class="form-check-input h-20px w-20px" type="checkbox" value="true"
                @if (isset($value) && ($value == 'true' || $value == '1')) checked="checked" @endif name="{{ $id }}"
                id="{{ $id }}">
            <span class="form-check-label fw-semibold">{{ __($name) }}</span>
        </label>

        @isset($additionalInfo)
            <small class="text-muted"><strong>{{ __($additionalInfo) }}</strong></small>
        @endisset
        @if ($errors->has($id))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first($id) }}</strong>
            </span>
        @endif
    </div>
@endif
