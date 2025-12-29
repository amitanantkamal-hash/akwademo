@if (config('services.facebook.client_id', '') != '' || config('services.google.client_id', '') != '')
    @if (config('services.facebook.client_id', '') != '')
        <div class="row g-3 mb-9">
            <!--begin::Col-->
            <div class="col-md-12">
                <!--begin::Google link=-->
                <a href="{{ route('facebook.login') }}"
                    class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-danger bg-state-light flex-center text-nowrap w-100">
                    <img alt="Logo" src="{{ asset('backend/Assets/media/brand-logos/facebook-4.svg') }}"
                        class="h-15px me-3" />{{ __('Continue with Facebook ') }}</a>
                <!--end::Google link=-->
            </div>
            <!--end::Col-->
        </div>
    @endif
    @if (config('services.google.client_id', '') != '')
        <div class="row g-3 mb-9">
            <!--begin::Col-->
            <div class="col-md-12">
                <!--begin::Google link=-->
                <a href="{{ route('google.login') }}"
                    class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-danger bg-state-light flex-center text-nowrap w-100">
                    <img alt="Logo" src="{{ asset('backend/Assets/media/brand-logos/google-icon.svg') }}"
                        class="h-15px me-3" />{{ __('Continue with Google') }}</a>
                <!--end::Google link=-->
            </div>
            <!--end::Col-->
        </div>
    @endif
    <!--begin::Separator-->
    <div class="separator separator-content my-14">
        <span class="w-125px text-gray-500 fw-semibold fs-7">{{ __('or wiith Email') }}</span>
    </div>
    <!--end::Separator-->
@endif
