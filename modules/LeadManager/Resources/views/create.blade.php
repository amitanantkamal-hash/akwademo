@extends('layouts.app-client')

@section('css')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css" />

    <style>
        .card {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            border: 0;
            border-radius: 12px;
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #3F4254;
        }

        .input-group-text {
            background-color: #F5F8FA;
            border-right: none;
        }

        .form-control,
        .form-select {
            border-left: none;
            padding-left: 0;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .btn-primary {
            background: linear-gradient(90deg, #009EF7 0%, #0095E8 100%);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-secondary {
            background: #E4E6EF;
            color: #3F4254;
            border: none;
            padding: 10px 20px;
            font-weight: 600;
        }

        .select2-container--bootstrap-5 .select2-selection {
            min-height: 45px;
            display: flex;
            align-items: center;
        }

        .help-text {
            font-size: 0.85rem;
            color: #7E8299;
            margin-top: 5px;
        }

        .required-field::after {
            content: "*";
            color: #F1416C;
            margin-left: 4px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title m-0">
                            <i class="fas fa-plus-circle me-2"></i>Add New Lead
                        </h3>
                    </div>
                    <div class="card-body p-5">
                        <form action="{{ route('leads.store') }}" method="POST" id="leadForm">
                            @csrf
                            <div class="row mb-8">
                                <div class="col-xl-6 mb-4">
                                    <label for="phone" class="form-label required-field">Phone Number
                                        <i class="fas fa-phone"></i></label>
                                    <div class="input-group input-group-lg">
                                        <input type="tel" class="form-control" id="phone" required pattern="\d+"
                                            title="Please enter numbers only">
                                        <!-- Hidden input is the actual field that Laravel will receive -->
                                        <input type="hidden" name="phone" id="full_phone">
                                    </div>
                                    <div class="help-text">Country code will be automatically added</div>
                                </div>
                                <div class="col-xl-6 mb-4">
                                    <label for="name" class="form-label">Name</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter client name">
                                    </div>
                                </div>
                                <div class="col-xl-6 mb-4">
                                    <label for="source_id" class="form-label">Source
                                        <i class="fas fa-source"></i></label>
                                    <div class="input-group input-group-lg">
                                        <select class="form-control select2-source" id="source_id" name="source_id"
                                            data-placeholder="Select or add a source">
                                            <option value=""></option>
                                            @foreach ($sources as $source)
                                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="help-text">Type to search or add a new source</div>
                                </div>
                                <div class="col-xl-6 mb-4">
                                    <label for="stage" class="form-label">Stage</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">
                                            <i class="fas fa-step-forward"></i>
                                        </span>
                                        <select class="form-control" id="stage" name="stage">
                                            @foreach ($stages as $stage)
                                                <option value="{{ $stage }}" {{ $stage == 'New' ? 'selected' : '' }}>
                                                    {{ $stage }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 mb-4">
                                    <label for="agent_id" class="form-label">Assign Agent</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-tie"></i>
                                        </span>
                                        <select class="form-control" id="agent_id" name="agent_id">
                                            <option value="">Unassigned</option>
                                            @foreach ($agents as $agent)
                                                <option value="{{ $agent->id }}"
                                                    @if (auth()->user()->hasRole('staff') && auth()->id() == $agent->id) selected @endif>
                                                    {{ $agent->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-6 mb-4">
                                    <label for="tags" class="form-label">Tags
                                        <i class="fas fa-tags"></i></label>
                                    <div class="input-group input-group-lg">
                                        <select class="form-control select2-tags" id="tags" name="tags[]" multiple
                                            data-placeholder="Select or add tags">
                                            @foreach ($existingTags as $tag)
                                                <option value="{{ $tag }}">{{ $tag }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="help-text">Type to search existing tags or add new ones</div>
                                </div>
                                <div class="col-xl-6 mb-4">
                                    <label for="groups" class="form-label">Groups
                                        <i class="fas fa-users"></i></label>
                                    <div class="input-group input-group-lg">
                                        <select class="form-control select2-groups" id="groups" name="groups[]" multiple
                                            data-placeholder="Select groups">
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="separator my-5"></div>

                            <h4 class="mb-5">Additional Information</h4>

                            <div class="row g-5">
                                @foreach ($fields as $field)
                                    <div class="{{ $field['class'] }}">
                                        @if ($field['ftype'] == 'input')
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">{{ $field['name'] }}</label>
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-flag"></i>
                                                    </span>
                                                    <input type="{{ $field['type'] ?? 'text' }}"
                                                        name="{{ $field['id'] }}" class="form-control"
                                                        placeholder="{{ $field['placeholder'] }}"
                                                        value="{{ $field['value'] ?? '' }}"
                                                        {{ $field['required'] ? 'required' : '' }} />
                                                </div>
                                            </div>
                                        @elseif ($field['ftype'] == 'select')
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">{{ $field['name'] }}</label>
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-list"></i>
                                                    </span>
                                                    <select name="{{ $field['id'] }}" class="form-select select2-field"
                                                        data-placeholder="{{ $field['placeholder'] }}"
                                                        {{ isset($field['multiple']) ? 'multiple' : '' }}>
                                                        <option value=""></option>
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
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-end mt-8">
                                <a href="{{ route('leads.index') }}" class="btn btn-secondary me-4">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Create Lead
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding new source -->
    <div class="modal fade" id="addSourceModal" tabindex="-1" aria-labelledby="addSourceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSourceModalLabel">
                        <i class="fas fa-plus me-2"></i>Add New Source
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="newSource" class="form-label">Source Name</label>
                        <input type="text" class="form-control form-control-lg" id="newSource"
                            placeholder="Enter source name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="saveNewSource">
                        <i class="fas fa-save me-2"></i>Save
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Select2 JS -->
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var phoneInput = document.querySelector("#phone");

            var iti = window.intlTelInput(phoneInput, {
                initialCountry: "in",
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: "polite",
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.13/build/js/utils.js"
            });

            // On form submit
            document.querySelector("#leadForm").addEventListener("submit", function(e) {
                // e.preventDefault(); // keep for debugging

                const countryData = iti.getSelectedCountryData();
                const dialCode = countryData.dialCode; // e.g. 91
                const localNumber = phoneInput.value.replace(/\D/g, ''); // strip spaces/dashes etc.

                // Combine manually (without +)
                const fullNumber = dialCode + localNumber;
                document.querySelector("#full_phone").value = fullNumber;

            });
        });
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var phoneInput = document.querySelector("#phone");


            $('#leadForm').on('submit', function(e) {
                e.preventDefault(); // Prevent normal submit

                // Format full phone number
                const dialCodeElement = document.querySelector('.iti__selected-dial-code');
                // Get its text content (the dial code) and remove the +
                const dialCode = dialCodeElement ? dialCodeElement.textContent.trim().replace('+', '') :
                    '91';
                const localNumber = phoneInput.value.replace(/\D/g, '');
                $('#full_phone').val(dialCode + localNumber);

                let formData = new FormData(this);

                // Ensure CSRF token is included
                formData.append('_token', $('input[name="_token"]').val());

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Lead Created!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('leads.index') }}";
                            });
                        } else {
                            // Show backend error message (like duplicate phone)
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let res = xhr.responseJSON || {};

                            // Check if 'errors' exists (validation) else show 'message'
                            if (res.errors) {
                                let errorText = '';
                                for (const key in res.errors) {
                                    errorText += res.errors[key].join('<br>') + '<br>';
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    html: errorText
                                });
                            } else if (res.message) {
                                // For custom backend messages like duplicate phone
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: res.message
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong! Please try again.'
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong! Please try again.'
                            });
                        }
                    }

                });
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            // Initialize Select2 for source
            $('.select2-source').select2({
                theme: "bootstrap-5",
                tags: true,
                createTag: function(params) {
                    return {
                        id: params.term,
                        text: params.term + ' (new)',
                        newTag: true
                    };
                }
            });

            // Initialize Select2 for tags
            $('.select2-tags').select2({
                theme: "bootstrap-5",
                tags: true,
                tokenSeparators: [',', ' '],
                createTag: function(params) {
                    return {
                        id: params.term,
                        text: params.term,
                        newTag: true
                    };
                }
            });

            // Initialize Select2 for groups
            $('.select2-groups').select2({
                theme: "bootstrap-5"
            });

            // Initialize Select2 for custom fields
            $('.select2-field').select2({
                theme: "bootstrap-5"
            });

            // Handle source creation
            $('.select2-source').on('select2:select', function(e) {
                var data = e.params.data;
                if (data.newTag) {
                    // Show modal for new source
                    $('#addSourceModal').modal('show');
                    $('#newSource').val(data.id);

                    // Prevent the tag from being added until we confirm
                    e.preventDefault();
                }
            });

            // Save new source
            $('#saveNewSource').on('click', function() {
                var newSource = $('#newSource').val().trim();
                if (!newSource) return;

                $.ajax({
                    url: "/lead-manager/lead-sources/store", // Backend route to save new source
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: newSource
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add the new source to Select2 and select it
                            var $select = $('.select2-source');
                            var option = new Option(response.data.name, response.data.id, true,
                                true);
                            $select.append(option).trigger('change');

                            // Close modal and clear input
                            $('#addSourceModal').modal('hide');
                            $('#newSource').val('');

                            // SweetAlert success
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Lead source added successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message || 'Failed to add source'
                            });
                        }
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong! Please try again.'
                        });
                        console.log(err);
                    }
                });
            });


        });
    </script>
@endsection
