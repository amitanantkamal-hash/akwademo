<x-guest-layout>

  <link rel="stylesheet" href="{{ asset('vendor/IntlTelInput/intlTelInput.css') }}">
  <script src="{{ asset('vendor/IntlTelInput/intlTelInput.min.js') }}"></script>

  <div class="d-flex flex-column flex-lg-row flex-column-fluid">

      <x-authentication-mt-aside />

      <x-authentication-mt-card>

          <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" method="POST"
              action="{{ route('register') }}">
              @csrf

              <!--begin::Heading-->
              <div class="text-center mb-2">
                  <!--begin::Title-->
                  <h1 class="text-gray-900 fw-bolder mb-0">
                      {{ __('Start Your Free Trial') }}
                  </h1>
                  <!--end::Title-->
              </div>

              @if (config('settings.enable_login_as_company', true))
              <div class="text-center mb-3">
                  <!--begin::Subtitle-->
                  <div class="text-gray-500 fw-semibold fs-6">
                      {{__('No limits, you can cancel anytime')}}
                  </div>
                  <!--end::Subtitle--->
              </div>
                  @include('auth.social-mt')
              @endif

              <x-authentication-mt-validation-errors class="mb-4" />

              <div class="fv-row mb-4">
                  <!--begin::Name-->
                  <x-authentication-mt-input type="text" placeholder="{{ __('Name') }}" name="name"
                      :value="old('name')" autofocus required autocomplete="name" />
                  <!--end::Name-->
              </div>

              <div class="fv-row mb-4">
                  <!--begin::Email-->
                  <x-authentication-mt-input type="text" placeholder="{{ __('Email') }}" name="email"
                      :value="old('email')" required autocomplete="username" />
                  <!--end::Email-->
              </div>

              <div class="fv-row mb-4 d-flex align-items-center">
                  <!--begin::Phone-->
                  <span><i class="ki-duotone ki-whatsapp fs-2x mx-4 ki-graph-up text-primary">
                          <span class="path1"></span>
                          <span class="path2"></span>
                      </i></span>
                  <x-authentication-mt-input id="phone" type="text" name="phone" :value="old('phone')" required
                      autocomplete="phone" />
                  <!--end::Phone-->
              </div>
              <!-- Hidden Country Code -->
              <input type="hidden" id="country_code" name="country_code" value="" />

              <div class="fv-row mb-4">
                  <!--begin::Company Name-->
                  <x-authentication-mt-input type="text" placeholder="{{ __('Company Name') }}" name="name_company"
                      :value="old('name_company')" autofocus required autocomplete="name_company" />
                  <!--end::Company Name-->
              </div>

              <div class="fv-row mb-4" data-kt-password-meter="true">
                  <!--begin::Wrapper-->
                  <div class="mb-1">
                      <!--begin::Input wrapper-->
                      <div class="position-relative mb-3">

                          <x-authentication-mt-input id="password" type="password" placeholder="{{ __('Password') }}"
                              name="password" autocomplete="new-password" />
                          <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                              data-kt-password-meter-control="visibility">
                              <i class="ki-outline ki-eye-slash fs-2"></i>
                              <i class="ki-outline ki-eye fs-2 d-none"></i>
                          </span>
                      </div>
                      <!--end::Input wrapper-->
                      <!--begin::Meter-->
                      <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                          <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                          <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                          <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                          <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                      </div>
                      <!--end::Meter-->
                  </div>
                  <!--end::Wrapper-->
                  <!--begin::Hint-->
                  {{-- <div class="text-muted">{{ __('Use 8 or more characters with a mix of letters, numbers & symbols.') }}</div> --}}
                  <!--end::Hint-->
              </div>

              <div class="fv-row mb-5">
                  <!--begin::Password Confirmation-->
                  <x-authentication-mt-input id="password_confirmation" type="password"
                      placeholder="{{ __('Confirm Password') }}" name="password_confirmation"
                      autocomplete="new-password" />
                  <!--end::Password Confirmation-->
              </div>

              @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                  <x-authentication-mt-register-checkbox />
              @endif

              <div class="d-grid mb-6">
                  <x-authentication-mt-button>
                      {{ __('Register') }}
                  </x-authentication-mt-button>
              </div>

              <div class="text-gray-500 text-center fw-semibold fs-6">
                  {{ __('Already registered?') }}

                  <a href="{{ route('login') }}" class="link-primary fw-semibold">
                      {{ __('Sign In') }}
                  </a>
              </div>
          </form>

          <x-slot name="languages">
              <x-dropdown-language />
          </x-slot>
      </x-authentication-mt-card>
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
</x-guest-layout>
