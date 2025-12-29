@php
    $class = 'col-md-12';
    $headerclass = 'd-none';
    $imgclass = 'd-none';
    $videoclass = 'd-none';
    $pdfclass = 'd-none';
    $caption_msg = "max 1024 characters allowed, You can also use {{name}} {{phone}} or any other custom field name.";

    $name = '';
    $header_typeDataSelected = 1;
    $header_text = '';
    $caption_text = '';
    $typeDataSelected = 2;
    $trigger = '';
    $footer_text = '';
    
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

        $name = $item->name ?? '';
        $header_typeDataSelected = $item->header_type ?? 1;
        $header_text = $item->header ?? '';
        $caption_text = $item->text ?? '';
        $typeDataSelected = $item->type ?? 2;
        $trigger = $item->trigger;
        $footer_text = $item->footer ?? '';

    @endphp


    {{-- @isset($item)
        {{ $item->name }}
    @endisset --}}
@endisset

<form action="{{ $setup['action'] }}" method="POST" id="repliesform" enctype="multipart/form-data">
    @csrf
    @isset($setup['isupdate'])
        @method('PUT')
    @endisset
    <div class="row" id="replies_managment">
        <div class="col-md-8 col-sm-12 col-xs-8 item card b-r-6 h-100 post-schedule wrap-caption">
            <div class="card-header">
                <h3 class="card-title"><i
                        class="{{ isset($setup['fa_icon']) ? __($setup['fa_icon']) : 'fa fa-circle' }} fs-20 me-2"
                        style="color: #7af586;"></i> {{ __($setup['title']) }}</h3>
                <div class="card-toolbar"></div>
            </div>

            @include('partials.input', [
                'class' => $class,
                'id' => 'name',
                'name' => __('Name'),
                'placeholder' => __('Enter name'),
                'value' => $name,
                'required' => true,
            ])
            @if ($setup['isBot'] == true)
                @include('partials.select', [
                    'class' => $class . 'mt-4',
                    'ftype2' => 'select2',
                    'name' => 'Header type',
                    //  'classselect' => 'changeSelect2',
                    'id' => 'header_type',
                    'placeholder' => 'Select header type',
                    'data' => [
                        '1' => __('Text'),
                        '2' => __('Image'),
                        '3' => __('Video'),
                        '4' => __('File'),
                    ],
                    'dataSelected' => $header_typeDataSelected,
                    'required' => true,
                ])

                @include('partials.input', [
                    'class' => $class,
                    'onvuechange' => 'setPreviewValue',
                    'id' => 'header_text',
                    'name' => __('Header Text'),
                    'placeholder' => __('Enter header'),
                    'value' => $header_text,
                    'max' => 60,
                    'additionalInfo' => __('max 60 characters allowed'),
                    'required' => false,
                ])

                @include('wpbox::file_manager.mini', [
                    'class' => 'd-none',
                    'id' => 'pdf',
                    'name' => __('PDF Document'),
                    'type' => 'pdf',
                    'addinID' => '_pdf',
                    'required' => true,
                    'accept' => 'application/pdf',
                    'select_multi' => 0,
                ])

            

                    @include('wpbox::file_manager.mini', [
                    'id' => 'imageupload',
                    'changevue' => 'handleImageUpload',
                    'type' => 'image',
                    'select_multi' => 0,
                    'name' => __('Select image'),
                    'required' => true,
                    'accept' => '.jpg, .jpeg, .png',
                ])

                @include('wpbox::file_manager.mini_video', [
                    'class' => 'd-none',
                    'id' => 'videoupload',
                    'changevue' => 'handleVideoUpload',
                    'type' => 'video',
                    'select_multi' => 0,
                    'addinID' => '_video',
                    'name' => __('Select video'),
                    'required' => true,
                    'accept' => '.mp4',
                ])
            @endif
            @include('partials.textarea', [
                'class' => $class,
                'id' => 'caption_text',
                'emoji' => true,
                'name' => 'Caption',
                'onvuechange' => 'setPreviewValue',
                'labelclass' => 'fs-14 fw-6 mb-2',
                'placeholder' => 'Enter message here',
                'additionalInfo' => $caption_msg,
                'required' => false,
                'value' => $caption_text,
            ])

            @if ($setup['isBot'] == true)
                @include('partials.select', [
                    'class' => $class . ' mt-4',
                    'ftype2' => 'select2',
                    //  'classselect' => 'changeSelect2',
                    'name' => 'Reply type',
                    'id' => 'type',
                    'placeholder' => 'Select reply type',
                    'data' => [
                        '2' => __('Reply bot: On exact match'),
                        '3' => __('Reply bot: When message contains'),
                        '4' => __('Welcome reply - when client send the first message'),
                    ],
                    'dataSelected' => $typeDataSelected,
                    'required' => true,
                ])

                @include('partials.keywordinput', [
                    'id' => 'trigger',
                    'classselect' => 'changeKeywordInput',
                    'editclass' => 'trigger',
                    'name' => __('Trigger Keyword (separate by comma)'),
                    'value' => $trigger,
                    'tophide' => 'yes',
                    'placeholder' => __('Enter bot reply keywrods'),
                    'required' => true,
                ])

                @include('partials.input', [
                    'class' => $class,
                    'id' => 'footer_text',
                    'name' => __('Footer'),
                    'value' => $footer_text,
                    'placeholder' => __('Enter footer'),
                    'max' => 60,
                    'additionalInfo' => __(
                        'Optional: max 60 characters allowed, Add a short line of text to the bottom of your message template. If you add the marketing opt-out button, the associated footer will be shown here by default.'),
                    'required' => false,
                ])

                @include('partials.interactive_groups', $fields)
            @else
                @include('partials.select', [
                    'class' => $class . ' mt-2',
                    'ftype2' => 'select2',
                    //  'classselect' => 'changeSelect2',
                    'name' => 'Reply type',
                    'id' => 'type',
                    'placeholder' => 'Select reply type',
                    'data' => ['1' => __('Just a quick reply')],
                    'dataSelected' => 1,
                    'required' => true,
                ])
            @endif
        </div>

        <div class="col-md-4 col-sm-12 col-xs-4 mb-4 item card b-r-6 h-100 post-schedule wrap-caption">
            <div class="card-header">
                <h3 class="card-title">{{ __('Preview') }}</h3>
                <div class="card-toolbar"></div>
            </div>
            <div class="card-body">
                @include('wpbox::replies.preview')
            </div>

            <div class="card mt-2">
                {{-- <div class="card-header">
                    <h3 class="card-title">{{ __('') }}</h3>

                    <div class="card-toolbar"></div>
                </div> --}}
                <div class="card-body">
                    <div class="d-grid mb-10">
                        @php $action_btn_text = ' quick reply' @endphp
                        @if ($setup['isBot'])
                            @php $action_btn_text = ' bot reply' @endphp
                        @endif
                        @if (isset($setup['isupdate']))
                            <button type="submit"
                                class="btn btn-success ml-3 mt-2">{{ __('Update' . $action_btn_text) }}</button>
                        @else
                            <button type="submit"
                                class="btn btn-success ml-3 mt-2">{{ __('Save' . $action_btn_text) }}</button>
                        @endif
                    </div>
                </div>
            </div>

        </div>


</form>
