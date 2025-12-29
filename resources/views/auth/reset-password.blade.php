<x-guest-layout>

    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        <x-authentication-mt-aside/>


        <x-authentication-mt-card>

            <form class="form w-100" novalidate="novalidate" id="kt_new_password_form"  method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="text-center mb-10">

                    <h1 class="text-gray-900 fw-bolder mb-3">{{ __('Setup New Password')}}</h1>

                    <div class="text-gray-500 fw-semibold fs-6">{{ __('Have you already reset the password?')}}
                    <a href="{{ route('login') }}" class="link-primary fw-bold">{{ __('Sign In')}}</a></div>

                </div>


                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <x-authentication-mt-validation-errors class="mb-4" />


                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!--begin::Input group--->
                <div class="fv-row mb-8">
                    <!--begin::Email-->
                    <x-authentication-mt-input type="text" placeholder="{{ __('Email') }}" name="email" :value="old('email', $request->email)" autocomplete="username"/>
                    <!--end::Email-->
                </div>

                <div class="fv-row mb-8" data-kt-password-meter="true">
                    <!--begin::Wrapper-->
                    <div class="mb-1">
                        <!--begin::Input wrapper-->
                        <div class="position-relative mb-3">

                            <x-authentication-mt-input id="password"  type="password" placeholder="{{ __('Password') }}" name="password" autocomplete="new-password"/>
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
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
                    <div class="text-muted">{{ __('Use 8 or more characters with a mix of letters, numbers & symbols.') }}</div>
                    <!--end::Hint-->
                </div>

                <div class="fv-row mb-5">
                    <!--begin::Password-->
                    <x-authentication-mt-input id="password_confirmation"  type="password" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" autocomplete="new-password"/>
                    <!--end::Password-->
                </div>

                <div class="d-grid ">
                    <x-authentication-mt-button>
                        {{ __('Reset Password') }}
                    </x-authentication-mt-button>
                </div>
            </form>

            <x-slot name="languages">
                <x-dropdown-language />
            </x-slot>
        </x-authentication-mt-card>
    </div>
</x-guest-layout>
