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
            {{-- <div class="separator my-3"></div>
            <div class="d-flex flex-wrap justify-content-center px-5 pb-5">
                <button class="btn btn-sm btn-light-danger fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                    <i class="ki-duotone ki-pencil fs-3 me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Register Number
                </button>
            </div> --}}
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
                            <span class="fw-bold">{{ __('Status') }}:</span>
                            {{ $company->getConfig('code_verification_status', 'N/A') }}
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
                <button type="button" class="btn btn-icon btn-sm btn-light-primary" data-bs-toggle="modal"
                    data-bs-target="#switchAccountModal" data-bs-toggle="tooltip" title="Switch Account">
                    <i class="ki-duotone ki-switch fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                </button>

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

            <form action="{{ route('refresh.whatsapp.status') }}" method="GET">
                <button class="btn btn-outline btn-block mt-4 w-100" type="submit">
                    <i class="fas fa-sync-alt me-2"></i> {{ __('Refresh Status') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Switch Account Modal -->
    <div class="modal fade" id="switchAccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Switch Organization Account</h2>
                     <div class="card-toolbar">
                        @if (config('settings.enable_create_company', true))
                            <a href="javascript:void(0);" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                data-bs-target="#createOrgModal"
                                data-bs-original-title="{{ __('Add new organization') }}">
                                <i class="ki-duotone ki-plus fs-2 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ __('New Organization') }}
                            </a>
                        @endif
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body py-10 px-5">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">{{ __('Name') }}</th>
                                    @if (config('settings.show_company_logo'))
                                        <th class="min-w-50px">{{ __('Logo') }}</th>
                                    @endif
                                    <th class="min-w-100px">{{ __('Status') }}</th>
                                    <th class="text-end min-w-125px">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach (auth()->user()->companies->where('active', 1) as $company)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.organizations.edit', $company) }}"
                                                class="text-gray-800 text-hover-primary fs-5 fw-bold">
                                                {{ $company->name }}
                                            </a>
                                        </td>
                                        @if (config('settings.show_company_logo'))
                                            <td>
                                                <img src="{{ $company->icon }}" class="img-fluid rounded-circle"
                                                    width="40" height="40">
                                            </td>
                                        @endif
                                        <td>
                                            <span class="badge badge-light-success">{{ __('Active') }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end">
                                                {{-- <a href="{{ route('admin.organizations.edit', $company) }}"
                                                    class="btn btn-icon btn-sm btn-light-info me-2"
                                                    data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                    <i class="ki-duotone ki-pencil fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a> --}}
                                                <a href="{{ route('admin.companies.switch', $company) }}"
                                                    class="btn btn-icon btn-sm btn-light-primary me-2"
                                                    data-bs-toggle="tooltip" title="{{ __('Switch Account') }}">
                                                    <i class="ki-duotone ki-switch fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </a>
                                                @if ($company->id != auth()->user()->company_id)
                                                    <form action="{{ route('admin.companies.destroy', $company) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-icon btn-sm btn-light-danger"
                                                            onclick="return confirm('{{ __('Are you sure you want to delete this organization?') }}')"
                                                            data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                            <i class="ki-duotone ki-trash fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                            </i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Initialize Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        function copyWhatsAppLink() {
            @if (auth()->check() && auth()->id() != 1)
                const phoneNumber =
                    "{{ str_replace([' ', '+'], '', $company->getConfig('display_phone_number', '11111111')) }}";
                const waLink = `https://wa.me/${phoneNumber}`;

                // Fallback for older browsers
                const copyToClipboard = (text) => {
                    if (navigator.clipboard) {
                        return navigator.clipboard.writeText(text);
                    } else {
                        // Fallback for older browsers
                        const textarea = document.createElement('textarea');
                        textarea.value = text;
                        document.body.appendChild(textarea);
                        textarea.select();
                        try {
                            document.execCommand('copy');
                            return Promise.resolve();
                        } catch (err) {
                            return Promise.reject(err);
                        } finally {
                            document.body.removeChild(textarea);
                        }
                    }
                };

                copyToClipboard(waLink).then(() => {
                    Toast.fire({
                        icon: "success",
                        title: "WhatsApp link copied to clipboard!"
                    });
                }).catch(err => {
                    Toast.fire({
                        icon: "error",
                        title: "Failed to copy link"
                    });
                    console.error('Failed to copy: ', err);
                });
            @else
                Toast.fire({
                    icon: "error",
                    title: "Operation not allowed"
                });
            @endif
        }

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endif
