<x-guest-layout>

    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        <x-authentication-mt-aside />

        <x-authentication-mt-card>

            <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" method="POST"
                action="{{ route('password.email') }}">
                @csrf

                <div class="text-center mb-10">
                    <h1 class="text-gray-900 fw-bolder mb-3"> {{ __('Forgot your password?') }}</h1>
                    <div class="text-gray-500 fw-semibold fs-6">
                        {{ __('No problem. Just let us know your email address and we will email') }}<br/>{{ 'you a password reset link that will allow you to choose a new one.' }}
                    </div>
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <x-authentication-mt-validation-errors class="mb-4" />

                <!--begin::Input group--->
                <div class="fv-row mb-8">
                    <!--begin::Email-->
                    <x-authentication-mt-input type="text" placeholder="{{ __('Email') }}" name="email"
                        autocomplete="username" autofocus required />
                    <!--end::Email-->
                </div>

                <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                    <x-authentication-mt-button>
                        {{ __('Email Password Reset Link') }}
                    </x-authentication-mt-button>
                    <a href="{{ route('login') }}" class=" ml-3 btn btn-light">{{ __('Cancel') }}</a>
                </div>

            </form>

            <x-slot name="languages">
                <x-dropdown-language />
            </x-slot>
        </x-authentication-mt-card>
    </div>

</x-guest-layout>
