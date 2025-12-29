@extends('layouts.app-client')

@section('title', __('Agents Management'))

@section('content')
    <div class="container-xxl">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-profile-user fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    {{ __('Agents Management') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $setup['items']->total() }}
                    {{ __('Agents') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                @if ($setup['items']->isNotEmpty())
                    <div class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="table-search" class="form-control form-control-solid w-250px ps-10"
                            placeholder="{{ __('Search agents...') }}">
                    </div>
                @endif

                <a href="{{ route($setup['webroute_path'] . 'create') }}" class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>
                    {{ __('Add New Agent') }}
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        @if ($setup['items']->isNotEmpty())
            <div class="row g-6 mb-7">
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-dark">{{ $setup['items']->total() }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Total Agents') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span
                            class="fs-2hx fw-bolder text-success">{{ $setup['items']->where('is_active', true)->count() }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Active Agents') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span
                            class="fs-2hx fw-bolder text-warning">{{ $setup['items']->where('last_logged_in_on', '>=', now()->subDays(7))->count() }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Active This Week') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span
                            class="fs-2hx fw-bolder text-danger">{{ $setup['items']->where('is_active', false)->count() }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Inactive Agents') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Agents Table Card -->
        <div class="card">
            @if ($setup['items']->isNotEmpty())
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('All Agents') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted fs-7">{{ __('Filter by status:') }}</span>
                            <select class="form-select form-select-sm w-150px" id="status-filter">
                                <option value="">{{ __('All Agents') }}</option>
                                <option value="active">{{ __('Active Only') }}</option>
                                <option value="inactive">{{ __('Inactive Only') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-200px">{{ __('Agent') }}</th>
                                    <th class="min-w-150px">{{ __('Contact Info') }}</th>
                                    <th class="min-w-100px">{{ __('Status') }}</th>
                                    <th class="min-w-100px">{{ __('Last Login') }}</th>
                                    <th class="min-w-200px text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($setup['items'] as $item)
                                    <tr data-agent-id="{{ $item->id }}" class="agent-row"
                                        data-status="{{ $item->is_active ? 'active' : 'inactive' }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px symbol-circle me-5">
                                                    <div
                                                        class="symbol-label bg-light-{{ $item->is_active ? 'success' : 'danger' }}">
                                                        <span
                                                            class="fs-3 text-{{ $item->is_active ? 'success' : 'danger' }} fw-bolder">{{ substr($item->name, 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark fw-bolder fs-6 mb-1">{{ $item->name }}</span>
                                                    {{-- <span class="text-muted fs-7">ID: {{ $item->id }}</span> --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-semibold fs-6">{{ $item->email }}</span>
                                                <span class="text-muted fs-7">{{ $item->phone ?? __('No phone') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-light-{{ $item->is_active ? 'success' : 'danger' }} status-badge">
                                                {{ $item->is_active ? __('Active') : __('Inactive') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-7">
                                                @if ($item->last_logged_in_on)
                                                    {{ $item->last_logged_in_on->diffForHumans() }}
                                                @else
                                                    <span class="text-muted">{{ __('Never') }}</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2 align-items-center">
                                                <!-- Status Toggle Switch -->
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input status-toggle" type="checkbox"
                                                        data-agent-id="{{ $item->id }}"
                                                        data-agent-name="{{ $item->name }}"
                                                        {{ $item->is_active ? 'checked' : '' }}
                                                        style="width: 40px; height: 20px;">
                                                </div>

                                                <!-- Edit Button -->
                                                <a href="{{ route($setup['webroute_path'] . 'edit', [$setup['parameter_name'] => $item->id]) }}"
                                                    class="btn btn-icon btn-light-primary btn-sm"
                                                    title="{{ __('Edit Agent') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-pencil fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>

                                                <!-- Login As Button -->
                                                {{-- <a href="{{ route($setup['webroute_path'] . 'loginas', [$setup['parameter_name'] => $item->id]) }}"
                                                    class="btn btn-icon btn-light-success btn-sm"
                                                    title="{{ __('Login as Agent') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    onclick="return confirmLoginAs('{{ addslashes($item->name) }}')">
                                                    <i class="ki-duotone ki-profile-user fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </a> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($setup['items']->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center">
                            <span class="text-muted fs-7">
                                {{ __('Showing') }}
                                <strong>{{ $setup['items']->firstItem() ?? 0 }}</strong>
                                {{ __('to') }}
                                <strong>{{ $setup['items']->lastItem() ?? 0 }}</strong>
                                {{ __('of') }}
                                <strong>{{ $setup['items']->total() }}</strong>
                                {{ __('entries') }}
                            </span>
                        </div>
                        <div class="d-flex flex-wrap py-2">
                            {{ $setup['items']->links() }}
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
                                    <i class="ki-duotone ki-profile-user fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="text-dark fw-bolder mb-3">{{ __('No Agents Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('You haven\'t added any agents yet. Agents can help you manage your business operations and customer interactions.') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <a href="{{ route($setup['webroute_path'] . 'create') }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    {{ __('Add Your First Agent') }}
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
                                    {{ __('Agents can manage customer conversations, handle tickets, and assist with daily operations.') }}
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
                    <h2 class="modal-title">{{ __('About Agents') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="text-dark mb-3">{{ __('What can agents do?') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Manage customer conversations') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Handle support tickets') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Process orders and requests') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Collaborate with team members') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-dark mb-3">{{ __('Agent Status') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('Active') }}</span>
                                <span>{{ __('Agent can login and perform normal operations') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-danger me-3">{{ __('Inactive') }}</span>
                                <span>{{ __('Agent cannot login but data is preserved') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route($setup['webroute_path'] . 'create') }}"
                        class="btn btn-primary">{{ __('Create Agent') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Status toggle functionality
            const statusToggles = document.querySelectorAll('.status-toggle');
            statusToggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const agentId = this.getAttribute('data-agent-id');
                    const agentName = this.getAttribute('data-agent-name');
                    const isActive = this.checked;

                    updateAgentStatus(agentId, agentName, isActive, this);
                });
            });

            // Status filter functionality
            const statusFilter = document.getElementById('status-filter');
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    const status = this.value;
                    const rows = document.querySelectorAll('.agent-row');

                    rows.forEach(row => {
                        if (status === '' || row.getAttribute('data-status') === status) {
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
                    const rows = document.querySelectorAll('.agent-row');

                    if (searchTerm.length === 0) {
                        // Show all rows based on status filter
                        rows.forEach(row => {
                            if (statusFilterValue === '' || row.getAttribute('data-status') ===
                                statusFilterValue) {
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
                        const email = row.querySelector('td:nth-child(2) span.text-gray-800')
                            .textContent.toLowerCase();
                        const id = row.querySelector('td:first-child span.text-muted').textContent
                            .toLowerCase();

                        const matchesSearch = name.includes(searchTerm) ||
                            email.includes(searchTerm) ||
                            id.includes(searchTerm);

                        const matchesStatus = statusFilterValue === '' ||
                            row.getAttribute('data-status') === statusFilterValue;

                        row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                    });
                });
            }
        });

        function updateAgentStatus(agentId, agentName, isActive, toggleElement) {
            const newStatus = isActive ? 'active' : 'inactive';
            const currentStatus = isActive ? 'inactive' : 'active';

            Swal.fire({
                title: '{{ __('Change Agent Status') }}',
                html: `{{ __('Are you sure you want to mark') }} <strong>${agentName}</strong> {{ __('as') }} <strong>${newStatus}</strong>?`,
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

                    // Send AJAX request to update status
                    const url = '{{ route('agent.status.update', ['agent' => ':agentId']) }}'.replace(':agentId',
                        agentId);

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                is_active: isActive,
                                _method: 'POST'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update UI elements
                                const row = toggleElement.closest('tr');
                                const badge = row.querySelector('.status-badge');
                                const avatar = row.querySelector('.symbol-label');

                                // Update status badge
                                badge.className =
                                    `badge badge-light-${isActive ? 'success' : 'danger'} status-badge`;
                                badge.textContent = isActive ? '{{ __('Active') }}' : '{{ __('Inactive') }}';

                                // Update avatar color
                                avatar.className = `symbol-label bg-light-${isActive ? 'success' : 'danger'}`;
                                avatar.querySelector('span').className =
                                    `fs-3 text-${isActive ? 'success' : 'danger'} fw-bolder`;

                                // Update data attribute
                                row.setAttribute('data-status', isActive ? 'active' : 'inactive');

                                // Show success message
                                Swal.fire({
                                    title: '{{ __('Success') }}',
                                    text: `{{ __('Agent status has been updated to') }} ${newStatus}`,
                                    icon: 'success',
                                    confirmButtonText: '{{ __('OK') }}'
                                });

                                // Update stats cards (you might want to reload the page or update via AJAX)
                                setTimeout(() => {
                                    location.reload(); // Reload to update stats cards
                                }, 1000);

                            } else {
                                throw new Error(data.message || '{{ __('Failed to update status') }}');
                            }
                        })
                        .catch(error => {
                            // Revert toggle on error
                            toggleElement.checked = !isActive;
                            toggleElement.disabled = false;

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

        function confirmLoginAs(agentName) {
            return Swal.fire({
                title: '{{ __('Login as Agent') }}',
                html: `{{ __('You are about to login as') }} <strong>${agentName}</strong>. {{ __('You will be able to return to your account using the stop impersonation feature.') }}`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: '{{ __('Continue Login') }}',
                cancelButtonText: '{{ __('Cancel') }}',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-light'
                },
                buttonsStyling: false
            }).then((result) => result.isConfirmed);
        }
    </script>
@endpush

@push('css')
    <style>
        .agent-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #f3f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #3699ff;
            font-size: 1.25rem;
        }

        .card-dashed {
            border: 1px dashed #e4e6ef;
            background: #fafafa;
        }

        .flex-center {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .agent-row td {
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

            .agent-row .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .agent-row .d-flex.gap-2 .btn {
                margin: 0;
            }

            #status-filter {
                width: 100% !important;
                margin-top: 1rem;
            }
        }
    </style>
@endpush
