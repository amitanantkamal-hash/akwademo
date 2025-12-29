<x-auth-layout>
    <x-validation-errors class="mb-4" />
    <style>
        .indicator-progress {
            display: none;
        }

        .btn[disabled] {
            cursor: not-allowed;
            opacity: 0.8;
        }
    </style>
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif
    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
        <form class="form w-100" novalidate="novalidate" id="gomint_sign_in_form"
            data-gomint-redirect-url="{{ route('two-factor.login') }}" action="{{ route('login') }}">
            @csrf
            <div class="text-center mb-11">
                <h1 class="text-dark fw-bolder mb-3">{{ __('Sign in') }}</h1>
                <div class="text-gray-500 fw-semibold fs-6">
                    {{ __('Power up your WhatsApp business—manage contacts, automate replies, and boost engagement.') }}
                </div>
            </div>
            @if (config('settings.enable_login_as_company', true))
                @include('auth.social')
            @endif
            <div class="fv-row mb-6">
                <input type="text" placeholder="{{ __('Email address') }}" name="email" autocomplete="off"
                    class="form-control bg-transparent" />
            </div>
            <div class="mb-10 fv-row" data-gomint-password-meter="true">
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
                </div>
            </div>
            <div class="d-flex form-group form-check flex-wrap gap-3 fs-base~ fw-semibold mb-8">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                <label class="form-check-label ps-1" for="remember">{{ __('Remember Me') }}</label>
            </div>
            @if (Route::has('password.request'))
                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                    <div></div>
                    <a href="{{ route('password.request') }}" class="text-info">{{ __('Forgot your password?') }}</a>
                </div>
            @endif
            <div class="d-grid mb-10">
                <button type="submit" id="gomint_sign_in_submit" class="btn btn-info">
                    <span class="indicator-label">{{ __('Sign in') }}</span>
                    <span class="indicator-progress d-none">{{ __('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            @if (Route::has('register'))
                <div class="text-center fw-semibold fs-6 mb-5"><span
                        class="text-gray-500 ">{{ __("Don't have an account?") }}</span>
                    <a href="{{ route('register') }}" class="text-info fs-5 me-1">{{ __('Sign up') }}</a>
                </div>
            @endif
            {{-- <div class="text-gray-500 text-center fw-semibold fs-6">
                <a href="#" class="link-info">{{ __('Resend activation code') }}</a>
            </div> --}}
        </form>
    </div>

</x-auth-layout>
