@extends('layouts.app-client')

@section('title', $setup['title'] ?? __('Replies Management'))

@section('css')
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
        <div class="card card-custom gutter-b">
            <div class="card-header card-header-custom d-flex justify-content-between align-items-center flex-wrap">
                <div class="card-title">
                    <h3 class="card-label fw-bolder text-dark">
                        {{ $setup['title'] ?? __('Replies Management') }}
                        <span class="d-block text-muted pt-2 fs-6">{{ $setup['subtitle'] ?? '' }}</span>
                    </h3>
                </div>
                <div class="card-toolbar">
                    @isset($setup['action_link2'])
                        <a href="{{ $setup['action_link2'] }}" class="btn btn-light-info btn-sm me-2">
                            <i class="ki-duotone ki-category fs-3 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                            {{ $setup['action_name2'] }}
                        </a>
                    @endisset

                    @isset($setup['action_link'])
                        <a href="{{ $setup['action_link'] }}" class="btn btn-primary">
                            <i class="ki-duotone ki-plus fs-2 me-1"></i> {{ $setup['action_name'] }}
                        </a>
                    @endisset

                    @isset($setup['usefilter'])
                        <button class="btn btn-light-info ml-2" type="button" data-toggle="collapse"
                            data-target="#filterCollapse">
                            <i class="ki-duotone ki-filter fs-2 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ __('Filter') }}
                        </button>
                    @endisset
                </div>
            </div>

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
                                <th class="min-w-150px">{{ __('Template Name') }}</th>
                                <th class="min-w-200px">{{ __('Buttons') }}</th>
                                <th class="min-w-50px text-center">{{ __('Status') }}</th>
                                <th class="min-w-100px text-end">{{ __('Actions') }}</th>
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
                                                {{-- <span class="text-muted fs-7">Created: {{ $item->created_at->format('M d, Y') }}</span> --}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
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
                                        <span class="badge badge-light-success">
                                            <span class="status-indicator status-active"></span>
                                            Active
                                        </span>
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <div class="d-flex justify-content-end action-buttons">
                                            <a href="{{ route('button_template.edit', ['button' => $item->id]) }}"
                                                class="action-btn btn-icon-primary m-2" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="ki-duotone ki-pencil fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>

                                            {{--                                             
                                            <a href="#" class="action-btn btn-light-primary" data-bs-toggle="tooltip" title="Preview">
                                                <i class="ki-duotone ki-eye fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </a> --}}

                                            <button
                                                class="btn btn-icon btn-light btn-active-light-danger btn-sm delete-btn m-2 ms-2 me-2"
                                                data-id="{{ $item->id }}"
                                                data-url="{{ route('button_template.delete', $item->id) }}"
                                                data-bs-toggle="tooltip" title="Delete">
                                                <i class="ki-duotone ki-trash fs-2 text-danger">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="ki-duotone ki-message-text-2 fs-2hx">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </div>
                                            <h3 class="fw-bold text-gray-700 mb-2">{{ __('No group found') }}</h3>
                                            <p class="text-muted mb-5">
                                                {{ __('There are no reply button group created yet') }}</p>
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
            // Staff role check (pass from Blade)
            const isStaff = @json(auth()->user()->hasRole('staff'));

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {

                    // Permission check
                    if (isStaff) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Permission Denied',
                            text: 'You do not have proper rights to delete this button group.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        return;
                    }

                    const templateName = this.closest('tr').querySelector('.text-dark').textContent;

                    Swal.fire({
                        title: 'Delete Group?',
                        html: `<div class="text-center">
                        <i class="ki-duotone ki-question fs-2hx text-danger mb-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <p class="fs-5">Are you sure you want to delete button group<br><b>${templateName}</b>?</p>
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
                            Swal.fire({
                                title: 'Deleting...',
                                text: 'Please wait while we delete the button group',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                didOpen: () => Swal.showLoading()
                            });

                            // AJAX request
                            axios.delete(this.dataset.url, {
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content
                                    }
                                })
                                .then(response => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'Interactive - Button group has been deleted!',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 2000,
                                        timerProgressBar: true
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                })
                                .catch(error => {
                                    console.error(error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed!',
                                        text: error.response?.data?.message ||
                                            'Could not delete button group',
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

        });
    </script>
@endsection
