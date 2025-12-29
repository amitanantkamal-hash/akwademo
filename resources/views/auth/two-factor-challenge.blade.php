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

    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
        <form class="form w-100" method="POST" action="{{ route('two-factor.login') }}" id="two_factor_form">
            @csrf
            <div class="text-center mb-11">
                <h1 class="text-dark fw-bolder mb-3">{{ __('Two-Factor Verification') }}</h1>
                <div class="text-gray-500 fw-semibold fs-6" x-data="{ recovery: false }">
                    <div x-show="! recovery">
                        {{ __('Please confirm access by entering the authentication code from your authenticator app.') }}
                    </div>
                    <div x-show="recovery">
                        {{ __('Please confirm access by entering one of your emergency recovery codes.') }}
                    </div>
                </div>
            </div>

            <div x-data="{ recovery: false }">
                <div class="fv-row mb-6" x-show="! recovery">
                    <input type="text" placeholder="{{ __('Authentication Code') }}" name="code" inputmode="numeric"
                        class="form-control bg-transparent" autofocus x-ref="code" autocomplete="one-time-code" />
                </div>

                <div class="fv-row mb-6" x-show="recovery">
                    <input type="text" placeholder="{{ __('Recovery Code') }}" name="recovery_code"
                        class="form-control bg-transparent" x-ref="recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                    <button type="button" class="btn btn-link p-0 text-info"
                        x-show="! recovery"
                        x-on:click="
                            recovery = true;
                            $nextTick(() => { $refs.recovery_code.focus() })
                        ">
                        {{ __('Use a recovery code') }}
                    </button>

                    <button type="button" class="btn btn-link p-0 text-info"
                        x-show="recovery"
                        x-on:click="
                            recovery = false;
                            $nextTick(() => { $refs.code.focus() })
                        ">
                        {{ __('Use an authentication code') }}
                    </button>
                </div>
            </div>

            <div class="d-grid mb-10">
                <button type="submit" id="two_factor_submit" class="btn btn-info">
                    <span class="indicator-label">{{ __('Log in') }}</span>
                    <span class="indicator-progress d-none">{{ __('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</x-auth-layout>
