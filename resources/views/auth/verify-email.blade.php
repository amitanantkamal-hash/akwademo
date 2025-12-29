<x-guest-layout>

    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        <x-authentication-mt-aside/>


        <x-authentication-mt-card>

            <div class="text-center mb-10">
                <h1 class="text-gray-900 fw-bolder mb-3">  {{ __('Verify email') }}</h1>
                <div class="text-gray-500 fw-semibold fs-6"> {{ __("Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}</div>
            </div>


            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                </div>
            @endif

            <form class="form w-100" method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div class="d-grid mb-10">
                    <x-authentication-mt-button>
                          {{ __('Resend Verification Email') }}
                    </x-authentication-mt-button>
                </div>

            </form>

            <x-slot name="languages">
                <x-dropdown-language />
            </x-slot>

            @auth
                <x-slot name="links">
                    <a href="{{ route('profile.show') }}">{{ __('Edit Profile') }}</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Log Out') }}</a>
                </x-slot>
            @endauth

        </x-authentication-mt-card>
    </div>

</x-guest-layout>
