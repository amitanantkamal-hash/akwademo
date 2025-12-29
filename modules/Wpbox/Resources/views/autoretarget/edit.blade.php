@extends('client.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header mt-10">
                        <h3 class="mb-0">Edit AutoRetarget Campaign: {{ $autoretargetCampaign->name }}</h3>
                    </div>

                    <div class="card-body">
                        <!-- Display validation errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('autoretarget.update', $autoretargetCampaign) }}" method="POST"
                            id="autoretargetForm">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-4">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control mt-2 @error('name') is-invalid @enderror"
                                    value="{{ old('name', $autoretargetCampaign->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-4 mb-4">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control mt-2 @error('description') is-invalid @enderror"
                                    rows="3">{{ old('description', $autoretargetCampaign->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <h4 class="mt-4 mb-4">Retargeting Messages</h4>

                            <div id="messages-container">
                                @foreach ($autoretargetCampaign->messages as $index => $message)
                                    <div class="message-card card mb-3">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Days After Delivery</label>
                                                    <input type="number"
                                                        class="form-control delay-days @error('messages.' . $index . '.delay_days') is-invalid @enderror"
                                                        name="messages[{{ $index }}][delay_days]"
                                                        value="{{ old('messages.' . $index . '.delay_days', $message->delay_days) }}"
                                                        min="0" required>
                                                    @error('messages.' . $index . '.delay_days')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Send Time</label>
                                                    <input type="time"
                                                        class="form-control send-time @error('messages.' . $index . '.send_time') is-invalid @enderror"
                                                        name="messages[{{ $index }}][send_time]"
                                                        value="{{ old('messages.' . $index . '.send_time', \Carbon\Carbon::parse($message->send_time)->format('H:i')) }}"
                                                        required>
                                                    @error('messages.' . $index . '.send_time')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Order</label>
                                                    <input type="number"
                                                        class="form-control order @error('messages.' . $index . '.order') is-invalid @enderror"
                                                        name="messages[{{ $index }}][order]"
                                                        value="{{ old('messages.' . $index . '.order', $message->order) }}"
                                                        required>
                                                    @error('messages.' . $index . '.order')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-message">Remove</button>
                                                </div>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Campaign</label>
                                                <select
                                                    class="form-control campaign-select @error('messages.' . $index . '.campaign_id') is-invalid @enderror"
                                                    name="messages[{{ $index }}][campaign_id]" required>
                                                    <option value="">-- Select Campaign --</option>
                                                    @foreach ($whatsappCampaigns as $campaign)
                                                        <option value="{{ $campaign->id }}"
                                                            {{ old('messages.' . $index . '.campaign_id', $message->campaign_id) == $campaign->id ? 'selected' : '' }}>
                                                            {{ $campaign->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('messages.' . $index . '.campaign_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <div class="alert alert-info">
                                                    <strong>Note:</strong>
                                                    @if ($message->delay_days == 0)
                                                        This message will be sent on the same day as the original campaign,
                                                        at the specified time.
                                                    @else
                                                        This message will be sent {{ $message->delay_days }} days after the
                                                        original campaign, at the specified time.
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-message" class="btn btn-secondary mb-4">
                                <i class="fas fa-plus"></i> Add Another Message
                            </button>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update AutoRetarget Campaign</button>
                                <a href="{{ route('autoretarget.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let messageCount = {{ $autoretargetCampaign->messages->count() }};

            // Add new message
            $('#add-message').click(function() {
                const newIndex = messageCount++;
                const newMessage = `
            <div class="message-card card mb-3">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Days After Delivery</label>
                            <input type="number" class="form-control delay-days" name="messages[${newIndex}][delay_days]" value="0" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label>Send Time</label>
                            <input type="time" class="form-control send-time" name="messages[${newIndex}][send_time]" value="09:00" required>
                        </div>
                        <div class="col-md-3">
                            <label>Order</label>
                            <input type="number" class="form-control order" name="messages[${newIndex}][order]" value="${newIndex}" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-message">Remove</button>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label>Campaign</label>
                        <select class="form-control campaign-select" name="messages[${newIndex}][campaign_id]" required>
                            <option value="">-- Select Campaign --</option>
                            @foreach ($whatsappCampaigns as $campaign)
                                <option value="{{ $campaign->id }}">
                                    {{ $campaign->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="alert alert-info">
                            <strong>Note:</strong> This message will be sent on the same day as the original campaign, at the specified time.
                        </div>
                    </div>
                </div>
            </div>
        `;
                $('#messages-container').append(newMessage);

                // Add event listener to update the note when delay_days changes
                $(`[name="messages[${newIndex}][delay_days]"]`).on('change', function() {
                    updateDelayNote(this);
                });
            });

            // Remove message
            $(document).on('click', '.remove-message', function() {
                if ($('.message-card').length > 1) {
                    $(this).closest('.message-card').remove();
                    // Reindex all messages
                    reindexMessages();
                    messageCount = $('.message-card').length;
                } else {
                    // alert('You must have at least one message');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'You must have at least one message',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Update delay note based on delay_days value
            function updateDelayNote(input) {
                const delayDays = $(input).val();
                const note = $(input).closest('.card-body').find('.alert-info');

                if (delayDays == 0) {
                    note.html(
                        '<strong>Note:</strong> This message will be sent on the same day as the original campaign, at the specified time.'
                    );
                } else if (delayDays == 1) {
                    note.html(
                        `<strong>Note:</strong> This message will be sent ${delayDays} day after the original campaign, at the specified time.`
                    );
                } else {
                    note.html(
                        `<strong>Note:</strong> This message will be sent ${delayDays} days after the original campaign, at the specified time.`
                    );
                }
            }

            // Add event listeners to existing delay_days inputs
            $('.delay-days').each(function() {
                $(this).on('change', function() {
                    updateDelayNote(this);
                });
            });

            // Reindex all messages
            function reindexMessages() {
                $('.message-card').each(function(index) {
                    $(this).find('.delay-days').attr('name', `messages[${index}][delay_days]`);
                    $(this).find('.send-time').attr('name', `messages[${index}][send_time]`);
                    $(this).find('.order').attr('name', `messages[${index}][order]`).val(index);
                    $(this).find('.campaign-select').attr('name', `messages[${index}][campaign_id]`);
                });
            }

            // AJAX Form submission
            $('#autoretargetForm').on('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                let errorMessage = '';

                // Reset validation
                $('.is-invalid').removeClass('is-invalid');

                // Check if all campaign selects have values
                $('.campaign-select').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        errorMessage = 'Please select a campaign for all messages';
                        $(this).addClass('is-invalid');
                    }
                });

                // Check if name is filled
                if (!$('#name').val()) {
                    isValid = false;
                    errorMessage = 'Please enter a name for the AutoRetarget campaign';
                    $('#name').addClass('is-invalid');
                }

                // Validate time format
                $('.send-time').each(function() {
                    const timeValue = $(this).val();
                    // Simple time format validation (HH:MM)
                    if (!/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/.test(timeValue)) {
                        isValid = false;
                        errorMessage = 'Please enter a valid time format (HH:MM) for all messages';
                        $(this).addClass('is-invalid');
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: errorMessage
                    });
                    return false;
                }

                // Show loading indicator
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we update your AutoRetarget campaign',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Prepare form data
                const formData = new FormData(this);

                // Send AJAX request
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.close();

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = response.redirect;
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();

                        let errorMessage =
                            'An error occurred while updating the AutoRetarget campaign';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // Handle validation errors
                            const errors = xhr.responseJSON.errors;
                            errorMessage = '';

                            for (const field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    errorMessage += errors[field][0] + '\n';
                                    $(`[name="${field}"]`).addClass('is-invalid');
                                }
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    }
                });
            });
        });
    </script>

    <style>
        .message-card {
            border-left: 4px solid #007bff;
            position: relative;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .remove-message {
            margin-top: 1.5rem;
        }
    </style>
@endpush
