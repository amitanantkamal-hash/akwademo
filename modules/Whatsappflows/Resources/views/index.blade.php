@extends('layouts.app-client')

@section('title', __('WhatsApp Flow Management'))

@section('content')
    <div class="container-xxl">
        @php
            // Determine current status selection
            $currentStatus = request('status');
            $isDefaultPublished = $currentStatus === null && ($setup['default_status'] ?? 'PUBLISHED') === 'PUBLISHED';
        @endphp
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-message-text-2 fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    {{ __('WhatsApp Flow Management') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $setup['items']->total() }}
                    {{ __('Flows') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                @if ($setup['items']->isNotEmpty())
                    <div class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="table-search" class="form-control form-control-solid w-250px ps-10"
                            placeholder="{{ __('Search flows...') }}">
                    </div>
                @endif

                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        {{ __('Flow Actions') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="{{ route('whatsapp-flows.create') }}" class="dropdown-item">
                                <i class="ki-duotone ki-plus fs-2 me-2"></i>
                                {{ __('Create Flow') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('whatsapp-flows.load') }}" class="dropdown-item">
                                <i class="ki-duotone ki-arrows-circle fs-2 me-2"></i>
                                {{ __('Sync Flows') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('whatsapp-flows.submissions') }}" class="dropdown-item">
                                <i class="ki-duotone ki-chart-line fs-2 me-2"></i>
                                {{ __('View Flow Data') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        @if ($setup['items']->isNotEmpty())
            @php
                $flows = $setup['items'];
                $publishedCount = $flows->where('status', 'PUBLISHED')->count();
                $draftCount = $flows->where('status', 'DRAFT')->count();
                $deprecatedCount = $flows->where('status', 'DEPRECATED')->count();
                $totalDataCount = $flows->sum('whats_app_flow_data_count_count');
            @endphp
            <div class="row g-6 mb-7">
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-dark">{{ $flows->total() }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Total Flows') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-success">{{ $publishedCount }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Published') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-warning">{{ $draftCount }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Draft') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-danger">{{ $deprecatedCount }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Deprecated') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Flows Table Card -->
        <div class="card">
            @if ($setup['items']->isNotEmpty())
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('All WhatsApp Flows') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted fs-7">{{ __('Filter by status:') }}</span>
                            <form method="GET">
                                <select name="status" class="form-select form-select-sm w-150px" data-control="select2"
                                    data-hide-search="true" onchange="this.form.submit()">
                                    <option value="all"
                                        {{ $currentStatus === 'ALLStatus' || $isDefaultPublished ? 'selected' : '' }}>
                                        {{ __('All Status') }}
                                    </option>
                                    <option value="PUBLISHED"
                                        {{ $currentStatus === 'PUBLISHED' || $isDefaultPublished ? 'selected' : '' }}>
                                        {{ __('Published') }}
                                    </option>
                                    <option value="DEPRECATED" {{ $currentStatus === 'DEPRECATED' ? 'selected' : '' }}>
                                        {{ __('Deprecated') }}
                                    </option>
                                    <option value="DRAFT" {{ $currentStatus === 'DRAFT' ? 'selected' : '' }}>
                                        {{ __('Draft') }}
                                    </option>
                                </select>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">#</th>
                                    <th class="min-w-250px">{{ __('Flow') }}</th>
                                    <th class="min-w-150px">{{ __('Category') }}</th>
                                    <th class="min-w-120px">{{ __('Status') }}</th>
                                    <th class="min-w-100px text-end">{{ __('Data Count') }}</th>
                                    <th class="min-w-150px text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($setup['items'] as $index => $item)
                                    <tr data-flow-id="{{ $item->id }}" class="flow-row"
                                        data-status="{{ $item->status }}">
                                        <td>{{ ($setup['items']->currentPage() - 1) * $setup['items']->perPage() + $loop->iteration }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px symbol-circle me-5">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-message-text-2 fs-3 text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="text-dark fw-bolder fs-6 mb-1">{{ $item->flow_name }}</span>
                                                    <span class="text-muted fs-7">ID:
                                                        {{ $item->unique_flow_id ?? $item->id }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-light-info fs-8">{{ __($item->whatsapp_flow_category) }}</span>
                                        </td>
                                        <td>
                                            @if ($item->status == 'PUBLISHED')
                                                <span class="badge badge-light-success status-badge">
                                                    <i class="ki-duotone ki-check-circle fs-4 me-1 text-success"></i>
                                                    {{ __($item->status) }}
                                                </span>
                                            @elseif ($item->status == 'DEPRECATED')
                                                <span class="badge badge-light-danger status-badge">
                                                    <i class="ki-duotone ki-cross-circle fs-4 me-1 text-danger"></i>
                                                    {{ __($item->status) }}
                                                </span>
                                            @else
                                                <span class="badge badge-light-warning status-badge">
                                                    <i class="ki-duotone ki-clock fs-4 me-1 text-warning"></i>
                                                    {{ __($item->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <span
                                                class="text-dark fw-bolder">{{ $item->whats_app_flow_data_count_count }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2 align-items-center">
                                                <!-- View Data Button -->
                                                @if ($item->status == 'PUBLISHED' || $item->status == 'DEPRECATED')
                                                    <a href="{{ route('whatsapp-flows.viewdata', $item->id) }}"
                                                        class="btn btn-icon btn-light-success btn-sm"
                                                        title="{{ __('View Data') }}" data-bs-toggle="tooltip"
                                                        data-bs-placement="top">
                                                        <i class="ki-duotone ki-eye fs-4">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </a>
                                                @endif

                                                <!-- Publish Button -->
                                                @if ($item->status == 'DRAFT')
                                                    <form action="{{ route('whatsapp-flows.publish', $item->id) }}"
                                                        method="GET" class="d-inline publish-form">
                                                        @csrf
                                                        <button type="button"
                                                            class="btn btn-icon btn-light-warning btn-sm publish-btn"
                                                            data-flow-id="{{ $item->id }}"
                                                            data-flow-name="{{ $item->flow_name }}"
                                                            title="{{ __('Publish Flow') }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="top">
                                                            <i class="ki-duotone ki-check-circle fs-4">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Deprecate Button -->
                                                @if ($item->status == 'PUBLISHED')
                                                    <button type="button"
                                                        class="btn btn-icon btn-light-danger btn-sm deprecate-btn"
                                                        data-flow-id="{{ $item->id }}"
                                                        data-flow-name="{{ $item->flow_name }}"
                                                        title="{{ __('Deprecate Flow') }}" data-bs-toggle="tooltip"
                                                        data-bs-placement="top">
                                                        <i class="ki-duotone ki-cross-circle fs-4">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </button>
                                                @endif

                                                <!-- Preview Button -->
                                                <a href="{{ $item->preview_url }}"
                                                    class="btn btn-icon btn-light-info btn-sm" target="_blank"
                                                    title="{{ __('Preview Flow') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-eye fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>

                                                <!-- Delete Button -->
                                                @if ($item->status != 'DEPRECATED' && $item->status == 'DRAFT')
                                                    <button type="button"
                                                        class="btn btn-icon btn-light-danger btn-sm delete-btn"
                                                        data-flow-id="{{ $item->id }}"
                                                        data-flow-name="{{ $item->flow_name }}"
                                                        title="{{ __('Delete Flow') }}" data-bs-toggle="tooltip"
                                                        data-bs-placement="top">
                                                        <i class="ki-duotone ki-trash fs-4">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </button>
                                                @endif
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
                            {{ $setup['items']->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            @else
                @if (request()->has('status') || request()->has('search'))
                    <!-- No Results for Filter -->
                    <div class="card-body">
                        <div class="text-center py-10">
                            <div class="symbol symbol-100px symbol-circle mb-5">
                                <div class="symbol-label bg-light-warning">
                                    <i class="ki-duotone ki-message-text-2 fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                            </div>
                            <h3 class="text-dark fw-bolder mb-3">{{ __('No Flows Match Your Criteria') }}</h3>
                            <p class="text-muted fs-5 mb-6">
                                {{ __('Try adjusting your filters or reset to see all flows.') }}
                            </p>
                            <a href="{{ route('whatsapp-flows.index') }}" class="btn btn-light btn-primary">
                                <i class="ki-duotone ki-arrow-circle-left fs-2"></i>
                                {{ __('Reset Filters') }}
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="card-body">
                        <div class="text-center py-10">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <!-- Icon -->
                                <div class="symbol symbol-100px symbol-circle mb-5">
                                    <div class="symbol-label bg-light-primary">
                                        <i class="ki-duotone ki-message-text-2 fs-2hx text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </div>
                                </div>

                                <!-- Text -->
                                <h3 class="text-dark fw-bolder mb-3">{{ __('No WhatsApp Flows Found') }}</h3>
                                <p class="text-muted fs-5 mb-6 w-lg-400px">
                                    {{ __('You haven\'t created any WhatsApp flows yet. Flows help you create interactive experiences for your customers on WhatsApp.') }}
                                </p>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-3">
                                    <a href="{{ route('whatsapp-flows.create') }}" class="btn btn-primary">
                                        <i class="ki-duotone ki-plus fs-2"></i>
                                        {{ __('Create Your First Flow') }}
                                    </a>
                                    <a href="{{ route('whatsapp-flows.load') }}" class="btn btn-light">
                                        <i class="ki-duotone ki-arrows-circle fs-2"></i>
                                        {{ __('Sync Existing Flows') }}
                                    </a>
                                </div>

                                <!-- Additional Help -->
                                <div class="mt-10">
                                    <div class="d-flex align-items-center text-muted fs-7">
                                        <i class="ki-duotone ki-information fs-3 me-2"></i>
                                        {{ __('WhatsApp Flows allow you to create guided experiences for customers within WhatsApp conversations.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @endif
        </div>
    </div>

    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{ __('About WhatsApp Flows') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="text-dark mb-3">{{ __('What are WhatsApp Flows?') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Interactive experiences within WhatsApp') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Guide customers through processes') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Collect information and process requests') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Enhance customer engagement') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-dark mb-3">{{ __('Flow Status') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('Published') }}</span>
                                <span>{{ __('Flow is active and can be used by customers') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-warning me-3">{{ __('Draft') }}</span>
                                <span>{{ __('Flow is under development and not yet published') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-danger me-3">{{ __('Deprecated') }}</span>
                                <span>{{ __('Flow is no longer active but data is preserved') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route('whatsapp-flows.create') }}" class="btn btn-primary">{{ __('Create Flow') }}</a>
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

            // Status filter functionality
            const statusFilter = document.getElementById('status-filter');
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    const status = this.value;
                    const rows = document.querySelectorAll('.flow-row');

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
                    const rows = document.querySelectorAll('.flow-row');

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
                        const name = row.querySelector('td:nth-child(2) span.text-dark').textContent
                            .toLowerCase();
                        const category = row.querySelector('td:nth-child(3) span').textContent
                            .toLowerCase();
                        const id = row.querySelector('td:nth-child(2) span.text-muted').textContent
                            .toLowerCase();

                        const matchesSearch = name.includes(searchTerm) ||
                            category.includes(searchTerm) ||
                            id.includes(searchTerm);

                        const matchesStatus = statusFilterValue === '' ||
                            row.getAttribute('data-status') === statusFilterValue;

                        row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                    });
                });
            }

            // Permission check
            const isStaff = @json(auth()->user()->hasRole('staff'));

            // Publish functionality
            document.querySelectorAll('.publish-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (isStaff) {
                        showPermissionDeniedToast();
                        return;
                    }

                    const flowId = this.getAttribute('data-flow-id');
                    const flowName = this.getAttribute('data-flow-name');
                    const form = this.closest('form');

                    Swal.fire({
                        title: '{{ __('Publish Flow') }}',
                        html: `{{ __('Are you sure you want to publish') }} <strong>"${flowName}"</strong>?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: `{{ __('Yes, publish') }}`,
                        cancelButtonText: '{{ __('Cancel') }}',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-light'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Deprecate functionality
            document.querySelectorAll('.deprecate-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (isStaff) {
                        showPermissionDeniedToast();
                        return;
                    }

                    const flowId = this.getAttribute('data-flow-id');
                    const flowName = this.getAttribute('data-flow-name');

                    Swal.fire({
                        title: '{{ __('Deprecate Flow') }}',
                        html: `{{ __('Are you sure you want to deprecate') }} <strong>"${flowName}"</strong>? {{ __('This action cannot be undone.') }}`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: `{{ __('Yes, deprecate') }}`,
                        cancelButtonText: '{{ __('Cancel') }}',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'btn btn-danger',
                            cancelButton: 'btn btn-light'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`{{ route('whatsapp-flows.deprecate', '') }}/${flowId}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(async response => {
                                    const data = await response.json();
                                    if (data.success) {
                                        Swal.fire({
                                            title: '{{ __('Deprecated') }}',
                                            text: `{{ __('Flow has been deprecated successfully.') }}`,
                                            icon: 'success',
                                            confirmButtonText: '{{ __('OK') }}'
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        throw new Error(data.message ||
                                            '{{ __('Failed to deprecate flow') }}'
                                        );
                                    }
                                })
                                .catch(error => {
                                    Swal.fire({
                                        title: '{{ __('Error') }}',
                                        text: error.message,
                                        icon: 'error',
                                        confirmButtonText: '{{ __('OK') }}'
                                    });
                                });
                        }
                    });
                });
            });

            // Delete functionality
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (isStaff) {
                        showPermissionDeniedToast();
                        return;
                    }

                    const flowId = this.getAttribute('data-flow-id');
                    const flowName = this.getAttribute('data-flow-name');

                    Swal.fire({
                        title: '{{ __('Delete Flow') }}',
                        html: `{{ __('Are you sure you want to delete') }} <strong>"${flowName}"</strong>? {{ __('This action cannot be undone.') }}`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: `{{ __('Yes, delete') }}`,
                        cancelButtonText: '{{ __('Cancel') }}',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'btn btn-danger',
                            cancelButton: 'btn btn-light'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`{{ route('whatsapp-flows.destroy', '') }}/${flowId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: '{{ __('Deleted') }}',
                                            text: `{{ __('Flow has been deleted successfully.') }}`,
                                            icon: 'success',
                                            confirmButtonText: '{{ __('OK') }}'
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        throw new Error(data.message ||
                                            '{{ __('Failed to delete flow') }}');
                                    }
                                })
                                .catch(error => {
                                    Swal.fire({
                                        title: '{{ __('Error') }}',
                                        text: error.message,
                                        icon: 'error',
                                        confirmButtonText: '{{ __('OK') }}'
                                    });
                                });
                        }
                    });
                });
            });

            function showPermissionDeniedToast() {
                Swal.fire({
                    icon: 'warning',
                    title: '{{ __('Permission Denied') }}',
                    text: '{{ __('You do not have rights to perform this action.') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }
        });
    </script>
@endpush

@push('css')
    <style>
        .flow-avatar {
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

        .flow-row td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .badge-light-primary {
            background-color: #f1faff;
            color: #3699ff;
        }

        .badge-light-success {
            background-color: #e8fff3;
            color: #50cd89;
        }

        .badge-light-warning {
            background-color: #fff8dd;
            color: #ffc700;
        }

        .badge-light-danger {
            background-color: #ffe2e5;
            color: #f1416c;
        }

        .badge-light-info {
            background-color: #f8f5ff;
            color: #8950fc;
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

            .flow-row .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .flow-row .d-flex.gap-2 .btn {
                margin: 0;
            }

            #status-filter {
                width: 100% !important;
                margin-top: 1rem;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }
    </style>
@endpush
