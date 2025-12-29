<x-auth-layout>
    <style>
        .alert-success {
            color: #121211;
            border-color: #65e792;
            background-color: #65e792;
        }
    </style>
    <div class="d-flex flex-center flex-column flex-lg-row-fluid">

        <div class="w-lg-500px p-10">

            <form class="form w-100 mb-13" novalidate="novalidate" data-gomint-redirect-url="{{ route('dashboard') }}"
                id="gomint_sing_in_two_factor_form">

                <div class="text-center mb-10">
                    <img alt="Logo" class="mh-200px" src="{{ asset('backend/Assets/img/otp_screen.svg') }}" />
                </div>

                <div class="text-center mb-10">
                    <h1 class="text-gray-900 mb-3">
                        Two-Factor Verification
                    </h1>
                    <div class="text-muted fw-semibold fs-5 mb-5">Check your whatsapp we have sent you OTP at</div>
                    <div class="fw-bold text-gray-900 fs-3">
                        <span id="phoneDisplay">
                            {{ isset(auth()->user()->phone)
                                ? str_repeat('*', max(0, strlen(auth()->user()->phone) - 6)) . substr(auth()->user()->phone, -6)
                                : '' }}

                        </span>
                    </div>

                </div>

                <div class="col-lg-12 col-sm-12 alertMessage"></div>
                <div class="mb-10">
                    <div class="fw-bold text-center text-gray-900 fs-6 mb-1 ms-1">Type your 6 digit security code
                    </div>
                    <div class="d-flex flex-wrap flex-stack">
                        <input type="text" name="code_1" data-inputmask="'mask': '9', 'placeholder': ''"
                            maxlength="1"
                            class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
                            value="" />
                        <input type="text" name="code_2" data-inputmask="'mask': '9', 'placeholder': ''"
                            maxlength="1"
                            class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
                            value="" />
                        <input type="text" name="code_3" data-inputmask="'mask': '9', 'placeholder': ''"
                            maxlength="1"
                            class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
                            value="" />
                        <input type="text" name="code_4" data-inputmask="'mask': '9', 'placeholder': ''"
                            maxlength="1"
                            class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
                            value="" />
                        <input type="text" name="code_5" data-inputmask="'mask': '9', 'placeholder': ''"
                            maxlength="1"
                            class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
                            value="" />
                        <input type="text" name="code_6" data-inputmask="'mask': '9', 'placeholder': ''"
                            maxlength="1"
                            class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
                            value="" />
                    </div>
                </div>
                <div class="d-flex flex-center">
                    <button type="button" id="gomint_sing_in_two_factor_submit" class="btn btn-info fw-bold">
                        <span class="indicator-label">
                            {{ __('Verify OTP') }}
                        </span>
                        <span class="indicator-progress">
                            {{ __('Please wait...') }} <span
                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>


            <div class="text-center fw-semibold fs-5">
                <span class="text-muted me-1">Didn’t get the code ?</span>

                <span class="d-inline-block align-middle font-sm color-grey-500" id="otp-text">
                    Resend OTP in
                </span>
                <span id="countdown" class="text-info">1:30</span>
                <a id="resend-otp-button" class="ml-3 resend-otp d-none" onclick="resendOtp()" type="button">
                    {{ __('Resend OTP') }}
                    <span id="resend-loader" style="display:none;">⏳</span>
                </a>
                {{-- <span class="text-muted me-1">or</span> --}}
                {{-- <a href="#" class="link-info fs-5">Call Us</a> --}}
            </div>
            <div class="text-center mt-2 fs-6">
                <span id="changeNumberText" onclick="openChangeModal()"
                    style="font-weight: bold; color: rgb(104, 102, 102); cursor: pointer;">Change
                    number</span>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeNumberModal" tabindex="-1" aria-labelledby="changeNumberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeNumberModalLabel">Change Phone Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alertMessageModel"></div>
                    <input type="tel" id="new-phone" class="form-control" placeholder="Enter New Phone Number">

                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-info" data-bs-dismiss="modal">Cancel</button> --}}
                    <button class="btn btn-info" onclick="updatePhone()">Update & Resend OTP</button>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
