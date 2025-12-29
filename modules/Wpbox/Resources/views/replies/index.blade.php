@extends('layouts.app-client')

@section('title', $setup['title'] ?? __('Replies Management'))

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('Metronic/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" />
    <style>
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.05);
        }

        .card-header-custom {
            background: linear-gradient(90deg, #f8f9fa 0%, #ffffff 100%);
            border-bottom: 1px solid #ebedf3;
            padding: 1.5rem 2rem;
            border-radius: 10px 10px 0 0 !important;
        }

        .action-buttons .btn {
            transition: all 0.3s ease;
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateX(2px);
        }

        .badge-light-success {
            background-color: rgba(25, 187, 135, 0.1);
            color: #19bb87;
            font-weight: 500;
        }

        .filter-collapse {
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-top: -10px;
        }

        .pagination-custom .page-item.active .page-link {
            background-color: #3699ff;
            border-color: #3699ff;
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .status-active {
            background-color: #19bb87;
        }

        .status-inactive {
            background-color: #f64e60;
        }

        .template-preview {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            margin-left: 5px;
        }

        .btn-icon-primary {
            background-color: rgba(54, 153, 255, 0.1);
            color: #3699ff;
        }

        .btn-icon-primary:hover {
            background-color: rgba(54, 153, 255, 0.2);
        }

        .btn-icon-danger {
            background-color: rgba(246, 78, 96, 0.1);
            color: #f64e60;
        }

        .btn-icon-danger:hover {
            background-color: rgba(246, 78, 96, 0.2);
        }

        .empty-state {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 3rem;
            text-align: center;
        }

        .empty-state-icon {
            font-size: 3.5rem;
            color: #e4e6ef;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl">

        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-message-text-2 fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    {{ $setup['title'] ?? __('Replies Management') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $setup['items']->count() }}
                    {{ __('Replies') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                @if ($setup['items']->isNotEmpty())
                    <div class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="reply-search" class="form-control form-control-solid w-250px ps-10"
                            placeholder="{{ __('Search replies...') }}">
                    </div>
                @endif

                @isset($setup['action_link'])
                    <a href="{{ $setup['action_link'] }}" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        {{ $setup['action_name'] }}
                    </a>
                @endisset

                @isset($setup['action_link2'])
                    <a href="{{ $setup['action_link2'] }}" class="btn btn-light-success">
                        <i class="ki-duotone ki-category fs-3 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        {{ $setup['action_name2'] }}
                    </a>
                @endisset
            </div>
        </div>
        <div class="card card-custom gutter-b">
            @isset($setup['usefilter'])
                <div class="collapse mt-3 filter-collapse" id="filterCollapse">
                    <div class="card-body pt-4 pb-2">
                        <form method="GET" action="">
                            <div class="row g-4 align-items-end">
                                @foreach ($setup['filterFields'] as $field)
                                    <div class="col-md-3">
                                        @include('partials.form-field', ['field' => $field])
                                    </div>
                                @endforeach
                                <div class="col-md-3">
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="ki-duotone ki-filter fs-2 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            {{ __('Apply') }}
                                        </button>
                                        <a href="" class="btn btn-light">{{ __('Reset') }}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endisset

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-hover table-row-bordered align-middle gy-4">
                        <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                            <tr>
                                <th class="min-w-150px">{{ __('Name') }}</th>
                                @if (request('type') != 'qr')
                                    <th class="min-w-200px">{{ __('Type') }}</th>
                                    <th class="min-w-200px">{{ __(key: 'Status') }}</th>
                                    {{-- <th class="min-w-50px text-center">{{ __('Buttons') }}</th> --}}
                                @endif
                                <th class="text-end text-nowrap"></th>
                            </tr>
                        </thead>
                        <tbody class="fs-6">
                            @forelse ($setup['items'] as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light-primary">
                                                    <i class="ki-duotone ki-message-text-2 fs-2 text-primary">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="text-dark fw-bold d-block">{{ $item->name }}</span>
                                                @if ($item->type == 1)
                                                    <span
                                                        class="text-gray-400 ">{{ Str::limit($item->text, 75, '...') }}</span>
                                                @endif
                                                {{-- <span class="text-muted fs-7">Created: {{ $item->created_at->format('M d, Y') }}</span> --}}
                                            </div>
                                        </div>
                                    </td>
                                    @if ($item->type != '1')
                                        <td class="border-bottom">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-600">
                                                        @if (isset($item->template_id))
                                                            {{ $item->bot_type == 2 ? __('Template bot: On exact match') : __('Template bot: When message contains') }}
                                                        @else
                                                            {{ $item->type == 1 ? __('Quick reply') : ($item->type == 2 ? __('Text bot: On exact match') : ($item->type == 4 ? __('Text bot: Welcome') : __('Text bot: When message contains'))) }}
                                                        @endif
                                                    </span>
                                                    <span class="text-gray-600">
                                                        @if (isset($item->trigger))
                                                            {{ __('Trigger by keyword') }}: <span
                                                                class="text-info">{{ __($item->trigger) }}</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-bottom">
                                            @if ($item->is_bot_active)
                                                <span
                                                    class="badge badge-light-success py-2 px-3">{{ __('Active') }}</span>
                                            @else
                                                <span
                                                    class="badge badge-light-danger py-2 px-3">{{ __('Deactive') }}</span>
                                            @endif
                                        </td>
                                    @endif
                                    {{-- <td>
                                        @php
                                            $options = [];
                                            $data = json_decode($item->template);
                                            if (!empty($data->templateButtons)) {
                                                $options = $data->templateButtons;
                                            }
                                        @endphp
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($options as $btn)
                                                <span class="badge badge-light-success py-3 px-3 d-flex align-items-center">
                                                    <i class="ki-duotone ki-message-2 fs-4 me-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    {{ $btn->quickReplyButton->displayText ?? ($btn->urlButton->displayText ?? ($btn->callButton->displayText ?? '')) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-center">

                                    </td>
                                    <td class="text-center">

                                    </td>
                                    <td class="text-center"> --}}

                                    </td>
                                    @if (isset($item->template_id))
                                        <td class="text-end border-bottom text-nowrap py-4 pe-4">

                                            <div class="dropdown dropdown-fixed dropdown-hide-arrow">
                                                <!-- ANALYTICS -->
                                                <a href="{{ route('campaigns.show', $item->id) }}"
                                                    class="btn btn-light-info btn-sm">
                                                    <i class="fas fa-analytics"></i> {{ __('Analytics') }}
                                                </a>
                                                {{-- <button
                                                    class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle px-3"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fad fa-th-list pe-0"></i>
                                                </button> --}}

                                                <a href="#"
                                                    class="btn btn-icon btn-light btn-active-light-danger btn-sm delete-btn"
                                                    data-url="{{ route('campaigns.deletes', $item->id) }}"
                                                    data-bs-toggle="tooltip" title="Delete">
                                                    <i class="ki-duotone ki-trash fs-3 text-danger">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </a>

                                                {{--   <ul class="dropdown-menu dropdown-menu-end">
                                                     <li>
                            <a href="{{ route('replies.edit', ['reply' => $item->id]) }}" class="dropdown-item"
                                data-remove-other-active="true" data-active="bg-light-primary" data-result="html"
                                data-content="main-wrapper"
                                data-history="{{ route('replies.edit', ['reply' => $item->id]) }}"
                                data-call-after="Core.calendar();">
                                <i class="fad fa-pen-square pe-2"></i> {{ __('Edit') }} </a>
                        </li> --}}
                                                {{-- <li>
                                <!-- Activate and Deactivate -->
                                @if ($item->is_bot_active)
                                    <a href="{{ route('campaigns.deactivatebot', $item->id) }}" class="dropdown-item">
                                        <i class="fa fa-ban pe-2"></i> {{ __('Deactivate') }}
                                    </a>
                                @else
                                    <a href="{{ route('campaigns.activatebot', $item->id) }}" class="dropdown-item">
                                        <i class="fa fa-bolt pe-2"></i> {{ __('Activate') }}
                                    </a>
                                @endif
                            </li> --}}


                                                {{-- <li>
                                                        <a href="{{ route('campaigns.delete', $item->id) }}"
                                                            class="dropdown-item"
                                                            data-confirm="Are you sure to delete this items?"
                                                            data-remove="item" data-active="bg-light-primary">
                                                            <i class="fad fa-trash-alt pe-2"></i> {{ __('Delete') }} </a>
                                                    </li> 
                                                </ul> --}}
                                            </div>

                                        </td>
                                    @else
                                        <td class="text-end border-bottom text-nowrap py-4 pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                {{-- <a href="#"
                                                class="btn btn-icon btn-light btn-active-light-primary btn-sm"
                                                data-bs-toggle="tooltip" title="Edit">
                                                <i class="ki-duotone ki-pencil fs-2 text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a> --}}

                                                @php
                                                    $type = 'bot'; // Default value
                                                    $currentParams = request()->query();

                                                    if (request()->query('type') === 'qr') {
                                                        $type = 'qr';
                                                    } elseif (request()->query('bot') === 'catalog') {
                                                        $type = 'catalog';
                                                    }
                                                @endphp

                                                <a href="{{ route(
                                                    'replies.edit',
                                                    [
                                                        'reply' => $item->id,
                                                        'type' => $type,
                                                    ] + $currentParams,
                                                ) }}"
                                                    class="btn btn-icon btn-light btn-active-light-primary btn-sm"
                                                    data-id="{{ $item->id }}" title="Edit">
                                                    <i class="ki-duotone ki-pencil fs-3 text-info">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>

                                                <a href="#"
                                                    class="btn btn-icon btn-light btn-active-light-danger btn-sm delete-btn"
                                                    data-id="{{ $item->id }}"
                                                    data-url="{{ route('replies.delete', ['reply' => $item->id]) }}"
                                                    data-bs-toggle="tooltip" title="Delete">
                                                    <i class="ki-duotone ki-trash fs-3 text-danger">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </a>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="ki-duotone ki-message-text-2 fs-2hx">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </div>
                                            <h3 class="fw-bold text-gray-700 mb-2">{{ __('No record found') }}</h3>
                                            <p class="text-muted mb-5">
                                                {{ __('There are no replies created yet') }}</p>
                                            @isset($setup['action_link'])
                                                <a href="{{ $setup['action_link'] }}" class="btn btn-primary">
                                                    <i class="ki-duotone ki-plus fs-2 me-1"></i> {{ $setup['action_name'] }}
                                                </a>
                                            @endisset
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if (!($setup['hidePaging'] ?? false) && $setup['items'] instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-between align-items-center flex-wrap mt-7">
                        <div class="text-muted fs-7 fw-semibold mb-2">
                            {{ __('Showing') }}
                            <span class="text-dark fw-bold">{{ $setup['items']->firstItem() }}</span>
                            {{ __('to') }}
                            <span class="text-dark fw-bold">{{ $setup['items']->lastItem() }}</span>
                            {{ __('of') }}
                            <span class="text-dark fw-bold">{{ $setup['items']->total() }}</span>
                            {{ __('entries') }}
                        </div>
                        <div class="pagination-custom">
                            {{ $setup['items']->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('topjs')
    <script>
        // Initialize Metronic tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Add animation to filter collapse
            $('#filterCollapse').on('show.bs.collapse', function() {
                $(this).parent().addClass('filter-active');
            }).on('hide.bs.collapse', function() {
                $(this).parent().removeClass('filter-active');
            });
        });
    </script>
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Delete button functionality
            const isStaff = @json(auth()->user()->hasRole('staff'));

            function handleDelete(buttonSelector, options = {}) {
                document.querySelectorAll(buttonSelector).forEach(button => {
                    button.addEventListener('click', function() {

                        // Check permission
                        if (isStaff) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Permission Denied',
                                text: 'You do not have proper rights to delete this item.',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            });
                            return;
                        }

                        const url = this.dataset.url;
                        const row = this.closest('tr');
                        const itemName = row.querySelector('.text-dark')?.textContent || 'Item';
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')
                            ?.content;

                        // Validate required elements
                        if (!url) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Missing delete URL',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            return;
                        }
                        if (!csrfToken) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Security Error',
                                text: 'Missing CSRF token',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            return;
                        }

                        // Confirmation
                        Swal.fire({
                            title: 'Delete Item?',
                            html: `<div class="text-center">
                        <i class="ki-duotone ki-question fs-2hx text-danger mb-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <p class="fs-5">Are you sure you want to delete<br><b>${itemName}</b>?</p>
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
                                // Show loading
                                const deleteSwal = Swal.fire({
                                    title: 'Deleting...',
                                    text: 'Please wait while we delete the item',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    didOpen: () => Swal.showLoading()
                                });

                                // Axios delete
                                axios.delete(url, {
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Accept': 'application/json'
                                        },
                                        timeout: 10000
                                    })
                                    .then(response => {
                                        deleteSwal.close();

                                        if (response.data.success) {
                                            // Animate row removal
                                            if (row) {
                                                row.style.opacity = 1;
                                                const fadeOut = setInterval(() => {
                                                    const opacity = parseFloat(
                                                        row.style.opacity);
                                                    if (opacity <= 0) {
                                                        clearInterval(fadeOut);
                                                        row.remove();
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Deleted!',
                                                            text: response
                                                                .data
                                                                .message,
                                                            toast: true,
                                                            position: 'top-end',
                                                            showConfirmButton: false,
                                                            timer: 1500,
                                                            timerProgressBar: true
                                                        });
                                                    } else {
                                                        row.style.opacity =
                                                            opacity - 0.05;
                                                    }
                                                }, 30);
                                            } else {
                                                // Fallback if no row element
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Deleted!',
                                                    text: response.data.message,
                                                    toast: true,
                                                    position: 'top-end',
                                                    showConfirmButton: false,
                                                    timer: 1500,
                                                    timerProgressBar: true
                                                });
                                            }
                                        } else {
                                            throw new Error(response.data.message ||
                                                'Deletion failed');
                                        }
                                    })
                                    .catch(error => {
                                        deleteSwal.close();
                                        let errorMessage = 'Could not delete item';

                                        if (error.response) {
                                            if (error.response.status === 404) {
                                                errorMessage =
                                                    'Item not found (already deleted?)';
                                            } else if (error.response.data?.message) {
                                                errorMessage = error.response.data
                                                    .message;
                                            }
                                        } else if (error.request) {
                                            errorMessage =
                                                'Network error - check your connection';
                                        } else {
                                            errorMessage = error.message;
                                        }

                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Failed!',
                                            text: errorMessage,
                                            footer: `<small>URL: ${url}</small>`,
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 2500,
                                            timerProgressBar: true
                                        });
                                    });
                            }
                        });
                    });
                });
            }

            // Initialize delete for all buttons with .delete-btn
            handleDelete('.delete-btn');


        });
    </script>
@endsection
