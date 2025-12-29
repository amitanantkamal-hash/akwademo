@extends('layouts.app-client')

@section('content')
    <style>
        .subscribe-btn {
            transition: all 0.3s ease;
            position: relative;
        }

        .subscribe-btn[data-kt-indicator="on"]::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 18px;
            height: 18px;
            margin: -9px 0 0 -9px;
            border: 2px solid transparent;
            border-top-color: #3699FF;
            border-radius: 50%;
            animation: button-spinner 0.6s linear infinite;
        }

        @keyframes button-spinner {
            to {
                transform: rotate(360deg);
            }
        }

        .subscribe-btn .subscribed-icon {
            color: #1BC5BD;
            /* Green color for subscribed state */
        }

        .subscribe-btn .subscribe-icon {
            color: #3699FF;
            /* Primary color for unsubscribed state */
        }
    </style>
    <!--begin::Container-->
    <div class="container-fluid px-0">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-dark">Meta Ad Accounts</span>
                        <span class="text-muted mt-2 font-weight-bold fs-6">Manage your connected Facebook ad accounts</span>
                    </h3>
                </div>
                <!--end::Card title-->

                @if ($connection)
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end">
                            @if ($buisnessId)
                                <a href="https://business.facebook.com/settings/billing_hub/payment_activity?business_id={{ $buisnessId }}"
                                    class="btn btn-light-primary me-3" target="_blank">
                                    <i class="ki-duotone ki-wallet fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    Manage CTWA Payment's
                                </a>
                            @endif
                            <a href="{{ route('ctwa.index') }}" class="btn btn-light-primary me-3">
                                <i class="ki-duotone ki-facebook fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Manage CTWA AD's
                            </a>

                            <a href="{{ route('ctwameta.refresh') }}" class="btn btn-light-primary me-3">
                                <i class="ki-duotone ki-arrows-circle fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Refresh Data
                            </a>
                            <a href="{{ route('ctwameta.connect') }}" class="btn btn-light-danger">
                                <i class="ki-duotone ki-reload fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Reconnect Account
                            </a>
                        </div>
                    </div>
                    <!--end::Card toolbar-->
                @endif
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0 pb-5 px-6">
                @if ($connection)
                    <!--begin::Connection status-->
                    <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between mb-10">
                        <!--begin::Facebook profile card-->
                        <div class="card card-flush bg-light-info shadow-sm w-100 me-lg-5 mb-5 mb-lg-0"
                            style="max-width: 400px;">
                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-center p-6">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-60px symbol-circle me-5">
                                    <img src="https://graph.facebook.com/{{ $connection->fb_user_id }}/picture?type=square"
                                        class="h-100 align-self-center" alt="FB Profile">
                                </div>
                                <!--end::Avatar-->

                                <!--begin::Details-->
                                <div class="d-flex flex-column">
                                    <span class="text-muted fw-bold mb-1">Connected Facebook Account</span>
                                    <span class="text-dark fw-bolder fs-4">ID: {{ $connection->fb_user_id }}</span>
                                    <span class="text-muted fs-7">Last updated:
                                        {{ $connection->updated_at->format('M d, Y H:i') }}</span>
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Facebook profile card-->

                        <!--begin::Webhook info card-->
                        {{-- <div class="card card-flush bg-light-info shadow-sm w-100 mt-4" style="max-width: 600px;">
                            <!--begin::Card header-->
                            <div class="card-header align-items-center border-0 p-6">
                                <div class="d-flex align-items-center">
                                    <span class="svg-icon svg-icon-warning svg-icon-2x me-3">
                                        <i class="ki-duotone ki-abstract-41 fs-2 text-warning">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <h4 class="text-warning mb-0">Webhook Configuration</h4>
                                </div>
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0 pb-6 px-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="fw-bold text-dark">Webhook URL</label>
                                            <div class="input-group input-group-solid">
                                                <input type="text" class="form-control form-control-solid"
                                                    id="webhookUrl" value="{{ $connection->webhook_url }}" readonly>
                                                <button class="btn btn-icon btn-light-info copy-btn"
                                                    data-target="#webhookUrl" title="Copy to clipboard">
                                                    <i class="ki-duotone ki-copy fs-2 text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                    </i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="fw-bold text-dark">Verification Token</label>
                                            <div class="input-group input-group-solid">
                                                <input type="text" class="form-control form-control-solid"
                                                    id="webhookToken" value="{{ $connection->webhook_secret }}" readonly>
                                                <button class="btn btn-icon btn-light-info copy-btn"
                                                    data-target="#webhookToken" title="Copy to clipboard">
                                                    <i class="ki-duotone ki-copy fs-2 text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                    </i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-muted fs-7">
                                    Use these details when setting up your Facebook webhook in the Developer Portal
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div> --}}
                        <!--end::Webhook info card-->
                    </div>
                    <!--end::Connection status-->

                    <!--begin::Business accounts section-->
                    <div class="mb-10">
                        <!--begin::Heading-->
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h4 class="fw-bolder text-dark">Business Accounts</h4>
                            <span class="badge badge-primary">{{ count($businessAccounts) }} businesses</span>
                        </div>
                        <!--end::Heading-->

                        <!--begin::Row-->
                        <div class="row g-6">
                            @foreach ($businessAccounts as $business)
                                <div class="col-xl-4 col-lg-6 business-account" data-business-id="{{ $business['id'] }}">
                                    <!--begin::Card-->
                                    <div class="card card-flush h-100">
                                        <!--begin::Card header-->
                                        <div class="card-header pt-5">
                                            <!--begin::Card title-->
                                            <div class="card-title d-flex flex-column">
                                                <!--begin::Business info-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Avatar-->
                                                    @if (isset($business['picture_url']) && $business['picture_url'])
                                                        <img src="{{ $business['picture_url'] }}"
                                                            alt="{{ $business['name'] }}" class="h-100 align-self-center">
                                                    @else
                                                        <div
                                                            class="symbol symbol-50px symbol-light-{{ ['primary', 'success', 'info', 'warning', 'danger'][$loop->index % 5] }} me-3">
                                                            <span class="symbol-label fw-bold fs-3">
                                                                {{ substr($business['name'] ?? '?', 0, 1) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    <!--end::Avatar-->

                                                    <!--begin::Details-->
                                                    <div class="d-flex flex-column">
                                                        <a href="#"
                                                            class="fs-4 fw-bold text-gray-900 text-hover-primary">{{ $business['name'] }}</a>
                                                        <span
                                                            class="text-muted fw-semibold">{{ $metaAccounts->where('business_id', $business['business_id'])->count() }}
                                                            ad accounts</span>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Business info-->
                                            </div>
                                            <!--end::Card title-->

                                            <!--begin::Card toolbar-->
                                            <div class="card-toolbar">
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-color-danger btn-active-light-danger"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <i class="ki-duotone ki-trash fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </button>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                    data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3"
                                                            data-kt-business-id="{{ $business['id'] }}"
                                                            onclick="confirmDeleteBusiness(this)">Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->
                                            </div>
                                            <!--end::Card toolbar-->
                                        </div>
                                        <!--end::Card header-->

                                        <!--begin::Card body-->
                                        <div class="card-body pt-1">
                                            <!--begin::Table-->
                                            <div class="table-responsive">
                                                <table class="table align-middle table-row-dashed fs-6 gy-3">
                                                    <!--begin::Table body-->
                                                    <tbody>
                                                        @foreach ($metaAccounts->where('business_id', $business['business_id']) as $account)
                                                            <tr class="ad-account" data-account-type="{{ $account->type }}"
                                                                data-account-status="{{ $account->status }}">
                                                                <!--begin::Account=-->
                                                                <td class="pe-0">
                                                                    <div class="d-flex align-items-center">
                                                                        <!--begin::Icon-->
                                                                        <div
                                                                            class="symbol symbol-40px symbol-light-{{ $account->status == 'ACTIVE' ? 'success' : ($account->status == 'PENDING_REVIEW' ? 'warning' : 'danger') }} me-4">
                                                                            <span class="symbol-label">
                                                                                <i
                                                                                    class="ki-duotone ki-abstract-26 fs-2 text-{{ $account->status == 'ACTIVE' ? 'success' : ($account->status == 'PENDING_REVIEW' ? 'warning' : 'danger') }}">
                                                                                    <span class="path1"></span>
                                                                                    <span class="path2"></span>
                                                                                </i>
                                                                            </span>
                                                                        </div>
                                                                        <!--end::Icon-->

                                                                        <!--begin::Details-->
                                                                        <div class="d-flex flex-column">
                                                                            <a href="#"
                                                                                class="text-gray-900 fw-bold text-hover-primary mb-1">{{ $account->name }}</a>
                                                                            <span
                                                                                class="text-muted fw-semibold">{{ $account->account_id }}</span>
                                                                        </div>
                                                                        <!--end::Details-->
                                                                    </div>
                                                                </td>
                                                                <!--end::Account-->

                                                                <!--begin::Action=-->
                                                                <td class="text-end">
                                                                    {{-- <span
                                                                        class="badge badge-light-{{ $account->type == 'ctwa' ? 'info' : 'secondary' }} fw-bold me-2">
                                                                        {{ strtoupper($account->type) }}
                                                                    </span> --}}
                                                                    <a href="{{ route('ctwameta.analytics', $account->account_id) }}"
                                                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                                        data-bs-toggle="tooltip" title="View Analytics">
                                                                        <i
                                                                            class="ki-duotone ki-chart-line fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </a>
                                                                </td>
                                                                <!--end::Action-->
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                            @endforeach
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Business accounts section-->

                    <!--begin::Facebook pages section-->
                    <div class="mb-10">
                        <!--begin::Heading-->
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h4 class="fw-bolder text-dark">Connected Facebook Pages</h4>
                            <span class="badge badge-primary">{{ count($pages) ?? 0 }} pages</span>
                        </div>
                        <!--end::Heading-->

                        @if (count($pages ?? []))
                            <!--begin::Pages grid-->
                            <div class="row g-6">
                                @foreach ($pages as $page)
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <!--begin::Card-->
                                        <div class="card card-flush h-100">
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex flex-column justify-content-between pb-5 pt-7">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-80px symbol-circle mx-auto mb-5">
                                                    @if (isset($page['picture_url']))
                                                        <img src="{{ $page['picture_url'] }}" alt="{{ $page['name'] }}"
                                                            class="h-100 align-self-center">
                                                    @else
                                                        <span class="symbol-label bg-light-primary">
                                                            <i class="ki-duotone ki-abstract-41 fs-2x text-primary">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                    @endif
                                                </div>
                                                <!--end::Avatar-->

                                                <!--begin::Details-->
                                                <div class="text-center mb-5">
                                                    <h5 class="fw-bold text-gray-900 mb-1 text-truncate"
                                                        title="{{ $page['name'] }}">{{ $page['name'] }}</h5>
                                                    <div class="text-muted fw-semibold mb-2">{{ $page['page_id'] }}</div>
                                                    <div class="badge badge-light-primary fw-bold mb-2">
                                                        {{ $page['category'] ?? 'Page' }}</div>
                                                </div>
                                                <!--end::Details-->

                                                <!--begin::Actions-->
                                                <div class="d-flex flex-center">
                                                    <!-- Subscribe Button -->
                                                    <button type="button"
                                                        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary me-2 subscribe-btn"
                                                        data-kt-page-id="{{ $page['page_id'] }}"
                                                        data-subscribed="{{ $page['subscribed'] ?? 'false' }}"
                                                        onclick="toggleSubscription(this)">
                                                        <i class="ki-duotone ki-check-circle fs-2 subscribed-icon"
                                                            style="display: {{ isset($page['subscribed']) && $page['subscribed'] ? 'inline-block' : 'none' }};">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <i class="ki-duotone ki-plus-circle fs-2 subscribe-icon"
                                                            style="display: {{ !isset($page['subscribed']) || !$page['subscribed'] ? 'inline-block' : 'none' }};">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </button>
                                                    <!-- View Leads Button -->
                                                    <a href="{{ route('facebook.pages.leads', $page['page_id']) }}"
                                                        class="btn btn-sm btn-light-primary fw-bold me-2">
                                                        <i class="ki-duotone ki-eye fs-3 me-1"></i> View Leads
                                                    </a>

                                                    <a href="{{ route('facebook.manage.forms', $page['page_id']) }}"
                                                        class="btn btn-sm btn-light-primary fw-bold me-2">
                                                        <i class="ki-duotone ki-eye fs-3 me-1"></i> Manage Forms
                                                    </a>


                                                    <!-- Fetch Leads Button -->
                                                    {{-- <button type="button" class="btn btn-sm btn-light-success fw-bold"
                                                        onclick="fetchNewLeads('{{ $page['page_id'] }}')">
                                                        <i class="ki-duotone ki-refresh fs-3 me-1"></i> Fetch Leads
                                                    </button> --}}

                                                    <!-- Existing delete button -->
                                                    <button type="button"
                                                        class="btn btn-sm btn-icon btn-color-danger btn-active-light-danger"
                                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        <i class="ki-duotone ki-trash fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i>
                                                    </button>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                        data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3"
                                                                data-kt-page-id="{{ $page['page_id'] }}"
                                                                onclick="confirmDeletePage(this)">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::Actions-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                @endforeach
                            </div>
                            <!--end::Pages grid-->
                        @else
                            <!--begin::Alert-->
                            <div class="alert alert-dismissible bg-light-primary d-flex flex-column flex-sm-row p-5 mb-10">
                                <!--begin::Icon-->
                                <i class="ki-duotone ki-information-5 fs-2hx text-primary me-4 mb-5 mb-sm-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <!--end::Icon-->

                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                    <!--begin::Title-->
                                    <h4 class="fw-semibold">No Facebook Pages Found</h4>
                                    <!--end::Title-->

                                    <!--begin::Content-->
                                    <span>Please ensure you've granted the necessary permissions to access your Facebook
                                        pages.</span>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Close-->
                                <button type="button"
                                    class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                                    data-bs-dismiss="alert">
                                    <i class="ki-duotone ki-cross fs-1 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </button>
                                <!--end::Close-->
                            </div>
                            <!--end::Alert-->
                        @endif
                    </div>
                    <!--end::Facebook pages section-->
                @else
                    <!--begin::No connection state-->
                    <div class="text-center py-15 px-5">
                        <!--begin::Illustration-->
                        <div class="symbol symbol-150px symbol-light-primary mb-8">
                            <i class="ki-duotone ki-abstract-41 fs-8x text-primary">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Illustration-->

                        <!--begin::Title-->
                        <h3 class="fw-bolder mb-5">Connect Your Facebook Account</h3>
                        <!--end::Title-->

                        <!--begin::Description-->
                        <div class="text-muted fw-semibold fs-5 mb-7">To view and manage your ad accounts, please connect
                            your Facebook account first.</div>
                        <!--end::Description-->

                        <!--begin::Action-->
                        <a href="{{ route('ctwameta.connect') }}" class="btn fw-bold px-6 py-3"
                            style="background-color: #1877F2; color: #fff;">
                            <i class="ki-duotone ki-facebook fs-2 me-2 text-white">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Connect Facebook Account
                        </a>

                        <!--end::Action-->
                    </div>
                    <!--end::No connection state-->
                @endif
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
@endsection

@section('topjs')
    <script>
        function fetchNewLeads(pageId) {
            Swal.fire({
                title: 'Fetching Leads...',
                text: 'Please wait while we get the latest leads.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch(`/facebook/pages/${pageId}/fetch-leads`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire('Success', data.message || 'Leads fetched successfully!', 'success');
                    } else {
                        Swal.fire('Error', data.message || 'Failed to fetch leads.', 'error');
                    }
                })
                .catch(() => {
                    Swal.close();
                    Swal.fire('Error', 'Something went wrong.', 'error');
                });
        }


        function toggleSubscription(button) {
            const pageId = button.getAttribute('data-kt-page-id');
            const isSubscribed = button.getAttribute('data-subscribed') === 'true';

            // Show loading state
            button.setAttribute('data-kt-indicator', 'on');
            button.disabled = true;

            // Make AJAX request to your controller
            $.ajax({
                url: '{{ route('meta.subscribe') }}',
                method: 'POST',
                data: {
                    page_id: pageId,
                    action: isSubscribed ? 'unsubscribe' : 'subscribe',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Toggle the button state
                        const newState = !isSubscribed;
                        button.setAttribute('data-subscribed', newState.toString());

                        // Toggle icons
                        $(button).find('.subscribed-icon').toggle(newState);
                        $(button).find('.subscribe-icon').toggle(!newState);

                        // Show success notification
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message || 'Operation failed');
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'An error occurred');
                },
                complete: function() {
                    // Remove loading state
                    button.removeAttribute('data-kt-indicator');
                    button.disabled = false;
                }
            });
        }
    </script>
    <script>
        // Class definition
        var KTAccountMeta = function() {
            // Shared variables
            var cards;

            // Private functions
            var initFilters = function() {
                // Initialize tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Copy to clipboard functionality with SweetAlert
                $(document).on('click', '.copy-btn', function(e) {
                    e.preventDefault();
                    var target = $(this).data('target');
                    var $input = $(target);

                    // Create temporary input
                    var $temp = $("<input>");
                    $("body").append($temp);

                    // Copy the value
                    $temp.val($input.val()).select();
                    document.execCommand("copy");
                    $temp.remove();

                    // Show SweetAlert toast
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Copied to clipboard!',
                        showConfirmButton: false,
                        timer: 1500,
                        toast: true,
                    });
                });
            };

            var initDeleteButtons = function() {
                // Delete business account confirmation
                window.confirmDeleteBusiness = function(element) {
                    const businessId = $(element).data('kt-business-id');

                    Swal.fire({
                        text: "Are you sure you want to delete this business account?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        }
                    }).then(function(result) {
                        if (result.value) {
                            // AJAX call to delete business account
                            $.ajax({
                                url: "{{ route('ctwameta.delete-business') }}",
                                method: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    business_id: businessId
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            text: "Business account deleted successfully!",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn fw-bold btn-primary",
                                            }
                                        }).then(function() {
                                            location.reload();
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        text: "Error deleting business account",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    });
                                }
                            });
                        }
                    });
                };

                // Delete page confirmation
                window.confirmDeletePage = function(element) {
                    const pageId = $(element).data('kt-page-id');

                    Swal.fire({
                        text: "Are you sure you want to delete this Facebook page?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        }
                    }).then(function(result) {
                        if (result.value) {
                            // AJAX call to delete page
                            $.ajax({
                                url: "{{ route('ctwameta.delete-page') }}",
                                method: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    page_id: pageId
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            text: "Facebook page deleted successfully!",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn fw-bold btn-primary",
                                            }
                                        }).then(function() {
                                            location.reload();
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        text: "Error deleting Facebook page",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    });
                                }
                            });
                        }
                    });
                };
            };

            var initCarousel = function() {
                // Initialize carousel if exists
                if (typeof tns !== 'undefined') {
                    const elements = document.querySelectorAll('.tns');
                    if (elements && elements.length > 0) {
                        elements.forEach(el => {
                            tns({
                                container: el,
                                mode: "carousel",
                                speed: 400,
                                autoplay: true,
                                autoplayTimeout: 5000,
                                autoplayButtonOutput: false,
                                mouseDrag: true,
                                gutter: 15,
                                nav: false,
                                controls: true,
                                responsive: {
                                    0: {
                                        items: 1,
                                    },
                                    576: {
                                        items: 2,
                                    },
                                    768: {
                                        items: 3,
                                    },
                                    992: {
                                        items: 4,
                                    }
                                },
                            });
                        });
                    }
                }
            };

            // Public methods
            return {
                init: function() {
                    cards = document.querySelectorAll('.business-account');

                    initFilters();
                    initDeleteButtons();
                    initCarousel();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTAccountMeta.init();
        });
    </script>
@endsection

@section('css')
    <style>
        /* Custom card hover effect */
        .card.card-flush:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Business account card header */
        .card-header {
            border-bottom: 1px solid #EFF2F5;
        }

        /* Ad account status indicators */
        .symbol-light-success .symbol-label {
            color: #50CD89 !important;
        }

        .symbol-light-warning .symbol-label {
            color: #F1BC00 !important;
        }

        .symbol-light-danger .symbol-label {
            color: #F1416C !important;
        }

        /* Delete button positioning */
        .card-toolbar .btn-icon {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .business-account {
                margin-bottom: 1.5rem;
            }
        }
    </style>
@endsection
