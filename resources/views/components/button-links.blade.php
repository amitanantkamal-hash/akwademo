@section('button-links')
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="{{ route('contacts.create') }}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">
            {{ __('Add Member') }}
        </a>
        <a href="{{ route('campaigns.create') }}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
            {{ __('New Campaign') }}
        </a>
    </div>
@endsection
