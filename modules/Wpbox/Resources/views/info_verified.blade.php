@php $company = auth()->user()->resolveCurrentCompany(); @endphp
@if (
    $company->getConfig('whatsapp_webhook_verified', 'no') != 'yes' ||
        $company->getConfig('whatsapp_settings_done', 'no') != 'yes')
    <div class="card card-flush mb-5 mt-4">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">WhatsApp Business</span>
                <span class="text-gray-500 pt-2 fw-semibold fs-6">Connection Status</span>
            </h3>
            <div class="card-toolbar">
                <span class="badge badge-light-danger">Not Connected</span>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="d-flex align-items-center p-5">
                <div class="symbol symbol-50px me-5">
                    <span class="symbol-label bg-light-danger">
                        <i class="ki-duotone ki-whatsapp fs-2x text-danger">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </span>
                </div>
                <div class="d-flex flex-column">
                    <span class="text-gray-800 fw-bold fs-4">Not Connected</span>
                    <span class="text-gray-600 fs-7">Connect your WhatsApp number</span>
                </div>
            </div>
            <!--<div class="separator my-3"></div>-->
            <!--<div class="d-flex flex-wrap justify-content-center px-5 pb-5">-->
            <!--    <button class="btn btn-sm btn-light-danger fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_1">-->
            <!--        <i class="ki-duotone ki-pencil fs-3 me-1">-->
            <!--            <span class="path1"></span>-->
            <!--            <span class="path2"></span>-->
            <!--        </i>-->
            <!--        Register Number-->
            <!--    </button>-->
            <!--</div>-->
        </div>
    </div>
@else
    <div class="card card-flush mb-5">
        <div class="card-header">
            <div class="card-title d-flex align-items-center gap-3">
                <i class="ki-duotone ki-whatsapp fs-2hx text-success">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <span class="text-gray-800 text-hover-primary fs-4 fw-bold">
                    {{ __('WhatsApp Business Details') }}
                </span>
            </div>
            <div class="card-toolbar">
                <span class="badge badge-light-success">Connected</span>
            </div>
        </div>
        <div class="card-body">
            <div class="border rounded p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="w-75">
                        <div class="fs-5 fw-bold d-flex align-items-center">
                            @if (strtolower($company->getConfig('name_status', '')) === 'approved')
                                <i class="ki-duotone ki-check-circle fs-2 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            @endif
                            {{ $company->getConfig('verified_name', 'N/A') }}
                        </div>

                        <div class="text-gray-700 mt-2">
                            <span class="fw-bold">{{ __('Display Name Status') }}:</span>
                            <span
                                class="badge badge-light-{{ strtolower($company->getConfig('name_status', '')) === 'approved' ? 'success' : 'warning' }}">
                                {{ ucfirst($company->getConfig('name_status', 'N/A')) }}
                            </span>
                        </div>

                        <div class="text-gray-700 mt-2">
                            <span class="fw-bold">{{ __('WhatsApp Number') }}:</span>
                            {{ $company->getConfig('display_phone_number', 'N/A') }}
                        </div>

                        <div class="text-gray-700 mt-2">
                            <span class="fw-bold">{{ __('Quality Rating') }}:</span>
                            <span
                                class="badge badge-light-{{ strtolower($company->getConfig('quality_rating', '')) === 'green' ? 'success' : (strtolower($company->getConfig('quality_rating', '')) === 'yellow' ? 'warning' : 'danger') }}">
                                {{ $company->getConfig('quality_rating', 'N/A') }}
                            </span>
                        </div>
                         <div class="text-gray-700 mt-2">
                            <span class="fw-bold">{{ __('Messaging Limit') }}:</span>
                            {{ $company->getConfig('messaging_limit_tier', 'N/A') }}
                        </div>
                         <div class="text-gray-700 mt-2">
                            <span class="fw-bold">{{ __('Can Send Message') }}:</span>
                            {{ $company->getConfig('can_send_message', 'N/A') }}
                        </div>
                        <div class="text-gray-700 mt-2">
                            <span class="fw-bold">{{ __('Organization') }}:</span>
                            <span class="text-info">{{ $company->name }}</span>
                        </div>
                    </div>
                    @if ($company->getConfig('profile_picture_url', '') != '')
                        <img src="{{ $company->getConfig('profile_picture_url', '') }}" alt="Profile Picture"
                            class="rounded-circle shadow border"
                            style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #ddd;">
                    @endif
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <!-- Copy Link Button -->
                <button onclick="copyWhatsAppLink()" class="btn btn-icon btn-sm btn-light-primary"
                    data-bs-toggle="tooltip" title="Copy WhatsApp Link">
                    <i class="ki-duotone ki-copy fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>


                <!-- Switch Account Button -->
                <!-- <button type="button" class="btn btn-icon btn-sm btn-light-primary" data-bs-toggle="modal"
                    data-bs-target="#switchAccountModal" data-bs-toggle="tooltip" title="Switch Account">
                    <i class="ki-duotone ki-switch fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                </button> -->

                <!-- Open Chat Button -->
                <a href="https://wa.me/{{ str_replace([' ', '+'], '', $company->getConfig('display_phone_number', '11111111')) }}"
                    target="_blank" class="btn btn-icon btn-sm btn-light-primary" data-bs-toggle="tooltip"
                    title="Start Chat">
                    <i class="ki-duotone ki-message-text fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </a>
            </div>
        </div>
    </div>
@endif
