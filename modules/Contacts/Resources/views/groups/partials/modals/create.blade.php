<div class="modal fade" tabindex="-1" id="kt_modal_create">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h2 class="modal-title">{{ __('Create Group') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
            </div>

            <form action="{{ $setup_create['action'] }}" method="POST" enctype="multipart/form-data">
                @csrf
                @isset($setup_create['isupdate'])
                    @method('PUT')
                @endisset
                <div class="modal-body mx-4">
                    @isset($setup_create['inrow'])
                        <div class="row">
                        @endisset
                        @include('partials.fields-modal', ['fields' => $fields_create])
                        @isset($setup_create['inrow'])
                        </div>
                    @endisset
                </div>
                <div class="modal-footer d-flex justify-content-center mt-4">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Close</button>
                    @if (isset($setup_create['isupdate']))
                        <button type="submit" class="btn btn-info">{{ __('Update') }}</button>
                    @else
                        <button type="submit" class="btn btn-info">{{ __('Create') }}</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>