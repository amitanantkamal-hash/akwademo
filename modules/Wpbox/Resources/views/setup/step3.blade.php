<!--begin::Card-->
<div class="card mt-4">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">
                <i class="ki-duotone ki-phone fs-2 text-info me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                {{ __('Step 3: Get your Account ID and Phone number ID') }}
            </span>
        </h3>
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body py-4">
        <!--begin::Step 1-->
        <div class="d-flex flex-column mb-10">
            <div class="d-flex align-items-center mb-2">
                <span class="bullet bullet-dot bg-info me-5"></span>
                <span class="text-gray-700 fw-semibold fs-6">
                    {{__('In the Facebook app, in WhatsApp -> API setup, you will find your Phone number ID and your WhatsApp Business Account ID.') }}
                </span>
            </div>
        </div>
        <!--end::Step 1-->
        
        <!--begin::Step 2-->
        <div class="d-flex flex-column">
            <div class="d-flex align-items-center mb-4">
                <span class="bullet bullet-dot bg-info me-5"></span>
                <span class="text-gray-700 fw-semibold fs-6">
                    {{__('Copy them and enter it here') }}
                </span>
            </div>
            
            <!--begin::Input Group-->
            <div class="row g-5 mb-5">
                <!-- Phone Number ID Input -->
                <div class="col-md-6">
                    <label for="phones" class="form-label required">{{ __('Phone number ID') }}</label>
                    <input type="text" 
                           class="form-control form-control-solid"
                           id="phones"
                           name="whatsapp_phone_number_id"
                           value="{{ $company->getConfig('whatsapp_phone_number_id','') }}"
                           placeholder="Phone number ID">
                </div>
                
                <!-- Business Account ID Input -->
                <div class="col-md-6">
                    <label for="account" class="form-label required">{{ __('WhatsApp Business Account ID') }}</label>
                    <input type="text" 
                           class="form-control form-control-solid"
                           id="account"
                           name="whatsapp_business_account_id"
                           value="{{ $company->getConfig('whatsapp_business_account_id','') }}"
                           placeholder="WhatsApp Business Account ID">
                </div>
            </div>
            <!--end::Input Group-->
            
            <!--begin::Submit Button-->
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" type="submit">
                    <i class="ki-duotone ki-check-circle fs-2 me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    {{ __('Submit') }}
                </button>
            </div>
            <!--end::Submit Button-->
        </div>
        <!--end::Step 2-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->