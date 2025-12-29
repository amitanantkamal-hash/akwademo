@extends('layouts.app-client', $setup)
@section('content')
    <div class="container-xxl card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bolder m-0">{{ $setup['title'] }}</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ $setup['action_link'] }}" class="btn btn-light-primary">
                    <i class="ki-duotone ki-arrow-left fs-3 me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    {{ $setup['action_name'] }}
                </a>
            </div>
        </div>

        <div class="card-body p-9">
            <form action="{{ $setup['action'] }}" method="POST" enctype="multipart/form-data" class="form">
                @csrf
                @isset($setup['isupdate'])
                    @method('PUT')
                @endisset

                <div class="row g-3">
                    @foreach ($fields as $field)
                        <div class="{{ $field['class'] }}">
                            @if ($field['ftype'] == 'image')
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">{{ __('Avatar') }}</label>
                                    <div class="col-lg-8">
                                        <div class="image-input image-input-outline" data-kt-image-input="true"
                                            style="background-image: url('{{ asset('assets/media/svg/avatars/blank.svg') }}')">
                                            <div class="image-input-wrapper w-125px h-125px"
                                                style="background-image: url('{{ $field['value'] ?? asset('assets/media/svg/avatars/blank.svg') }}')">
                                            </div>
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <input type="file" name="{{ $field['id'] }}"
                                                    accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="avatar_remove" />
                                            </label>
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                title="Cancel avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                title="Remove avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                        </div>
                                        <div class="form-text">{{ __('Allowed file types: png, jpg, jpeg. Max size 2MB.') }}
                                        </div>
                                    </div>
                                </div>
                            @elseif ($field['ftype'] == 'input')
                                <div class="mb-4">
                                    <label class="form-label fs-6 fw-bold">{{ $field['name'] }}</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="ki-duotone ki-flag fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <input type="{{ $field['type'] ?? 'text' }}" name="{{ $field['id'] }}"
                                            class="form-control form-control-solid"
                                            placeholder="{{ $field['placeholder'] }}" value="{{ $field['value'] ?? '' }}"
                                            {{ $field['required'] ? 'required' : '' }} />
                                    </div>
                                </div>
                            @elseif ($field['ftype'] == 'select')
                                <div class="mb-4">
                                    <label class="form-label fs-6 fw-bold">{{ $field['name'] }}</label>
                                    <div class="input-group input-group-solid">
                                        <select name="{{ $field['id'] }}" class="form-select form-select-solid"
                                            data-kt-select2="true" data-placeholder="{{ $field['placeholder'] }}"
                                            {{ isset($field['multiple']) ? 'multiple' : '' }}>
                                            @foreach ($field['data'] as $key => $value)
                                                <option value="{{ $key }}"
                                                    @if (isset($field['multipleselected']) && in_array($key, $field['multipleselected'])) selected
                                    @elseif(isset($field['value']) && $field['value'] == $key)
                                        selected @endif>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif ($field['ftype'] == 'bool')
                                <div class="mb-4 d-flex align-items-center">
                                    <div class="form-check form-check-solid form-switch form-check-custom">
                                        <input class="form-check-input" type="checkbox" name="{{ $field['id'] }}"
                                            {{ isset($field['value']) && $field['value'] ? 'checked' : '' }} />
                                        <label class="form-check-label fw-bold ms-3">
                                            <i class="ki-duotone ki-element-11 fs-2 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                            {{ $field['name'] }}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="card-footer d-flex justify-content-start py-6 px-9">
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-duotone ki-check-circle fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        @if (isset($setup['isupdate']))
                            {{ __('Update') }}
                        @else
                            {{ __('Create') }}
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('topjs')
    <script>
        $(document).ready(function() {
            // Enhanced Image Input Handling
            const imageInputElement = document.querySelector('[data-kt-image-input="true"]');
            const imageInput = KTImageInput.getInstance(imageInputElement);

            // Initialize with default image
            if (!imageInput.getImage()) {
                imageInput.setImage('{{ asset('media/avatars/blank.png') }}');
            }

            // Handle cancel button click
            $('[data-kt-image-input-action="remove"]').on('click', function() {
                imageInput.setImage('{{ asset('media/avatars/blank.png') }}');
                imageInputElement.querySelector('input[type="file"]').value = '';
            });

            // Initialize Select2
            $('[data-kt-select2="true"]').select2({
                placeholder: $(this).data('placeholder'),
                minimumResultsForSearch: Infinity,
                dropdownParent: $(this).closest('.modal').length ? $(this).closest('.modal') : document.body
            });
        });
    </script>
@endsection
