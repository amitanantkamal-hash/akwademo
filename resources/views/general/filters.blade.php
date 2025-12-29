<form class="d-flex flex-column justify-content-between align-items-center w-100">
    <div class="flex-grow-1 d-flex flex-column flex-sm-column flex-md-column flex-lg-row flex-xl-row pt-4 w-100">
        @include('partials.fields', ['fields' => isset($setup['filterFields']) ? $setup['filterFields'] : $setup['fields']])
    </div>
    <div class="flex-1 ms-6 d-flex justify-content-end w-100 mt-4">
        @if ($setup['parameters'])
            <div class="d-flex me-4">
                <a href="{{ Request::url() }}" class="btn btn-light-secondary btn-sm">{{ __('crud.clear_filters') }} Claudio aqui</a>
            </div>
            <div class="d-flex me-4">
                <a href="{{ Request::fullUrl() . '&report=true' }}"
                    class="btn btn-light-dark btn-sm">{{ __('crud.download_report') }}</a>
            </div>
        @else
            <div class="d-flex"></div>
        @endif
        <button type="submit" class="btn btn-light-success btn-sm">{{ __('crud.filter') }}</button>
    </div>
</form>
