@if (!empty($result))
    @php
        $value = $result;
        $detect = $value->detect;
        $file_url = get_file_url($value->file);
        if (strpos($value->file, 'digitaloceanspaces.com') !== false) {
            //force cdn refrence in sharable url
            $do_cdn_path = env('DO_CDN_PATH');
            $do_path = env('DO_PATH');
            if ($do_cdn_path && $do_path) {
                $file_url = str_replace($do_path, $do_cdn_path, $file_url); //cdn path
            }
           // $file_url = str_replace('digitaloceanspaces.com', 'cdn.digitaloceanspaces.com', $file_url);
        }
        $detect_icon = detect_file_icon($detect);
        $text = $detect_icon['text'];
        $icon = $detect_icon['icon'];
    @endphp
    <a class="fm-list-item rounded border bg-white" href="javascript:void(0);" data-id="{{ $value->ids }}"
        data-is-image="{{ $value->is_image }}" data-file="{{ $file_url }}" data-type="{{ $value->detect }}">
        <img class="fm-list-overplay" src="{{ asset('backend/Assets/File_manager/img/overplay.png') }}">
        <div class="fm-list-box">
            <div class="fm-chechbox form-check form-check-inline d-none">
                <input class="form-check-input d-none" type="checkbox" name="medias[]" value="{{ $file_url }}"
                    checked="true">
                <label class="form-check-label" for="{{ $value->ids }}"></label>
            </div>
            @if ($detect == 'image')
                <div class="fm-list-hover">
                    <div
                        class="fm-list-media rounded d-flex flex-column align-items-center justify-content-center fs-40 text-primary">
                        <img class="lazy" src="{{ asset('backend/Assets/File_manager/img/loading.gif') }}"
                            data-src="{{ $file_url }}">
                    </div>
                </div>
            @else
                <div class="fm-list-hover">
                    <div
                        class="fm-list-media rounded d-flex flex-column align-items-center justify-content-center fs-40 text-{{ $text }}">
                        <i class="{{ $icon }}"></i>
                    </div>
                </div>
            @endif
            <div class="fm-list-info border-top">
                <div class="text-truncate fw-5 text-dark" title="{{ $value->name }}">{{ $value->name }}
                </div>
                <div class="text-muted fs-8">{{ format_bytes($value->size) }}</div>
            </div>
        </div>
        <button type="button" href="javascript:void(0)" class="remove text-danger"><i class="ki-duotone ki-cross-square fs-2"><span
            class="path1"></span><span class="path2"></span></i></button>
    </a>
@endif
