@extends('client.app', ['title' => __($setup['title'])])

@section('content')
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

        .field-type-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
        }
    </style>

    <div id="kt_app_content_container" class="container-xxl px-4">
        <div class="col-12">
            @include('partials.flash-client')
        </div>

        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-element-11 fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    {{ __($setup['title']) }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $setup['items']->total() }}
                    {{ __('Fields') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">

                @if ($setup['items']->isNotEmpty())
                    <form action="{{ route('contacts.fields.index') }}" method="GET"
                        class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" name="name" value="{{ request('name') }}"
                            class="form-control form-control-solid w-250px ps-10" placeholder="{{ __('Search field...') }}"
                            onkeydown="if(event.key==='Enter'){ this.form.submit(); }">
                    </form>
                @endif

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create">
                    <i class="ki-duotone ki-plus fs-2"></i>
                    {{ __($setup['action_name']) }}
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        @if ($setup['items']->isNotEmpty())
            @php
                $textFields = $setup['items']->where('type', 'text')->count();
                $numberFields = $setup['items']->where('type', 'number')->count();
                $dateFields = $setup['items']->where('type', 'date')->count();
                $selectFields = $setup['items']->where('type', 'select')->count();
            @endphp

            <div class="row g-6 mb-7">
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #3699FF;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-primary me-4">
                                <i class="ki-duotone ki-element-11 fs-2hx text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $setup['items']->total() }}</span>
                                <span class="stats-label">{{ __('Total Fields') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #1BC5BD;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-success me-4">
                                <i class="ki-duotone ki-text-align-left fs-2hx text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $textFields }}</span>
                                <span class="stats-label">{{ __('Text Fields') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #FFA800;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-warning me-4">
                                <i class="ki-duotone ki-calendar-8 fs-2hx text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $dateFields }}</span>
                                <span class="stats-label">{{ __('Date Fields') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #F64E60;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-danger me-4">
                                <i class="ki-duotone ki-number-fs fs-2hx text-danger">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $numberFields + $selectFields }}</span>
                                <span class="stats-label">{{ __('Number/Select Fields') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Fields Table Card -->
        <div class="card">
            @if ($setup['items']->isNotEmpty())
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('Custom Fields') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted fs-7">{{ __('Filter by type:') }}</span>
                            <select class="form-select form-select-sm w-150px" id="type-filter">
                                <option value="">{{ __('All Types') }}</option>
                                <option value="text">{{ __('Text') }}</option>
                                <option value="number">{{ __('Number') }}</option>
                                <option value="date">{{ __('Date') }}</option>
                                <option value="select">{{ __('Select') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6" id="fields-table">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-250px">{{ __('Field') }}</th>
                                    <th class="min-w-150px">{{ __('Type') }}</th>
                                    <th class="min-w-100px">{{ __('Required') }}</th>
                                    <th class="min-w-150px">{{ __('Created') }}</th>
                                    <th class="min-w-150px text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($setup['items'] as $item)
                                    <tr data-field-type="{{ $item->type }}" class="field-row">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px symbol-circle me-5">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-element-11 fs-2 text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6 mb-1">{{ $item->name }}</span>
                                                    {{-- <span class="text-muted fs-7">ID: {{ $item->id }}</span> --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-light-{{ $item->type === 'text' ? 'primary' : ($item->type === 'number' ? 'warning' : ($item->type === 'date' ? 'info' : 'success')) }} field-type-badge">
                                                {{ __(ucfirst($item->type)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-{{ $item->required ? 'success' : 'danger' }}">
                                                {{ $item->required ? __('Yes') : __('No') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-7">
                                                {{ $item->created_at->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2 align-items-center">
                                                <!-- Edit Button -->
                                                <button type="button"
                                                    class="btn btn-icon btn-light-primary btn-sm edit-button"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_edit"
                                                    data-id="{{ $item->id }}" title="{{ __('Edit Field') }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <i class="ki-duotone ki-pencil fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>

                                                <!-- Delete Button -->
                                                <a href="{{ route('contacts.fields.delete', ['field' => $item->id]) }}"
                                                    class="btn btn-icon btn-light-danger btn-sm delete-field"
                                                    data-field-name="{{ $item->name }}"
                                                    title="{{ __('Delete Field') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-trash fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </a>
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
                                    <i class="ki-duotone ki-element-11 fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="fw-bolder mb-3">{{ __('No Fields Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('You haven\'t created any custom fields yet. Custom fields help you store additional information about your contacts.') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_create">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    {{ __('Create Your First Field') }}
                                </button>
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
                                    {{ __('Custom fields allow you to collect specific information like birthdays, preferences, or custom notes.') }}
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
                    <h2 class="modal-title">{{ __('About Custom Fields') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="mb-3">{{ __('Field Types') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-primary me-3">{{ __('Text') }}</span>
                                <span>{{ __('For names, descriptions, and short text') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-warning me-3">{{ __('Number') }}</span>
                                <span>{{ __('For numeric values like age, quantity') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-info me-3">{{ __('Date') }}</span>
                                <span>{{ __('For birthdays, anniversaries, events') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('Select') }}</span>
                                <span>{{ __('For predefined options like status') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h4 class="mb-3">{{ __('Best Practices') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Use descriptive field names') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Mark required fields appropriately') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Group related fields together') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_create">
                        {{ __('Create Field') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Field Modal -->
    <div class="modal fade" id="kt_modal_create" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fw-bold">
                        <i class="ki-duotone ki-plus fs-2 me-2 text-primary">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ __('Create Field') }}
                    </h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form id="kt_modal_create_form" class="form" action="{{ $setup_create['action'] }}"
                        method="POST">
                        @csrf
                        @isset($setup_create['isupdate'])
                            @method('PUT')
                        @endisset

                        @isset($setup_create['inrow'])
                            <div class="row g-9 mb-8">
                            @endisset

                            @include('partials.fields-modal', ['fields' => $fields_create])

                            @isset($setup_create['inrow'])
                            </div>
                        @endisset

                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                data-bs-dismiss="modal">{{ __('Discard') }}</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ki-duotone ki-check fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ isset($setup_create['isupdate']) ? __('Update') : __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Field Modal -->
    <div class="modal fade" id="kt_modal_edit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fw-bold">
                        <i class="ki-duotone ki-pencil fs-2 me-2 text-primary">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ __('Edit Field') }}
                    </h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-modal-action="close">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div id="modal-form-content"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Type filter functionality
            const typeFilter = document.getElementById('type-filter');
            if (typeFilter) {
                typeFilter.addEventListener('change', function() {
                    const type = this.value;
                    const rows = document.querySelectorAll('.field-row');

                    rows.forEach(row => {
                        if (type === '' || row.getAttribute('data-field-type') === type) {
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
                    const typeFilterValue = typeFilter ? typeFilter.value : '';
                    const rows = document.querySelectorAll('.field-row');

                    if (searchTerm.length === 0) {
                        // Show all rows based on type filter
                        rows.forEach(row => {
                            if (typeFilterValue === '' || row.getAttribute('data-field-type') ===
                                typeFilterValue) {
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
                        const type = row.querySelector('td:nth-child(2) span').textContent
                            .toLowerCase();
                        const id = row.querySelector('td:first-child span.text-muted').textContent
                            .toLowerCase();

                        const matchesSearch = name.includes(searchTerm) ||
                            type.includes(searchTerm) ||
                            id.includes(searchTerm);

                        const matchesType = typeFilterValue === '' ||
                            row.getAttribute('data-field-type') === typeFilterValue;

                        row.style.display = (matchesSearch && matchesType) ? '' : 'none';
                    });
                });
            }

            // Edit button functionality
            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function() {
                    const fieldId = this.getAttribute('data-id');

                    // Show loading state
                    const modalContent = document.getElementById('modal-form-content');
                    modalContent.innerHTML = `
                        <div class="text-center py-10">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Loading field details...</p>
                        </div>
                    `;

                    fetch(`fields/${fieldId}/edit`)
                        .then(response => response.text())
                        .then(data => {
                            modalContent.innerHTML = data;
                        })
                        .catch(error => {
                            console.error('Error loading form:', error);
                            modalContent.innerHTML = `
                                <div class="alert alert-danger">
                                    <i class="ki-duotone ki-cross-circle fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Error loading field details. Please try again.
                                </div>
                            `;
                        });
                });
            });

            // Delete field functionality
            document.querySelectorAll('.delete-field').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const fieldName = this.getAttribute('data-field-name');
                    const deleteUrl = this.getAttribute('href');

                    Swal.fire({
                        title: 'Delete Field?',
                        html: `<div class="text-center">
                                <i class="ki-duotone ki-question fs-2hx text-danger mb-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <p class="fs-5">Are you sure you want to delete<br><b>${fieldName}</b>?</p>
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
                    }).then(result => {
                        if (result.isConfirmed) {
                            // Show loading
                            Swal.fire({
                                title: 'Deleting...',
                                text: 'Please wait while we delete the field',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                didOpen: () => Swal.showLoading()
                            });

                            // AJAX delete
                            fetch(deleteUrl, {
                                    method: 'GET',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Deleted!',
                                            text: 'Field has been deleted successfully!',
                                            timer: 2000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        throw new Error(data.message ||
                                            'Delete failed');
                                    }
                                })
                                .catch(error => {
                                    console.error(error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed!',
                                        text: 'Could not delete field. Please try again.',
                                        confirmButtonText: 'OK'
                                    });
                                });
                        }
                    });
                });
            });
        });
    </script>
@endsection

@push('css')
    <style>
        .field-avatar {
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

        .field-row td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
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

            .field-row .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            #type-filter {
                width: 100% !important;
                margin-top: 1rem;
            }
        }
    </style>
@endpush
