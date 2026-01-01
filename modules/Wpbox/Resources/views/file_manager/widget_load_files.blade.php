@if ($image_data['page'] == 0 && $image_data['folder'] != 0)
    <div class="col-2">
        <a href="javascript:void(0);" class="fm-list-item fm-folder-item rounded mb-4 bg-white" data-folder-id="">
            <img class="fm-list-overplay" src="{{ asset('backend/Assets/File_manager/img/overplay.png') }}">
            <div class="fm-list-box">
                <div class="fm-list-hover h-100">
                    <div
                        class="fm-list-media rounded-top d-flex flex-column align-items-center justify-content-center fs-100 text-primary">
                        <i class="fad fa-chevron-left"></i>
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
            $detect = $value->detect; //detect_file_type($value->extension);
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
        <div class="col-2">
            @if ($value->is_folder) 
                <a href="javascript:void(0);" class="fm-list-item folderOpen fm-folder-item rounded mb-4 bg-white overflow-hidden"
                    data-folder-id="{{ $value->ids }}" data-id="{{ $value->ids }}" data-type="{{ $value->detect }}">
                    
                    <img class="fm-list-overplay" src="{{ asset('backend/Assets/File_manager/img/overplay.png') }}">
                    <div class="fm-list-box">
                        <div class="fm-chechbox folder-checkbox form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="folder_ids[]" value="{{ $value->ids }}">
                            <label class="form-check-label" for="{{ $value->ids }}"></label>
                        </div>
                        <div class="fm-list-hover">
                            <div
                                class="fm-list-media rounded-top fm-bg-folder d-flex flex-column align-items-center justify-content-center fs-50 text-primary">
                            </div>
                        </div>
                        <div class="fm-list-info border-top">
                            <div class="text-truncate fw-5 text-dark">{{ $value->name }}</div>
                            <div class="text-muted fs-8">{{ __('Folder') }}</div>
                        </div>
                    </div>
                </a>
            @else
                <a class="fm-list-item rounded mb-4 bg-white" href="javascript:void(0);" data-id="{{ $value->ids }}"
                    data-is-image="{{ $value->is_image }}" data-file="{{ $file_url }}"
                    data-type="{{ $value->detect }}">
                    <img class="fm-list-overplay" src="{{ asset('backend/Assets/File_manager/img/overplay.png') }}">
                    <div class="fm-list-box">
                        <div class="fm-chechbox form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="file_ids[]"
                                value="{{ $value->ids }}">
                            <label class="form-check-label" for="{{ $value->ids }}"></label>
                        </div>
                        @if ($detect == 'image')
                            <div class="fm-list-hover">
                                <div
                                    class="fm-list-media rounded-top d-flex flex-column align-items-center justify-content-center fs-40 text-primary">
                                    <img class="lazy"
                                        src="{{ asset('backend/Assets/File_manager/img/loading.gif') }}"
                                        data-src="{{ $file_url }}">
                                </div>
                            </div>
                        @else
                            {{-- @if ($detect == 'video')
                                <div class="fm-list-hover overflow-hidden position-relative">
                                    <video class="fm-video miw-100">
                                        <source src="{{ $file_url }}" type="video/mp4">
                                        {{ __('Your browser does not support the video tag.') }}
                                    </video>
                                    <div
                                        class="fm-list-media rounded-top d-flex flex-column align-items-center justify-content-center fs-40 text-{{ $text }}">
                                        <i class="{{ $icon }}"></i>
                                    </div>
                                </div>
                            @else --}}
                            <div class="fm-list-hover">
                                <div
                                    class="fm-list-media rounded-top d-flex flex-column align-items-center justify-content-center fs-40 text-{{ $text }}">
                                    <i class="{{ $icon }}"></i>
                                </div>
                            </div>
                            {{-- @endif --}}
                        @endif
                        <div class="fm-list-info border-top">
                            <div class="text-truncate fw-5 text-dark" title="{{ $value->name }}">{{ $value->name }}
                            </div>
                            <div class="text-muted fs-8">{{ format_bytes($value->size) }}</div>
                        </div>

                    </div>
                </a>
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
