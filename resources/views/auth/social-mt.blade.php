@if (config('services.facebook.client_id',"")!=""||config('services.google.client_id',"")!="")
    
    <!--begin::Heading-->

    <!--begin::Login options-->
    <div class="row g-3 mb-6 items-center justify-center ">
        @if (config('services.google.client_id',"")!="")
        <!--begin::Col-->
        <div class="col-md-{{ config('services.facebook.client_id', "") != "" ? '6' : '12' }}">
            <!--begin::Google link--->
            <a href="{{ route('google.login') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                <img alt="Logo" src="/Metronic/assets/media/svg/brand-logos/google-icon.svg" class="h-15px me-3"/>
                {{ __('Iniciar con Google')}}
            </a>
            <!--end::Google link--->
        </div>
        <!--end::Col-->
        @endif

        @if (config('services.facebook.client_id',"")!="")
        <!--begin::Col-->
        <div class="col-md-{{ config('services.google.client_id', "") != "" ? '6' : '12' }}">
            <!--begin::Google link--->
            <a href="{{ route('facebook.login') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                <img alt="Logo" src="/Metronic/assets/media/svg/brand-logos/facebook-2.svg" class="h-15px me-3"/>
                {{ __('Facebook')}}
            </a>
            <!--end::Google link--->
        </div>
        <!--end::Col-->
        @endif


    </div>
    <!--end::Login options-->

    <!--begin::Separator-->
    <div class="separator separator-content my-6">
        <span class="w-200px text-gray-500 fw-semibold fs-7">{{ __('or using email') }}</span>
    </div>
    <!--end::Separator-->
@endif
