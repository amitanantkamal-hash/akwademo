<div id="whatsapp_connect">
    <div class="text-gray-800 text-hover-primary fs-2 fw-bold me-3 p-0">
        {{ __('Whatsapp Cloud API - Connection Status') }}
    </div>
    <div class="mt-8">
        @if (
            $company->getConfig('whatsapp_webhook_verified', 'no') != 'yes' ||
                $company->getConfig('whatsapp_settings_done', 'no') != 'yes')
            <div class="d-flex flex-column">
                <div class="alert alert-dismissible bg-dark d-flex align-items-center p-5">
                    <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span
                            class="path2"></span></i>
                    <div class="text-white">
                        <strong>{{ __('Not connected!') }}</strong>
                        {{ __('Please complete all the steps in order to connect to Whatsapp Cloud API.') }}
                    </div>
                </div>
                <button onclick="location.reload()" class="btn btn-outline btn-block"
                    type="button">{{ __('Refresh status') }}</button>
            </div>
        @else
            <div class="alert alert-dismissible bg-dark d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-primary me-4"><span class="path1"></span><span
                        class="path2"></span></i>
                <div class="text-white">
                    <strong>{{ __('Success!') }}</strong>
                    {{ __('You are now connected to Whatsapp Cloud API. You can start use the system.') }}
                </div>
            </div>
        @endif
    </div>
</div>
