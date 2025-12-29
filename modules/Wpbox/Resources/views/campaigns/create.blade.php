@extends('layouts.app-client')

@section('title')
    @if ($isBot)
        <i class="fas fa-robot me-2"></i>{{ __('Create new template bot') }}
    @elseif ($isAPI)
        <i class="fas fa-code me-2"></i>{{ __('Create new API campaign') }}
    @elseif (isset($_GET['resend']))
        <h1 class="mb-3 mt--3">📢 {{ __('Smart retargeting campaign') }}</h1>
    @elseif ($isReminder)
        <h1 class="mb-3 mt--3"><i class="fas fa-bell me-2"></i>{{ __('Create new reminder') }}</h1>
    @else
        <i class="fas fa-paper-plane me-2"></i>{{ __('Send new campaign') }}
    @endif
    <x-button-links />
@endsection

@section('css')
    <link href="{{ asset('backend/Assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' type='text/css' href="{{ asset('backend/Assets/File_manager/css/file_manager.css') }}">
    <style>
        /* 🔥 Custom tooltip wrapper (NO Bootstrap conflict) */
        .custom-tooltip {
            position: relative;
            display: inline-flex;
            align-items: center;
            margin-left: 6px;
        }

        /* Tooltip bubble */
        .custom-tooltip-text {
            visibility: hidden;
            opacity: 0;

            min-width: 260px;
            max-width: 320px;
            background-color: #000;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px 12px;

            position: absolute;
            z-index: 9999;

            bottom: 130%;
            left: 50%;
            transform: translateX(-50%);

            transition: opacity 0.25s ease;
            white-space: normal;
        }

        /* Arrow */
        .custom-tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 6px;
            border-style: solid;
            border-color: black transparent transparent transparent;
        }

        /* Show on hover */
        .custom-tooltip:hover .custom-tooltip-text {
            visibility: visible;
            opacity: 1;
        }

    </style>
@endsection

@section('content')
    @include('companies.partials.modals-client')

    <form method="POST" action="{{ route('campaigns.store') }}" id="campaignForm" enctype="multipart/form-data">
        @csrf
        <div class="container-xxl container-fluid mt--7" id="campign_managment">
            <div class="row">
                <!--Main info-->
                <div class="col-xl-4">
                    <div class="card card-flush">
                        <div class="card-header">
                            <div class="card-title">
                                @if ($isBot)
                                    <h2><i class="fas fa-robot me-2"></i>{{ __('Template bot') }}</h2>
                                @elseif ($isAPI)
                                    <h2><i class="fas fa-code me-2"></i>{{ __('API campaign') }}</h2>
                                @elseif ($isReminder)
                                    <h3 class="mb-0"><i class="fas fa-bell me-2"></i>{{ __('Reminder') }}</h3>
                                @else
                                    <h2><i class="fas fa-paper-plane me-2"></i>{{ __('Campaign') }}</h2>
                                @endif
                            </div>
                        </div>
                        @include('wpbox::campaigns.new.campaign')
                    </div>
                </div>

                @if (isset($_GET['template_id']))
                    <!--Variables-->
                    <div class="col-xl-4">
                        <div class="card card-flush">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2><i class="fas fa-code-branch me-2"></i>{{ __('Variables') }}</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                @include('wpbox::campaigns.new.variables')
                                @if (isset($selectedTemplateComponents[1]) && $selectedTemplateComponents[1]['type'] == 'CAROUSEL')
                                    @php
                                        $products = App\Models\CatalogProduct::where('company_id', $company_id)->get();
                                    @endphp
                                    <div class="form-group">
                                        <label class="form-control-label" for="product">{{ __('Select Product') }}</label>
                                        <input type="hidden" value="{{ $products[0]->catalog_id }}" name="catalog_id">
                                        <select name="product_retailer_id[]" id="product" class="form-control" multiple>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->retailer_id }}">{{ $product->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
 
                    <!--Preview and send-->
                    <div class="col-xl-4">
                        <div class="card card-flush">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2><i class="fas fa-eye me-2"></i>{{ __('Preview') }}</h2>
                                </div>
                            </div>
                            @include('wpbox::campaigns.new.preview')
                        </div>

                        @if ($isAPI)
                            <div class="card card-flush mt-4">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2><i class="fas fa-save me-2"></i>{{ __('Save API campaign') }}</h2>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    @if (!isset($_GET['contact_id']))
                                        <p><i
                                                class="fas fa-info-circle me-2"></i>{{ __('This message will be sent once API with campaign ID called') }}
                                        </p>
                                    @endif
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-info px-6" type="submit">
                                            <i class="fas fa-save me-2"></i>{{ __('Save API Campaign') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card card-flush mt-4">
                                <div class="card-body">
                                    @if (!isset($_GET['contact_id']))
                                        @if ($isBot || $isReminder)
                                        @else
                                            <div class="mb-5 mb-4">
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="autoretarget_enabled" id="autoretarget_enabled" value="1"
                                                        {{ old('autoretarget_enabled') ? 'checked' : '' }} />
                                                    <span
                                                        class="form-check-label fw-semibold text-muted">{{ __('Enable AutoRetarget') }}</span>
                                                </label>
                                            </div>

                                            <div id="autoretarget_section" style="display: none;">
                                                <div class="mb-5">
                                                    <label for="autoretarget_campaign_id"
                                                        class="form-label">{{ __('AutoRetarget Campaign') }}</label>
                                                    <select class="form-select form-select-solid"
                                                        id="autoretarget_campaign_id" name="autoretarget_campaign_id">
                                                        <option value="">{{ __('Select an AutoRetarget Campaign') }}
                                                        </option>
                                                        @foreach ($autoretargetCampaigns as $autoretargetCampaign)
                                                            <option value="{{ $autoretargetCampaign->id }}"
                                                                {{ old('autoretarget_campaign_id') == $autoretargetCampaign->id ? 'selected' : '' }}>
                                                                {{ $autoretargetCampaign->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="row align-items-center h-100">
                                        <div class="col-6 d-flex flex-column justify-content-center">
                                            @if (!isset($_GET['contact_id']))
                                                @if ($isBot)
                                                    <h2 class="my-2"><i
                                                            class="fas fa-robot me-2"></i>{{ __('Save bot') }}</h2>
                                                @elseif ($isReminder)
                                                    <h3 class="mb-0"><i
                                                            class="fas fa-bell me-2"></i>{{ __('Save reminder campaign') }}
                                                    </h3>
                                                @else
                                                    <h2 class="my-2"><i
                                                            class="fas fa-paper-plane me-2"></i>{{ __('Send campaign') }}
                                                    </h2>
                                                @endif
                                                @if ($isBot)
                                                    <p><i
                                                            class="fas fa-info-circle me-2"></i>{{ __('This message will be sent to the contact once the trigger rule is met in the message sent by the contact.') }}
                                                    </p>
                                                @elseif ($isAPI)
                                                    <p><i
                                                            class="fas fa-info-circle me-2"></i>{{ __('This message will be sent once API with campaign ID called') }}
                                                    </p>
                                                @elseif ($isReminder)
                                                    <p><i
                                                            class="fas fa-info-circle me-2"></i>{{ __('This message will be sent based on the reminder settings.') }}
                                                    </p>
                                                @else
                                                    @if ($selectedContacts != '')
                                                        @if ($selectedContacts == 1)
                                                            <p><i class="fas fa-users me-2"></i>{{ __('Send to') }}:
                                                                {{ $selectedContacts }} {{ __('contact') }}</p>
                                                        @else
                                                            <p><i class="fas fa-users me-2"></i>{{ __('Send to') }}:
                                                                {{ $selectedContacts }} {{ __('contacts') }}</p>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </div>

                                        <div class="col-6 d-flex justify-content-end align-items-center h-100">
                                            @if ($isBot)
                                                <button class="btn btn-info px-6" type="submit">
                                                    <i class="fas fa-save me-2"></i>{{ __('Save bot') }}
                                                </button>
                                            @elseif ($isAPI)
                                                <button class="btn btn-success mt-4" type="submit">
                                                    <i class="fas fa-save me-2"></i>{{ __('Save API Campaign') }}
                                                </button>
                                            @elseif ($isReminder)
                                                <button class="btn btn-success mt-4" type="submit">
                                                    <i class="fas fa-save me-2"></i>{{ __('Save Reminder Campaign') }}
                                                </button>
                                            @else
                                                @if (!isset($_GET['contact_id']) && $selectedContacts > 0)
                                                    <button class="btn btn-info px-6" type="submit">
                                                        <i class="fas fa-paper-plane me-2"></i>{{ __('Send campaign') }}
                                                    </button>
                                                @elseif (isset($_GET['contact_id']))
                                                    <button class="btn btn-info px-6" type="submit">
                                                        <i class="fas fa-paper-plane me-2"></i>{{ __('Send campaign') }}
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </form>
@endsection

@section('topjs')
    <script>
        let campaignData = {
            bodyText: @json($component->text ?? '') // Ensure safe JSON conversion
        };
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("campaignForm").addEventListener("submit", function(event) {

                // Check if HEADER with IMAGE exists and imagePreview is empty
                // IMAGE check
                let hasImageHeader = @json(collect($selectedTemplateComponents)->contains(fn($c) => $c['type'] === 'HEADER' && $c['format'] === 'IMAGE'));
                if (hasImageHeader && (!vuec.imagePreview || !vuec.imagePreview.trim())) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Image Required",
                        text: "Please upload an image before submitting.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                // VIDEO check
                let hasVideoHeader = @json(collect($selectedTemplateComponents)->contains(fn($c) => $c['type'] === 'HEADER' && $c['format'] === 'VIDEO'));
                if (hasVideoHeader && (!vuec.videoPreview || !vuec.videoPreview.trim())) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Video Required",
                        text: "Please upload a video before submitting.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                // PDF/DOCUMENT check
                // let hasPdfHeader = @json(collect($selectedTemplateComponents)->contains(fn($c) => $c['type'] === 'HEADER' && $c['format'] === 'DOCUMENT'));
                // if (hasPdfHeader && (!vuec.pdfPreview || !vuec.pdfPreview.trim())) {
                //     event.preventDefault();
                //     Swal.fire({
                //         title: "PDF Required",
                //         text: "Please upload a PDF before submitting.",
                //         icon: "warning",
                //         confirmButtonText: "OK"
                //     });
                //     return;
                // }


                // Prevent default to show loading
                event.preventDefault();

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we process your campaign.",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                let formData = new FormData(this);

                @if ($campaignResendId && $rtype)
                    formData.append('resend', "{{ $campaignResendId }}");
                    formData.append('rtype', "{{ $rtype }}");
                @endif

                fetch(this.action, {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": document.querySelector("input[name='_token']").value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();

                        if (data.success) {
                            Swal.fire({
                                title: "Success!",
                                text: data.message || "Campaign submitted successfully!",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                window.location.href = data.redirect ||
                                    "{{ route('campaigns.index') }}";
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: data.message || "An error occurred while submitting.",
                                icon: "error",
                                confirmButtonText: "Try Again"
                            });
                        }
                    })
                    .catch(error => {
                        Swal.close();
                        Swal.fire({
                            title: "Error!",
                            text: "Something went wrong! Please try again.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        console.error("Error:", error);
                    });
            });
        });
    </script>


    <script>
        imagetopreview = "campaigns";
        var vuec = null;
        var component = @json($selectedTemplateComponents);

        function submitJustCampign() {
            event.preventDefault();
            const formData = new FormData(document.getElementById("campaignForm"));
            let urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('resend')) {
                formData.set('resend', urlParams.get('resend'));
            }

            if (urlParams.has('templates_type')) {
                formData.set('templates_type', urlParams.get('templates_type'));
            }

            if (urlParams.has('rtype')) {
                formData.set('rtype', urlParams.get('rtype'));
            }
            const url = window.location.pathname + "?" + new URLSearchParams(formData).toString();
            window.location.href = url;
        }

        window.onload = function() {
            vuec = new Vue({
                el: '#campign_managment',
                data: {
                    body_1: "",
                    body_2: "",
                    body_3: "",
                    body_4: "",
                    body_5: "",
                    body_6: "",
                    body_7: "",
                    body_8: "",
                    body_9: "",
                    header_1: "",
                    imagePreview: null,
                    videoPreview: null,
                    pdfPreview: null,
                    bodyText: campaignData.bodyText
                },
                computed: {
                    formattedBodyText() {
                        let bodyText = this.bodyText || "";

                        // Replace placeholders with current values
                        for (let i = 1; i <= 9; i++) {
                            let placeholder = new RegExp("\\{\\{\\s*body_" + i + "\\s*\\}\\}", "g");
                            if (this[`body_${i}`]) {
                                bodyText = bodyText.replace(placeholder, this[`body_${i}`]);
                            }
                        }

                        // Apply precise formatting with improved regex
                        return bodyText
                            .replace(/\*([^*]+?)\*/g, '<strong>$1</strong>') // *bold*
                            .replace(/_([^_]+?)_/g, '<em>$1</em>'); // _italic_
                    }
                },
                methods: {
                    setPreviewValue() {
                        for (let i = 1; i <= 9; i++) {
                            this[`body_${i}`] = this.$refs[`paramvalues[body][${i}]`] ? this.$refs[
                                `paramvalues[body][${i}]`].value : "";
                        }
                        this.header_1 = this.$refs['paramvalues[header][1]'] ? this.$refs[
                            'paramvalues[header][1]'].value : "";
                    },
                    handleImageUpload(media_url) {
                        if (media_url) {
                            this.imagePreview = media_url;
                        }
                    },
                    handleVideoUpload(media_url) {
                        if (media_url) {
                            this.videoPreview = media_url;
                        }
                    },
                    handlePdfUpload(media_url) {
                        if (media_url) {
                            this.pdfPreview = media_url;
                        }
                    },
                }
            });
            vuec.setPreviewValue();
        }
    </script>
    <script>
        (function () {

            function initCustomTooltips() {
                document.querySelectorAll('[data-tooltip]').forEach(el => {

                    // Prevent duplicate initialization
                    if (el.getAttribute('data-tooltip-init') === '1') return;

                    const text = el.getAttribute('data-tooltip');
                    const placement = el.getAttribute('data-placement') || 'top';

                    if (!text) return;

                    // Set required bootstrap attributes dynamically
                    el.setAttribute('data-bs-toggle', 'tooltip');
                    el.setAttribute('data-bs-placement', placement);
                    el.setAttribute('data-bs-original-title', text);

                    new bootstrap.Tooltip(el);

                    el.setAttribute('data-tooltip-init', '1');
                });
            }

            // Initial load
            document.addEventListener('DOMContentLoaded', initCustomTooltips);

            // Livewire support
            document.addEventListener('livewire:load', function () {
                Livewire.hook('message.processed', initCustomTooltips);
            });

            // Vue support (optional)
            window.initCustomTooltips = initCustomTooltips;

        })();
    </script>

@endsection
