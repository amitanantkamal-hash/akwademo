<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($method)
    <div class="modal-body">
        @include('partials.fields-modal', ['fields' => $fields])
    </div>
    <div class="modal-footer d-flex justify-content-center mt-4">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info">{{ __('Update') }}</button>
    </div>
</form>
