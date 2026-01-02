<div id="fm-selected-mini-{{ $id }}"
    class="fm-selected-media fm-selected-mini @isset($class) {{ $class }} @endisset"
    data-loading="false" data-result="html" data-select-multi="{{ $select_multi }}">
    
    <div class="fm-progress-bar bg-primary"></div>
    <div class="items clearfix"></div>
    <div class="drophere">
        <span class="d-flex align-items-center justify-content-center">{{ __('Select media') }}</span>
    </div>
    <ul class="fm-mini-option d-flex align-items-center">
        <li class="text-nowrap">
            <a href="javascript:void(0);"
                class="px-3 py-2 d-block btn text-gray-700 btn-active-light btnOpenFileManager"
                data-select-multi="{{ $select_multi }}" data-type="{{ $type }}" data-id=""><i
                    class="ki-duotone ki-picture fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i> <span class="fs-12">{{ __('File manager') }}</span></a>
        </li>
        <li class="text-nowrap">
            <button type="button" class="px-3 py-2 d-block btn btn-active-light fileinput-button">
                <i class="ki-duotone ki-folder-up fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <input id="fileupload" type="file" name="files[]" multiple="" accept="{{ $accept }}">
            </button>
        </li>
    </ul>
    {{-- <small>{{__('Allowed file types ( .png, .jpg, .pdf, .mp4, .mp3) ')}}. </small>
    <small>{{__('You are able to uploaded any file provided the file is not larger than the maximum file upload size Image - 2MB and Video 15 MB and is an allowed file format')}}</small> --}}

    
    @isset($tooltip)
        <span class="custom-tooltip">
            <i class="fas fa-info-circle text-muted cursor-pointer"></i>
            <span class="tooltiptext">
                {{ $tooltip }}
            </span>
        </span>
    @endisset
</div>
