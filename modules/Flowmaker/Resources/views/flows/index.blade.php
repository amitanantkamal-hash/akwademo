@extends('layouts.app-client')

@section('title', $setup['title'] ?? __('Flow Management'))

@section('content')
    <div class="container-xxl">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-category fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                    </i>
                    {{ $setup['title'] ?? __('Flow Management') }}
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
                        @isset($setup['action_link'])
                            <li>
                                <a href="{{ $setup['action_link'] }}" class="dropdown-item">
                                    <i class="ki-duotone ki-plus fs-2 me-2"></i>
                                    {{ $setup['action_name'] }}
                                </a>
                            </li>
                        @endisset

                        @isset($setup['action_link2'])
                            <li>
                                <a href="{{ $setup['action_link2'] }}" class="dropdown-item">
                                    <i class="ki-duotone ki-category fs-2 me-2"></i>
                                    {{ $setup['action_name2'] }}
                                </a>
                            </li>
                        @endisset
                    </ul>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        @if ($setup['items']->isNotEmpty())
            {{-- <div class="row g-6 mb-7">
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-dark">{{ $setup['items']->total() }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Total Flows') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-success">{{ $setup['items']->count() }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Active') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-warning">0</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Draft') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-info">0</span>
                        <span class="text-gray-600 fw-semibold">{{ __('This Week') }}</span>
                    </div>
                </div>
            </div> --}}
        @endif

        <!-- Flows Table Card -->
        <div class="card">
            @if ($setup['items']->isNotEmpty())
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('All Flows') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <span class="text-muted fs-7">
                            {{ __('Showing') }} {{ $setup['items']->firstItem() }} - {{ $setup['items']->lastItem() }}
                            {{ __('of') }} {{ $setup['items']->total() }}
                        </span>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-250px">{{ __('Flow') }}</th>
                                    <th class="min-w-150px">{{ __('Status') }}</th>
                                    <th class="min-w-200px text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($setup['items'] as $item)
                                    <tr data-flow-id="{{ $item->id }}" class="flow-row">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px symbol-circle me-5">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-category fs-3 text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark fw-bolder fs-6 mb-1">{{ $item->name }}</span>
                                                    {{-- <span class="text-muted fs-7">ID: {{ $item->id }}</span> --}}
                                                    {{-- <span class="text-muted fs-8 mt-1">
                                                        <i class="ki-duotone ki-calendar-8 fs-4 me-1"></i>
                                                        {{ $item->created_at->format('M d, Y') }}
                                                    </span> --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-success status-badge">
                                                <i class="ki-duotone ki-check-circle fs-4 me-1 text-success"></i>
                                                {{ __('Active') }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2 align-items-center">
                                                <!-- Flow Maker Button -->
                                                <a href="{{ route('flowmaker.edit', ['flow' => $item->id]) }}"
                                                    class="btn btn-icon btn-light-success btn-sm"
                                                    title="{{ __('Flow Maker') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-pencil fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>

                                                <!-- Edit Button -->
                                                <a href="{{ route('flows.edit', ['flow' => $item->id]) }}"
                                                    class="btn btn-icon btn-light-primary btn-sm"
                                                    title="{{ __('Edit Flow') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-setting-3 fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>

                                                <!-- Export Button -->
                                                <a href="{{ url('/flows/view' . $item->id . '/export') }}"
                                                    class="btn btn-icon btn-light-info btn-sm"
                                                    title="{{ __('Export Flow Data') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-file-down fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>

                                                <!-- Import Button -->
                                                <a href="{{ url('/flows/view' . $item->id . '/import') }}"
                                                    class="btn btn-icon btn-light-warning btn-sm"
                                                    title="{{ __('Import Flow Data') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-file-up fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>

                                                <!-- Delete Button -->
                                                <button type="button"
                                                    class="btn btn-icon btn-light-danger btn-sm delete-flow-btn"
                                                    data-flow-id="{{ $item->id }}"
                                                    data-flow-name="{{ $item->name }}"
                                                    data-delete-url="{{ route('flows.delete', ['flow' => $item->id]) }}"
                                                    title="{{ __('Delete Flow') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-trash fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if (!$setup['hidePaging'] ?? false && $setup['items']->hasPages())
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
                            {{ $setup['items']->appends(request()->query())->links() }}
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
                                    <i class="ki-duotone ki-category fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="text-dark fw-bolder mb-3">{{ __('No Flows Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('You haven\'t created any flows yet. Flows help you automate processes and create interactive experiences for your users.') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                @isset($setup['action_link'])
                                    <a href="{{ $setup['action_link'] }}" class="btn btn-primary">
                                        <i class="ki-duotone ki-plus fs-2"></i>
                                        {{ $setup['action_name'] }}
                                    </a>
                                @endisset

                                @isset($setup['action_link2'])
                                    <a href="{{ $setup['action_link2'] }}" class="btn btn-primary">
                                        <i class="ki-duotone ki-category fs-2"></i>
                                        {{ $setup['action_name2'] }}
                                    </a>
                                @endisset
                            </div>

                            <!-- Additional Help -->
                            <div class="mt-10">
                                <div class="d-flex align-items-center text-muted fs-7">
                                    <i class="ki-duotone ki-information fs-3 me-2"></i>
                                    {{ __('Flows can automate workflows, process data, and create seamless user experiences.') }}
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
                    <h2 class="modal-title">{{ __('About Flow Management') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="text-dark mb-3">{{ __('What can you do with flows?') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Automate business processes') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Create interactive user experiences') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Process and manage data efficiently') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Integrate with various platforms') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-dark mb-3">{{ __('Flow Actions') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('Flow Maker') }}</span>
                                <span>{{ __('Design and build your flow logic') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-primary me-3">{{ __('Edit') }}</span>
                                <span>{{ __('Modify flow settings and configuration') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-info me-3">{{ __('Export') }}</span>
                                <span>{{ __('Download flow data for analysis') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-warning me-3">{{ __('Import') }}</span>
                                <span>{{ __('Upload data to your flow') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    @isset($setup['action_link'])
                        <a href="{{ $setup['action_link'] }}" class="btn btn-primary">{{ $setup['action_name'] }}</a>
                    @endisset
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

            // Search functionality
            const searchInput = document.getElementById('table-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('.flow-row');

                    if (searchTerm.length === 0) {
                        rows.forEach(row => row.style.display = '');
                        return;
                    }

                    rows.forEach(row => {
                        const flowName = row.querySelector('.text-dark').textContent.toLowerCase();
                        const flowId = row.querySelector('.text-muted').textContent.toLowerCase();

                        const matchesSearch = flowName.includes(searchTerm) || flowId.includes(
                            searchTerm);
                        row.style.display = matchesSearch ? '' : 'none';
                    });
                });
            }

            // Delete flow functionality
            document.querySelectorAll('.delete-flow-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const flowId = this.getAttribute('data-flow-id');
                    const flowName = this.getAttribute('data-flow-name');
                    const deleteUrl = this.getAttribute('data-delete-url');

                    // Permission check for staff users
                    @if (auth()->user()->hasRole('staff'))
                        showPermissionDeniedToast();
                        return;
                    @endif

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
                            Swal.fire({
                                title: '{{ __('Deleting...') }}',
                                html: '{{ __('Please wait while we delete the flow.') }}',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Use GET request as per original code
                            fetch(deleteUrl, {
                                    method: 'GET',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: '{{ __('Deleted') }}',
                                            text: '{{ __('Flow has been deleted successfully.') }}',
                                            icon: 'success',
                                            confirmButtonText: '{{ __('OK') }}'
                                        }).then(() => {
                                            // Remove the row with animation
                                            const row = document.querySelector(
                                                `[data-flow-id="${flowId}"]`
                                                );
                                            if (row) {
                                                row.style.opacity = '0';
                                                setTimeout(() => {
                                                    row.remove();
                                                    // Update stats if needed
                                                    location.reload();
                                                }, 300);
                                            } else {
                                                location.reload();
                                            }
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
            transition: all 0.3s ease;
        }

        .flow-row:hover {
            background-color: #f8f9fa;
            transform: translateX(4px);
        }

        .badge-light-success {
            background-color: #e8fff3;
            color: #50cd89;
        }

        .btn-icon {
            transition: all 0.3s ease;
        }

        .btn-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

            .table-responsive {
                font-size: 0.875rem;
            }
        }
    </style>
@endpush
