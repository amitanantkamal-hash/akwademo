@extends('client.app')

@section('content')
    <div>
        <div id="kt_app_content_container" class="container-fluid ">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100 mb-8">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Account Settings
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="/metronic8/demo38/index.html" class="text-muted text-hover-primary">
                                My Profile </a>
                        </li>

                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="#"
                        class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold"
                        data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                        Add Contact
                    </a>

                    <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_create_campaign">
                        New Campaign
                    </a>
                </div>
                <!--end::Actions-->
            </div>

            <div class="card mb-6">
                @include('profile.components.card-header')
            </div>
            <div class="card  mb-5 mb-xl-10">
                <!--begin::Card body-->
                <div class="card-body">
                    
            <!--begin::Notice-->
            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-12 p-6">
                        <!--begin::Icon-->
                    <i class="ki-duotone ki-information fs-2tx text-warning me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>        <!--end::Icon-->
                
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack flex-grow-1 ">
                                <!--begin::Content-->
                        <div class=" fw-semibold">
                                                <h4 class="text-gray-900 fw-bold">We need your attention!</h4>
                            
                                                <div class="fs-6 text-gray-700 ">Your payment was declined. To start using tools, please <a href="#" class="fw-bold"  data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">Add Payment Method</a>.</div>
                                        </div>
                        <!--end::Content-->
                    
                        </div>
                <!--end::Wrapper-->  
            </div>
            <!--end::Notice-->
            
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-lg-7">
                            <!--begin::Heading-->
                            <h3 class="mb-2">Active until Dec 09, 2024</h3>
                            <p class="fs-6 text-gray-600 fw-semibold mb-6 mb-lg-15">We will send you a notification upon Subscription expiration </p>
                            <!--end::Heading-->
            
                            <!--begin::Info-->
                            <div class="fs-5 mb-2">
                                <span class="text-gray-800 fw-bold me-1">$24.99</span> 
                                <span class="text-gray-600 fw-semibold">Per Month</span>
                            </div>
                            <!--end::Info-->
            
                            <!--begin::Notice-->
                            <div class="fs-6 text-gray-600 fw-semibold">
                                Extended Pro Package. Up to 100 Agents & 25 Projects
                            </div>
                            <!--end::Notice-->
                        </div>
                        <!--end::Col-->
            
                        <!--begin::Col-->
                        <div class="col-lg-5">
                            <!--begin::Heading-->
                            <div class="d-flex text-muted fw-bold fs-5 mb-3">
                                <span class="flex-grow-1 text-gray-800">Users</span>
                                <span class="text-gray-800">86 of 100 Used</span>
                            </div>
                            <!--end::Heading-->
            
                            <!--begin::Progress-->
                            <div class="progress h-8px bg-light-primary mb-2">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 86%" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <!--end::Progress-->
            
                            <!--begin::Description-->
                            <div class="fs-6 text-gray-600 fw-semibold mb-10">14 Users remaining until your plan requires update</div>
                            <!--end::Description-->
            
                            <!--begin::Action-->
                            <div class="d-flex justify-content-end pb-0 px-0">
                                <a href="#" class="btn btn-light btn-active-light-primary me-2" id="kt_account_billing_cancel_subscription_btn">Cancel Subscription</a>
                                <a href="{{route('available.plans')}}"><button class="btn btn-info" ">Upgrade Plan</button></a>
                            </div>
                            <!--end::Action-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Billing Summary-->
            <div class="card-footer">
                @include('profile.components.card-footer')
            </div>

            {{-- Modals --}}
            <div class="modal fade" tabindex="-1" id="kt_modal_enable_factor">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h2 class="modal-title">{{ __('Two Factor Authentication') }}</h3>
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="ki-outline ki-cross fs-1"></i>
                                </div>
                        </div>
                        <div class="modal-body scroll-y pt-10 pb-15 px-lg-17">
                            <div data-kt-element="options">
                                <p class="text-muted fs-5 fw-semibold mb-10">
                                    In addition to your username and password, you’ll have to enter a code (delivered
                                    via app or
                                    SMS) to log into your account.
                                </p>
                                <div class="pb-10">
                                    <input type="radio" class="btn-check" name="auth_option" value="apps"
                                        checked="checked" id="kt_modal_two_factor_authentication_option_1">
                                    <label
                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                                        for="kt_modal_two_factor_authentication_option_1">
                                        <i class="ki-outline ki-setting-2 fs-4x me-4"></i>
                                        <span class="d-block fw-semibold text-start">
                                            <span class="text-gray-900 fw-bold d-block fs-3">Authenticator Apps</span>
                                            <span class="text-muted fw-semibold fs-6">
                                                Get codes from an app like Google Authenticator, Microsoft
                                                Authenticator, Authy
                                                or 1Password.
                                            </span>
                                        </span>
                                    </label>
                                    <input type="radio" class="btn-check" name="auth_option" value="sms"
                                        id="kt_modal_two_factor_authentication_option_2">
                                    <label
                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center"
                                        for="kt_modal_two_factor_authentication_option_2">
                                        <i class="ki-outline ki-message-text-2 fs-4x me-4"></i>
                                        <span class="d-block fw-semibold text-start">
                                            <span class="text-gray-900 fw-bold d-block fs-3">SMS</span>
                                            <span class="text-muted fw-semibold fs-6">We will send a code via SMS if
                                                you need
                                                to use your backup login method.</span>
                                        </span>
                                    </label>
                                </div>
                                <button class="btn btn-info w-100" data-kt-element="options-select">Continue</button>
                            </div>
                            <div class="d-none" data-kt-element="apps">
                                <h3 class="text-gray-900 fw-bold mb-7">
                                    Authenticator Apps
                                </h3>
                                <div class="text-gray-500 fw-semibold fs-6 mb-10">
                                    Using an authenticator app like
                                    <a href="https://support.google.com/accounts/answer/1066447?hl=en"
                                        target="_blank">Google
                                        Authenticator</a>,
                                    <a href="https://www.microsoft.com/en-us/account/authenticator"
                                        target="_blank">Microsoft
                                        Authenticator</a>,
                                    <a href="https://authy.com/download/" target="_blank">Authy</a>, or
                                    <a href="https://support.1password.com/one-time-passwords/"
                                        target="_blank">1Password</a>,
                                    scan the QR code. It will generate a 6 digit code for you to enter below.
                                    <div class="pt-5 text-center">
                                        <img src="/metronic8/demo38/assets/media/misc/qr.png" alt=""
                                            class="mw-150px">
                                    </div>
                                </div>
                                <div
                                    class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-10 p-6">
                                    <i class="ki-outline ki-information fs-2tx text-warning me-4"></i>
                                    <div class="d-flex flex-stack flex-grow-1 ">
                                        <div class=" fw-semibold">
                                            <div class="fs-6 text-gray-700 ">If you having trouble using the QR code,
                                                select
                                                manual entry on your app, and enter your username and the code: <div
                                                    class="fw-bold text-gray-900 pt-2">KBSS3QDAAFUMCBY63YCKI5WSSVACUMPN
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form data-kt-element="apps-form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                    action="#">
                                    <div class="mb-10 fv-row fv-plugins-icon-container">
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            placeholder="Enter authentication code" name="code">
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-center">
                                        <button type="reset" data-kt-element="apps-cancel" class="btn btn-light me-3">
                                            Cancel
                                        </button>
                                        <button type="submit" data-kt-element="apps-submit" class="btn btn-info">
                                            <span class="indicator-label">
                                                Submit
                                            </span>
                                            <span class="indicator-progress">
                                                Please wait... <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="d-none" data-kt-element="sms">
                                <h3 class="text-gray-900 fw-bold fs-3 mb-5">
                                    SMS: Verify Your Mobile Number
                                </h3>
                                <div class="text-muted fw-semibold mb-10">
                                    Enter your mobile phone number with country code and we will send you a verification
                                    code
                                    upon request.
                                </div>
                                <form data-kt-element="sms-form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                    action="#">
                                    <div class="mb-10 fv-row fv-plugins-icon-container">
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            placeholder="Mobile number with country code..." name="mobile">
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-center">
                                        <button type="reset" data-kt-element="sms-cancel" class="btn btn-light me-3">
                                            Cancel
                                        </button>
                                        <button type="submit" data-kt-element="sms-submit" class="btn btn-info">
                                            <span class="indicator-label">
                                                Submit
                                            </span>
                                            <span class="indicator-progress">
                                                Please wait... <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
