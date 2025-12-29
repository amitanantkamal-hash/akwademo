<div class="modal fade" id="fileCaptionModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-gray-800">{{ __('Send media & caption') }}</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    @include('wpbox::file_manager.mini', [
                        'id' => 'multimediaupload',
                        'changevue' => 'handleMultiMediaUpload',
                        'type' => 'all',
                        'select_multi' => 0,
                        'name' => __('Select file'),
                        'required' => true,
                        'accept' => '.jpg, .jpeg, .png, application/pdf, .mp4, .mp3',
                    ])
                </div>

                @include('partials.textarea', [
                    'id' => 'media_caption',
                    'name' => 'Caption (Optional)',
                    'placeholder' => '',
                    'labelclass' => 'fs-14 fw-6 text-info mt-3',
                    'required' => false,
                ])
                <div class="d-flex justify-content-start">
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-light-info m-r-6" data-bs-dismiss="modal"
                        aria-label="Close">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-info btnFileCaptionSendModal">{{ __('Send now') }}</button>
                </div>

            </div>
        </div>
    </div>
</div>
