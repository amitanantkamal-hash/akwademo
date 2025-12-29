@extends('general.index', $setup)

@section('head')
    <link rel="stylesheet" href="{{ asset('custom/whatsapp-flows/css/new_css.css?v=1.0.1') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('custom/whatsapp-flows/js/include_head.js') }}"></script>
@endsection

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <style>
        .form-wrap.form-builder .frmb li.form-field {
            position: relative;
            padding: 6px;
            clear: both;
            margin-left: 0;
            margin-bottom: 3px;
            background-color: var(--form-field-background-color);
            /* Use the theme-based variable */
            transition: background-color 250ms ease-in-out, margin-top 400ms;
        }

        .form-wrap.form-builder .frmb-control li {
            background-color: var(--form-field-background-color);
        }
    </style>
    <section class="section container-xxl">
        <div class="card">
            <div class="card-body data-card">
                <div class="page-title">
                    <div class="alert alert-dismissible bg-light-success border border-primary border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10"
                        bis_skin_checked="1">

                        <i class="ki-duotone ki-whatsapp fs-2hx text-primary me-4 mb-5 mb-sm-0"><span
                                class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <div class="d-flex flex-column pe-0 pe-sm-10" bis_skin_checked="1">
                            <h5 class="mb-1">{{ __('Whatsapp Flows') }}</h5>
                            <span>{{ __('When utilising template flow, you are responsible for
                                                                                                                                                customising the experience to suit your use case, adhering to applicable laws and complying
                                                                                                                                                with WhatsApp Business Messaging Policy. Learn more about templates.') }}</span>
                        </div>
                        <button type="button"
                            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                            data-bs-dismiss="alert">
                            <i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </button>
                    </div>
                    {{-- <div class="row">
                        <div class="col-12 col-md-12 order-md-1 order-last">
                            <h3>Whatsapp Flows</h3>
                            <p class="text-subtitle text-muted">When utilising template flow, you are responsible for
                                customising the experience to suit your use case, adhering to applicable laws and complying
                                with WhatsApp Business Messaging Policy. Learn more about templates.</p>
                        </div>
                    </div> --}}
                </div>
                <form class="form form-vertical" enctype="multipart/form-data" method="POST" action="">
                    <input type="hidden" name="csrf_token" id="csrf_token"value="{{ csrf_token() }}">
                    <div class="form-group text-left d-flex justify-content-left flex-column py-4">
                        <input type="hidden" id="default_form_data" value="">
                        <div class="row">
                            <input type="hidden" id="flow_update_id" value="0">
                            <div class="col-6 col-md-6">
                                <div
                                    class="form-group mt-2 mt-sm-2 ms-sm-0 mt-md-2 ms-md-0 mt-lg-2 ms-lg-0 mt-xl-2 ms-xl-0 w-100">
                                    <label class="control-label required" for="">Name</label>
                                    <a href="#" data-bs-placement="top" data-bs-toggle="popover" data-trigger="focus"
                                        title="Unique name of your whatsapp flows"><i class='fa fa-info-circle'></i>
                                    </a>
                                    <div class="input-group">
                                        <input name="flow_name" id="flow_name" value="" class="form-control" required
                                            type="text" placeholder="Any name to identify it later">
                                    </div>
                                </div>
                            </div>


                            <div class="col-6 col-md-6">
                                <div
                                    class="form-group mt-2 mt-sm-2 ms-sm-0 mt-md-2 ms-md-0 mt-lg-2 ms-lg-0 mt-xl-2 ms-xl-0 w-100">
                                    <label class="control-label required">
                                        {{ __('Flow Title') }}
                                    </label>
                                    <a href="#" data-bs-placement="top" data-bs-toggle="popover"
                                        data-bs-trigger="focus" title="Title of your whatsapp flows"><i
                                            class='fa fa-info-circle'></i>
                                    </a>
                                    <input name="form_title" id="form_title" class="form-control" type="text"
                                        placeholder="Title Whatsapp flow" required value="">
                                </div>
                            </div>

                            <div class="col-6 col-md-6">
                                <div
                                    class="form-group mt-2 mt-sm-2 ms-sm-0 mt-md-2 ms-md-0 mt-lg-2 ms-lg-0 mt-xl-2 ms-xl-0 w-100">
                                    <label class="control-label required">
                                        {{ __('Screen Unique Name') }}
                                    </label>
                                    <a href="#" data-bs-placement="top" data-bs-toggle="popover"
                                        data-bs-trigger="focus"
                                        title="{{ __('The screen name must be unique, contain no spaces, and should not include any numeric characters') }}"><i
                                            class='fa fa-info-circle'></i> </a>
                                    <input name="optin_form_name" id="optin_form_name"
                                        placeholder="{{ __('Screen Unique Name') }}" class="form-control" required
                                        type="text" value="" oninput="sanitizeAlphabetInput(event)">
                                </div>

                            </div>
                            <div class="col-6 col-md-6">
                                <div
                                    class="form-group mt-2 mt-sm-2 ms-sm-0 mt-md-2 ms-md-0 mt-lg-2 ms-lg-0 mt-xl-2 ms-xl-0 w-100">
                                    <label class="control-label required">
                                        {{ __('Categories') }}
                                    </label>
                                    <a href="#" data-bs-placement="top" data-bs-toggle="popover"
                                        data-bs-trigger="focus" title="Choose Chategories"><i class='fa fa-info-circle'></i>
                                    </a>
                                    <div><select class="form-control select2" id="whatsapp_flow_category"
                                            multiple="multiple" style="width:100% !important;"
                                            name="whatsapp_flow_category">
                                            <option value="SIGN_UP">SIGN_UP</option>
                                            <option value="SIGN_IN">SIGN_IN</option>
                                            <option value="APPOINTMENT_BOOKING">APPOINTMENT_BOOKING</option>
                                            <option value="LEAD_GENERATION">LEAD_GENERATION</option>
                                            <option value="CONTACT_US">CONTACT_US</option>
                                            <option value="CUSTOMER_SUPPORT">CUSTOMER_SUPPORT</option>
                                            <option value="SURVEY">SURVEY</option>
                                            <option value="OTHER">OTHER</option>
                                        </select></div>
                                </div>
                            </div>
                            {{-- <div class="col-6 col-md-6 px-2">
                                <div class="form-group">
                                    <label style="width:100%">
                                        After flow submittion* <a href="{{}}" data-placement="top"
                                            data-toggle="popover" data-trigger="focus" title="Choose Reply"><i
                                                class='fa fa-info-circle'></i> </a>
                                    </label>
                                    <div id="post_back_dropdown"><select class="form-control"
                                            id="whatsapp_bot_post_back"
                                            name="whatsapp_bot_post_back">
                                            <option value="0">Please select reply message</option>
                                        </select></div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </form>
                <div class="row px-2">
                    <div class="col-md-12">
                        <div id="optin-form-builder" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('topjs')
    <script src="{{ asset('custom/whatsapp-flows/js/redesigned.js') }}"></script>
    <script src="{{ asset('custom/whatsapp-flows/js/jquery.nicescroll.min.js') }}"></script>

    <script type="text/javascript">
        "use strict"
        var default_form_data = [];

        var whatsapp_flows_lang_settings = 'Whatsapp Flows';
        var global_lang_save = 'Save';
        var global_lang_ok = 'OK';
        var global_lang_success = 'Success';
        var global_lang_warning = 'Warning';
        var global_lang_error = 'Error';
        var global_lang_remove = 'Remove';
        var global_lang_confirm = 'Confirm';
        var optin_form_lang_forget_submit_button = 'You forgot to choose a button field';
        var optin_form_lang_textarea_lenght_check = 'Your textrea field label name  must be between 20 characters';
        var optin_form_lang_checkbox_group_length_check = 'Your checkbox field label name  must be between 30 characters';
        var optin_form_lang_select_group_length_check = 'Your select field label name  must be between 30 characters';
        var optin_form_lang_radio_group_length_check = 'Your radio field label name  must be between 30 characters';
        var optin_form_lang_checkbox_group_option_check = 'Your checkbox field option name or value can not be empty';
        var optin_form_lang_select_group_option_check = 'Your select field option name value or can not be empty';
        var optin_form_lang_radio_group_option_check = 'Your radio field option name value can or not be empty';
        var optin_form_lang_screein_id_validate =
            'The Screen Unique name must be unique, should only consist of alphabets and underscores i.e: flow_title_name_example';
        var global_lang_delete_confirmation =
            'Do you really want to delete this record? This action cannot be undone and will delete any other related data if needed.';
        var global_lang_remove_confirmation =
            'Do you really want to remove this record? This will only remove the data from our system.';
        var global_lang_saved_successfully = 'Data has been saved successfully.';
        var global_lang_deleted_successfully = 'Data has been deleted successfully.';
        var global_lang_removed_successfully = 'Data has been removed successfully.';
        var global_lang_fill_required_fields = 'Please fill the required fields.';

        var subscribers_followup = [];
        var subscribers_previous_followup_list = [];
        var progress_gif = '{{ asset('custom/whatsapp-flows/imgs/progress.gif') }}';

        var whatsapp_flows_optin_save_form_data = '{{ route('whatsapp-flows.store') }}';
        var whatsapp_flow_list = '{{ route('whatsapp-flows.index') }}';
        var whatsapp_create_flows = '';

        var areWeUsingScroll = true;
    </script>
    <script>
        function sanitizeAlphabetInput(event) {
            const input = event.target;
            const cursorPosition = input.selectionStart; // Save cursor position
            const originalValue = input.value;

            // Remove non-alphabetic characters
            const sanitizedValue = originalValue.replace(/[^A-Za-z]/g, '');

            // Update value only if changes are needed
            if (sanitizedValue !== originalValue) {
                input.value = sanitizedValue;

                // Adjust cursor position (accounts for removed characters)
                const adjustedPosition = cursorPosition - (originalValue.length - sanitizedValue.length);
                input.setSelectionRange(adjustedPosition, adjustedPosition);
            }
        }
    </script>
    <script src="{{ asset('custom/whatsapp-flows/js/whatsapp-list.js') }}"></script>
    <script src="{{ asset('custom/whatsapp-flows/js/whatsapp-flow-builder.js') }}"></script>
    <script src="{{ asset('custom/whatsapp-flows/js/common.js') }}"></script>
    <script src="{{ asset('custom/whatsapp-flows/js/include.js') }}"></script>
@endsection
