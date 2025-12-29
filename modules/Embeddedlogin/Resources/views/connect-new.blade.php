<div class="mt-8">
    <div class="text-gray-800 text-hover-primary fs-2 fw-bold me-3 p-0">
        {{ __('Connect with WhatsApp') }}
    </div>

    <div class="d-flex flex-column mt-4">
        @if (config('embeddedlogin.config_id', '') != '' && !$setupDone)
            @include('embeddedlogin::whatsappembeded')
        @endif
        @if ($setupDone)
            @include('embeddedlogin::whatsappembeded')
            <div class="alert alert-dismissible bg-dark d-flex align-items-center p-5 mt-8">
                <i class="ki-duotone ki-verify fs-2hx text-primary me-4">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div class="text-white">
                    {{ __('You have connected via WhatsApp Embedded login.') }}
                </div>
            </div>
            @include('embeddedlogin::info_verified')
        @endif
    </div>
</div>