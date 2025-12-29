@isset($separator)
    <br />
    <h4 id="sep{{ $id }}" class="display-4 mb-0">{{ __($separator) }}</h4>
    <hr />
@endisset
<div id="form-group-{{ $id }}" class="form-group{{ $errors->has($id) ? ' has-danger' : '' }} mt-6">
    @if(!(isset($type) && $type == "hidden"))
        {{-- <label class="fs-6 fw-semibold form-label mt-3" for="{{ $id }}">{{ __($name) }}@isset($link)<a target="_blank" href="{{ $link }}">{{ $linkName }}</a>@endisset</label> --}}
    @endif
    <div class="dropzone">
        <label for="{{ $id }}" >
            <div class="dz-message needsclick">
                <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>
                <div class="ms-4">
                    <h3 class="fs-5 mt-3 fw-bold text-gray-900 mb-1">Click to upload the file</h3>
                    <span>{{ __("Size Max. 5 MB") }}</span>
                </div>
            </div>
        </label>
        <input
            type="file"
            id="{{ $id }}"
            name="{{ $id }}"
            class="d-none"
            @isset($accept) accept="{{ $accept }}" @endisset
            @isset($multiple) multiple @endisset
            @isset($changevue) @change="{{ $changevue }}" ref="{{ $id }}" @endisset
            @isset($onvuechange) @input="{{ $onvuechange }}" ref="{{ $id }}" @endisset
            <?php if($required) {echo 'required';} ?>
            onchange="handleFileChange('{{ $id }}', event)"/>
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
