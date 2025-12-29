{{-- Brij Mohan Negi Update --}}
@php
    $data = false;
    $sections = false;

    if (isset($field['template'])) {
        $data = json_decode($field['template']);
        if (!empty($data) && isset($data->sections) && count($data->sections) != 0) {
            $sections = $data->sections;
        }
    }
@endphp

<div class="wa-template-section">
    @if ($sections)
        @foreach ($sections as $key => $section)
            <div class="card b-r-6 mb-4 wa-template-section-item" data-count="{{ $key + 1 }}">
                <div class="card-header">
                    <div class="card-title">{{ __('Section') }}{{ $key + 1 }}</div>
                </div>

                <div class="card-body">

                    <div class="mb-4">
                        <label class="form-label">{{ __('Section name') }}</label>
                        <input type="text" name="section_name[{{ $key + 1 }}]"
                            class="form-control form-control-solid" maxlength="24" value="{{ $section->title }}">
                        <small class="form-text text-muted">{{ __('max 24 characters allowed') }}</small>
                    </div>

                    <label class="form-label mb-3">{{ __('List option') }}</label>

                    <div class="wa-template-option">

                        @php
                            $options = false;
                            if (!empty($section)) {
                                if (!empty($section) && isset($section->rows) && count($section->rows) != 0) {
                                    $options = $section->rows;
                                }
                            }
                        @endphp

                        @foreach ($options as $option_key => $option)
                            <div class="card border b-r-6 mb-4 wa-template-option-item">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <label class="form-label">{{ __('Option name') }}</label>
                                        <input type="text" name="options[{{ $key + 1 }}][name][]"
                                            class="form-control form-control-solid" maxlength="24"
                                            value="{{ $option->title }}">
                                        <small
                                            class="form-text text-muted">{{ __('max 24 characters allowed') }}</small>
                                    </div>

                                    <div class="">
                                        <label class="form-label">{{ __('Option description') }}</label>
                                        <input type="text" name="options[{{ $key + 1 }}][desc][]"
                                            class="form-control form-control-solid" value="{{ $option->description }}">
                                    </div>

                                </div>
                            </div>
                        @endforeach



                    </div>

                </div>

                <div class="card-footer wa-template-wrap-add">
                    <a href="javascript:void(0);"
                        class="btn btn-dark px-3 btn-wa-add-list-option">{{ __('Add new option') }}</a>
                </div>
            </div>
        @endforeach

    @endif
</div>

<div class="mt-5 mb-4 d-flex justify-content-between">
    <button type="button" class="btn btn-dark me-2 btn-wa-add-section">{{ __('Add new option') }}</button>
</div>

<div class="wa-template-data-option d-none">
    <div class="card border b-r-6 mb-4 wa-template-option-item">
        <div class="card-header">
            <div class="card-title">{{ __('Option item') }}</div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-danger px-3 b-r-6 remove-item"
                    data-remove="wa-template-option-item"><i class="fad fa-trash-alt pe-0 me-0"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <label class="form-label">{{ __('Option name') }}</label>
                <input type="text" name="options[{count}][name][]" maxlength="24"
                    class="form-control form-control-solid">
                <small class="form-text text-muted">{{ __('max 24 characters allowed') }}</small>
            </div>

            <div class="">
                <label class="form-label">{{ __('Option description') }}</label>
                <input type="text" name="options[{count}][desc][]" class="form-control form-control-solid">
            </div>

        </div>
    </div>
</div>

<div class="wa-template-data-section d-none">
    <div class="card b-r-6 mb-4 wa-template-section-item" data-count="{count}">
        <div class="card-header">
            <div class="card-title">{{ __('Section') }} {count}</div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-danger px-3 b-r-6 remove-item"
                    data-remove="wa-template-section-item"><i class="fad fa-trash-alt pe-0 me-0"></i></button>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-4">
                <label class="form-label">{{ __('Section name') }}</label>
                <input type="text" name="section_name[{count}]" maxlength="24"
                    class="form-control form-control-solid">
                <small class="form-text text-muted">{{ __('max 24 characters allowed') }}</small>
            </div>

            <label class="form-label mb-3">{{ __('List option') }}</label>

            <div class="wa-template-option"></div>

        </div>

        <div class="card-footer wa-template-wrap-add">
            <a href="javascript:void(0);"
                class="btn btn-dark px-3 btn-wa-add-list-option">{{ __('Add new option') }}</a>
        </div>
    </div>
</div>

@section('js')
    <script>
        const script = document.createElement("script");
        script.src = "https://dotflo.org/cus-assets/sendinai/whatsapp.js";
        script.async = true;
        document.head.appendChild(script);
    </script>
@endsection
