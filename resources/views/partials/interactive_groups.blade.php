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
    <label class="form-label mb-2" for="btn_msg_4">{{ __('Bot reply with') }}</label>
    <ul class="nav nav-pills mb-3 bg-white rounded fs-14 nx-scroll overflow-x-auto d-flex text-over b-r-6 border"
        id="pills-tab">
        <li class="nav-item me-0">
            <label for="type_text_media"
                class="nav-link bg-active-info text-gray-700 px-4 py-3 b-r-6 text-active-white @if ($interactive_id == 1) active @endif"
                data-bs-toggle="pill" data-bs-target="#wa_text_and_media" type="button"
                role="tab">{{ __('Text only') }}</label>
            <input class="d-none" type="radio" name="action_type_radio" id="type_text_media" @if ($interactive_id == 1) checked='true' @endif
                value="1">
        </li>
        <li class="nav-item me-0">
            <label for="type_button" class="nav-link bg-active-info text-gray-700 px-4 py-3 b-r-6 text-active-white @if ($interactive_id == 2) active @endif"
                data-bs-toggle="pill" data-bs-target="#wa_button" type="button"
                role="tab">{{ __('Buttons') }}</label>
            <input class="d-none" type="radio" name="action_type_radio" id="type_button" value="2" @if ($interactive_id == 2) checked='true' @endif>
        </li>
        <li class="nav-item me-0">
            <label for="type_template" class="nav-link bg-active-info text-gray-700 px-4 py-3 b-r-6 text-active-white @if ($interactive_id == 3) active @endif"
                data-bs-toggle="pill" data-bs-target="#wa_list_message" type="button"
                role="tab">{{ __('List buttons') }}</label>
            <input class="d-none" type="radio" name="action_type_radio" id="type_template" value="3" @if ($interactive_id == 3) checked='true' @endif>
        </li>
    </ul>
    <div class="tab-content pt-3" id="nav-tabContent">
        <div class="tab-pane fade show @if ($interactive_id == 1) active @endif" id="wa_text_and_media"
            role="tabpanel">
        </div>
        <div class="tab-pane fade show @if ($interactive_id == 2) active @endif" id="wa_button" role="tabpanel">
            @include('partials.interactive_buttongroups')
        </div>
        <div class="tab-pane fade show @if ($interactive_id == 3) active @endif" id="wa_list_message" role="tabpanel">
            @include('partials.interactive_listbuttongroups')
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        Core.select2();
    });
</script>
