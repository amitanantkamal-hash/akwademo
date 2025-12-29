<x-auth-layout>
    <style>
        .alert-success {
            color: #121211;
            border-color: #65e792;
            background-color: #65e792;
        }
    </style>
    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
        <form class="form w-100" novalidate="novalidate" id="gomint_sign_up_form" action="{{ route('register.store') }}">

            <div class="text-center mb-11">
                <h1 class="text-dark fw-bolder mb-3">{{ __('Sign Up') }}</h1>

                <div class="text-gray-500 fw-semibold fs-6">
                    {{ __('Create your account and take control of your WhatsApp automation') }}</div>

            </div>
            @if (config('settings.enable_login_as_company', true))
                @include('auth.social')
            @endif
            <div class="fv-row mb-6">
                <input type="text" placeholder="{{ __('Fullname') }}" name="name" autocomplete="off"
                    class="form-control bg-transparent" />
            </div>
            <div class="fv-row mb-6">
                <input type="text" placeholder="{{ __('Email address') }}" name="email" autocomplete="off"
                    class="form-control bg-transparent" />

            </div>
            <div class="fv-row mb-6 d-flex align-items-center">
                <x-authentication-mt-input id="phone" type="text" name="phone" :value="old('phone')" required
                    autocomplete="phone" />

                <span><i class="ki-duotone ki-whatsapp fs-2x mx-4 ki-graph-up text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i></span>
            </div>
            <input type="hidden" id="country_code" name="country_code" value="" />

            <div class="fv-row mb-6" data-gomint-password-meter="true">
                <div class="mb-1">
                    <div class="position-relative mb-3">
                        <input class="form-control bg-transparent" type="password" placeholder="{{ __('Password') }}"
                            name="password" autocomplete="off" />
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                            data-gomint-password-meter-control="visibility">
                            <i class="bi bi-eye-slash fs-2"></i>
                            <i class="bi bi-eye fs-2 d-none"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center mb-3" data-gomint-password-meter-control="highlight">
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                    </div>
                </div>
                <div class="text-muted">{{ __('Use 8 or more characters with a mix of letters, numbers & symbols') }}
                </div>

            </div>
            <div class="mb-6 fv-row" data-gomint-password-meter="true">
                <div class="mb-1">
                    <div class="position-relative mb-3">
                        <input placeholder="{{ __('Confirm password') }}" name="password_confirmation" type="password"
                            autocomplete="off" class="form-control bg-transparent" />

                    </div>
                </div>
            </div>

            <div class="fv-row mb-6">
                <x-authentication-mt-input type="text" placeholder="{{ __('Company Name') }}" name="name_company"
                    :value="old('name_company')" autofocus required autocomplete="name_company" />
            </div>
            {{-- <div class="fv-row mb-8">
                <select name="timezone" aria-label="{{ __('Select a Timezone') }}" data-control="select2"
                    data-placeholder="{{ __('Select a timezone..') }}"
                    class="form-control bg-transparent form-select-lg">
                    @foreach (timezone_identifiers_list() as $timezone)
                        <option value="{{ $timezone }}"{{ $timezone == old('timezone') ? ' selected' : 'Asia' }}>
                            {{ $timezone }}</option>
                    @endforeach
                </select>
            </div> --}}
            <!--end::Input group-->
            <!--begin::Google Recaptcha=-->
            {{-- @if (config('settings.google_recaptcha_status', true))
                <div class="g-recaptcha  mb-3" data-sitekey="{{ config('settings.google_recaptcha_status') }}"></div>
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            @endif --}}
            <!--begin::Accept-->
            {{-- @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature()) --}}
            {{-- <div class="fv-row mb-8">
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="toc" value="1" />
                    <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">{{ __('I agree to the') }}
                        <a href="{{ config('settings.terms_of_service_url', '') }}"
                            class="ms-1 link-danger">{{ __('Terms of Service') }}</a> {{ __('and') }}
                        <a href="{{ config('settings.privacy_policy_url', '') }}"
                            class="ms-1 link-danger">{{ __('Privacy Policy') }}</a>.</span>
                </label>
            </div> --}}
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="fv-row mb-8">
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="terms" checked="checked" required>

                        <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
                            {!! __('I have read and agree to the :term-conditions and the :privacy-policy of this website.', [
                                'term-conditions' =>
                                    '<a target="_blank" href="' .
                                    route('terms-conditions') .
                                    '" class="d-inline-block color-success">' .
                                    __('Terms & Conditions') .
                                    '</a>',
                                'privacy-policy' =>
                                    '<a target="_blank" href="' .
                                    route('privacy-policy') .
                                    '" class="d-inline-block color-success">' .
                                    __('Privacy Policy') .
                                    '</a>',
                            ]) !!}
                            {{-- I have read and agree to the Terms & Conditions and the Privacy
                            Policy of this website. --}}
                        </span><span class="checkmark"></span>
                    </label>
                </div>
            @endif
            <div class="fv-row mb-8">
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="is_optin" checked="checked">

                    <span
                        class="form-check-label fw-semibold text-gray-700 fs-base ms-1">{{ __('I want to receive design
                                                inspiration and product
                                                updates. (No spam. You can opt-out anytime.)') }}</span><span
                        class="checkmark"></span>
                </label>
            </div>
            <div class="d-grid mb-10">
                <button type="submit" id="gomint_sign_up_submit" class="btn btn-info">
                    <span class="indicator-label">{{ __('Sign up') }}</span>
                    <span class="indicator-progress">{{ __('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>

                </button>
            </div>
            <div class="text-center fw-semibold fs-6"><span
                    class="text-gray-500 ">{{ __('Already have an Account?') }}</span>
                <a href="{{ route('login') }}" class="text-info fw-semibold">{{ __('Sign in') }}</a>
            </div>
        </form>
    </div>

    <script>
        const input = document.querySelector("#phone");
        const country_code = document.querySelector("#country_code");
        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            separateDialCode: true,
            geoIpLookup: callback => {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            },
            utilsScript: "{{ asset('vendor/IntlTelInput/utils.js') }}",
        });
        input.addEventListener("countrychange", function() {
            country_code.value = iti.getSelectedCountryData().dialCode;
        });
    </script>
</x-auth-layout>
