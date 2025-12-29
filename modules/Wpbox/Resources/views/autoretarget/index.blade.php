@extends('client.app', ['title' => __('AutoRetarget Campaigns')])

@section('content')
    <div class="container-xxl">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-rocket fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    {{ __('AutoRetarget Campaigns') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $autoretargetCampaigns->total() }}
                    {{ __('Campaigns') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                @if ($autoretargetCampaigns->isNotEmpty())
                    <div class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="table-search" class="form-control form-control-solid w-250px ps-10"
                            placeholder="{{ __('Search campaigns...') }}">
                    </div>
                @endif

                <a href="{{ route('autoretarget.create') }}" class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>
                    {{ __('Create New') }}
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        @if ($autoretargetCampaigns->isNotEmpty())
            @php
                $activeCampaigns = $autoretargetCampaigns->where('is_active', true)->count();
                $inactiveCampaigns = $autoretargetCampaigns->where('is_active', false)->count();
                $totalMessages = $autoretargetCampaigns->sum(function ($campaign) {
                    return $campaign->messages->count();
                });
                $averageMessages =
                    $autoretargetCampaigns->count() > 0
                        ? round($totalMessages / $autoretargetCampaigns->count(), 1)
                        : 0;
            @endphp

            <div class="row g-6 mb-7">
                <div class="col-xl-6 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #3699FF;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-primary me-4">
                                <i class="ki-duotone ki-rocket fs-2hx text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value text-dark">{{ $autoretargetCampaigns->total() }}</span>
                                <span class="stats-label">{{ __('Total Campaigns') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #1BC5BD;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-success me-4">
                                <i class="ki-duotone ki-check-circle fs-2hx text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value text-dark">{{ $activeCampaigns }}</span>
                                <span class="stats-label">{{ __('Active Campaigns') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-xl-6 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #FFA800;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-warning me-4">
                                <i class="ki-duotone ki-message-text fs-2hx text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value text-dark">{{ $totalMessages }}</span>
                                <span class="stats-label">{{ __('Total Messages') }}</span>
                            </div>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #F64E60;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-danger me-4">
                                <i class="ki-duotone ki-information fs-2hx text-danger">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value text-dark">{{ $averageMessages }}</span>
                                <span class="stats-label">{{ __('Avg Messages/Campaign') }}</span>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        @endif

        <!-- Campaigns Table Card -->
        <div class="card">
            @if ($autoretargetCampaigns->isNotEmpty())
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('All Campaigns') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted fs-7">{{ __('Filter by status:') }}</span>
                            <select class="form-select form-select-sm w-150px" id="status-filter">
                                <option value="">{{ __('All Statuses') }}</option>
                                <option value="active">{{ __('Active Only') }}</option>
                                <option value="inactive">{{ __('Inactive Only') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6"
                            id="campaigns-table">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-250px">{{ __('Campaign') }}</th>
                                    <th class="min-w-200px">{{ __('Description') }}</th>
                                    <th class="min-w-100px text-center">{{ __('Messages') }}</th>
                                    <th class="min-w-120px">{{ __('Status') }}</th>
                                    <th class="min-w-150px text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($autoretargetCampaigns as $campaign)
                                    <tr data-campaign-status="{{ $campaign->is_active ? 'active' : 'inactive' }}"
                                        class="campaign-row">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px symbol-circle me-5">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-rocket fs-2 text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="text-dark fw-bolder fs-6 mb-1">{{ $campaign->name }}</span>
                                                    {{-- <span class="text-muted fs-7">ID: {{ $campaign->id }}</span> --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="text-muted fs-7">{{ Str::limit($campaign->description, 60) }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{ $campaign->messages->count() }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <!-- Status Toggle Switch -->
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input status-toggle" type="checkbox"
                                                        data-campaign-id="{{ $campaign->id }}"
                                                        data-campaign-name="{{ $campaign->name }}"
                                                        {{ $campaign->is_active ? 'checked' : '' }}>
                                                </div>
                                                <!-- Status Badge -->
                                                <span
                                                    class="badge badge-light-{{ $campaign->is_active ? 'success' : 'danger' }}">
                                                    {{ $campaign->is_active ? __('Active') : __('Inactive') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2 align-items-center">
                                                <!-- Edit Button -->
                                                <a href="{{ route('autoretarget.edit', $campaign) }}"
                                                    class="btn btn-icon btn-light-primary btn-sm"
                                                    title="{{ __('Edit Campaign') }}" data-bs-toggle="tooltip">
                                                    <i class="ki-duotone ki-pencil fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('autoretarget.destroy', $campaign) }}"
                                                    method="POST" class="delete-campaign-form d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-icon btn-light-danger btn-sm delete-campaign"
                                                        data-campaign-id="{{ $campaign->id }}"
                                                        data-campaign-name="{{ $campaign->name }}"
                                                        title="{{ __('Delete Campaign') }}" data-bs-toggle="tooltip">
                                                        <i class="ki-duotone ki-trash fs-4">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($autoretargetCampaigns->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center">
                            <span class="text-muted fs-7">
                                {{ __('Showing') }}
                                <strong>{{ $autoretargetCampaigns->firstItem() ?? 0 }}</strong>
                                {{ __('to') }}
                                <strong>{{ $autoretargetCampaigns->lastItem() ?? 0 }}</strong>
                                {{ __('of') }}
                                <strong>{{ $autoretargetCampaigns->total() }}</strong>
                                {{ __('entries') }}
                            </span>
                        </div>
                        <div class="d-flex flex-wrap py-2">
                            {{ $autoretargetCampaigns->links('vendor.pagination.metronic') }}
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="card-body">
                    <div class="text-center py-10">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <!-- Icon -->
                            <div class="symbol symbol-100px symbol-circle mb-5">
                                <div class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-rocket fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="text-dark fw-bolder mb-3">{{ __('No Campaigns Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('You haven\'t created any AutoRetarget campaigns yet. These campaigns help you automatically re-engage with your contacts based on their interactions.') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <a href="{{ route('autoretarget.create') }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    {{ __('Create Your First Campaign') }}
                                </a>
                                <a href="#" class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#helpModal">
                                    <i class="ki-duotone ki-information fs-2"></i>
                                    {{ __('Learn More') }}
                                </a>
                            </div>

                            <!-- Additional Help -->
                            <div class="mt-10">
                                <div class="d-flex align-items-center text-muted fs-7">
                                    <i class="ki-duotone ki-information fs-3 me-2"></i>
                                    {{ __('AutoRetarget campaigns automatically send follow-up messages to contacts based on specific triggers and conditions.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{ __('About AutoRetarget Campaigns') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="text-dark mb-3">{{ __('What are AutoRetarget Campaigns?') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Automatically re-engage inactive contacts') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Send targeted follow-up messages') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Improve conversion rates') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Save time with automation') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-dark mb-3">{{ __('Campaign Status') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('Active') }}</span>
                                <span>{{ __('Campaign is running and sending messages') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-danger me-3">{{ __('Inactive') }}</span>
                                <span>{{ __('Campaign is paused and not sending messages') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route('autoretarget.create') }}" class="btn btn-primary">{{ __('Create Campaign') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Status filter functionality
            const statusFilter = document.getElementById('status-filter');
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    const status = this.value;
                    const rows = document.querySelectorAll('.campaign-row');

                    rows.forEach(row => {
                        if (status === '' || row.getAttribute('data-campaign-status') === status) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Search functionality
            const searchInput = document.getElementById('table-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const statusFilterValue = statusFilter ? statusFilter.value : '';
                    const rows = document.querySelectorAll('.campaign-row');

                    if (searchTerm.length === 0) {
                        // Show all rows based on status filter
                        rows.forEach(row => {
                            if (statusFilterValue === '' || row.getAttribute(
                                'data-campaign-status') === statusFilterValue) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                        return;
                    }

                    rows.forEach(row => {
                        const name = row.querySelector('td:first-child span.text-dark').textContent
                            .toLowerCase();
                        const description = row.querySelector('td:nth-child(2) span').textContent
                            .toLowerCase();
                        const id = row.querySelector('td:first-child span.text-muted').textContent
                            .toLowerCase();

                        const matchesSearch = name.includes(searchTerm) ||
                            description.includes(searchTerm) ||
                            id.includes(searchTerm);

                        const matchesStatus = statusFilterValue === '' ||
                            row.getAttribute('data-campaign-status') === statusFilterValue;

                        row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                    });
                });
            }

            // Status toggle functionality
            const statusToggles = document.querySelectorAll('.status-toggle');
            statusToggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const campaignId = this.getAttribute('data-campaign-id');
                    const campaignName = this.getAttribute('data-campaign-name');
                    const isActive = this.checked;

                    updateCampaignStatus(campaignId, campaignName, isActive, this);
                });
            });

            // Delete campaign functionality
            const isStaff = @json(auth()->user()->hasRole('staff'));

            document.querySelectorAll('.delete-campaign').forEach(button => {
                button.addEventListener('click', function() {
                    if (isStaff) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Permission Denied',
                            text: 'You do not have rights to delete this campaign.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        return;
                    }

                    const campaignId = this.getAttribute('data-campaign-id');
                    const campaignName = this.getAttribute('data-campaign-name');
                    const form = this.closest('.delete-campaign-form');

                    Swal.fire({
                        title: 'Delete Campaign?',
                        html: `<div class="text-center">
                            <i class="ki-duotone ki-question fs-2hx text-danger mb-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <p class="fs-5">Are you sure you want to delete<br><b>${campaignName}</b>?</p>
                            <p class="text-muted fs-7">This action cannot be undone</p>
                        </div>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-danger px-6',
                            cancelButton: 'btn btn-light px-6'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            function updateCampaignStatus(campaignId, campaignName, isActive, toggleElement) {
                const newStatus = isActive ? 'active' : 'inactive';
                const currentStatus = isActive ? 'inactive' : 'active';

                Swal.fire({
                    title: '{{ __('Change Campaign Status') }}',
                    html: `{{ __('Are you sure you want to mark') }} <strong>${campaignName}</strong> {{ __('as') }} <strong>${newStatus}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: `{{ __('Yes, mark as') }} ${newStatus}`,
                    cancelButtonText: '{{ __('Cancel') }}',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: `btn btn-${isActive ? 'success' : 'danger'}`,
                        cancelButton: 'btn btn-light'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state on toggle
                        toggleElement.disabled = true;

                        fetch("{{ url('/autoretarget/toggle-status') }}/" + campaignId, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "X-Requested-With": "XMLHttpRequest"
                                },
                                body: JSON.stringify({
                                    enabled: isActive,
                                    autoretarget_campaign_id: campaignId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update UI elements
                                    const row = toggleElement.closest('tr');
                                    const badge = row.querySelector('.badge');

                                    // Update status badge
                                    badge.className =
                                        `badge badge-light-${isActive ? 'success' : 'danger'}`;
                                    badge.textContent = isActive ? '{{ __('Active') }}' :
                                        '{{ __('Inactive') }}';

                                    // Update data attribute
                                    row.setAttribute('data-campaign-status', isActive ? 'active' :
                                        'inactive');

                                    // Show success message
                                    Swal.fire({
                                        title: '{{ __('Success') }}',
                                        text: `{{ __('Campaign status has been updated to') }} ${newStatus}`,
                                        icon: 'success',
                                        confirmButtonText: '{{ __('OK') }}'
                                    });

                                } else {
                                    throw new Error(data.message ||
                                        '{{ __('Failed to update status') }}');
                                }
                            })
                            .catch(error => {
                                // Revert toggle on error
                                toggleElement.checked = !isActive;

                                Swal.fire({
                                    title: '{{ __('Error') }}',
                                    text: error.message,
                                    icon: 'error',
                                    confirmButtonText: '{{ __('OK') }}'
                                });
                            })
                            .finally(() => {
                                toggleElement.disabled = false;
                            });
                    } else {
                        // Revert toggle if cancelled
                        toggleElement.checked = !isActive;
                    }
                });
            }

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
        });
    </script>
@endsection

@push('css')
    <style>
        .stats-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stats-value {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
        }

        .stats-label {
            font-size: 0.9rem;
            color: #7E8299;
            font-weight: 500;
        }

        .campaign-row td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        /* Custom switch styling */
        .form-check-input.status-toggle {
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #50cd89;
            border-color: #50cd89;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(80, 205, 137, 0.25);
        }

        @media (max-width: 768px) {
            .d-flex.flex-column.flex-sm-row {
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .d-flex.flex-column.flex-sm-row .btn {
                margin-top: 1rem;
                width: 100%;
            }

            .w-250px {
                width: 100% !important;
            }

            .campaign-row .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            #status-filter {
                width: 100% !important;
                margin-top: 1rem;
            }
        }
    </style>
@endpush
