@extends('client.app', ['title' => __('Group Management')])

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

        .contact-count-badge {
            font-size: 0.8rem;
            padding: 0.3rem 0.7rem;
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
                    <i class="ki-duotone ki-people fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    {{ __('Group Management') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $setup['items']->total() }}
                    {{ __('Groups') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                @if ($setup['items']->isNotEmpty())
                    <form action="{{ route('contacts.groups.index') }}" method="GET"
                        class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" name="name" value="{{ request('name') }}"
                            class="form-control form-control-solid w-250px ps-10" placeholder="{{ __('Search groups...') }}"
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
                $totalContacts = $setup['items']->sum('contacts_count');
                $groupsWithContacts = $setup['items']->where('contacts_count', '>', 0)->count();
                $emptyGroups = $setup['items']->where('contacts_count', 0)->count();
                $averageContacts =
                    $setup['items']->count() > 0 ? round($totalContacts / $setup['items']->count(), 1) : 0;
            @endphp

            <div class="row g-6 mb-7">
                <div class="col-xl-4 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #3699FF;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-primary me-4">
                                <i class="ki-duotone ki-people fs-2hx text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $setup['items']->total() }}</span>
                                <span class="stats-label">{{ __('Total Groups') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #1BC5BD;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-success me-4">
                                <i class="ki-duotone ki-profile-user fs-2hx text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $totalContacts }}</span>
                                <span class="stats-label">{{ __('Total Contacts') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #FFA800;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-warning me-4">
                                <i class="ki-duotone ki-check-circle fs-2hx text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $groupsWithContacts }}</span>
                                <span class="stats-label">{{ __('Active Groups') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

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
                                <span class="stats-value">{{ $averageContacts }}</span>
                                <span class="stats-label">{{ __('Avg Contacts/Group') }}</span>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        @endif

        <!-- Groups Table Card -->
        <div class="card">
            @if ($setup['items']->isNotEmpty())
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('Contact Groups') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted fs-7">{{ __('Filter by:') }}</span>
                            <select class="form-select form-select-sm w-150px" id="contacts-filter">
                                <option value="">{{ __('All Groups') }}</option>
                                <option value="with-contacts">{{ __('With Contacts') }}</option>
                                <option value="empty">{{ __('Empty Groups') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6" id="groups-table">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-250px">{{ __('Group') }}</th>
                                    <th class="min-w-100px text-center">{{ __('Contacts') }}</th>
                                    <th class="min-w-150px">{{ __('Status') }}</th>
                                    <th class="min-w-150px">{{ __('Created') }}</th>
                                    <th class="min-w-200px text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($setup['items'] as $item)
                                    <tr data-group-contacts="{{ $item->contacts_count }}" class="group-row">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px symbol-circle me-5">
                                                    <div
                                                        class="symbol-label bg-light-{{ $item->contacts_count > 0 ? 'primary' : 'secondary' }}">
                                                        <i
                                                            class="ki-duotone ki-people fs-2 text-{{ $item->contacts_count > 0 ? 'primary' : 'secondary' }}">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6 mb-1">{{ $item->name }}</span>
                                                    {{-- <span class="text-muted fs-7">ID: {{ $item->id }}</span> --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-light-{{ $item->contacts_count > 0 ? 'primary' : 'success' }} contact-count-badge">
                                                {{ $item->contacts_count }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-light-{{ $item->contacts_count > 0 ? 'success' : 'warning' }}">
                                                {{ $item->contacts_count > 0 ? __('Active') : __('Empty') }}
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
                                                    data-id="{{ $item->id }}" title="{{ __('Edit Group') }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <i class="ki-duotone ki-pencil fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>

                                                <!-- Delete Group Button -->
                                                <button class="btn btn-icon btn-light-danger btn-sm delete-group"
                                                    data-group-id="{{ $item->id }}"
                                                    data-group-name="{{ $item->name }}"
                                                    title="{{ __('Delete Group') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-trash fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </button>

                                                <!-- Delete with Contacts Button (Conditional) -->
                                                @if ($item->contacts_count > 0)
                                                    <button class="btn btn-light-danger btn-sm delete-group-with-contacts"
                                                        data-group-id="{{ $item->id }}"
                                                        data-group-name="{{ $item->name }}"
                                                        title="{{ __('Delete Group with Contacts') }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <i class="ki-duotone ki-trash fs-2 me-1"></i>
                                                        {{ __('With Contacts') }}
                                                    </button>
                                                @endif

                                                <!-- Loading Spinner -->
                                                <span class="spinner-border spinner-border-sm d-none"
                                                    id="loader-{{ $item->id }}"></span>
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
                            {{ $setup['items']->links('vendor.pagination.metronic') }}
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
                                    <i class="ki-duotone ki-people fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="fw-bolder mb-3">{{ __('No Groups Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('You haven\'t created any groups yet. Groups help you organize and manage your contacts more effectively.') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_create">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    {{ __('Create Your First Group') }}
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
                                    {{ __('Groups allow you to segment contacts for targeted messaging and better organization.') }}
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
                    <h2 class="modal-title">{{ __('About Groups') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="mb-3">{{ __('Why use groups?') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Organize contacts by category or purpose') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Send targeted messages to specific segments') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Track performance by group') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Manage permissions and access') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h4 class="mb-3">{{ __('Group Status') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('Active') }}</span>
                                <span>{{ __('Group contains contacts and can be used for messaging') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-warning me-3">{{ __('Empty') }}</span>
                                <span>{{ __('Group has no contacts yet') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_create">
                        {{ __('Create Group') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('contacts::groups.partials.modals.create')
    @include('contacts::groups.partials.modals.edit')
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

            // Contacts filter functionality
            const contactsFilter = document.getElementById('contacts-filter');
            if (contactsFilter) {
                contactsFilter.addEventListener('change', function() {
                    const filter = this.value;
                    const rows = document.querySelectorAll('.group-row');

                    rows.forEach(row => {
                        const contactsCount = parseInt(row.getAttribute('data-group-contacts'));

                        if (filter === '' ||
                            (filter === 'with-contacts' && contactsCount > 0) ||
                            (filter === 'empty' && contactsCount === 0)) {
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
                    const contactsFilterValue = contactsFilter ? contactsFilter.value : '';
                    const rows = document.querySelectorAll('.group-row');

                    if (searchTerm.length === 0) {
                        // Show all rows based on contacts filter
                        rows.forEach(row => {
                            const contactsCount = parseInt(row.getAttribute('data-group-contacts'));

                            if (contactsFilterValue === '' ||
                                (contactsFilterValue === 'with-contacts' && contactsCount > 0) ||
                                (contactsFilterValue === 'empty' && contactsCount === 0)) {
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
                        const id = row.querySelector('td:first-child span.text-muted').textContent
                            .toLowerCase();

                        const matchesSearch = name.includes(searchTerm) || id.includes(searchTerm);

                        const contactsCount = parseInt(row.getAttribute('data-group-contacts'));
                        const matchesFilter = contactsFilterValue === '' ||
                            (contactsFilterValue === 'with-contacts' && contactsCount > 0) ||
                            (contactsFilterValue === 'empty' && contactsCount === 0);

                        row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
                    });
                });
            }

            // Delete handlers
            function handleDelete(url, groupId, groupName, isWithContacts = false) {
                const title = isWithContacts ? 'Delete Group with Contacts?' : 'Delete Group?';
                const text = isWithContacts ?
                    `This will permanently delete the group <b>${groupName}</b> and all ${isWithContacts} contacts within it. This action cannot be undone.` :
                    `Are you sure you want to delete the group <b>${groupName}</b>? Contacts will be removed from this group but not deleted.`;

                Swal.fire({
                    title: title,
                    html: `<div class="text-center">
                            <i class="ki-duotone ki-question fs-2hx text-danger mb-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <p class="fs-5">${text}</p>
                            <p class="text-muted fs-7">This action cannot be undone</p>
                       </div>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: isWithContacts ? 'Yes, delete everything!' : 'Yes, delete group!',
                    cancelButtonText: 'Cancel',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-danger px-6',
                        cancelButton: 'btn btn-light px-6'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const button = document.querySelector(`[data-group-id="${groupId}"]`);
                        const loader = document.getElementById(`loader-${groupId}`);

                        if (button) button.disabled = true;
                        if (loader) loader.classList.remove('d-none');

                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    _method: 'DELETE'
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire({
                                    text: data.message || 'Group deleted successfully!',
                                    icon: 'success',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    }
                                }).then(() => {
                                    location.reload();
                                });
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    text: 'Error deleting group. Please try again.',
                                    icon: 'error',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    }
                                });
                            })
                            .finally(() => {
                                if (button) button.disabled = false;
                                if (loader) loader.classList.add('d-none');
                            });
                    }
                });
            }

            // Delete group button
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-group')) {
                    e.preventDefault();
                    const button = e.target.closest('.delete-group');
                    const groupId = button.getAttribute('data-group-id');
                    const groupName = button.getAttribute('data-group-name');

                    // Permission check
                    const isStaff = @json(auth()->user()->hasRole('staff'));
                    if (isStaff) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Permission Denied',
                            text: 'You do not have rights to delete this group.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        return;
                    }

                    handleDelete(`/contacts/groups/${groupId}`, groupId, groupName);
                }

                // Delete group with contacts button
                if (e.target.closest('.delete-group-with-contacts')) {
                    e.preventDefault();
                    const button = e.target.closest('.delete-group-with-contacts');
                    const groupId = button.getAttribute('data-group-id');
                    const groupName = button.getAttribute('data-group-name');
                    const contactsCount = button.closest('tr').getAttribute('data-group-contacts');

                    // Permission check
                    const isStaff = @json(auth()->user()->hasRole('staff'));
                    if (isStaff) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Permission Denied',
                            text: 'You do not have rights to delete this group and its contacts.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        return;
                    }

                    handleDelete(`/contacts/groups/delete-with-contacts/${groupId}`, groupId, groupName,
                        contactsCount);
                }
            });

            // Edit button handler
            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function() {
                    const groupId = this.getAttribute('data-id');
                    const loader = document.getElementById(`loader-${groupId}`);
                    const modalContent = document.querySelector('#kt_modal_edit .modal-body');

                    if (loader) loader.classList.remove('d-none');

                    fetch(`groups/${groupId}/edit`)
                        .then(response => response.text())
                        .then(data => {
                            if (modalContent) modalContent.innerHTML = data;
                        })
                        .catch(error => {
                            console.error('Error loading form:', error);
                            Swal.fire({
                                text: "Error loading form",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        })
                        .finally(() => {
                            if (loader) loader.classList.add('d-none');
                        });
                });
            });
        });
    </script>
@endsection

@push('css')
    <style>
        .group-avatar {
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

        .group-row td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .delete-group-with-contacts {
            font-size: 0.8rem;
            padding: 0.35rem 0.75rem;
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

            .group-row .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .group-row .d-flex.gap-2 .btn {
                margin: 0;
            }

            #contacts-filter {
                width: 100% !important;
                margin-top: 1rem;
            }

            .delete-group-with-contacts {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush
