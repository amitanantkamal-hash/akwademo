<!--begin::Card-->
<div class="card mt-4">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">
                <i class="ki-duotone ki-key fs-2 text-primary me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                {{ __('Step 2: Get your permanent access token') }}
            </span>
        </h3>
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body py-4">
        <!--begin::Step 1-->
        <div class="d-flex flex-column mb-10">
            <div class="d-flex flex-column flex-md-row align-items-md-center mb-4">
                <span class="bullet bullet-dot bg-primary me-5 mb-2 mb-md-0"></span>
                <div class="d-flex flex-column flex-md-row align-items-md-center flex-wrap">
                    <span class="text-gray-700 fw-semibold fs-6 me-md-2">
                        {{__('The process of creating a permanent access token is explained in details in the Facebook Docs') }}
                    </span>
                    <a target="_blank" href="https://developers.facebook.com/docs/whatsapp/business-management-api/get-started#1--acquire-an-access-token-using-a-system-user-or-facebook-login" 
                       class="btn btn-icon btn-sm btn-light-primary mt-2 mt-md-0 ms-md-2">
                        <i class="ki-duotone ki-exit-up fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Step 1-->
        
        <!--begin::Step 2-->
        <div class="d-flex flex-column">
            <div class="d-flex flex-column flex-md-row align-items-md-center mb-4">
                <span class="bullet bullet-dot bg-primary me-5 mb-2 mb-md-0"></span>
                <div class="d-flex flex-column w-100">
                    <span class="text-gray-700 fw-semibold fs-6 mb-3">
                        {{__('Once you have the permanent access token, enter it here') }}
                    </span>
                    
                    <!--begin::Input-->
                    <div class="col-md-6 px-0 mb-4">
                        <input type="text" 
                               class="form-control form-control-solid"
                               id="token"
                               name="whatsapp_permanent_access_token"
                               value="{{ $company->getConfig('whatsapp_permanent_access_token','') }}"
                               placeholder="Permanent access token">
                    </div>
                    <!--end::Input-->
                    
                    <!--begin::Submit button-->
                    {{-- <button class="btn btn-info mt-4" type="submit">
                        <i class="ki-duotone ki-save fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ __('Save access token')}}
                    </button> --}}
                    <!--end::Submit button-->
                </div>
            </div>
        </div>
        <!--end::Step 2-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->