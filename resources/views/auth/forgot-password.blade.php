<x-auth-layout>
    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
        <form class="form w-100" novalidate="novalidate" data-gomint-redirect-url="{{ route('login') }}" id="gomint_password_reset_form"
            action="{{ route('password.email') }}">
            <div class="text-center mb-10">
                <h1 class="text-dark fw-bolder mb-3">{{ __('Forgot Password ?')}}</h1>
                <div class="text-gray-500 fw-semibold fs-6">{{ __('Enter your registered email address to change your Anantkamal Wademo
                    account password.') }}</div>
            </div>
            <div class="fv-row mb-8">
                <input type="text" placeholder="{{ __('Email address')}}" id="email" name="email" autocomplete="off"
                    class="form-control bg-transparent" />
            </div>
            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                <button type="submit" id="gomint_password_reset_submit" class="btn btn-info me-4">
                    <span class="indicator-label">{{ __('Submit') }}</span>
                    <span class="indicator-progress">{{ __('Please wait...') }}<span
                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <a href="{{ route('login') }}" class="btn btn-light">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-auth-layout>