<div class="card mb-4">
    <div class="card-header">
        <h3>{{ $setup_create['title'] }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $setup_create['action'] }}">
            @csrf
            <div class="row">
                @foreach($fields_create as $field)
                    @include('wpbox::replies.partials.form-field', ['field' => $field])
                @endforeach
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save') }}
                    </button>
                    <a href="{{ $setup_create['action_link'] }}" class="btn btn-secondary">
                        {{ $setup_create['action_name'] }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>