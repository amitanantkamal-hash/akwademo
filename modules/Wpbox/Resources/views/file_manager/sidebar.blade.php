<div class="submenu-right fm-submenu d-flex flex-column flex-row-auto p-20 bg-white n-scroll">
    <div class="fm-options">
        <div class="mb-4">
            <div class="btn-group btn-group-sm w-100" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light fm-select-all">
                    <span class="fm-btn-select-all"><i class="ki-duotone ki-double-check fs-2"><span
                                class="path1"></span><span class="path2"></span></i> {{ __('Select all') }}</span>
                    <span class="fm-btn-deselect-all"><i class="ki-duotone ki-cross-square fs-2"><span
                        class="path1"></span><span class="path2"></span></i> {{ __('Deselect All') }} </span>
                </button>
                <button type="button" class="btn btn-danger w-30 fm-delete-all"><i class="ki-duotone ki-delete-files"><span
                    class="path1"></span><span class="path2"></span></i></button>
            </div>
        </div>
        {{-- <div class="mb-4">
            <button class="btn btn-light-primary btn-sm w-100 fm-open-new-folder mb-2">
                <i class="fad fa-plus"></i> {{ __('New folder') }} </button>
            <div class="fm-box-new-folder">
                <div class="input-group mb-3">
                    <input type="text" class="form-control fs-12 fm-input-new-folder" name="create_new_folder"
                        placeholder="Enter folder name">
                    <button type="button" class="btn btn-info fs-12 p-r-10 p-l-12 fm-btn-new-folder">
                        <i class="fad fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div> --}}
        {{-- code added by amit pawar 18-11-2025 form action to create new folder --}}
        <div class="mb-4">
            <button class="btn btn-light-primary btn-sm w-100 fm-open-new-folder mb-2">
                <i class="fad fa-plus"></i> {{ __('New folder') }} </button>
            <div class="fm-box-new-folder">
                <div class="input-group mb-3">
                    <input type="text" class="form-control fs-12 fm-input-new-folder" name="create_new_folder"
                        placeholder="Enter folder name">
                    <button type="button" class="btn btn-info fs-12 p-r-10 p-l-12 fm-btn-new-folder">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
        {{-- end --}}
        <div class="mb-4">
            <h3 class="mb-3 text-gray-800 fs-16"><i class="ki-duotone ki-folder-up fs-2"><span
                class="path1"></span><span class="path2"></span></i> {{ __('Upload') }}</h3>

            <div class="fm-box-upload mb-2 rounded p-5 text-center bg-light-dark">

                <div class="fm-upload-dd p-10 rounded">

                    <div class="fm-upload-area">

                        <div class="icon fs-40 text-primary">
                            <i class="ki-duotone ki-folder-up fs-2"><span
                                class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div class="text-gray-500">
                            {{ __('Drag & Drop files here') }} </div>

                        <div class="py-2 text-gray-500">
                            {{ __('Or') }} </div>

                        <div class="text">
                            <button type="button" class="btn btn-info btn-sm fileinput-button">
                                {{ __(' Browser Files') }} <input id="fileupload" type="file" name="files[]"
                                    multiple="">
                            </button>
                        </div>

                        <div class="fm-upload-area-overplay">
                            <div class="d-flex align-items-center justify-content-center text-white fw-6 fs-40 h-100">
                                {{ __('Drop files to upload') }} </div>
                        </div>

                    </div>

                </div>

            </div>

            {{-- <div class="row px-2">

                <div class="col-md-12 px-1 mb-2">
                    <button class="btn btn-light btn-sm w-100 fm-open-upload-by-url"><i class="fad fa-link"></i>
                        {{ __('Upload by ur') }}l</button>
                </div>
            </div>

            <div class="fm-box-upload-by-url">
                <div class="input-group mb-3">
                    <input type="text" class="form-control fs-12 fm-input-upload-by-url" name="upload_by_url"
                        placeholder="{{ __('Enter file url') }}">
                    <button type="button" class="btn btn-info fs-12 p-r-10 p-l-12 fm-btn-upload-by-url">
                        <i class="fad fa-download"></i>
                    </button>
                </div>
            </div> --}}
        </div>
        <div class="mb-4">
            <h3 class="mb-3 text-gray-800 fs-16"><i class="ki-duotone ki-filter fs-2"><span
                class="path1"></span><span class="path2"></span></i> {{ __('Filter') }}</h3>

            <div class="input-group mb-2">
                <span class="input-group-text bg-white px-3">
                    <i class="ki-duotone ki-magnifier fs-2"><span
                        class="path1"></span><span class="path2"></span></i>
                </span>
                <input type="text" class="form-control ajax-filter fm-input-search fs-12 fw-4" name="keyword"
                    placeholder="{{ __('Enter keyword') }}">
            </div>

            <div class="input-group mb-2 d-none">
                <input type="text" class="form-control ajax-filter fs-12 fw-4 fm-input-folder" name="folder">
            </div>

            <div class="form-group">
                <label class="fs-12">{{ __('Media Type') }}</label>

                <div class="input-group">
                    <span class="input-group-text bg-white px-3">
                        <i class="ki-duotone ki-category fs-2"><span
                            class="path1"></span><span class="path2"></span></i>
                    </span>
                    <select class="form-control fs-12 fw-4 ajax-filter fm-input-filter" name="filter">
                        <option value="">{{ __('All Media') }}</option>
                        <option value="image">{{ __('Image') }}</option>
                        <option value="video">{{ __('Video') }}</option>
                        <option value="pdf">{{ __('Pdf') }}</option>
                        {{-- <option value="document">{{ __('Document') }}</option> --}}
                        <option value="mp3">{{ __('Audio') }}</option>
                        {{-- <option value="zip">{{ __('Zip') }}</option> --}}
                        {{-- <option value="other">{{ 'Other' }}</option> --}}
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="fm-storage mb-3">
        <h3 class="mb-3 text-gray-800 fs-16"><i class="ki-duotone ki-information fs-2"><span
            class="path1"></span><span class="path2"></span></i>
            {{ __('Media info') }}</h3>
        <div class="d-flex justify-content-between mb-2">
            <div>
                <div class="fw-6 fs-18 text-primary">{{ format_bytes($setup['total_size']) }}</div>
                <div class="fs-12 text-gray-800">{{ __('Used') }}</div>
            </div>
            <div class="text-end text-gray-800">
                <div class="fw-6 fs-18 total">{{ sprintf(__('%dMB'), $setup['max_storage']) }}</div>
                <div class="fs-12">{{ __('Total') }}</div>
            </div>
        </div>
        <div class="progress h-5">
            <div class="progress-bar bg-primary" style="width:{{ $setup['media_info']['image']['percent'] }}%"></div>
            <div class="progress-bar bg-success" style="width:{{ $setup['media_info']['video']['percent'] }}%"></div>
            <div class="progress-bar bg-warning" style="width{{ $setup['media_info']['document']['percent'] }}%">
            </div>
            <div class="progress-bar bg-danger" style="width:{{ $setup['media_info']['audio']['percent'] }}%"></div>
            <div class="progress-bar bg-dark" style="width:{{ $setup['media_info']['other']['percent'] }}%"></div>
        </div>
    </div>

    <div class="fm-stats">
        <div class="d-flex align-items-center mb-3">
            <div>
                <div class="symbol symbol-45px me-2">
                    <span class="symbol-label bg-light-primary fs-20 text-primary">
                        <i class="ki-duotone ki-picture fs-2"><span
                            class="path1"></span><span class="path2"></span></i>
                    </span>
                </div>
            </div>
            <div class="flex-fill text-gray-700">
                <div class="fw-6 fs-12">{{ __('Images') }}</div>
                <div class="fs-10 text-muted">{{ sprintf(__('%d files'), $setup['media_info']['image']['count']) }}
                </div>
            </div>
            <div class="flex-fill text-end fw-6 text-primary fs-12 text-gray-700">
                {{ format_bytes($setup['media_info']['image']['size']) }}</div>
        </div>

        <div class="d-flex align-items-center mb-3">
            <div>
                <div class="symbol symbol-45px me-2">
                    <span class="symbol-label bg-light-success fs-20 text-success">
                        <i class="ki-duotone ki-youtube fs-2"><span
                            class="path1"></span><span class="path2"></span></i>
                    </span>
                </div>
            </div>
            <div class="flex-fill text-gray-700">
                <div class="fw-6 fs-12">{{ __('Videos') }}</div>
                <div class="fs-10 text-muted">{{ sprintf(__('%d files'), $setup['media_info']['video']['count']) }}
                </div>
            </div>
            <div class="flex-fill text-end fw-6 text-primary fs-12 text-gray-700">
                {{ format_bytes($setup['media_info']['video']['size']) }}</div>
        </div>

        <div class="d-flex align-items-center mb-3">
            <div>
                <div class="symbol symbol-45px me-2">
                    <span class="symbol-label bg-light-primary fs-20 text-primary">
                        <i class="ki-duotone ki-call fs-2"><span
                            class="path1"></span><span class="path2"></span></i>
                    </span>
                </div>
            </div>
            <div class="flex-fill text-gray-700">
                <div class="fw-6 fs-12">{{ __('Audios') }}</div>
                <div class="fs-10 text-muted">{{ sprintf(__('%d files'), $setup['media_info']['audio']['count']) }}
                </div>
            </div>
            <div class="flex-fill text-end fw-6 text-primary fs-12 text-gray-700">
                {{ format_bytes($setup['media_info']['audio']['size']) }}</div>
        </div>

        {{-- <div class="d-flex align-items-center mb-3">
            <div>
                <div class="symbol symbol-45px me-2">
                    <span class="symbol-label bg-light-info fs-20 text-info">
                        <i class="ki-duotone ki-book fs-2"><span
                            class="path1"></span><span class="path2"></span></i>
                    </span>
                </div>
            </div>
            <div class="flex-fill text-gray-700">
                <div class="fw-6 fs-12">{{ __('CSV') }}</div>
                <div class="fs-10 text-muted">{{ sprintf(__('%d files'), $setup['media_info']['csv']['count']) }}
                </div>
            </div>
            <div class="flex-fill text-end fw-6 text-info fs-12 text-gray-700">
                {{ format_bytes($setup['media_info']['csv']['size']) }}</div>
        </div> --}}

        <div class="d-flex align-items-center mb-3">
            <div>
                <div class="symbol symbol-45px me-2">
                    <span class="symbol-label bg-light-danger fs-20 text-danger">
                        <i class="ki-duotone ki-note-2 fs-2"><span
                            class="path1"></span><span class="path2"></span></i>
                    </span>
                </div>
            </div>
            <div class="flex-fill text-gray-700">
                <div class="fw-6 fs-12">{{ __('PDF') }}</div>
                <div class="fs-10 text-muted">{{ sprintf(__('%d files'), $setup['media_info']['pdf']['count']) }}
                </div>
            </div>
            <div class="flex-fill text-end fw-6 text-danger fs-12 text-gray-700">
                {{ format_bytes($setup['media_info']['pdf']['size']) }}</div>
        </div>

        {{-- <div class="d-flex align-items-center mb-3">
            <div>
                <div class="symbol symbol-45px me-2">
                    <span class="symbol-label bg-light-warning fs-20 text-warning">
                        <i class="ki-duotone ki-directbox-default fs-2"><span
                            class="path1"></span><span class="path2"></span></i>
                    </span>
                </div>
            </div>
            <div class="flex-fill text-gray-700">
                <div class="fw-6 fs-12">{{ __('Documents') }}</div>
                <div class="fs-10 text-muted">
                    {{ sprintf(__('%d files'), $setup['media_info']['document']['count']) }}</div>
            </div>
            <div class="flex-fill text-end fw-6 text-warning fs-12 text-gray-700">
                {{ format_bytes($setup['media_info']['document']['size']) }}</div>
        </div> --}}

        {{-- <div class="d-flex align-items-center mb-3">
            <div>
                <div class="symbol symbol-45px me-2">
                    <span class="symbol-label fs-20">
                        <i class="ki-duotone ki-archive fs-2"><span
                            class="path1"></span><span class="path2"></span></i>
                    </span>
                </div>
            </div>
            <div class="flex-fill text-gray-700">
                <div class="fw-6 fs-12">{{ __('Others') }}</div>
                <div class="fs-10 text-muted">{{ sprintf(__('%d files'), $setup['media_info']['other']['count']) }}
                </div>
            </div>
            <div class="flex-fill text-end fw-6 text-dark fs-12 text-gray-700">
                {{ format_bytes($setup['media_info']['other']['size']) }}</div>
        </div> --}}
    </div>
</div>
