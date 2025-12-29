<form id="editForm" method="POST" action="{{ $action }}">
    @csrf
    @method('PUT')
    <div class="row">
        @foreach($fields as $field)
            @include('partials.form-field', ['field' => $field])
        @endforeach
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Update') }}
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                {{ __('Cancel') }}
            </button>
        </div>
    </div>
</form>