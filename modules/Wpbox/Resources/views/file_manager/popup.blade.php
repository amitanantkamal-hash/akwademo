<div class="modal fade file-manager file-manager-modal" data-select-multi="{{ $media_select }}" id="file-manager"
    tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="file-manager">{{ __('File manager') }}</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <div class="input-group mb-2 d-none">
                    <input type="text" class="form-control ajax-filter fs-12 fw-4 fm-input-folder" name="folder">
                    <input type="hidden" class="ajax-filter fm-input-filter" name="filter"
                        value="{{ $media_type }}">
                </div>
            </div>
            {{-- {{ route('file-manager.load_files', ['widget' => 'widget']) }} --}}
            <div class="modal-body shadow-none n-scroll overflow-hidden bg-light-dark fm-list row px-2 py-4 ajax-load-scroll m-l-0 m-r-0 align-content-start"
                data-url="{{ route('file-manager.load_widget_files') }}" data-scroll="ajax-load-scroll"
                data-call-after="File_manager.lazy();">
                <div class="mw-400 container d-flex align-items-center justify-content-center text-center mih-500">
                    <div>
                        <div class="text-center px-4">
                            <img class="mh-190 mb-4" alt="" src="{{ asset('backend/Assets/img/empty.png') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-info btnAddFiles" data-transfer="{{ $media_id }}"
                    data-bs-dismiss="modal">{{ __('Done') }}</button>
            </div>
        </div>
    </div>
</div>
