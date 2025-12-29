@if ($variables != null)
    @foreach ($variables as $key => $itemBox)
        <div class="card mb-5 border-0 shadow-sm"> <!-- Added border-0 and shadow-sm for Metronic look -->
            <div class="card-header border-0 pt-5"> <!-- Added border-0 and pt-5 for header spacing -->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 d-flex align-items-center">
                        <!-- Added d-flex align-items-center -->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx me-2"> <!-- Metronic icon styling -->
                            <i
                                class="fas fa-@switch($key)
                                @case('header') heading @break
                                @case('body') align-left @break
                                @case('document') file-pdf @break
                                @case('image') image @break
                                @case('video') video @break
                                @case('buttons') mouse-pointer @break
                                @default cube
                            @endswitch"></i>
                        </span>
                        {{ __(ucfirst($key)) }}
                    </span>
                </h3>
            </div>
            <div class="card-body pt-0 pb-5"> <!-- Adjusted padding -->
                @if ($key == 'header' || $key == 'body')
                    @foreach ($itemBox as $item)
                        <div class="row mb-6 align-items-center">
                            <div class="col-md-6 pe-5"> <!-- Added pe-5 for right padding -->
                                @include('partials.input', [
                                    'onvuechange' => 'setPreviewValue',
                                    'id' => 'paramvalues[' . $key . '][' . $item['id'] . ']',
                                    'name' => __('Variable') . ' ' . $item['id'],
                                    'placeholder' => $item['exampleValue'],
                                    'value' => $item['exampleValue'],
                                    'required' => false,
                                    'wrapperClass' => 'mb-3',
                                    'inputClass' => 'form-control form-control-solid',
                                    'labelClass' => 'fs-6 fw-bold mb-2',
                                ])
                            </div>
                            <div class="col-md-6 ps-5"> <!-- Added ps-5 for left padding -->
                                @include('partials.select', [
                                    'id' => 'parammatch[' . $key . '][' . $item['id'] . ']',
                                    'name' => __('Match with a contact field'),
                                    'data' => $contactFields,
                                    'required' => true,
                                    'value' => '-2',
                                    'additionalInfos' =>
                                        'Use contact field, as a value for the variable, or use static value.',
                                    'wrapperClass' => 'mb-3',
                                    'selectClass' => 'form-select form-select-solid',
                                    'labelClass' => 'fs-6 fw-bold mb-2',
                                ])
                            </div>
                        </div>
                    @endforeach
                @elseif ($key == 'document')
                    <div class="mb-6">
                        @include('wpbox::file_manager.mini', [
                            'id' => 'pdf',
                            'changevue' => 'handlePdfUpload',
                            'name' => __('PDF Document'),
                            'type' => 'pdf',
                            'required' => true,
                            'accept' => 'application/pdf',
                            'select_multi' => 0,
                            'wrapperClass' => 'mb-3',
                            'inputClass' => 'form-control form-control-solid',
                            'labelClass' => 'fs-6 fw-bold mb-2',
                            'tooltip' => 'This document is mandatory as per Meta (WhatsApp) policy.',
                        ])
                    </div>
                @elseif ($key == 'image')
                    <div class="mb-6">
                        @include('wpbox::file_manager.mini', [
                            'id' => 'imageupload',
                            'changevue' => 'handleImageUpload',
                            'type' => 'image',
                            'select_multi' => 0,
                            'name' => __('Select image'),
                            'required' => true,
                            'accept' => '.jpg, .jpeg, .png',
                            'wrapperClass' => 'mb-3',
                            'inputClass' => 'form-control form-control-solid',
                            'labelClass' => 'fs-6 fw-bold mb-2',
                            'tooltip' => 'This image is mandatory as per Meta (WhatsApp) policy.',
                        ])
                    </div>
                @elseif ($key == 'video')
                    <div class="mb-6">
                        @include('wpbox::file_manager.mini', [
                            'id' => 'imageupload',
                            'changevue' => 'handleVideoUpload',
                            'type' => 'video',
                            'select_multi' => 0,
                            'name' => __('Select video'),
                            'required' => true,
                            'accept' => '.mp4',
                            'wrapperClass' => 'mb-3',
                            'inputClass' => 'form-control form-control-solid',
                            'labelClass' => 'fs-6 fw-bold mb-2',
                            'tooltip' => 'This video is mandatory as per Meta (WhatsApp) policy.',
                        ])
                    </div>
                @elseif ($key == 'buttons')
                    <div class="mb-0">
                        @foreach ($itemBox as $button)
                            <div class="card mb-6 border-0 shadow-sm">
                                <div class="card-header border-0">
                                    <h4 class="card-title fw-bolder">
                                        <span class="svg-icon svg-icon-muted svg-icon-2hx me-2">
                                            <i class="fas fa-mouse-pointer"></i>
                                        </span>
                                        {{ __('Button') }} {{ $loop->iteration }}
                                    </h4>
                                </div>
                                <div class="card-body pt-0 pb-0">
                                    @foreach ($button as $keybtn => $item)
                                        @if ($item['type'] == 'URL')
                                            <div class="mb-6">
                                                <div class="mb-4"> <!-- Input field container -->
                                                    @include('partials.input', [
                                                        'prepend' => $item['exampleValue'],
                                                        'id' =>
                                                            'paramvalues[' .
                                                            $key .
                                                            '][' .
                                                            $keybtn .
                                                            '][' .
                                                            $item['id'] .
                                                            ']',
                                                        'name' => $item['text'],
                                                        'placeholder' => '',
                                                        'value' => '',
                                                        'required' => false,
                                                        'wrapperClass' => 'mb-3',
                                                        'inputClass' => 'form-control form-control-solid',
                                                        'labelClass' => 'fs-6 fw-bold mb-2',
                                                    ])
                                                </div>
                                                <div> <!-- Select field container -->
                                                    @include('partials.select', [
                                                        'id' =>
                                                            'parammatch[' .
                                                            $key .
                                                            '][' .
                                                            $keybtn .
                                                            '][' .
                                                            $item['id'] .
                                                            ']',
                                                        'name' => __('Match with a contact field'),
                                                        'data' => $contactFields,
                                                        'required' => true,
                                                        'value' => '-2',
                                                        'additionalInfos' =>
                                                            'Use contact field, as a value for the variable, or use static value.',
                                                        'wrapperClass' => 'mb-3',
                                                        'selectClass' => 'form-select form-select-solid',
                                                        'labelClass' => 'fs-6 fw-bold mb-2',
                                                    ])
                                                </div>
                                            </div>
                                        @elseif($item['type'] == 'COPY_CODE')
                                            <div class="mb-6">
                                                <div class="mb-4"> <!-- Input field container -->
                                                    @include('partials.input', [
                                                        'id' =>
                                                            'paramvalues[' .
                                                            $key .
                                                            '][' .
                                                            $keybtn .
                                                            '][' .
                                                            $item['id'] .
                                                            ']',
                                                        'name' => $item['text'],
                                                        'placeholder' => $item['exampleValue'],
                                                        'value' => '',
                                                        'required' => false,
                                                        'wrapperClass' => 'mb-3',
                                                        'inputClass' => 'form-control form-control-solid',
                                                        'labelClass' => 'fs-6 fw-bold mb-2',
                                                    ])
                                                </div>
                                                <div> <!-- Select field container -->
                                                    @include('partials.select', [
                                                        'id' =>
                                                            'parammatch[' .
                                                            $key .
                                                            '][' .
                                                            $keybtn .
                                                            '][' .
                                                            $item['id'] .
                                                            ']',
                                                        'name' => __('Match with a contact field'),
                                                        'data' => $contactFields,
                                                        'required' => true,
                                                        'value' => '-2',
                                                        'additionalInfos' =>
                                                            'Use contact field, as a value for the variable, or use static value.',
                                                        'wrapperClass' => 'mb-3',
                                                        'selectClass' => 'form-select form-select-solid',
                                                        'labelClass' => 'fs-6 fw-bold mb-2',
                                                    ])
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach
@endif
