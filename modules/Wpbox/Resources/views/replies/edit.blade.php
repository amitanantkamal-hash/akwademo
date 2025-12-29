@extends('layouts.app-client', ['title' => __('Send new campaign')])
@section('css')
    <link href="{{ asset('backend/Assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' type='text/css' href="{{ asset('backend/Assets/File_manager/css/file_manager.css') }}">
    <link rel='stylesheet' type='text/css' href="{{ asset('backend/Assets//plugins/tagsinput/bootstrap-tagsinput.css') }}">
    <style>
        :root {
            --kt-primary: #3699FF;
            --kt-primary-light: #E1F0FF;
            --kt-secondary: #E4E6EF;
            --kt-success: #1BC5BD;
            --kt-info: #8950FC;
            --kt-warning: #FFA800;
            --kt-danger: #F64E60;
            --kt-light: #F3F6F9;
            --kt-dark: #181C32;
            --kt-gray: #7E8299;
            --kt-border: #E4E6EF;
            --kt-card-shadow: 0px 0px 20px rgba(0, 0, 0, 0.05);
            --kt-transition: all 0.3s ease;
        }

        .card {
            border-radius: 0.75rem;
            box-shadow: var(--kt-card-shadow);
            transition: var(--kt-transition);
            border: none;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            box-shadow: 0px 5px 30px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid var(--kt-border);
            padding: 1.25rem 1.5rem;
            border-radius: 0.75rem 0.75rem 0 0 !important;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--kt-dark);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--kt-dark);
        }

        .form-control,
        .form-select {
            border-radius: 0.5rem;
            border: 1px solid var(--kt-border);
            padding: 0.75rem 1rem;
            transition: var(--kt-transition);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--kt-primary);
            box-shadow: 0 0 0 3px rgba(54, 153, 255, 0.1);
        }

        .btn {
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: var(--kt-transition);
        }

        .btn-success {
            background-color: var(--kt-success);
            border-color: var(--kt-success);
        }

        .btn-success:hover {
            background-color: #0bb7af;
            transform: translateY(-2px);
        }

        .preview-container {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid var(--kt-border);
            padding: 1.5rem;
            margin-top: 1rem;
            min-height: 380px;
        }

        .preview-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--kt-border);
        }

        .preview-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--kt-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .preview-message {
            background-color: var(--kt-light);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
            position: relative;
        }

        .preview-message::after {
            content: "";
            position: absolute;
            left: -8px;
            top: 15px;
            width: 0;
            height: 0;
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
            border-right: 8px solid var(--kt-light);
        }

        .preview-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .preview-content {
            margin-bottom: 0.75rem;
        }

        .preview-footer {
            font-size: 0.9rem;
            color: var(--kt-gray);
            padding-top: 0.75rem;
            border-top: 1px dashed var(--kt-border);
        }

        .form-section {
            padding: 1.25rem;
            border-radius: 0.75rem;
            background-color: #fafafa;
            margin-bottom: 1.5rem;
            border: 1px solid var(--kt-border);
        }

        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .icon-box {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            background-color: rgba(54, 153, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--kt-primary);
            font-size: 1.25rem;
        }

        .input-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.5rem;
            border: 1px solid var(--kt-border);
            border-radius: 0.5rem;
            min-height: 50px;
        }

        .tag {
            background-color: var(--bs-primary);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 10px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tag-remove {
            cursor: pointer;
        }

        .tag-input {
            flex: 1;
            border: none;
            outline: none;
            min-width: 100px;
        }

        .file-upload {
            border: 2px dashed var(--kt-border);
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: var(--kt-transition);
            background-color: #fafafa;
        }

        .file-upload:hover {
            border-color: var(--kt-primary);
            background-color: rgba(54, 153, 255, 0.05);
        }

        .file-upload i {
            font-size: 2rem;
            color: var(--kt-primary);
            margin-bottom: 0.75rem;
        }

        .file-upload-text {
            font-weight: 500;
            color: var(--kt-dark);
        }

        .file-upload-subtext {
            font-size: 0.9rem;
            color: var(--kt-gray);
            margin-top: 0.25rem;
        }

        .form-info {
            font-size: 0.85rem;
            color: var(--kt-gray);
            margin-top: 0.5rem;
            display: block;
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 0.9rem;
            background-color: var(--kt-success);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--kt-transition);
            text-align: center;
            margin-top: 1.5rem;
        }

        .btn-submit:hover {
            background-color: #0bb7af;
            transform: translateY(-2px);
        }

        .btn-submit i {
            margin-right: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <!-- Interactive Elements Section -->
    <div class="main-wrapper flex-grow-1 n-scroll">
        <div class="container">
            @php
                $class = 'col-md-12';
                $headerclass = 'd-none';
                $imgclass = 'd-none';
                $videoclass = 'd-none';
                $pdfclass = 'd-none';
                $caption_msg =
                    'max 1024 characters allowed, You can also use {{ name }} {{ phone }} or any other custom field name.';

                $name = '';
                $header_typeDataSelected = 1;
                $header_text = '';
                $caption_text = '';
                $typeDataSelected = 2;
                $trigger = '';
                $footer_text = '';

                $currentMedia = null;
            @endphp

            @isset($setup['item'])
                @php
                    $item = $setup['item'];

                    if ($item->header_type == 1) {
                        $headerclass = '';
                    } elseif ($item->header_type == 2) {
                        $imgclass = '';
                    } elseif ($item->header_type == 3) {
                        $videoclass = '';
                    } elseif ($item->header_type == 4) {
                        $pdfclass = '';
                    }
                    $currentMedia = $item->media ?? null;
                    $name = $item->name ?? '';
                    $header_typeDataSelected = $item->header_type ?? 1;
                    $header_text = $item->header ?? '';
                    $caption_text = $item->text ?? '';
                    $typeDataSelected = $item->type ?? 2;
                    $trigger = $item->trigger;
                    $footer_text = $item->footer ?? '';
                @endphp
            @endisset

            @php
                $mediaPath = $setup['mediaPath'] ?? null;
                $buttonInfo = $setup['buttonInfo'] ?? null;
                // Initialize media display
                $showMedia = false;
                $mediaType = 'image';
                if ($item->header_type == 2) {
                    $showMedia = true;
                    $mediaType = 'image';
                } elseif ($item->header_type == 3) {
                    $showMedia = true;
                    $mediaType = 'video';
                } elseif ($item->header_type == 4) {
                    $showMedia = true;
                    $mediaType = 'pdf';
                }
            @endphp

            <form action="{{ $setup['action'] }}" method="POST" id="repliesform" enctype="multipart/form-data">
                @csrf
                @isset($setup['isupdate'])
                    @method('PUT')
                @endisset

                <div class="row">
                    <!-- Left Column - Form Inputs -->
                    <div class="col-lg-8">
                        <div class="card animate-fade-in">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ki-duotone ki-abstract-42 fs-2" style="color: #7af586;">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    {{ __($setup['title']) }}
                                </h3>
                            </div>

                            <div class="card-body">
                                <!-- Name Field -->
                                <div class="mb-5">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter name" value="{{ $name }}">
                                </div>

                                @if ($setup['isBot'] == true)
                                    <!-- Header Type Section -->
                                    <div class="form-section">
                                        <h4 class="form-section-title">
                                            <div class="icon-box">
                                                <i class="fas fa-heading"></i>
                                            </div>
                                            {{ __('Header Content') }}
                                        </h4>

                                        <!-- File Uploads -->
                                        <div class="form-group">
                                            <label class="fs-6 fw-semibold form-label mt-3"
                                                for="header"><strong>{{ __('Header type') }}</strong></label>
                                            <span class="badge badge-light-info">{{ __('Optional') }}</span><br />
                                            <small>{{ __('Add a title or choose which type of media you will use for this header.') }}</small>
                                            <select name="header" id="header" class="form-control" v-model="headerType">
                                                <option value="none">{{ __('None') }}</option>
                                                <option value="TEXT">{{ __('Text') }}</option>
                                                <option value="IMG">{{ __('Image') }}</option>
                                                <option value="VIDEO">{{ __('Video') }}</option>
                                                <option value="PDF">{{ __('PDF') }}</option>
                                            </select>
                                        </div>

                                        <!-- Templpate header text -->
                                        <div v-if="headerType=='text'" class="form-group form-group-header_text d-none">
                                            <label class="fs-6 fw-semibold form-label mt-3"
                                                for="header_text"><strong>{{ __('Header text') }}</strong></label>
                                            <div class="input-group">
                                                <input v-model="headerText" @input="validateHeaderText" type="text"
                                                    name="header_text" id="header_text" maxlength="60" class="form-control"
                                                    placeholder="{{ __('Header text') }}" value="{{ $header_text }}">
                                            </div>

                                            <div class="mt-2">
                                                <small>{{ __('You can use variables to personalize the header text. Characters limit 60.') }}</small>
                                            </div>

                                        </div>

                                        <!-- Template header image -->
                                        <div v-if="headerType === 'image'"
                                            class="form-group upload-container mt-4 fm-selected-mini-imageupload d-none">
                                            @include('wpbox::file_manager.mini', [
                                                'id' => 'header_image',
                                                'changevue' => 'handleImageUpload',
                                                'type' => 'image',
                                                'select_multi' => 0,
                                                'name' => __('Select image'),
                                                'required' => true,
                                                'accept' => '.jpg, .jpeg, .png',
                                            ])
                                        </div>

                                        <!-- Template header video -->
                                        <div v-if="headerType === 'video'"
                                            class="form-group mt-4 upload-container fm-selected-mini-videoupload d-none">
                                            @include('wpbox::file_manager.mini', [
                                                'id' => 'header_video',
                                                'changevue' => 'handleVideoUpload',
                                                'type' => 'video',
                                                'select_multi' => 0,
                                                'name' => __('Select video'),
                                                'required' => true,
                                                'accept' => '.mp4',
                                            ])
                                        </div>

                                        <!-- Template header pdf -->
                                        <div v-if="headerType=='pdf'"
                                            class="form-group mt-3 upload-container fm-selected-mini-pdf d-none">
                                            @include('wpbox::file_manager.mini', [
                                                'id' => 'header_pdf',
                                                'name' => __('Header PDF'),
                                                'type' => 'pdf',
                                                'required' => true,
                                                'accept' => 'application/pdf',
                                                'select_multi' => 0,
                                            ])
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Pre-select the correct tab
                                            @if (isset($item->action_type))
                                                $('input[name="action_type_radio"][value="{{ $item->action_type }}"]').prop('checked', true);
                                                $('.nav-link').removeClass('active');
                                                $('.tab-pane').removeClass('show active');

                                                // Activate selected tab
                                                @if ($item->action_type == 2)
                                                    $('#type_button').closest('li').find('.nav-link').addClass('active');
                                                    $('#wa_button').addClass('show active');
                                                @elseif ($item->action_type == 3)
                                                    $('#type_template').closest('li').find('.nav-link').addClass('active');
                                                    $('#wa_list_message').addClass('show active');
                                                @endif
                                            @endif

                                            // Pre-select button group
                                            @if (isset($buttonInfo))
                                                @if ($item->action_type == 2)
                                                    $('#btn_template_group_id').val("{{ $buttonInfo->id }}");
                                                @elseif ($item->action_type == 3)
                                                    $('#listbtn_template_group_id').val("{{ $buttonInfo->id }}");
                                                @endif
                                            @endif
                                        });
                                    </script>
                                @endif

                                <!-- Caption Text -->
                                <div class="mb-5">
                                    <label for="caption_text" class="form-label">Caption</label>
                                    <textarea class="form-control" id="caption_text" name="caption_text" rows="4" placeholder="Enter message here">{{ $caption_text }}</textarea>
                                    <span class="form-info">{{ $caption_msg }}</span>
                                </div>

                                @if ($setup['isBot'] == true)
                                    <!-- Footer Text -->
                                    <div class="mb-5">
                                        <label for="footer_text" class="form-label">Footer</label>
                                        <input type="text" class="form-control" id="footer_text" name="footer_text"
                                            placeholder="Enter footer" value="{{ $footer_text }}" maxlength="60">
                                        <span
                                            class="form-info">{{ __('Optional: max 60 characters allowed. Add a short line to
                                                                                                                                                                                                                                                                                                                                                                                                            the bottom of your message.') }}</span>
                                    </div>
                                @endif
                                <!-- Reply Type -->
                                <div class="mb-5">
                                    <label for="type" class="form-label">Reply Type</label>
                                    <select class="form-select" id="type" name="type" required>
                                        @if ($setup['isBot'])
                                            <option value="2" {{ $typeDataSelected == 2 ? 'selected' : '' }}>Reply
                                                bot: On exact match</option>
                                            <option value="3" {{ $typeDataSelected == 3 ? 'selected' : '' }}>Reply
                                                bot: When message contains</option>
                                            <option value="4" {{ $typeDataSelected == 4 ? 'selected' : '' }}>Welcome
                                                reply - when client sends the first message</option>
                                        @else
                                            <option value="1" selected>Just a quick reply</option>
                                        @endif
                                    </select>
                                </div>

                                @if ($setup['isBot'] == true)
                                    <!-- Trigger Keywords -->
                                    <div class="mb-5">
                                        <label for="trigger" class="form-label">Trigger Keyword (separate by
                                            comma)</label>
                                        <div class="input-tags">
                                            <input type="text" class="tag-input" placeholder="Add keywords..."
                                                value="{{ $trigger }}">
                                        </div>
                                    </div>
                                @endif
                                @php
                                    $botType = false;
                                    $currentParams = request()->query();
                                    if (request()->query('bot') != 'catalog') {
                                        $botType = true;
                                    }
                                @endphp

                                @if ($setup['isBot'] == true && $botType == true)
                                    <!-- Interactive Elements -->
                                    <div class="form-section">
                                        <h4 class="form-section-title">
                                            <div class="icon-box">
                                                <i class="fas fa-puzzle-piece"></i>
                                            </div>
                                            {{ __('Interactive Elements') }}
                                        </h4>

                                        {{-- Brij Mohan Negi Update --}}
                                        @php
                                            $interactive_action_type = '';
                                            $interactive_button_id = '';
                                            $interactive_list_id = '';
                                            $interactive_id = 1;

                                        @endphp
                                        @if (isset($fields[6]['value']) && !empty($fields[6]['value']))
                                            @php
                                                $interactive = json_decode($fields[6]['value']);
                                                $interactive_action_type = $interactive->action_type;

                                                if ($interactive_action_type == 3) {
                                                    $interactive_list_id = $interactive->id;
                                                    $interactive_id = 3;
                                                } elseif ($interactive_action_type == 2) {
                                                    $interactive_button_id = $interactive->id;
                                                    $interactive_id = 2;
                                                }

                                            @endphp
                                        @endif
                                        <div class="mt-2">
                                            <label class="form-label mb-2"
                                                for="btn_msg_4">{{ __('Bot reply with') }}</label>
                                            <ul class="nav nav-pills mb-3 bg-white rounded fs-14 nx-scroll overflow-x-auto d-flex text-over b-r-6 border"
                                                id="pills-tab">
                                                <li class="nav-item me-0">
                                                    <label for="type_text_media"
                                                        class="nav-link bg-active-info text-gray-700 px-4 py-3 b-r-6 text-active-white @if ($interactive_id == 1) active @endif"
                                                        data-bs-toggle="pill" data-bs-target="#wa_text_and_media"
                                                        type="button" role="tab">{{ __('Text only') }}</label>
                                                    <input class="d-none" type="radio" name="action_type_radio"
                                                        id="type_text_media"
                                                        @if ($interactive_id == 1) checked='true' @endif
                                                        value="1">
                                                </li>
                                                <li class="nav-item me-0">
                                                    <label for="type_button"
                                                        class="nav-link bg-active-info text-gray-700 px-4 py-3 b-r-6 text-active-white @if ($interactive_id == 2) active @endif"
                                                        data-bs-toggle="pill" data-bs-target="#wa_button" type="button"
                                                        role="tab">{{ __('Buttons') }}</label>
                                                    <input class="d-none" type="radio" name="action_type_radio"
                                                        id="type_button" value="2"
                                                        @if ($interactive_id == 2) checked='true' @endif>
                                                </li>
                                                <li class="nav-item me-0">
                                                    <label for="type_template"
                                                        class="nav-link bg-active-info text-gray-700 px-4 py-3 b-r-6 text-active-white @if ($interactive_id == 3) active @endif"
                                                        data-bs-toggle="pill" data-bs-target="#wa_list_message"
                                                        type="button" role="tab">{{ __('List buttons') }}</label>
                                                    <input class="d-none" type="radio" name="action_type_radio"
                                                        id="type_template" value="3"
                                                        @if ($interactive_id == 3) checked='true' @endif>
                                                </li>
                                            </ul>
                                            <div class="tab-content pt-3" id="nav-tabContent">
                                                <div class="tab-pane fade show @if ($interactive_id == 1) active @endif"
                                                    id="wa_text_and_media" role="tabpanel">
                                                </div>
                                                <div class="tab-pane fade show @if ($interactive_id == 2) active @endif"
                                                    id="wa_button" role="tabpanel">
                                                    @include('partials.interactive_buttongroups')
                                                </div>
                                                <div class="tab-pane fade show @if ($interactive_id == 3) active @endif"
                                                    id="wa_list_message" role="tabpanel">
                                                    @include('partials.interactive_listbuttongroups')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Preview and Submit -->
                    <div class="col-lg-4">

                        <div class="mt-2">
                            <div class="card card-flush">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>{{ __('Preview') }}</h2>
                                    </div>
                                </div>

                                <div class="card-body pt-0">
                                    <div class="card-body d-flex flex-column align-items-end"
                                        style="text-align: left; background: url('{{ asset('uploads/default/dotflo/bg.png') }}'); max-width: 100%;">

                                        <div id="previewElement" class="card shadow-lg w-100 mb-1"
                                            style="max-width: 100%; border-radius: 12px; overflow: hidden;">

                                            <!-- Chat-like message container -->
                                            <div class="card-body pt-0 mt-6" style="background-color: #ffffff;">
                                                <img src="{{ asset($item->media) ?? asset('uploads/files/default.png') }}"
                                                    class="card-img-top imageContainer w-100" id="card-img-top"
                                                    style="@if (empty($item->media)) display: none; @endif" />

                                                <h6 class="mt-6 mb-2 py-0 fs-11" id="headerTextPreview">@isset($item->header){{ $item->header }}@endisset
                                                </h6>

                                                <p class="card-text text-dark-50 font-weight-normal fs-13 mt-8">
                                                    <span dir="auto"
                                                        style="overflow-wrap: break-word; text-align: initial; white-space: pre-wrap;"
                                                        id="bodyTextPreview">@isset($item->text){{ $item->text }}@endisset</span>
                                                </p>

                                                <span class="text-muted text-xs" id="footerTextPreview">@isset($item->footer){{ $item->footer }}@endisset</span>
                                            </div>
                                        </div>

                                        {{-- Dynamic Button List Injected Here --}}
                                        <div id="button_list_template" class="w-100"></div>

                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-info mt-3">
                                            <i class="ki-outline ki-save fs-2 me-1"></i> {{ __('Update BotReply') }}
                                        </button>
                                    </div>
                                    @if ($setup['isBot'] == true)
                                        <div class="mt-4 text-end">
                                            <?php
                                            $qrCodeData = null;
                                            if (!empty($setup['qr']) && file_exists($setup['qr'])) {
                                                $qrCodeData = base64_encode(file_get_contents($setup['qr']));
                                            }
                                            ?>

                                            @if ($qrCodeData)
                                                <div class="d-flex justify-content-end">
                                                    <a class="btn btn-info btn-sm mt-2"
                                                        href="data:image/png;base64,{{ $qrCodeData }}"
                                                        download="whatsapp_qr.png" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Download QR Code">
                                                        <i class="ki-duotone ki-cloud-download">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </div>

                                                <div class="d-inline-block">
                                                    <img src="data:image/png;base64,{{ $qrCodeData }}"
                                                        class="img-fluid" alt="{{ __('WhatsApp QR Code') }}">

                                                </div>
                                            @else
                                                <p class="text-danger">{{ __('QR Code not available.') }}</p>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>



                        {{-- <div class="d-flex justify-content-end text-end"
                            style="background: url('{{ asset('uploads/default/dotflo/bg.png') }}');">
                            <div class="card shadow-sm animate__animated animate__fadeIn">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ki-outline ki-eye fs-2 me-1"></i> Preview
                                    </h3>
                                </div>

                                <div class="card-body p-5">
                                    <div class="d-flex flex-column gap-5">
                                        <div class="d-flex align-items-center gap-4">
                                            <div class="symbol symbol-40px bg-primary text-white fw-bold">B</div>
                                            <div>
                                                <div class="fw-bold text-gray-900">Business Name</div>
                                                <div class="text-muted fs-8">Just now</div>
                                            </div>
                                        </div>

                                        <div class="border rounded p-4 bg-light">
                                            <div class="mb-4">
                                                <img id="card-img-top" src="{{ asset('uploads/default/dotflo/bg.png') }}"
                                                    alt="Card image" class="w-100 rounded" style="display: none;" />
                                            </div>

                                            <h4 class="text-gray-800 mb-4 fs-6" id="headerTextPreview">
                                                @isset($item->header)
                                                    {{ $item->header }}
                                                @endisset
                                            </h4>

                                            <p class="text-gray-600 fs-6 mt-2" id="bodyTextPreview"
                                                style="white-space: pre-wrap;">
                                                @isset($item->text)
                                                    {{ $item->text }}
                                                @endisset
                                            </p>

                                            <div class="text-muted fs-8 mt-3" id="footerTextPreview">
                                                @isset($item->footer)
                                                    {{ $item->footer }}
                                                @endisset
                                            </div>
                                        </div>

                                        <div id="button_list_template" class="mt-4"></div>

                                        @php $action_btn_text = $setup['isBot'] ? ' bot reply' : ' quick reply'; @endphp

                                        @if (isset($setup['isupdate']))
                                            <button type="submit" class="btn btn-light-primary w-100">
                                                <i class="ki-outline ki-refresh fs-2 me-2"></i>
                                                Update{{ $action_btn_text }}
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="ki-outline ki-save fs-2 me-2"></i> Save{{ $action_btn_text }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div> --}}


                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('topjs')
    <script type="text/javascript">
        imagetopreview = "chatbot";

        $(function() {
            $(".changeSelect2").select2();
            $(".changeKeywordInput").tagsinput("refresh");
        });
    </script>

    <script type="text/javascript">
        $(function() {
            Core.select2();
        });
    </script>
    <script>
        imagetopreview = "replies";
    </script>
    <script src="{{ asset('backend/Assets/File_manager/plugins/jquery.lazy/jquery.lazy.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/Assets/File_manager/js/file_manager.js') }}"></script> --}}
    <script src="{{ asset('backend/Assets/plugins/tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script>
        // Initialize form with existing values
        $(document).ready(function() {
            // Set header type
            const headerType = "{{ $item->header_type ?? 'none' }}";
            $('#header').val(headerType).trigger('change');
            // alert('hi');
            // Set initial values
            $('#name').val("{{ $item->name }}");
            $('#caption_text').val(`{!! $item->text !!}`);
            $('#footer_text').val("{{ $item->footer }}");
            $('#type').val("{{ $item->type }}");

            // Set media preview if exists
            @if ($mediaPath)
                @if ($item->header_type == 2)
                    $('#card-img-top').attr('src', "{{ $mediaPath }}").show();
                @endif
            @endif

            // Initialize tags input with existing values
            @if ($item->trigger)
                const triggers = "{{ $item->trigger }}".split(',');
                triggers.forEach(trigger => {
                    $('.tag-input').tagsinput('add', trigger.trim());
                });
            @endif
        });

        // Handle media selection
        $('.file-manager-select').on('change', function() {
            const fileUrl = $(this).val();
            if (fileUrl) {
                $('#card-img-top').attr('src', fileUrl).show();
            }
        });

        // Handle header text changes
        $('#header_text').on('input', function() {
            $('#headerTextPreview').text($(this).val());
        });

        // Handle form submission
        $('#repliesform').on('submit', function(e) {
            // Convert tags to comma-separated string
            const tags = $('.tag-input').tagsinput('items');
            $('<input>').attr({
                type: 'hidden',
                name: 'trigger',
                value: tags.join(',')
            }).appendTo(this);
        });
    </script>
    <script>
        $('#header').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            // console.log(">>>>valueSelected", valueSelected)
            if (valueSelected == "TEXT") {
                document.getElementById("card-img-top").style.display = "none";
                // $('#form-group-header_text').removeClass("d-none");
                $('#headerTextPreview').removeClass("d-none");
                // $('#fm-selected-mini-pdf').addClass("d-none");
                // $('#fm-selected-mini-imageupload').addClass("d-none");
                // $('#fm-selected-mini-videoupload').addClass("d-none");
                $(".upload-container").addClass("d-none");
                $(".form-group-header_text").removeClass("d-none");
                File_manager.unselectFiles($('.fm-selected-media .fm-list-item'));
            } else if (valueSelected == "IMG") {
                document.getElementById("card-img-top").src =
                    '{{ asset($currentMedia) ?? asset('backend/Assets/img/no-image.jpg') }}';
                document.getElementById("card-img-top").style.display = "block";
                // $('#form-group-header_text').addClass("d-none");
                $('#headerTextPreview').addClass("d-none");
                // $('#fm-selected-mini-pdf').addClass("d-none");
                // $('#fm-selected-mini-imageupload').removeClass("d-none");
                // $('#fm-selected-mini-videoupload').addClass("d-none");
                $(".upload-container").addClass("d-none");
                $(".form-group-header_text").addClass("d-none");
                $("#header_text").val('');
                $('.fm-selected-mini-imageupload').removeClass("d-none");
                File_manager.unselectFiles($('.fm-selected-media .fm-list-item'));
            } else if (valueSelected == "VIDEO") {
                document.getElementById("card-img-top").src =
                    '{{ asset('backend/Assets/img/video-default.png') }}';
                document.getElementById("card-img-top").style.display = "block";
                // $('#form-group-header_text').addClass("d-none");
                $('#headerTextPreview').addClass("d-none");
                // $('#fm-selected-mini-pdf').addClass("d-none");
                // $('#fm-selected-mini-imageupload').addClass("d-none");
                // $('#fm-selected-mini-videoupload').removeClass("d-none");
                $(".upload-container").addClass("d-none");
                $('.fm-selected-mini-videoupload').removeClass("d-none");
                $(".form-group-header_text").addClass("d-none");
                $("#header_text").val('');
                File_manager.unselectFiles($('.fm-selected-media .fm-list-item'));
            } else if (valueSelected == "PDF") {
                document.getElementById("card-img-top").src = '{{ asset('backend/Assets/img/pdf.png') }}';
                document.getElementById("card-img-top").style.display = "block";
                // $('#form-group-header_text').addClass("d-none");
                $('#headerTextPreview').addClass("d-none");
                // $('#fm-selected-mini-pdf').removeClass("d-none");
                // $('#fm-selected-mini-imageupload').addClass("d-none");
                // $('#fm-selected-mini-videoupload').addClass("d-none");
                $(".upload-container").addClass("d-none");
                $('.fm-selected-mini-pdf').removeClass("d-none");
                $(".form-group-header_text").addClass("d-none");
                $("#header_text").val('');
                File_manager.unselectFiles($('.fm-selected-media .fm-list-item'));
            } else if (valueSelected == "none") {
                $(".upload-container").addClass("d-none");
                $(".form-group-header_text").addClass("d-none");
                $("#header_text").val('');
                File_manager.unselectFiles($('.fm-selected-media .fm-list-item'));
            }
        });

        $('#header_text').on('keyup change', function(e) {
            console.log('>>>>>>>>>>> header_text ' + this.value);
            $("#headerTextPreview").html(this.value);
        });

        $('#footer_text').on('keyup change', function(e) {
            $("#footerTextPreview").html(this.value);
        });

        $('#caption_text').on('keyup change', function(e) {
            $("#bodyTextPreview").html(this.value);
        });

        $('#pills-tab').on('change', function(e) {
            $(".button_preview").remove();
            $('#btn_template_group_id').val('');
            $('#listbtn_template_group_id').val('');
        });

        //     var BUTTON_LIST_TEMPLATE = `    
    // <div class="button_preview card mt-1" style="min-width: 18rem;text-align: center;background-color: #f3f6f9;">
    //     <div class="card-body" style="padding:1rem">
    //             <img class="button_list_icon" style="height: 18px" src="{{ asset('backend/Assets/img/{icon}.png') }}" />
    //         <span class="" style="color: #00a5f4">{button_list_name}</span>
    //     </div>
    // </div>`;

        const BUTTON_LIST_TEMPLATE = `
        <div class="button_preview border-0 shadow-sm bg-light-info rounded card mb-1 text-center">
            <div class="card-body py-3">
                <img class="button_list_icon" style="height: 18px" src="{{ asset('backend/Assets/img/{icon}.png') }}" />
                <span style="color: #00a5f4">{button_list_name}</span>
            </div>
        </div>`;

        let shouldShowDefault = true;

        @isset($item['button_info'])
            @if ($item['action_type'] == 3)
                shouldShowDefault = false;
                let button_name = @json($item['button_info']->button_text);
                let option = BUTTON_LIST_TEMPLATE
                    .replace(/{button_list_name}/g, button_name)
                    .replace(/{icon}/g, 'list');
                document.getElementById("button_list_template").innerHTML += option;
            @elseif ($item['action_type'] == 2)
                shouldShowDefault = false;
                let button_info = @json($item['button_info']->template);
                let button_obj = JSON.parse(button_info);
                let buttons = button_obj.templateButtons ?? [];

                buttons.forEach(btn => {
                    let name = btn.quickReplyButton.displayText;
                    let option = BUTTON_LIST_TEMPLATE
                        .replace(/{button_list_name}/g, name)
                        .replace(/{icon}/g, 'reply');
                    document.getElementById("button_list_template").innerHTML += option;
                });
            @endif
        @endisset

        // Conditionally render default button based on bot_type
        @if ($setup['bot_type'] == 1)
            if (shouldShowDefault) {
                let defaultOption = BUTTON_LIST_TEMPLATE
                    .replace(/{button_list_name}/g, "Menu Option")
                    .replace(/{icon}/g, "list");
                document.getElementById("button_list_template").innerHTML += defaultOption;
            }
        @endif

        // Simulate tag input functionality
        $(document).on('click', '.tag-remove', function() {
            $(this).parent().remove();
        });

        $('.tag-input').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                const value = $(this).val().trim();
                if (value) {
                    const tag = $('<span class="tag">' + value + ' <span class="tag-remove">×</span></span>');
                    $(this).before(tag);
                    $(this).val('');
                }
            }
        });

        // Simulate file upload interaction
        $('.file-upload').on('click', function() {
            $(this).css({
                'border-color': 'var(--kt-primary)',
                'background-color': 'rgba(54, 153, 255, 0.05)'
            }).find('.file-upload-text').text('File selected!');

            // Update preview based on header type
            const headerType = $('#header_type').val();
            if (headerType === '2') {
                $('#headerTextPreview').text('Image Attachment');
            } else if (headerType === '3') {
                $('#headerTextPreview').text('Video Attachment');
            } else if (headerType === '4') {
                $('#headerTextPreview').text('Document Attachment');
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headerSelect = document.getElementById('header');
            const textSection = document.getElementById('header_text_section');
            const imageSection = document.getElementById('header_image_section');
            const videoSection = document.getElementById('header_video_section');
            const pdfSection = document.getElementById('header_pdf_section');
            const headerText = document.getElementById('header_text');
            const textCounter = document.getElementById('text_counter');
            const preview = document.getElementById('preview');

            // File upload triggers
            document.getElementById('image_upload').addEventListener('click', () => {
                document.getElementById('header_image').click();
            });

            document.getElementById('video_upload').addEventListener('click', () => {
                document.getElementById('header_video').click();
            });

            document.getElementById('pdf_upload').addEventListener('click', () => {
                document.getElementById('header_pdf').click();
            });

            // Handle text input character count
            headerText.addEventListener('input', function() {
                const length = this.value.length;
                textCounter.textContent = `${length}/60 characters`;
                textCounter.className = length > 60 ? 'counter warning' : 'counter';

                if (headerSelect.value === 'text') {
                    updatePreview();
                }
            });

            // Handle header type change
            headerSelect.addEventListener('change', function() {
                // Hide all sections
                textSection.style.display = 'none';
                imageSection.style.display = 'none';
                videoSection.style.display = 'none';
                pdfSection.style.display = 'none';

                // Show selected section
                switch (this.value) {
                    case 'text':
                        textSection.style.display = 'block';
                        break;
                    case 'image':
                        imageSection.style.display = 'block';
                        break;
                    case 'video':
                        videoSection.style.display = 'block';
                        break;
                    case 'pdf':
                        pdfSection.style.display = 'block';
                        break;
                }

                updatePreview();
            });

            // File change handlers
            document.getElementById('header_image').addEventListener('change', function(e) {
                updatePreview();
            });

            document.getElementById('header_video').addEventListener('change', function(e) {
                updatePreview();
            });

            document.getElementById('header_pdf').addEventListener('change', function(e) {
                updatePreview();
            });

            // Update preview based on selection
            function updatePreview() {
                const type = headerSelect.value;
                let content = '';

                switch (type) {
                    case 'none':
                        content = 'No header selected';
                        break;
                    case 'text':
                        const text = headerText.value || 'No text entered';
                        content = `<div class="preview-text">${text}</div>`;
                        break;
                    case 'image':
                        const imageInput = document.getElementById('header_image');
                        if (imageInput.files.length > 0) {
                            const file = imageInput.files[0];
                            content = `🖼️ Image selected: <strong>${file.name}</strong><br>
                                       <small>Type: ${file.type}, Size: ${Math.round(file.size/1024)}KB</small>`;
                        } else {
                            content = 'No image selected';
                        }
                        break;
                    case 'video':
                        const videoInput = document.getElementById('header_video');
                        if (videoInput.files.length > 0) {
                            const file = videoInput.files[0];
                            content = `📹 Video selected: <strong>${file.name}</strong><br>
                                       <small>Type: ${file.type}, Size: ${Math.round(file.size/1024)}KB</small>`;
                        } else {
                            content = 'No video selected';
                        }
                        break;
                    case 'pdf':
                        const pdfInput = document.getElementById('header_pdf');
                        if (pdfInput.files.length > 0) {
                            const file = pdfInput.files[0];
                            content = `📄 PDF selected: <strong>${file.name}</strong><br>
                                       <small>Size: ${Math.round(file.size/1024)}KB</small>`;
                        } else {
                            content = 'No PDF selected';
                        }
                        break;
                }

                preview.innerHTML = content;
            }

            // Initialize the view
            headerSelect.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
<!-- Add this at the bottom of your blade file -->
@section('js')
    <script>
        $(document).ready(function() {
            // Initialize tags input
            $('.tag-input').tagsinput({
                trimValue: true,
                confirmKeys: [13, 44, 32] // Enter, comma, space
            });

            // Set initial tags
            @if ($trigger)
                var tags = "{{ $trigger }}".split(',');
                tags.forEach(function(tag) {
                    $('.tag-input').tagsinput('add', tag.trim());
                });
            @endif

            // Handle form submission
            $('#repliesform').on('submit', function(e) {
                e.preventDefault();

                let errors = [];

                // Validate template name
                if (!$('#name').val().trim()) {
                    errors.push('Name is required');
                } else if (!$('#caption_text').val().trim()) {
                    errors.push('Message content is required');
                }

                // Show errors if any exist
                if (errors.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errors.join('<br>• ').replace(/^/, '• '),
                        confirmButtonColor: '#3085d6',
                    });
                    return false; // Prevent form submission
                }

                // Show loading state
                const submitBtn = $('button[type="submit"]');
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');

                // Get form data including files
                const formData = new FormData(this);

                // Add tags to form data
                @if ($setup['isBot'] == true)
                    // Add tags to form data
                    const tags = $('.tag-input').tagsinput('items');
                    formData.set('trigger', tags.join(','));
                @endif

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Show success message
                        showAlert('success', response.message);

                        // Redirect if needed
                        if (response.redirect) {
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1500);
                        } else {
                            // Update button state
                            submitBtn.prop('disabled', false);
                            submitBtn.html(
                                '<i class="ki-outline ki-save fs-2 me-1"></i> Save Template'
                            );

                            // If it was a new item, update form action for future updates
                            if (response.id) {
                                const newAction = "{{ $setup['action'] }}/" + response.id;
                                $('#repliesform').attr('action', newAction);
                                $('#repliesform').append(
                                    '<input type="hidden" name="_method" value="PUT">');
                            }
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false);
                        submitBtn.html(
                            '<i class="ki-outline ki-save fs-2 me-1"></i> Save Template');

                        // Handle validation errors
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = [];

                            $.each(errors, function(field, messages) {
                                errorMessages.push(messages.join('<br>'));
                            });

                            showAlert('error', errorMessages.join('<br>'));
                        } else {
                            showAlert('error', 'An error occurred. Please try again.');
                        }
                    }
                });
            });

            // Show alert function
            function showAlert(type, message) {
                // Remove existing alerts
                $('.ajax-alert').remove();

                const alertHtml = `
            <div class="ajax-alert alert alert-${type} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

                $('body').append(alertHtml);

                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    $('.ajax-alert').alert('close');
                }, 5000);
            }

            // Handle file selection changes
            $('.file-manager-select').on('change', function() {
                const id = $(this).attr('id');
                const file = $(this).val();
                const previewElement = $('#card-img-top');

                if (file) {
                    if (id === 'header_image') {
                        previewElement.attr('src', file).show();
                    } else if (id === 'header_video') {
                        previewElement.attr('src', '{{ asset('backend/Assets/img/video-default.png') }}')
                            .show();
                    } else if (id === 'header_pdf') {
                        previewElement.attr('src', '{{ asset('backend/Assets/img/pdf.png') }}').show();
                    }
                } else {
                    previewElement.hide();
                }
            });
        });
    </script>
@endsection