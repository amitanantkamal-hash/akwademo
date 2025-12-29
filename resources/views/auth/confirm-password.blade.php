<x-guest-layout>

    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        <x-authentication-mt-aside/>


        <x-authentication-mt-card>

            <form class="form w-100" novalidate="novalidate" method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="text-center mb-10">
                    <h1 class="text-gray-900 fw-bolder mb-3">  {{ __('Confirm Password') }}</h1>
                    <div class="text-gray-500 fw-semibold fs-6">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</div>
                </div>

                <x-authentication-mt-validation-errors class="mb-4" />

                <!--begin::Input group--->
                <div class="fv-row mb-8">
                    <!--begin::Email-->
                    <x-authentication-mt-input type="password" placeholder="{{ __('Password') }}" name="password" autocomplete="current-password" autofocus required/>
                    <!--end::Email-->
                </div>

                <div class="d-grid mb-10">
                    <x-authentication-mt-button>
                        {{ __('Confirm Password') }}
                    </x-authentication-mt-button>
                </div>

            </form>
            <x-slot name="languages">
                <x-dropdown-language />
            </x-slot>
        </x-authentication-mt-card>
    </div>

</x-guest-layout>
