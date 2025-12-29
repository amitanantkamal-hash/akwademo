<div class="card card-flush">
    <div class="card-header mt-3">
        <div class="card-title">
            <h2>{{ __('Whatsapp Cloud API - Connection Status') }}</h2>
        </div>
    </div>
    <div class="card-body overflow-auto overflow-x-hidden scrollable-div pt-3">
        @if ($company->getConfig('whatsapp_webhook_verified','no')!='yes' || $company->getConfig('whatsapp_settings_done','no')!='yes')
            <div class="alert alert-danger" role="alert">
                <strong>{{ __('Not connected!') }}</strong> {{ __('Please complete all the steps in order to connect to Whatsapp Cloud API')}}
            </div>
            <button onclick="location.reload()" class="btn btn-success" type="button">{{ __('Refresh status')}}</button>
        @else
            <div class="alert alert-primary" role="alert">
                <strong>{{ __('Success!')}}</strong> {{ __('You are now connected to Whatsapp Cloud API. You can start use the system') }}
            </div>
        @endif
    </div>
</div>
