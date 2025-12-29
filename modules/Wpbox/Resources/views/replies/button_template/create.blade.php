@extends('layouts.app-client')

@section('content')
    <div class="container">
        <form method="POST" action="{{ $setup['action'] }}">
            @csrf

            <div class="card b-r-6 shadow-sm">
                {{-- Card Header --}}
                <div class="card-header bg-light-primary border-0 py-6 d-flex align-items-center">
                    <a href="{{ $setup['action_link'] }}" class="btn btn-icon btn-light-primary me-5 b-r-6">
                        <i class="{{ $setup['action_icon'] }} fs-2"></i>
                    </a>
                    <div>
                        <h3 class="card-title text-gray-800 fs-2 fw-bolder">
                            <i class="ki-outline ki-notification-status fs-1"></i> {{ $setup['title'] }}
                        </h3>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Group Name Field --}}
                    <div class="mb-8">
                        <div class="fv-row">
                            <label class="form-label fs-6 fw-bold text-gray-700 required">{{ __('Group name') }}</label>
                            <input type="text" name="name" class="form-control form-control-solid b-r-6 p-6"
                                placeholder="{{ __('Enter button group name') }}" required>
                        </div>
                    </div>

                    <div class="separator border-2 my-8"></div>

                    {{-- Button Configuration Section --}}
                    <div class="card b-r-6 border border-primary shadow-sm">
                        <div class="wa-template-option" id="wa-template-option-div-id">
                            <div class="card-header bg-light-primary border-0 py-5">
                                <h3 class="card-title text-gray-800 fs-2 fw-bolder">{{ __('Buttons') }}</h3>
                            </div>

                            <div class="card-body p-0">
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
                                        if (
                                            !empty($data) &&
                                            isset($data->templateButtons) &&
                                            count($data->templateButtons) != 0
                                        ) {
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
                                                $default_button_action =
                                                    $value->quickReplyButton->default_button_action;
                                                $remove_tags = $value->quickReplyButton->remove_tags;
                                                $start_flow = $value->quickReplyButton->start_flow;
                                                $user_press_the_button =
                                                    $value->quickReplyButton->user_press_the_button;
                                                $webhook_url = $value->quickReplyButton->webhook_url;
                                            } elseif (isset($value->urlButton)) {
                                                $displayText = $value->urlButton->displayText;
                                            } elseif (isset($value->callButton)) {
                                                $displayText = $value->callButton->displayText;
                                            }
                                        @endphp

                                        <div class="card border b-r-6 mb-8 wa-template-option-item">
                                            <div class="card-header bg-light-success border-0 py-5">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h3 class="card-title fs-4 fw-bold text-gray-800">
                                                        {{ __('Configure Button') }} {{ $key + 1 }}
                                                    </h3>
                                                    <button type="button"
                                                        class="btn btn-icon btn-sm btn-light-danger wa-template-option-remove b-r-6">
                                                        <i class="ki-duotone ki-trash fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="card-body pt-1 px-8 pb-8">
                                                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-8 fs-6">
                                                    <li class="nav-item">
                                                        <label for="btn_type_text_{{ $key + 1 }}"
                                                            class="nav-link text-active-primary {{ data_get($value, 'quickReplyButton') != false ? 'active' : '' }}"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#nav_btn_type_text_{{ $key + 1 }}">
                                                            {{ __('Text Button') }}
                                                        </label>
                                                        <input class="d-none" type="radio"
                                                            name="btn_msg_type[{{ $key + 1 }}]"
                                                            id="btn_type_text_{{ $key + 1 }}"
                                                            {{ data_get($value, 'quickReplyButton') != false ? 'checked="true"' : '' }}
                                                            value="1">
                                                    </li>
                                                    <li class="nav-item">
                                                        <label for="btn_type_link_{{ $key + 1 }}"
                                                            class="nav-link text-active-primary {{ data_get($value, 'urlButton') != false ? 'active' : '' }}"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#nav_btn_type_link_{{ $key + 1 }}">
                                                            {{ __('Link Button') }}
                                                        </label>
                                                        <input class="d-none" type="radio"
                                                            name="btn_msg_type[{{ $key + 1 }}]"
                                                            id="btn_type_link_{{ $key + 1 }}"
                                                            {{ data_get($value, 'urlButton') != false ? 'checked="true"' : '' }}
                                                            value="2">
                                                    </li>
                                                </ul>

                                                @php $keyvalue = $key + 1; @endphp

                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="mb-8">
                                                        <label
                                                            class="form-label fs-6 fw-bold text-gray-700 required">{{ __('Button text') }}</label>
                                                        <input type="text"
                                                            name="btn_msg_display_text[{{ $keyvalue }}]"
                                                            class="form-control form-control-solid btn_msg_display_text_{{ $keyvalue }} p-6"
                                                            placeholder="Enter your caption" maxlength="20"
                                                            value="{{ $displayText }}" required>
                                                        <small
                                                            class="form-text text-muted">{{ __('max 20 characters allowed') }}</small>
                                                    </div>

                                                    <div class="tab-pane fade @isset($value->quickReplyButton) show active @endisset"
                                                        id="nav_btn_type_text_{{ $keyvalue }}" role="tabpanel">

                                                        <div class="row g-6 mb-8">
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
                                                            <div class="row g-6 mb-8">
                                                                <div class="col-md-6 fv-row">
                                                                    @include('partials.keywordinput', [
                                                                        'id' => "add_tags[$keyvalue]",
                                                                        'editclass' => "add_tags_{$keyvalue}",
                                                                        'name' => __(
                                                                            'Add Tag(s) (separate by comma)'),
                                                                        'value' => $add_tags ?? '',
                                                                        'placeholder' => __('Enter tag here'),
                                                                    ])
                                                                </div>

                                                                <div class="col-md-6 fv-row">
                                                                    @include('partials.keywordinput', [
                                                                        'id' => "remove_tags[$keyvalue]",
                                                                        'editclass' => "remove_tags_{$keyvalue}",
                                                                        'value' => $remove_tags ?? '',
                                                                        'name' => __(
                                                                            'Remove Tag(s) (separate by comma)'),
                                                                        'placeholder' => __('Enter tag here'),
                                                                    ])
                                                                </div>

                                                                <div class="col-md-6 fv-row">
                                                                    @include('partials.select', [
                                                                        'multiple' => true,
                                                                        'name' => 'Assign conversation to a group',
                                                                        'id' => 'conversation_groups[$keyvalue]',
                                                                        'placeholder' => 'Select a group',
                                                                        'dataSelected' =>
                                                                            $conversation_groups ?? '',
                                                                        'data' => $groups,
                                                                    ])
                                                                </div>

                                                                <div class="col-md-6 fv-row">
                                                                    @include('partials.select', [
                                                                        'name' => __(
                                                                            'Assign conversation to a user'),
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
                                                            <div class="row g-6 mb-8">
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
                                                            <div class="row g-6 mb-8">
                                                                <div class="col-md-6 fv-row">
                                                                    @include('partials.select', [
                                                                        'name' => __('Action Type'),
                                                                        'id' => "default_button_action[$keyvalue]",
                                                                        'placeholder' => __('Select'),
                                                                        'dataSelected' =>
                                                                            $default_button_action ?? '',
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
                                                        <div class="fv-row">
                                                            <label
                                                                class="form-label fs-6 fw-bold text-gray-700 required">{{ __('Link') }}</label>
                                                            <input class="form-control form-control-solid p-6"
                                                                name="btn_msg_link[{{ $key + 1 }}]"
                                                                placeholder="{{ __('Enter url') }}"
                                                                value="{{ data_get($value, 'urlButton') != false ? data_get($value->urlButton, 'url') : '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="wa-empty py-15 text-center p-10">
                                        <div class="text-center">
                                            <img class="mh-150px mb-7" alt=""
                                                src="{{ asset('backend/Assets/img/empty.png') }}">
                                            <h4 class="text-gray-600 fs-5 fw-semibold">
                                                {{ __('No buttons configured yet') }}</h4>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div
                            class="card-footer bg-light py-6 wa-template-wrap-add text-center {{ count($options) >= 3 ? 'd-none' : '' }}">
                            <button type="button" class="btn btn-primary px-6 fw-bold btn-wa-add-option">
                                <i class="ki-duotone ki-plus fs-2 me-1"></i>{{ __('Add new button') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Form Footer --}}
                <div class="card-footer bg-light py-6 text-end">
                    <button type="submit" class="btn btn-primary fw-bold px-6 b-r-6 py-3">
                        <i class="ki-outline ki-notification-status fs-1"></i> {{ __('Add Button Group') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Button Template (Hidden) --}}
    <template id="button-template">
        <div class="card border b-r-6 mb-6 wa-template-option-item">
            <div class="card-header bg-light-success border-0 py-5">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-4 fw-bold text-gray-800">{{ __('Configure Button') }} <span
                            class="button-number">1</span></h3>
                    <button type="button" class="btn btn-icon btn-sm btn-light-danger button-remove b-r-6">
                        <i class="fad fa-trash-alt"></i>
                    </button>
                </div>
            </div>

            <div class="card-body pt-1 px-8 pb-8">
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-8 fs-6">
                    <li class="nav-item">
                        <label class="nav-link text-active-primary active" data-bs-toggle="tab"
                            data-bs-target="#text-button-{count}">
                            {{ __('Text Button') }}
                        </label>
                        <input class="d-none" type="radio" name="buttons[{count}][type]" value="text" checked>
                    </li>
                    <li class="nav-item">
                        <label class="nav-link text-active-primary" data-bs-toggle="tab"
                            data-bs-target="#link-button-{count}">
                            {{ __('Link Button') }}
                        </label>
                        <input class="d-none" type="radio" name="buttons[{count}][type]" value="link">
                    </li>
                </ul>

                <div class="mb-8">
                    <label class="form-label fs-6 fw-bold text-gray-700 required">{{ __('Button text') }}</label>
                    <input type="text" name="buttons[{count}][text]" class="form-control form-control-solid p-6"
                        placeholder="{{ __('Enter button text') }}" maxlength="25" required>
                    <small class="form-text text-muted">{{ __('max 25 characters allowed') }}</small>
                </div>

                <div class="tab-content">
                    {{-- Text Button Tab --}}
                    <div class="tab-pane fade show active" id="text-button-{count}">
                        <div class="row g-6 mb-8">
                            <div class="col-md-6 fv-row">
                                <label
                                    class="form-label fs-6 fw-bold text-gray-700">{{ __('When user presses the button') }}</label>
                                <select name="buttons[{count}][action_type]"
                                    class="form-select form-select-solid p-6 action-type">
                                    <option value="reply">{{ __('Quick reply') }}</option>
                                    <option value="flow">{{ __('Start a flow') }}</option>
                                    <option value="system">{{ __('System default action') }}</option>
                                </select>
                            </div>
                        </div>

                        {{-- Quick Reply Options --}}
                        <div class="action-section action-reply">
                            <div class="row g-6 mb-8">
                                <div class="col-md-6 fv-row">
                                    <label class="form-label fs-6 fw-bold text-gray-700">{{ __('Add Tags') }}</label>
                                    <input type="text" name="buttons[{count}][add_tags]"
                                        class="form-control form-control-solid p-6"
                                        placeholder="{{ __('Comma separated tags') }}">
                                </div>

                                <div class="col-md-6 fv-row">
                                    <label class="form-label fs-6 fw-bold text-gray-700">{{ __('Remove Tags') }}</label>
                                    <input type="text" name="buttons[{count}][remove_tags]"
                                        class="form-control form-control-solid p-6"
                                        placeholder="{{ __('Comma separated tags') }}">
                                </div>

                                <div class="col-md-6 fv-row">
                                    <label
                                        class="form-label fs-6 fw-bold text-gray-700">{{ __('Assign to Group') }}</label>
                                    <select name="buttons[{count}][group_id]" class="form-select form-select-solid p-6">
                                        <option value="">{{ __('Select group') }}</option>
                                        @foreach ($groups as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 fv-row">
                                    <label
                                        class="form-label fs-6 fw-bold text-gray-700">{{ __('Assign to User') }}</label>
                                    <select name="buttons[{count}][user_id]" class="form-select form-select-solid p-6">
                                        <option value="">{{ __('Select user') }}</option>
                                        @foreach ($users as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 fv-row">
                                    <label class="form-label fs-6 fw-bold text-gray-700">{{ __('Webhook URL') }}</label>
                                    <input type="url" name="buttons[{count}][webhook]"
                                        class="form-control form-control-solid p-6"
                                        placeholder="{{ __('https://example.com/webhook') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Flow Options --}}
                        <div class="action-section action-flow d-none">
                            <div class="row g-6 mb-8">
                                <div class="col-md-6 fv-row">
                                    <label class="form-label fs-6 fw-bold text-gray-700">{{ __('Flow Name') }}</label>
                                    <select name="buttons[{count}][flow_id]" class="form-select form-select-solid p-6">
                                        {{-- Populate with flows --}}
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- System Action Options --}}
                        <div class="action-section action-system d-none">
                            <div class="row g-6 mb-8">
                                <div class="col-md-6 fv-row">
                                    <label class="form-label fs-6 fw-bold text-gray-700">{{ __('Action Type') }}</label>
                                    <select name="buttons[{count}][system_action]"
                                        class="form-select form-select-solid p-6">
                                        <option value="unsubscribe">{{ __('Unsubscribe') }}</option>
                                        <option value="resubscribe">{{ __('Re-subscribe') }}</option>
                                        <option value="human">{{ __('Chat with human') }}</option>
                                        <option value="bot">{{ __('Chat with bot') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Link Button Tab --}}
                    <div class="tab-pane fade" id="link-button-{count}">
                        <div class="fv-row">
                            <label class="form-label fs-6 fw-bold text-gray-700 required">{{ __('Button URL') }}</label>
                            <input type="url" name="buttons[{count}][url]"
                                class="form-control form-control-solid p-6"
                                placeholder="{{ __('https://example.com') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection

@section('js')
    <script>
        var WA_TEMPLATE = `
    <div class="wa-template-data-option">
        <div class="card border b-r-6 mb-8 wa-template-option-item">
            <div class="card-header bg-light-success border-0 py-5">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-4 fw-bold text-gray-800">{{ __('Configure Button') }} {count}</h3>
                    <button type="button" class="btn btn-icon btn-sm btn-light-danger wa-template-option-remove b-r-6">
                        <i class="ki-duotone ki-trash fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                    </button>
                </div>
            </div>
            <div class="card-body pt-1 px-8 pb-8">
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-8 fs-6" id=" -tab">
                    <li class="nav-item">
                        <label for="btn_type_text_{count}"
                            class="nav-link active text-active-primary"
                            data-bs-toggle="tab" data-bs-target="#nav_btn_type_text_{count}" type="button"
                            role="tab">{{ __('Text & Action Button') }}</label>
                        <input class="d-none" type="radio" name="btn_msg_type[{count}]" id="btn_type_text_{count}"
                            checked="true" value="1">
                    </li>
                    <li class="nav-item">
                        <label for="btn_type_link_{count}"
                            class="nav-link text-active-primary"
                            data-bs-toggle="tab" data-bs-target="#nav_btn_type_link_{count}" type="button"
                            role="tab">{{ __('CTA - Link Button') }}</label>
                        <input class="d-none" type="radio" name="btn_msg_type[{count}]" id="btn_type_link_{count}"
                            value="2">
                    </li>
                </ul>

                <div class="mb-8">
                    <label class="form-label fs-6 fw-bold text-gray-700 required">{{ __('Button text') }}</label>
                    <input type="text" name="btn_msg_display_text[{count}]"
                        class="form-control form-control-solid btn_msg_display_text_{count} p-6" maxlength="25"
                        placeholder="{{ __('Enter button text') }}" required>
                    <small class="form-text text-muted">{{ __('max 25 characters allowed') }}</small>
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
                <div class="tab-pane fade mb-8" id="nav_btn_type_link_{count}" role="tabpanel">
                    <div class="fv-row">
                        <label class="form-label fs-6 fw-bold text-gray-700 required">{{ __('Link') }}</label>
                        <input class="form-control form-control-solid p-6" name="btn_msg_link[{count}]"
                            placeholder="{{ __('Enter your url') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>`;
    </script>
    <script>
        function selectChangeFun2(id, sectionID) {
            var e = document.getElementById(id);
            var value = e.value;
            var selectedIndex = e.selectedIndex;

            @if ($button_count != 0)
                selectedIndex = selectedIndex + 1;
            @endif

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
    <script src="{{ asset('backend/Assets/js/whatsapp.js') }}"></script>
@endsection
