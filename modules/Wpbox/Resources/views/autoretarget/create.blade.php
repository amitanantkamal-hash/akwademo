@extends('client.app')

@section('content')
    <div class="container-xxl">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-abstract-21 fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Create AutoRetarget Campaign
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">New Campaign</span>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('autoretarget.index') }}" class="btn btn-primary">
                    <i class="ki-duotone ki-arrow-left fs-2 me-1"></i>
                    Back to Campaigns
                </a>
            </div>
        </div>

        <!-- Progress Stepper -->
        <div class="card card-flush mb-7">
            <div class="card-body">
                <div class="stepper stepper-pills" id="autoretarget_stepper">
                    <div class="stepper-nav flex-center flex-wrap">
                        <div class="stepper-item mx-2 my-2 current" data-kt-stepper-element="nav">
                            <div class="stepper-wrapper d-flex align-items-center">
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="ki-duotone ki-setting-3 fs-2 stepper-check">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Basic Information</h3>
                                    <div class="stepper-desc">Campaign setup</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stepper-item mx-2 my-2" data-kt-stepper-element="nav">
                            <div class="stepper-wrapper d-flex align-items-center">
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="ki-duotone ki-message-text-2 fs-2 stepper-check">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="stepper-number">2</span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Message Sequence</h3>
                                    <div class="stepper-desc">Configure retargeting</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stepper-item mx-2 my-2" data-kt-stepper-element="nav">
                            <div class="stepper-wrapper d-flex align-items-center">
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="ki-duotone ki-eye fs-2 stepper-check">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="stepper-number">3</span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Review & Save</h3>
                                    <div class="stepper-desc">Finalize campaign</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-center mb-7">
                <i class="ki-duotone ki-information fs-2hx me-4">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
                <div class="d-flex flex-column">
                    <h4 class="alert-heading">Please fix the following errors:</h4>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('autoretarget.store') }}" method="POST" id="autoretargetForm">
            @csrf
            
            <div class="row g-6">
                <!-- Basic Information -->
                <div class="col-xl-6">
                    <div class="card card-flush h-100">
                        <div class="card-header">
                            <div class="card-title">
                                <h2 class="fw-bolder d-flex align-items-center">
                                    <i class="ki-duotone ki-setting-3 fs-2 me-3 text-primary"></i>
                                    Basic Information
                                </h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <!-- Campaign Name -->
                            <div class="fv-row mb-8">
                                <label class="fs-6 fw-bold form-label mb-3 required">
                                    <i class="ki-duotone ki-tag fs-2 me-2 text-primary"></i>
                                    Campaign Name
                                </label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text">
                                        <i class="ki-duotone ki-edit fs-2 text-primary"></i>
                                    </span>
                                    <input type="text" name="name" id="name"
                                        class="form-control form-control-solid @error('name') is-invalid @enderror" 
                                        value="{{ old('name') }}" 
                                        placeholder="Enter campaign name" required>
                                </div>
                                @error('name')
                                    <div class="text-danger fs-7 mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted mt-1">
                                    Give your AutoRetarget campaign a descriptive name
                                </div>
                            </div>

                            <!-- Campaign Description -->
                            <div class="fv-row mb-8">
                                <label class="fs-6 fw-bold form-label mb-3">
                                    <i class="ki-duotone ki-document fs-2 me-2 text-primary"></i>
                                    Description
                                </label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text">
                                        <i class="ki-duotone ki-document fs-2 text-primary"></i>
                                    </span>
                                    <textarea name="description" id="description" 
                                        class="form-control form-control-solid @error('description') is-invalid @enderror"
                                        rows="3" placeholder="Describe your AutoRetarget campaign">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <div class="text-danger fs-7 mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted mt-1">
                                    Optional description for your campaign
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Sequence -->
                <div class="col-xl-6">
                    <div class="card card-flush h-100">
                        <div class="card-header">
                            <div class="card-title">
                                <h2 class="fw-bolder d-flex align-items-center">
                                    <i class="ki-duotone ki-message-text-2 fs-2 me-3 text-primary"></i>
                                    Retargeting Sequence
                                </h2>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" id="add-message" class="btn btn-light-primary btn-sm">
                                    <i class="ki-duotone ki-plus fs-2 me-1"></i>
                                    Add Message
                                </button>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="text-muted fs-7 mb-4">
                                Configure the sequence of messages to be sent after order delivery
                            </div>

                            <div id="messages-container">
                                <!-- Initial Message Card -->
                                <div class="message-card card mb-6">
                                    <div class="card-header border-0">
                                        <h4 class="card-title fw-bolder d-flex align-items-center">
                                            <span class="bullet bullet-vertical me-3 bg-primary"></span>
                                            Message #1
                                        </h4>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-icon btn-light-danger btn-sm remove-message">
                                                <i class="ki-duotone ki-trash fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row g-4 mb-4">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold required">Days After Delivery</label>
                                                <div class="input-group input-group-solid">
                                                    <span class="input-group-text">
                                                        <i class="ki-duotone ki-calendar-8 fs-2 text-primary"></i>
                                                    </span>
                                                    <input type="number"
                                                        class="form-control form-control-solid delay-days @error('messages.0.delay_days') is-invalid @enderror"
                                                        name="messages[0][delay_days]"
                                                        value="{{ old('messages.0.delay_days', 1) }}" 
                                                        min="0" 
                                                        placeholder="0" 
                                                        required>
                                                </div>
                                                @error('messages.0.delay_days')
                                                    <div class="text-danger fs-7 mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold required">Send Time</label>
                                                <div class="input-group input-group-solid">
                                                    <span class="input-group-text">
                                                        <i class="ki-duotone ki-clock fs-2 text-primary"></i>
                                                    </span>
                                                    <input type="time"
                                                        class="form-control form-control-solid send-time @error('messages.0.send_time') is-invalid @enderror"
                                                        name="messages[0][send_time]"
                                                        value="{{ old('messages.0.send_time', '09:00') }}" 
                                                        required>
                                                </div>
                                                @error('messages.0.send_time')
                                                    <div class="text-danger fs-7 mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold required">Sequence Order</label>
                                                <div class="input-group input-group-solid">
                                                    <span class="input-group-text">
                                                        <i class="ki-duotone ki-sort fs-2 text-primary"></i>
                                                    </span>
                                                    <input type="number"
                                                        class="form-control form-control-solid order @error('messages.0.order') is-invalid @enderror"
                                                        name="messages[0][order]" 
                                                        value="{{ old('messages.0.order', 0) }}"
                                                        required>
                                                </div>
                                                @error('messages.0.order')
                                                    <div class="text-danger fs-7 mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="fv-row">
                                            <label class="form-label fw-bold required">Select Campaign</label>
                                            <div class="input-group input-group-solid">
                                                <span class="input-group-text">
                                                    <i class="ki-duotone ki-paper-plane fs-2 text-primary"></i>
                                                </span>
                                                <select class="form-control form-control-solid campaign-select @error('messages.0.campaign_id') is-invalid @enderror"
                                                    name="messages[0][campaign_id]" required>
                                                    <option value="">-- Select WhatsApp Campaign --</option>
                                                    @foreach ($whatsappCampaigns as $campaign)
                                                        <option value="{{ $campaign->id }}"
                                                            {{ old('messages.0.campaign_id') == $campaign->id ? 'selected' : '' }}>
                                                            {{ $campaign->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('messages.0.campaign_id')
                                                <div class="text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info d-flex align-items-center">
                                <i class="ki-duotone ki-information fs-2hx me-4 text-info"></i>
                                <div class="d-flex flex-column">
                                    <h4 class="alert-heading">AutoRetarget Sequence</h4>
                                    <p class="mb-0">
                                        Messages will be sent automatically based on the sequence order and timing settings.
                                        Each message triggers after the specified days from order delivery.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card card-flush mt-6">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bolder text-dark mb-1">Ready to Create Campaign</h4>
                            <p class="text-muted mb-0">Review your settings before saving the AutoRetarget campaign</p>
                        </div>
                        <div class="d-flex gap-3">
                            <a href="{{ route('autoretarget.index') }}" class="btn btn-light">
                                <i class="ki-duotone ki-cross fs-2 me-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ki-duotone ki-check fs-2 me-2"></i>
                                Save AutoRetarget Campaign
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let messageCount = 1;

            // Initialize stepper
            const stepper = new KTStepper(document.getElementById('autoretarget_stepper'));

            // Add new message
            $('#add-message').click(function() {
                const newIndex = messageCount++;
                const newMessage = `
                    <div class="message-card card mb-6">
                        <div class="card-header border-0">
                            <h4 class="card-title fw-bolder d-flex align-items-center">
                                <span class="bullet bullet-vertical me-3 bg-primary"></span>
                                Message #${newIndex + 1}
                            </h4>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-icon btn-light-danger btn-sm remove-message">
                                    <i class="ki-duotone ki-trash fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-4 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">Days After Delivery</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="ki-duotone ki-calendar-8 fs-2 text-primary"></i>
                                        </span>
                                        <input type="number" 
                                               class="form-control form-control-solid delay-days" 
                                               name="messages[${newIndex}][delay_days]" 
                                               value="1" 
                                               min="0" 
                                               placeholder="0" 
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">Send Time</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="ki-duotone ki-clock fs-2 text-primary"></i>
                                        </span>
                                        <input type="time" 
                                               class="form-control form-control-solid send-time" 
                                               name="messages[${newIndex}][send_time]" 
                                               value="09:00" 
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold required">Sequence Order</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="ki-duotone ki-sort fs-2 text-primary"></i>
                                        </span>
                                        <input type="number" 
                                               class="form-control form-control-solid order" 
                                               name="messages[${newIndex}][order]" 
                                               value="${newIndex}" 
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row">
                                <label class="form-label fw-bold required">Select Campaign</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text">
                                        <i class="ki-duotone ki-paper-plane fs-2 text-primary"></i>
                                    </span>
                                    <select class="form-control form-control-solid campaign-select" 
                                            name="messages[${newIndex}][campaign_id]" 
                                            required>
                                        <option value="">-- Select WhatsApp Campaign --</option>
                                        @foreach ($whatsappCampaigns as $campaign)
                                            <option value="{{ $campaign->id }}">
                                                {{ $campaign->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('#messages-container').append(newMessage);
                stepper.goNext(); // Move to next step when adding message
            });

            // Remove message
            $(document).on('click', '.remove-message', function() {
                if ($('.message-card').length > 1) {
                    $(this).closest('.message-card').remove();
                    reindexMessages();
                    messageCount = $('.message-card').length;
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cannot Remove',
                        text: 'You must have at least one message in the sequence',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Reindex all messages
            function reindexMessages() {
                $('.message-card').each(function(index) {
                    const $card = $(this);
                    $card.find('h4 .bullet').parent().text(`Message #${index + 1}`);
                    $card.find('.delay-days').attr('name', `messages[${index}][delay_days]`);
                    $card.find('.send-time').attr('name', `messages[${index}][send_time]`);
                    $card.find('.order').attr('name', `messages[${index}][order]`).val(index);
                    $card.find('.campaign-select').attr('name', `messages[${index}][campaign_id]`);
                });
            }

            // Form validation and submission
            $('#autoretargetForm').on('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                const errorMessages = [];

                // Reset validation
                $('.is-invalid').removeClass('is-invalid');
                $('.text-danger').remove();

                // Validate campaign name
                if (!$('#name').val().trim()) {
                    isValid = false;
                    errorMessages.push('Please enter a name for the AutoRetarget campaign');
                    $('#name').addClass('is-invalid');
                }

                // Validate all campaign selects
                $('.campaign-select').each(function(index) {
                    if (!$(this).val()) {
                        isValid = false;
                        errorMessages.push(`Please select a campaign for Message #${index + 1}`);
                        $(this).addClass('is-invalid');
                        $(this).closest('.fv-row').append(
                            '<div class="text-danger fs-7 mt-1">Please select a campaign</div>'
                        );
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errorMessages.join('<br>'),
                        confirmButtonText: 'OK'
                    });
                    return false;
                }

                // Show loading indicator
                Swal.fire({
                    title: 'Creating Campaign...',
                    text: 'Please wait while we set up your AutoRetarget campaign',
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
                                title: 'Campaign Created!',
                                text: response.message,
                                confirmButtonText: 'View Campaigns'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = response.redirect || '{{ route('autoretarget.index') }}';
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

                        let errorMessage = 'An error occurred while creating the AutoRetarget campaign';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = 'Please fix the following errors:<br>';
                            
                            for (const field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    errorMessage += `• ${errors[field][0]}<br>`;
                                    $(`[name="${field}"]`).addClass('is-invalid');
                                }
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorMessage
                        });
                    }
                });
            });

            // Real-time validation
            $('input, select').on('change', function() {
                $(this).removeClass('is-invalid');
                $(this).closest('.fv-row').find('.text-danger').remove();
            });
        });
    </script>

    <style>
        .message-card {
            border-left: 4px solid #3699ff;
            transition: all 0.3s ease;
        }

        .message-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .is-invalid {
            border-color: #f64e60 !important;
        }

        .bullet-vertical {
            width: 4px;
            height: 40px;
            border-radius: 2px;
        }

        .required:after {
            content: " *";
            color: #f64e60;
        }

        @media (max-width: 768px) {
            .d-flex.flex-column.flex-sm-row {
                flex-direction: column !important;
            }
            
            .card-toolbar {
                margin-top: 1rem;
            }
        }
    </style>
@endpush