@extends('layouts.app-client')

@section('title')
    {{ __('Whatsapp Web Widget creator') }}
    <x-button-links />
@endsection

@section('content')
    <!--begin::Container-->
    <!--begin::Row-->
    <div class="container-xxl">
        <div class="row g-5">
            <div class="col-12">
                @include('partials.flash-client')
            </div>

            <!-- Left Column - Form -->
            <div class="col-md-6">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <span class="svg-icon svg-icon-1 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M6 8.725C6 8.15 6.4 7.725 7 7.725H14L18 11.725V12.275L14 16.275H7C6.4 16.275 6 15.85 6 15.275V8.725Z"
                                        fill="currentColor" />
                                    <path opacity="0.3"
                                        d="M22 8.725C22 8.15 21.6 7.725 21 7.725H18L14 11.725V12.275L18 16.275H21C21.6 16.275 22 15.85 22 15.275V8.725Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <h2>{{ __('Whatsapp Web Widget creator') }}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <form action="{{ route('embedwhatsapp.store') }}" method="POST" enctype="multipart/form-data"
                            id="widgetForm">
                            @csrf

                            <!-- Logo Input -->
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Logo') }}</label>
                                <div class="col-lg-8">
                                    <div class="image-input image-input-outline" data-kt-image-input="true"
                                        style="background-image: url('{{ asset('assets/media/svg/avatars/blank.svg') }}')">
                                        <div class="image-input-wrapper w-125px h-125px"
                                            style="background-image: url('{{ $widget['logo'] ?? asset('assets/media/svg/avatars/blank.svg') }}')">
                                        </div>
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Change logo">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="logo_remove" />
                                        </label>
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            title="Cancel logo">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            title="Remove logo">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="form-text">{{ __('Allowed file types: png, jpg, jpeg. Max size 2MB.') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="row mb-6">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('WhatsApp Phone
                                                                                                    Number') }}</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-telephone-fill"></i>
                                        </span>
                                        <input type="tel" class="form-control" name="phone_number" id="phone_number"
                                            value="{{ $widget['phone_number'] ?? preg_replace('/[^A-Za-z0-9]/', '', auth()->user()->company->getConfig('display_phone_number', '')) }}"
                                            placeholder="e.g. +1234567890" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Header Text -->
                            <div class="row mb-6">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Header Text') }}</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="header_text" id="header_text"
                                        value="{{ $widget['header_text'] ?? '' }}" placeholder="e.g. Chat with us"
                                        required>
                                </div>
                            </div>

                            <!-- Header Subtext -->
                            <div class="row mb-6">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Header Subtext') }}</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="header_subtext" id="header_subtext"
                                        value="{{ $widget['header_subtext'] ?? '' }}" placeholder="e.g. We're here to help"
                                        required>
                                </div>
                            </div>

                            <!-- Widget Text -->
                            <div class="row mb-6">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Widget Text') }}</label>
                                <div class="col-lg-8">
                                    <textarea class="form-control" name="widget_text" id="widget_text" placeholder="Enter your widget message here..."
                                        required>{{ $widget['widget_text'] ?? '' }}</textarea>
                                </div>
                            </div>

                            <!-- Button Text -->
                            <div class="row mb-6">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Button Text') }}</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="button_text" id="button_text"
                                        value="{{ $widget['button_text'] ?? '' }}" placeholder="e.g. Start Chat" required>
                                </div>
                            </div>

                            <!-- Widget Type -->
                            <div class="row mb-6">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Widget Type') }}</label>
                                <div class="col-lg-8">
                                    <select class="form-select" name="widget_type" id="widget_type" required>
                                        <option value="1"
                                            {{ ($widget['widget_type'] ?? '1') == '1' ? 'selected' : '' }}>
                                            {{ __('With start chat
                                                                                                                            button') }}
                                        </option>
                                        <option value="2"
                                            {{ ($widget['widget_type'] ?? '1') == '2' ? 'selected' : '' }}>
                                            {{ __('With input field') }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Input Field Placeholder (Conditional) -->
                            <div id="inputFieldContainer"
                                class="row mb-6 {{ ($widget['widget_type'] ?? '1') == '2' ? '' : 'd-none' }}">
                                <label
                                    class="col-lg-4 col-form-label fw-semibold fs-6">{{ __('Input Field Placeholder') }}</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="input_field_placeholder"
                                        id="input_field_placeholder"
                                        value="{{ $widget['input_field_placeholder'] ?? '' }}"
                                        placeholder="e.g. Type your message...">
                                </div>
                            </div>

                            <!-- Button Color -->
                            <div class="row mb-6">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Button Color') }}</label>
                                <div class="col-lg-8">
                                    <div class="d-flex align-items-center">
                                        <input type="color" class="form-control form-control-color w-50px h-50px"
                                            id="button_color" name="button_color"
                                            value="{{ $widget['button_color'] ?? '#14c656' }}">
                                        <input type="text" class="form-control form-control-solid ms-3 w-100px"
                                            id="button_color_hex" value="{{ $widget['button_color'] ?? '#14c656' }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Header Color -->
                            <div class="row mb-6">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Header Color') }}</label>
                                <div class="col-lg-8">
                                    <div class="d-flex align-items-center">
                                        <input type="color" class="form-control form-control-color w-50px h-50px"
                                            id="header_color" name="header_color"
                                            value="{{ $widget['header_color'] ?? '#006654' }}">
                                        <input type="text" class="form-control form-control-solid ms-3 w-100px"
                                            id="header_color_hex" value="{{ $widget['header_color'] ?? '#006654' }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                                fill="currentColor" />
                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    {{ __('Save Changes') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>

            <!-- Right Column - Widget Code and Preview -->
            <div class="col-md-6">
                @if (isset($widget['url']))
                    <!-- Widget Code Card -->
                    <div class="card mb-5">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Embedded Widget Code') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <textarea class="form-control" id="widgetCode" rows="3" readonly>
<script src="{{ $widget['url'] }}"></script>
<div id="embed-dotflo-whatsapp-chat"></div>
                            </textarea>
                                <button class="btn btn-primary mt-3" onclick="copyWidgetCode()">
                                    <i class="bi bi-clipboard me-2"></i>Copy Code
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Live Preview') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-2">
                            <button id="refreshPreviewBtn" class="btn btn-sm btn-primary me-2"
                                onclick="refreshPreview()">
                                <i class="fas fa-sync-alt me-1"></i>Refresh
                            </button>
                        </div>
                        <iframe id="widgetPreviewFrame" src="about:blank"
                            style="width: 100%; height: 450px; border: 0px solid #ddd; border-radius: 8px;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
        <!--end::Container-->

        @include('layouts.footers.auth')
        @if (isset($widget['url']))
            <script src="{{ $widget['url'] }}"></script>
        @endif
        {{-- <div id="embed-dotflo-whatsapp-chat"></div> --}}
    </div>
@endsection


@section('topjs')
    <script>
        // Initialize DOM elements
        const widgetForm = document.getElementById('widgetForm');
        const widgetTypeSelect = document.getElementById('widget_type');
        const inputFieldContainer = document.getElementById('inputFieldContainer');
        const loadingIndicator = document.getElementById('widgetLoading');

        // Copy widget code to clipboard
        function copyWidgetCode() {
            const widgetCode = document.getElementById('widgetCode');
            widgetCode.select();
            document.execCommand('copy');

            // Show SweetAlert toast
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Widget code copied to clipboard!',
                showConfirmButton: false,
                timer: 3000
            });
        }

        @if (isset($widget['url']))
            function loadPreview() {
                const previewFrame = document.getElementById('widgetPreviewFrame');

                const previewHtml = `
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body { 
                            margin: 0; 
                            padding: 0; 
                            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                        }
                        #embed-dotflo-whatsapp-chat {
                            position: relative;
                            width: 100%;
                            height: 100%;
                        }
                    </style>
                </head>
                <body>
                    <div id="embed-dotflo-whatsapp-chat"></div>
                    <script src="{{ $widget['url'] }}"><\/script>
                </body>
                </html>
            `;

                previewFrame.srcdoc = previewHtml;
            }
        @endif
        // Load and initialize the widget
        function loadWhatsappWidget() {
            @if (isset($widget['url']))
                // Show loading indicator
                if (loadingIndicator) loadingIndicator.classList.remove('d-none');

                // Check if script is already loaded
                if (document.querySelector(`script[src="{{ $widget['url'] }}"]`)) {
                    initializeWidget();
                    return;
                }

                const script = document.createElement('script');
                script.src = "{{ $widget['url'] }}";

                script.onload = function() {
                    initializeWidget();
                };

                script.onerror = function() {
                    console.error('Failed to load WhatsApp widget script');
                    if (loadingIndicator) loadingIndicator.classList.add('d-none');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load widget script'
                    });
                };

                document.head.appendChild(script);
            @endif
        }

        // Initialize the widget after script loads
        function initializeWidget() {
            try {
                const container = document.getElementById('liveWidgetContainer');
                if (!container) return;

                // Create the widget container if it doesn't exist
                let widgetDiv = document.getElementById('embed-dotflo-whatsapp-chat');
                if (!widgetDiv) {
                    widgetDiv = document.createElement('div');
                    widgetDiv.id = 'embed-dotflo-whatsapp-chat';
                    container.appendChild(widgetDiv);
                }

                // Initialize widget if function exists
                if (typeof initWhatsappWidget === 'function') {
                    window.whatsappWidget = initWhatsappWidget({
                        target: 'liveWidgetContainer',
                        phone: document.getElementById('phone_number').value,
                        headerText: document.getElementById('header_text').value,
                        headerSubtext: document.getElementById('header_subtext').value,
                        buttonText: document.getElementById('button_text').value,
                        buttonColor: document.getElementById('button_color').value,
                        // Add other parameters as needed
                    });
                }

                // Hide loading indicator
                if (loadingIndicator) loadingIndicator.classList.add('d-none');

                // Ensure widget stays visible
                setTimeout(() => {
                    const widget = document.getElementById('embed-dotflo-whatsapp-chat');
                    if (widget) {
                        widget.style.display = 'block';
                        widget.style.visibility = 'visible';
                        widget.style.opacity = '1';
                    }
                }, 500);

            } catch (error) {
                console.error('Error initializing widget:', error);
                if (loadingIndicator) loadingIndicator.classList.add('d-none');
            }
        }

        function refreshPreview() {
            toastr.info('Refreshing preview...');
            loadPreview();
        }

        // Update widget when form changes
        function updateWidget() {
            if (window.whatsappWidget && typeof window.whatsappWidget.update === 'function') {
                window.whatsappWidget.update({
                    phone: document.getElementById('phone_number').value,
                    headerText: document.getElementById('header_text').value,
                    headerSubtext: document.getElementById('header_subtext').value,
                    buttonText: document.getElementById('button_text').value,
                    buttonColor: document.getElementById('button_color').value,
                    // Add other parameters as needed
                });
            }

            // Also update the default preview elements
            document.getElementById('previewHeader').textContent =
                document.getElementById('header_text').value || 'Chat with Us';
            document.getElementById('previewSubheader').textContent =
                document.getElementById('header_subtext').value || "We're here to help";
            document.getElementById('previewChatBtn').textContent =
                document.getElementById('button_text').value || 'Start Chat';
            document.getElementById('previewChatBtn').style.backgroundColor =
                document.getElementById('button_color').value || '#14c656';

            // Update logo preview
            const logoPreview = document.querySelector('.image-input-wrapper');
            if (logoPreview) {
                const previewLogo = document.getElementById('previewLogo');
                const logoUrl = logoPreview.style.backgroundImage;
                if (logoUrl && logoUrl !== 'url("{{ asset('assets/media/svg/avatars/blank.svg') }}")') {
                    previewLogo.src = logoUrl.replace('url("', '').replace('")', '');
                }
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Load widget with slight delay
            setTimeout(loadWhatsappWidget, 500);
            loadPreview();
            // Update widget when form changes
            if (widgetForm) {
                widgetForm.addEventListener('input', function() {
                    updateWidget();
                });
            }

            // Toggle widget type fields
            if (widgetTypeSelect) {
                widgetTypeSelect.addEventListener('change', function() {
                    if (this.value === '2') {
                        inputFieldContainer.classList.remove('d-none');
                        document.getElementById('input_field_placeholder').required = true;
                    } else {
                        inputFieldContainer.classList.add('d-none');
                        document.getElementById('input_field_placeholder').required = false;
                    }
                });
            }
        });
    </script>
@endsection

@section('css')
    <style>
        .min-h-100px {
            min-height: 100px;
        }

        #widgetPreviewContainer {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        #refreshPreviewBtn {
            transition: all 0.3s ease;
        }

        #refreshPreviewBtn:hover {
            transform: translateY(-2px);
        }

        /* Widget container styling */
        #liveWidgetContainer {
            width: 100%;
            min-height: 400px;
        }

        /* Ensure widget elements are visible */
        #embed-dotflo-whatsapp-chat {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Loading indicator */
        #widgetLoading {
            z-index: 10;
        }

        /* Form control styling */
        .form-control-color {
            height: 50px;
            width: 50px;
            padding: 2px;
            cursor: pointer;
            border-radius: 0.475rem;
        }

        /* Preview styling */
        #defaultPreview {
            transition: all 0.3s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .col-md-6 {
                margin-bottom: 20px;
            }
        }
    </style>
@endsection
