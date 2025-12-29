{{-- Brij Mohan Negi Update --}}
<div class="card b-r-6">
    <div class="card-header bg-light-primary border-0">
        <h3 class="card-title text-gray-800 fs-2 fw-bolder">{{ __('Button List') }}</h3>
    </div>

    <div class="card-body p-0">
        <div class="wa-template-option" id="wa-template-option-div-id">
            @php
                $users = [];
                $groups = [];
                $button_count = 0;

                if (isset($field['users']) && isset($field['groups'])) {
                    $users = $field['users'];
                    $groups = $field['groups'];
                } else {
                    $users = $users;
                    $groups = $groups;
                }

                $options = [];
                if (isset($field['template'])) {
                    $data = json_decode($field['template']);
                    if (!empty($data) && isset($data->templateButtons) && count($data->templateButtons) != 0) {
                        $options = $data->templateButtons;
                    }
                }
            @endphp

            @if (!empty($options))
                @foreach ($options as $key => $value)
                    @php
                        $button_count++;
                        $displayText = '';
                        if (isset($value->quickReplyButton)) {
                            $displayText = $value->quickReplyButton->displayText;
                            $add_tags = $value->quickReplyButton->add_tags;
                            $conversation_groups = $value->quickReplyButton->conversation_groups;
                            $conversation_user = $value->quickReplyButton->conversation_user;
                            $default_button_action = $value->quickReplyButton->default_button_action;
                            $remove_tags = $value->quickReplyButton->remove_tags;
                            $start_flow = $value->quickReplyButton->start_flow;
                            $user_press_the_button = $value->quickReplyButton->user_press_the_button;
                            $webhook_url = $value->quickReplyButton->webhook_url;
                        } elseif (isset($value->urlButton)) {
                            $displayText = $value->urlButton->displayText;
                        } elseif (isset($value->callButton)) {
                            $displayText = $value->callButton->displayText;
                        }
                    @endphp

                    <div class="card border b-r-6 mb-6 wa-template-option-item">
                        <div class="card-header bg-light-success py-4">
                            <div class="card-title fs-4 fw-bold text-gray-800">{{ __('Configure Button') }}
                                {{ $key + 1 }}</div>
                            <div class="card-toolbar">
                                <button type="button"
                                    class="btn btn-icon btn-sm btn-light-danger wa-template-option-remove b-r-6">
                                    <i class="fad fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body pt-1">
                            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-4 fs-6">
                                <li class="nav-item">
                                    <label for="btn_type_text_{{ $key + 1 }}"
                                        class="nav-link text-active-primary {{ data_get($value, 'quickReplyButton') != false ? 'active' : '' }}"
                                        data-bs-toggle="tab" data-bs-target="#nav_btn_type_text_{{ $key + 1 }}">
                                        {{ __('Text Button') }}
                                    </label>
                                    <input class="d-none" type="radio" name="btn_msg_type[{{ $key + 1 }}]"
                                        id="btn_type_text_{{ $key + 1 }}"
                                        {{ data_get($value, 'quickReplyButton') != false ? 'checked="true"' : '' }}
                                        value="1">
                                </li>
                                <li class="nav-item">
                                    <label for="btn_type_link_{{ $key + 1 }}"
                                        class="nav-link text-active-primary {{ data_get($value, 'urlButton') != false ? 'active' : '' }}"
                                        data-bs-toggle="tab" data-bs-target="#nav_btn_type_link_{{ $key + 1 }}">
                                        {{ __('Link Button') }}
                                    </label>
                                    <input class="d-none" type="radio" name="btn_msg_type[{{ $key + 1 }}]"
                                        id="btn_type_link_{{ $key + 1 }}"
                                        {{ data_get($value, 'urlButton') != false ? 'checked="true"' : '' }}
                                        value="2">
                                </li>
                            </ul>

                            @php $keyvalue = $key + 1; @endphp

                            <div class="tab-content" id="nav-tabContent">
                                <div class="mb-6">
                                    <label
                                        class="form-label fs-6 fw-bold text-gray-700">{{ __('Button text') }}</label>
                                    <input type="text" name="btn_msg_display_text[{{ $keyvalue }}]"
                                        class="form-control form-control-solid btn_msg_display_text_{{ $keyvalue }}"
                                        placeholder="Enter your caption" maxlength="20" value="{{ $displayText }}">
                                    <small class="form-text text-muted">{{ __('max 20 characters allowed') }}</small>
                                </div>

                                <div class="tab-pane fade @isset($value->quickReplyButton) show active @endisset"
                                    id="nav_btn_type_text_{{ $keyvalue }}" role="tabpanel">

                                    <div class="row g-6 mb-6">
                                        <div class="col-md-6 fv-row">
                                            @include('partials.select', [
                                                'name' => __('When user press the button'),
                                                'id' => "user_press_the_button[$keyvalue]",
                                                'value' => '1',
                                                'function' => $keyvalue,
                                                'function_type' => 2,
                                                'placeholder' => __('Select'),
                                                'required' => false,
                                                'dataSelected' => $user_press_the_button ?? '',
                                                'data' => [
                                                    '1' => __('Quick reply'),
                                                    '2' => __('Start a flow'),
                                                    '3' => __('System default action button'),
                                                ],
                                            ])
                                        </div>
                                    </div>

                                    <div
                                        class="send_message_section_{{ $keyvalue }} @isset($user_press_the_button) @if ($user_press_the_button == 1) @else d-none @endif @endisset">
                                        <div class="row g-6 mb-6">
                                            <div class="col-md-6 fv-row">
                                                @include('partials.keywordinput', [
                                                    'id' => "add_tags[$keyvalue]",
                                                    'editclass' => "add_tags_{$keyvalue}",
                                                    'name' => __('Add Tag(s) (separate by comma)'),
                                                    'value' => $add_tags ?? '',
                                                    'placeholder' => __('Enter tag here'),
                                                ])
                                            </div>

                                            <div class="col-md-6 fv-row">
                                                @include('partials.keywordinput', [
                                                    'id' => "remove_tags[$keyvalue]",
                                                    'editclass' => "remove_tags_{$keyvalue}",
                                                    'value' => $remove_tags ?? '',
                                                    'name' => __('Remove Tag(s) (separate by comma)'),
                                                    'placeholder' => __('Enter tag here'),
                                                ])
                                            </div>

                                            <div class="col-md-6 fv-row">
                                                @include('partials.select', [
                                                    'multiple' => true,
                                                    'name' => 'Assign conversation to a group',
                                                    'id' => 'conversation_groups[$keyvalue]',
                                                    'placeholder' => 'Select a group',
                                                    'dataSelected' => $conversation_groups ?? '',
                                                    'data' => $groups,
                                                ])
                                            </div>

                                            <div class="col-md-6 fv-row">
                                                @include('partials.select', [
                                                    'name' => __('Assign conversation to a user'),
                                                    'id' => 'conversation_user[{$key + 1 }]',
                                                    'dataSelected' => $conversation_user ?? '',
                                                    'placeholder' => __('Select a user'),
                                                    'data' => $users,
                                                ])
                                            </div>

                                            <div class="col-md-12 fv-row">
                                                @include('partials.input', [
                                                    'id' => "webhook_url[$keyvalue]",
                                                    'value' => $webhook_url ?? '',
                                                    'name' => __('Send data to Webhook URL'),
                                                    'placeholder' => __('Enter webhook url'),
                                                ])
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="start_a_flow_section_{{ $keyvalue }} @isset($user_press_the_button) @if ($user_press_the_button == 2) @else d-none @endif @endisset">
                                        <div class="row g-6 mb-6">
                                            <div class="col-md-6 fv-row">
                                                @include('partials.select', [
                                                    'name' => __('Flow name'),
                                                    'id' => "start_flow[$keyvalue]",
                                                    'placeholder' => __('Select flow'),
                                                    'data' => [],
                                                ])
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="default_button_section_{{ $keyvalue }} @isset($user_press_the_button) @if ($user_press_the_button == 3) @else d-none @endif @endisset">
                                        <div class="row g-6 mb-6">
                                            <div class="col-md-6 fv-row">
                                                @include('partials.select', [
                                                    'name' => __('Action Type'),
                                                    'id' => "default_button_action[$keyvalue]",
                                                    'placeholder' => __('Select'),
                                                    'dataSelected' => $default_button_action ?? '',
                                                    'data' => [
                                                        '1' => __('Unsubscribe'),
                                                        '2' => __('Re-subscribe'),
                                                        '3' => __('Chat with human'),
                                                        '4' => __('Chat with bot'),
                                                    ],
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade mb-6 {{ data_get($value, 'urlButton') != false ? 'show active' : '' }}"
                                    id="nav_btn_type_link_{{ $key + 1 }}" role="tabpanel">
                                    <label class="form-label fs-6 fw-bold text-gray-700">{{ __('Link') }}</label>
                                    <input class="form-control form-control-solid"
                                        name="btn_msg_link[{{ $key + 1 }}]"
                                        placeholder="{{ __('Enter your url') }}"
                                        value="{{ data_get($value, 'urlButton') != false ? data_get($value->urlButton, 'url') : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="wa-empty py-15">
                    <div class="text-center">
                        <img class="mh-150px mb-7" alt="" src="{{ asset('backend/Assets/img/empty.png') }}">
                        <h4 class="text-gray-600">{{ __('No buttons configured yet') }}</h4>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="card-footer bg-light py-6 wa-template-wrap-add {{ count($options) >= 3 ? 'd-none' : '' }}">
        <button type="button" class="btn btn-primary px-6 fw-bold btn-wa-add-option">
            <i class="fad fa-plus-circle me-2"></i>{{ __('Add new button') }}
        </button>
    </div>
</div>
@section('js')
    <script>
        var WA_TEMPLATE = `
        <div class="wa-template-data-option">
            <div class="card border b-r-6 mb-6 wa-template-option-item">
        <div class="card-header">
            <div class="card-title">{{ __('Configure Button') }} {count}</div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-danger wa-template-option-remove px-3 b-r-6"><i
                        class="fad fa-trash-alt pe-0 me-0"></i></button>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs mb-3 bg-light-dark rounded border" id=" -tab">
                <li class="nav-item">
                    <label for="btn_type_text_{count}"
                        class="nav-link active bg-active-white text-gray-700 px-4 py-3 text-active-success"
                        data-bs-toggle="tab" data-bs-target="#nav_btn_type_text_{count}" type="button"
                        role="tab">{{ __('Text & Action Button') }}</label>
                    <input class="d-none" type="radio" name="btn_msg_type[{count}]" id="btn_type_text_{count}"
                        checked="true" value="1">
                </li>
                <li class="nav-item">
                    <label for="btn_type_link_{count}"
                        class="nav-link bg-active-white text-gray-700 px-4 py-3 text-active-success"
                        data-bs-toggle="tab" data-bs-target="#nav_btn_type_link_{count}" type="button"
                        role="tab">{{ __('CTA - Link Button') }}</label>
                    <input class="d-none" type="radio" name="btn_msg_type[{count}]" id="btn_type_link_{count}"
                        value="2">
                </li>
                {{-- <li class="nav-item">
                    <label for="btn_type_call_{count}"
                        class="nav-link bg-active-white text-gray-700 px-4 py-3 text-active-success"
                        data-bs-toggle="pill" data-bs-target="#nav_btn_type_call_{count}" type="button"
                        role="tab">{{ __('Call Action Button') }}</label>
                    <input class="d-none" type="radio" name="btn_msg_type[{count}]" id="btn_type_call_{count}"
                        value="3">
                </li> --}}
            </ul>

            <div class="tab-content pt-3" id="nav-tabContent">
                <div class="mb-3">
                    <label class="form-label">{{ __('Button text') }}</label>
                    <input type="text" name="btn_msg_display_text[{count}]"
                        class="form-control form-control-solid btn_msg_display_text_{count}" maxlength="20"
                        placeholder="{{ __('Enter button text') }}">
                        <small class="form-text text-muted">{{ __('max 20 characters allowed') }}</small>
                </div>
                <div class="tab-pane fade show active" id="nav_btn_type_text_{count}" role="tabpanel">

                    @include('partials.select', [
                        'class' => 'col-md-4 mt-4',
                        'classselect' => 'changeSelect2',
                        'name' => __('When user press the button'),
                        'id' => 'user_press_the_button[{count}]',
                        'value' => '1',
                        'function' => '{count}',
                        'ftype2' => 'select2',
                        'placeholder' => __('Select'),
                        'required' => false,
                        'data' => [
                            '1' => __('Quick reply'),
                            //  '2' => __('Send message'),
                            '2' => __('Start a flow'),
                            '3' => __('System default action button'),
                        ],
                    ])

                    <div class="send_message_section_{count}">

                        @include('partials.keywordinput', [
                            'id' => 'add_tags[{count}]',
                            'classselect' => 'changeKeywordInput',
                            'editclass' => 'add_tags_{count}',
                            'name' => __('Add Tag(s) (separate by comma)'),
                            'value' => '',
                            'tophide' => 'yes',
                            'placeholder' => __('Enter tag here'),
                            'required' => false,
                        ])

                        @include('partials.keywordinput', [
                            'id' => 'remove_tags[{count}]',
                            'editclass' => 'remove_tags_{count}',
                            'classselect' => 'changeKeywordInput',
                            'value' => '',
                            'name' => __('Remove Tag(s) (separate by comma)'),
                            'tophide' => 'yes',
                            'placeholder' => __('Enter tag here'),
                            'required' => false,
                        ])

                        @include('partials.select', [
                            'multiple' => true,
                            'classselect' => 'changeSelect2',
                            'class' => 'col-md-12 mt-4',
                            'name' => 'Assign conversation to a group',
                            'id' => 'conversation_groups[{count}]',
                            'placeholder' => 'Select a group',
                            'value' => '',
                            'data' => $groups,
                            'required' => false,
                        ])

                        @include('partials.select', [
                            'class' => 'col-md-4 mt-4',
                            'classselect' => 'changeSelect2',
                            'name' => __('Assign conversation to a user'),
                            'id' => 'conversation_user[{count}]',
                            //   'ftype2' => 'select2',
                            'value' => '',
                            'placeholder' => __('Select a user'),
                            'required' => false,
                            'data' => $users,
                        ])

                        @include('partials.input', [
                            'id' => 'webhook_url[{count}]',
                            'value' => '',
                            'name' => __('Send data to Webhook URL'),
                            'placeholder' => __('Enter webhook url'),
                            'required' => false,
                        ])

                    </div>
                    <div class="start_a_flow_section_{count} d-none">
                        @include('partials.select', [
                            'class' => 'col-md-4 mt-4',
                            'classselect' => 'changeSelect2',
                            'name' => __('Flow name'),
                            'id' => 'start_flow[{count}]',
                            //   'ftype2' => 'select2',
                            'value' => '',
                            'placeholder' => __('Select flow'),
                            'required' => false,
                            'data' => [],
                        ])
                    </div>
                    <div class="default_button_section_{count} d-none">
                        @include('partials.select', [
                            'class' => 'col-md-4 mt-4',
                            'classselect' => 'changeSelect2',
                            'name' => __('Action Type'),
                            'id' => 'default_button_action[{count}]',
                            //   'ftype2' => 'select2',
                            'placeholder' => __('Select action'),
                            'value' => '',
                            'required' => false,
                            'data' => [
                                '1' => __('Unsubscribe'),
                                '2' => __('Re-subscribe'),
                                '3' => __('Chat with human'),
                                '4' => __('Chat with bot'),
                            ],
                        ])
                    </div>

                </div>
                <div class="tab-pane fade mb-3" id="nav_btn_type_link_{count}" role="tabpanel">
                    <label class="form-label">{{ __('Link') }}</label>
                    <input class="form-control form-control-solid" name="btn_msg_link[{count}]"
                        placeholder="{{ __('Enter your url') }}">
                </div>
                <div class="tab-pane fade mb-3" id="nav_btn_type_call_{count}" role="tabpanel">
                    <label class="form-label">{{ __('Phone number') }}</label>
                    <input class="form-control form-control-solid" name="btn_msg_call[{count}]"
                        placeholder="{{ __('Ex: +1 (234) 5678-901') }}">
                </div>
            </div>

            <ul class="text-success fs-12 mb-0">
                {{-- <li>Random message by Spintax. Ex: {Hi|Hello|Hola}</li> --}}
                <li>{{ __('Text Button: Enter a message to quick reply for the button') }}</li>
                <li>{{ __('Url Button: Enter URL for the button') }}</li>
                {{-- <li>{{ __('Call Button: Enter Phone number for the button') }}</li> --}}
                {{-- <li>[Bulk messaging] - Add custom variables: %name%, %param1%, %param2%,...</li> --}}
            </ul>
        </div>
    </div>
</div>`;
    </script>
    <script>
        function selectChangeFun2(id, sectionID) {
            var e = document.getElementById(id);
            var value = e.value;
            var selectedIndex = e.selectedIndex;

            //  alert(selectedIndex);
            @if ($button_count != 0)
                selectedIndex = selectedIndex + 1;
            @endif
            // default_button_section_{count} start_a_flow_section_{count} send_message_section_{count}
            if (selectedIndex === 1) {
                $('.send_message_section_' + sectionID).removeClass("d-none");
                $('.start_a_flow_section_' + sectionID).addClass("d-none");
                $('.default_button_section_' + sectionID).addClass("d-none");

            } else if (selectedIndex === 2) {
                $('.send_message_section_' + sectionID).addClass("d-none");
                $('.start_a_flow_section_' + sectionID).removeClass("d-none");
                $('.default_button_section_' + sectionID).addClass("d-none");

            } else if (selectedIndex === 3) {
                $('.send_message_section_' + sectionID).addClass("d-none");
                $('.start_a_flow_section_' + sectionID).addClass("d-none");
                $('.default_button_section_' + sectionID).removeClass("d-none");

            }
        }

        function selectChangeFun(id, sectionID) {
            var e = document.getElementById(id);
            var value = e.value;
            var selectedIndex = e.selectedIndex;

            if (selectedIndex === 1) {
                $('.send_message_section_' + sectionID).removeClass("d-none");
                $('.start_a_flow_section_' + sectionID).addClass("d-none");
                $('.default_button_section_' + sectionID).addClass("d-none");

            } else if (selectedIndex === 2) {
                $('.send_message_section_' + sectionID).addClass("d-none");
                $('.start_a_flow_section_' + sectionID).removeClass("d-none");
                $('.default_button_section_' + sectionID).addClass("d-none");

            } else if (selectedIndex === 3) {
                $('.send_message_section_' + sectionID).addClass("d-none");
                $('.start_a_flow_section_' + sectionID).addClass("d-none");
                $('.default_button_section_' + sectionID).removeClass("d-none");

            }
        }
    </script>
    <script>
        const script = document.createElement("script");
        script.src = "https://dotflo.org/cus-assets/sendinai/whatsapp.js";
        script.async = true;
        document.head.appendChild(script);
    </script>
@endsection
