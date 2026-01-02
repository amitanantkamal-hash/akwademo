@if ($image_data['page'] == 0 && $image_data['folder'] != 0)
    <div class="col-2">
        <a href="javascript:void(0);" class="fm-list-item fm-folder-item rounded mb-4 bg-white" data-folder-id="">
            <img class="fm-list-overplay" src="{{ asset('backend/Assets/File_manager/img/overplay.png') }}">
            <div class="fm-list-box">
                <div class="fm-list-hover h-100">
                    <div
                        class="fm-list-media rounded-top d-flex flex-column align-items-center justify-content-center fs-100 text-primary">
                        <i class="fa fa-chevron-left"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endif

@if (!empty($image_data['result']))
    @php $items = json_decode($image_data['result']) @endphp
    @foreach ($items as $key => $value)
        @php
            $detect = $value->detect;
            $file_url = get_file_url($value->file);

            // For DigitalOcean CDN
            if (strpos($value->file, 'digitaloceanspaces.com') !== false) {
                $do_cdn_path = env('DO_CDN_PATH');
                $do_path = env('DO_PATH');
                if ($do_cdn_path && $do_path) {
                    $file_url = str_replace($do_path, $do_cdn_path, $file_url);
                }
            }

            $detect_icon = detect_file_icon($detect);
            $text = $detect_icon['text'];
            $icon = $detect_icon['icon'];
        @endphp

        <div class="col-2">
            @if ($value->is_folder)
                <div class="position-relative">
                    <div class="fm-list-item fm-folder-item folderOpen rounded mb-4 bg-white overflow-hidden"
                        data-folder-id="{{ $value->ids }}">
                        <img class="fm-list-overplay" src="{{ asset('backend/Assets/File_manager/img/overplay.png') }}">
                        <div class="fm-list-box">
                            <div class="fm-list-hover">
                                <div
                                    class="fm-list-media rounded-top fm-bg-folder d-flex flex-column align-items-center justify-content-center fs-100 text-primary">
                                </div>
                            </div>
                            <div class="fm-list-info border-top d-flex justify-content-between align-items-center">
                                <div class="text-truncate me-5">
                                    <div class="text-truncate fw-5 text-dark">
                                        {{ $value->name }}
                                    </div>
                                    <div class="text-muted fs-11">{{ __('Folder') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="fm-list-item rounded mb-4 bg-white" href="javascript:void(0);" data-id="{{ $value->ids }}"
                    data-file="{{ $file_url }}">
                    <img class="fm-list-overplay" src="{{ asset('backend/Assets/File_manager/img/overplay.png') }}">
                    <div class="fm-list-box">
                        <div class="fm-chechbox form-check form-check-inline">
                            <input class="form-check-input fm-check-item" type="checkbox" name="ids[]"
                                id="{{ $value->ids }}" value="{{ $value->ids }}">
                            <label class="form-check-label" for="{{ $value->ids }}"></label>
                        </div>
                        @if ($detect == 'image')
                            <div class="fm-list-hover">
                                <div
                                    class="fm-list-media rounded-top d-flex flex-column align-items-center justify-content-center fs-90 text-primary">
                                    <img class="lazy"
                                        src="{{ asset('backend/Assets/File_manager/img/loading.gif') }}"
                                        data-src="{{ $file_url }}">
                                </div>
                            </div>
                        @else
                            <div class="fm-list-hover">
                                <div
                                    class="fm-list-media rounded-top d-flex flex-column align-items-center justify-content-center fs-90 text-{{ $text }}">
                                    <i class="{{ $icon }}"></i>
                                </div>
                            </div>
                        @endif
                        <div class="fm-list-info border-top text-center">
                            <div class="text-truncate fw-5 text-dark" title="{{ $value->name }}">
                                {{ $value->name }}
                            </div>
                            <div class="text-muted fs-11 d-flex align-items-center justify-content-center">
                                {{ format_bytes($value->size) }}
                                <button type="button" class="btn btn-link p-0 ms-2 copy-path-btn text-primary"
                                    data-path="{{ $file_url }}" title="{{ __('Copy Path') }}">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            @endif
        </div>
    @endforeach
@else
    @if ($image_data['page'] == 0 && $image_data['folder'] == 0)
        <div
            class="fm-empty text-center fs-90 text-muted h-100 d-flex flex-column align-items-center justify-content-center">
            <img class="mh-190 mb-4" alt="" src="{{ asset('backend/Assets/img/empty.png') }}">
        </div>
    @endif
@endif
