@extends('client.app', ['title' => __($setup['title'])])

@section('content')
    <style>
        /* Existing styles remain the same */
        .pagination {
            margin: 0;
        }

        .page-item.active .page-link {
            background-color: #3699FF;
            border-color: #3699FF;
            color: white !important;
            font-weight: 600;
        }

        .page-link {
            color: #7E8299;
            padding: 0.5rem 0.75rem;
            border: 1px solid #E4E6EF;
            margin-left: 0.25rem;
            min-width: 38px;
            text-align: center;
        }

        .page-item:first-child .page-link,
        .page-item:last-child .page-link {
            min-width: 42px;
        }

        .page-item:first-child .page-link {
            margin-left: 0;
            border-top-left-radius: 0.42rem;
            border-bottom-left-radius: 0.42rem;
        }

        .page-item:last-child .page-link {
            border-top-right-radius: 0.42rem;
            border-bottom-right-radius: 0.42rem;
        }

        .page-item.disabled .page-link {
            color: #B5B5C3;
            background-color: #F5F8FA;
            border-color: #E4E6EF;
        }

        .page-item:not(.active):not(.disabled) .page-link:hover {
            background-color: #F5F8FA;
            border-color: #E4E6EF;
        }

        #rows-per-page {
            width: 80px !important;
        }

        #reset-selection {
            transition: all 0.3s ease;
        }

        #reset-selection:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        #reset-selection:hover:not(:disabled) {
            background-color: #f1f1f2;
            color: #181C32;
        }

        .table-search-input {
            min-width: 300px;
            margin-right: 10px;
        }

        #filtered-count {
            margin-left: 10px;
            font-weight: 600;
            color: #3699FF;
        }

        #kt_contact_table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-container {
            max-height: 500px;
            overflow-y: auto;
            border-radius: 8px;
            border: 1px solid #e4e6ef;
        }

        #kt_contact_table thead {
            position: sticky;
            top: 0;
            background: #f9f9f9;
            z-index: 10;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        #kt_contact_table th {
            padding: 12px;
            text-transform: uppercase;
            font-weight: 600;
            border-bottom: 2px solid #e4e6ef;
        }

        #kt_contact_table th:first-child,
        #kt_contact_table td:first-child {
            padding-left: 16px !important;
        }

        #kt_contact_table th:last-child,
        #kt_contact_table td:last-child {
            padding-right: 16px !important;
        }

        /* New stats cards styling */
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
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div id="kt_app_content_container" class="container-xxl px-4">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-profile-user fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    {{ __('Contacts Management') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $setup['items']->total() }}
                    {{ __('Contacts') }}</span>
            </div>
        </div>
        <div class="col-12">
            @include('partials.flash-client')
        </div>

        <!-- Stats Section -->
        <div class="row g-6 mb-7">
            <!-- Total Contacts -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                    style="border-left-color: #3699FF;">
                    <div class="d-flex align-items-center w-100 px-4">
                        <div class="stats-icon bg-light-primary me-4">
                            <i class="ki-duotone ki-profile-user fs-2hx text-primary">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="stats-value">{{ $totalContacts ?? 0 }}</span>
                            <span class="stats-label">{{ __('Total Contacts') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscribed Contacts -->
            <div class="col-xl-3 col-sm-6">
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
                            <span class="stats-value">{{ $subscribedCount ?? 0 }}</span>
                            <span class="stats-label">{{ __('Subscribed') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unsubscribed Contacts -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                    style="border-left-color: #F64E60;">
                    <div class="d-flex align-items-center w-100 px-4">
                        <div class="stats-icon bg-light-danger me-4">
                            <i class="ki-duotone ki-cross-circle fs-2hx text-danger">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="stats-value">{{ $unsubscribedCount ?? 0 }}</span>
                            <span class="stats-label">{{ __('Unsubscribed') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- This Week's Contacts -->
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
                            <span class="stats-value">{{ $weeklyContacts ?? 0 }}</span>
                            <span class="stats-label">{{ __('Added This Week') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Agent Stats (if applicable) -->
        @if (isset($agentStats) && $agentStats->isNotEmpty())
            <div class="row g-6 mb-7">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title fw-bolder">{{ __('Agent Performance') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-row-bordered table-hover align-middle fs-6 gy-5">
                                    <thead>
                                        <tr class="text-start text-gray-700 fw-bold fs-7 text-uppercase">
                                            <th>{{ __('Agent') }}</th>
                                            <th class="text-center">{{ __('Total Contacts') }}</th>
                                            <th class="text-center">{{ __('This Week') }}</th>
                                            <th class="text-center">{{ __('Subscribed') }}</th>
                                            <th class="text-center">{{ __('Conversion Rate') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agentStats as $agent)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-40px symbol-circle me-3">
                                                            <div class="symbol-label bg-light-primary">
                                                                <span
                                                                    class="text-primary fw-bolder">{{ substr($agent->name, 0, 1) }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-bolder">{{ $agent->name }}</span>
                                                            <span class="text-muted fs-7">{{ $agent->email }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-light-primary fs-7">{{ $agent->total_contacts }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-light-success fs-7">{{ $agent->weekly_contacts }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-light-info fs-7">{{ $agent->subscribed_contacts }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $conversionRate =
                                                            $agent->total_contacts > 0
                                                                ? round(
                                                                    ($agent->subscribed_contacts /
                                                                        $agent->total_contacts) *
                                                                        100,
                                                                    1,
                                                                )
                                                                : 0;
                                                    @endphp
                                                    <span
                                                        class="badge badge-light-{{ $conversionRate >= 50 ? 'success' : ($conversionRate >= 30 ? 'warning' : 'danger') }} fs-7">
                                                        {{ $conversionRate }}%
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Contacts Table Card -->
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative fs-4 fw-semibold my-1">
                        {{ __($setup['title']) }}
                        <span class="badge fw-bold px-3 py-2 ms-2 badge-light-info">
                            {{ $setup['subtitle'] }}
                        </span>
                    </div>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-3">
                        <!-- Left: Search input + Mobile Menu Button -->
                        <div class="d-flex align-items-center gap-2 flex-grow-1">
                            <form method="GET" class="d-flex align-items-center position-relative">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4 text-gray-500">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" id="localSearchInput" name="name"
                                    class="form-control form-control-solid ps-12 w-250px"
                                    placeholder="Search in this list..." value="{{ request('name') }}"
                                    onkeydown="if(event.key === 'Enter') this.form.submit()">
                            </form>

                            <!-- Mobile Dropdown Button -->
                            <div class="d-flex d-lg-none">
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-light-primary" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="ki-duotone ki-element-4 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#filterModal"><i
                                                    class="ki-outline ki-filter fs-2 me-2"></i>Filter</a></li>
                                        <li><a href="javascript:void(0);" class="dropdown-item action-export-excel"
                                                data-export-url="{{ route('contacts.export', request()->query()) }}"><i
                                                    class="ki-outline ki-exit-up fs-2 me-2"></i>Export Excel</a></li>
                                        <li><a href="{{ route('contacts.newimport.index') }}" class="dropdown-item"><i
                                                    class="ki-outline ki-exit-up fs-2 me-2"></i>Import Excel</a></li>
                                        <li><a href="javascript:void(0);" class="dropdown-item action-reset-selection"><i
                                                    class="ki-outline ki-arrows-circle fs-2 me-2"></i>Reset Selection</a>
                                        </li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_create"
                                                class="dropdown-item"><i
                                                    class="ki-outline ki-plus fs-2 me-2"></i>Create</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a href="#" class="dropdown-item action-move-to-group">Add to group</a>
                                        </li>
                                        <li><a href="#" class="dropdown-item action-remove-from-group">Remove from
                                                group</a></li>
                                        <li><a href="#" class="dropdown-item action-subscribe-contact">Subscribe</a>
                                        </li>
                                        <li><a href="#"
                                                class="dropdown-item action-unsubscribe-contact">Unsubscribe</a></li>
                                        <li><a href="#" class="dropdown-item action-selected-delete">Delete
                                                selected</a></li>
                                        <li><a href="#"
                                                class="dropdown-item action-convert-to-lead">{{ __('Convert to Lead') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Desktop Buttons -->
                        <div class="d-none d-lg-flex align-items-center gap-2 flex-wrap">
                            <!-- Filter -->
                            <button type="button" class="btn btn-light-primary" data-bs-toggle="modal"
                                data-bs-target="#filterModal">
                                <i class="ki-outline ki-filter fs-2"></i>
                            </button>

                            <!-- Export Menu -->
                            <div class="dropdown">
                                <button type="button" class="btn btn-light-primary" data-bs-toggle="dropdown">
                                    <i class="ki-outline ki-exit-up fs-2"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a href="javascript:void(0);" id="export-excel-btn" class="dropdown-item"
                                            data-export-url="{{ route('contacts.export', request()->query()) }}">
                                            Export Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contacts.newimport.index') }}" class="dropdown-item">
                                            Import Excel
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Reset Selection -->
                            <button id="reset-selection" class="btn btn-light-danger" disabled>
                                <i class="ki-outline ki-arrows-circle fs-2"></i>
                            </button>

                            <!-- Create New -->
                            <button id="modal_create" data-bs-toggle="modal" data-bs-target="#kt_modal_create"
                                class="btn btn-primary">
                                <i class="ki-outline ki-plus fs-2"></i>
                            </button>

                            <!-- Bulk Actions -->
                            <div>
                                <button class="btn btn-light-success" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end" disabled id="bulk_action_btn">
                                    <i class="ki-outline ki-abstract-41 fs-2"></i> Bulk Actions
                                </button>

                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                            {{ __('Main Actions') }}
                                        </div>
                                    </div>
                                    <div class="menu-item px-3"><a class="menu-link px-3" href="#"
                                            id="move-to-group">{{ __('Add to group') }}</a></div>
                                    <div class="menu-item px-3"><a class="menu-link px-3" href="#"
                                            id="remove-from-group">{{ __('Remove from group') }}</a></div>
                                    <div class="menu-item px-3"><a class="menu-link px-3" href="#"
                                            id="subscribe-contact">{{ __('Subscribe') }}</a></div>
                                    <div class="menu-item px-3"><a class="menu-link px-3" href="#"
                                            id="unsubscribe-contact">{{ __('Unsubscribe') }}</a></div>
                                    <div class="menu-item px-3"><a class="menu-link px-3" href="#"
                                            id="bulk-delete-btn">{{ __('Delete selected') }}</a></div>
                                    <div class="menu-item px-3">
                                        <a class="menu-link px-3" href="#" id="convert-to-lead">
                                            {{ __('Convert to Lead') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Modal -->
            <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Filter Contacts</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="contactFilterForm" method="GET" action="{{ route('contacts.index') }}">
                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ request('name') }}" placeholder="Search by name">
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ request('phone') }}" placeholder="Search by phone">
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Email</label>
                                        <input type="text" name="email" class="form-control"
                                            value="{{ request('email') }}" placeholder="Search by email">
                                    </div>
                                    {{-- <div class="col-md-6 mb-5">
                                        <label class="form-label">Tag</label>
                                        <input type="text" name="tag" class="form-control"
                                            value="{{ request('tag') }}" placeholder="Search by tag">
                                    </div> --}}
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Group</label>
                                        <select name="group" id="groupSelect" class="form-select">
                                            <option value="">All Groups</option>
                                            @foreach ($setup['groups'] as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ request('group') == $group->id ? 'selected' : '' }}>
                                                    {{ $group->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Status</label>
                                        <select name="subscribed" class="form-select">
                                            <option value="">All Statuses</option>
                                            <option value="1" {{ request('subscribed') == '1' ? 'selected' : '' }}>
                                                Subscribed</option>
                                            <option value="0" {{ request('subscribed') == '0' ? 'selected' : '' }}>
                                                Not
                                                Subscribed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Country</label>
                                        <select name="country_id" id="countrySelect" class="form-select">
                                            <option value="">All Countries</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('contacts.index') }}" class="btn btn-light me-2">Reset</a>
                            <button type="submit" form="contactFilterForm" class="btn btn-primary">Apply
                                Filters</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="d-flex align-items-center justify-content-between mb-5">
                    <div>
                        <span id="selected-count" class="fw-bold text-gray-600">No records selected</span>
                        <span id="filtered-count"></span>
                    </div>
                    <span id="showing-entries" class="text-muted">
                        @if ($setup['items']->total() > 0)
                            Showing {{ $setup['items']->firstItem() }} to {{ $setup['items']->lastItem() }} of
                            {{ $setup['items']->total() }} entries
                        @endif
                    </span>
                </div>

                <div class="table-responsive table-container shadow-sm" style="max-height: 70vh; overflow-y: auto;"
                    id="contacts-scroll-container">
                    <table id="kt_contact_table" class="table table-row-bordered table-hover align-middle fs-6 gy-5">
                        <thead class="position-sticky top-0 bg-light shadow-sm">
                            <tr class="text-start text-gray-700 fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                    </div>
                                </th>
                                <th><i class="bi bi-person-fill text-primary me-2"></i> {{ __('User') }}</th>
                                <th><i class="bi bi-telephone-fill text-success me-2"></i> {{ __('Phone') }}</th>
                                <th><i class="bi bi-check-circle-fill text-info me-2"></i> {{ __('Status') }}</th>
                                <th class="text-center"><i class="bi bi-people-fill text-warning me-2"></i>
                                    {{ __('Groups') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600" id="contacts-tbody">
                            @foreach ($setup['items'] as $item)
                                <tr>
                                    <td class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input select-item" type="checkbox"
                                                value="{{ $item->id }}">
                                        </div>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>
                                        <span class="badge badge-light-{{ $item->subscribed ? 'success' : 'danger' }}">
                                            {{ $item->subscribed ? 'Subscribed' : 'Not Subscribed' }}
                                        </span>
                                    </td>
                                    <td>
                                        @foreach ($item->groups as $group)
                                            <span class="badge badge-light-primary me-1">{{ $group->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-end">
                                        <!-- Action buttons -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div id="loading-indicator" class="text-center py-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>

                @if ($setup['items']->hasPages())
                    <div class="col-sm-12 col-md-7 d-flex">
                        {{ $setup['items']->links('vendor.pagination.metronic') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Add Contact Modal -->
        <div class="modal fade" tabindex="-1" id="kt_modal_create" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered mw-850px">
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="modal-title">
                            <i class="ki-duotone ki-profile-user fs-2x me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            {{ __('Add Contact') }}
                        </h2>
                        <!--end::Modal title-->

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->

                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <form action="{{ $setup_create['action'] }}" method="POST" enctype="multipart/form-data"
                            class="form">
                            @csrf
                            @isset($setup_create['isupdate'])
                                @method('PUT')
                            @endisset

                            <div class="scroll-y me-n7 pe-7" id="kt_modal_create_scroll">
                                <div class="row g-5">
                                    @foreach ($fields_create as $field)
                                        <div class="{{ $field['class'] }} @if ($field['ftype'] === 'image') mb-8 @endif">
                                            @if ($field['ftype'] == 'image')
                                                <div class="row mb-6">
                                                    <label
                                                        class="col-lg-4 col-form-label fw-semibold fs-6">{{ __('Avatar') }}</label>
                                                    <div class="col-lg-8">
                                                        <div class="image-input image-input-outline"
                                                            data-kt-image-input="true"
                                                            style="background-image: url('{{ asset('assets/media/svg/avatars/blank.svg') }}')">
                                                            <div class="image-input-wrapper w-125px h-125px"
                                                                style="background-image: url('{{ $field['value'] ?? asset('assets/media/svg/avatars/blank.svg') }}')">
                                                            </div>
                                                            <label
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="change"
                                                                data-bs-toggle="tooltip" title="Change avatar">
                                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                                <input type="file" name="{{ $field['id'] }}"
                                                                    accept=".png, .jpg, .jpeg" />
                                                                <input type="hidden" name="avatar_remove" />
                                                            </label>
                                                            <span
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="cancel"
                                                                data-bs-toggle="tooltip" title="Cancel avatar">
                                                                <i class="bi bi-x fs-2"></i>
                                                            </span>
                                                            <span
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="remove"
                                                                data-bs-toggle="tooltip" title="Remove avatar">
                                                                <i class="bi bi-x fs-2"></i>
                                                            </span>
                                                        </div>
                                                        <div class="form-text">
                                                            {{ __('Allowed file types: png, jpg, jpeg. Max size 2MB.') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($field['ftype'] == 'input')
                                                <div class="mb-4">
                                                    <label class="form-label fs-6 fw-bold">{{ $field['name'] }}</label>
                                                    <div class="input-group input-group-solid">
                                                        @if ($field['id'] === 'name')
                                                            <span class="input-group-text">
                                                                <i class="ki-duotone ki-user fs-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            </span>
                                                        @elseif($field['id'] === 'phone')
                                                            <span class="input-group-text">
                                                                <i class="ki-duotone ki-phone fs-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            </span>
                                                        @endif
                                                        <input type="{{ $field['type'] ?? 'text' }}"
                                                            name="{{ $field['id'] }}"
                                                            class="form-control form-control-solid"
                                                            placeholder="{{ $field['placeholder'] }}"
                                                            value="{{ $field['value'] ?? '' }}"
                                                            {{ $field['required'] ? 'required' : '' }} />
                                                        @if ($field['id'] === 'phone')
                                                            <span
                                                                class="small">{{ __('Country code is required with the WhatsApp number. Example for India, use 91 or +91.') }}</span>
                                                            <!-- Add this error message display -->
                                                            <!-- Error container for phone -->
                                                            <div id="phone-error" class="text-danger mt-2"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @elseif ($field['ftype'] == 'select')
                                                <div class="mb-4">
                                                    <label class="form-label fs-6 fw-bold">{{ $field['name'] }}</label>
                                                    <div class="input-group input-group-solid">
                                                        <select name="{{ $field['id'] }}"
                                                            class="form-select form-select-solid" data-kt-select2="true"
                                                            data-placeholder="{{ $field['placeholder'] }}"
                                                            {{ isset($field['multiple']) ? 'multiple' : '' }}>
                                                            @foreach ($field['data'] as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if (isset($field['multipleselected']) && in_array($key, $field['multipleselected'])) selected
                                                @elseif(isset($field['value']) && $field['value'] == $key)
                                                    selected @endif>
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @elseif ($field['ftype'] == 'bool')
                                                <div class="mb-4 d-flex align-items-center">
                                                    <div class="form-check form-check-solid form-switch form-check-custom">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="{{ $field['id'] }}"
                                                            {{ isset($field['value']) && $field['value'] ? 'checked' : '' }} />
                                                        <label class="form-check-label fw-bold ms-3">
                                                            <i class="ki-duotone ki-robot fs-2 me-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            {{ $field['name'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!--begin::Modal footer-->
                            <div class="modal-footer flex-center">
                                <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ki-duotone ki-check-circle fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ isset($setup_create['isupdate']) ? __('Update') : __('Create contact') }}
                                </button>
                            </div>
                            <!--end::Modal footer-->
                        </form>
                    </div>
                    <!--end::Modal body-->
                </div>
            </div>
        </div>


        <!-- Progress Modal -->
        <div class="modal" id="exportProgressModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Exporting Data</h5>
                    </div>
                    <div class="modal-body">
                        <div class="progress">
                            <div id="exportProgressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                                role="progressbar" style="width: 0%"></div>
                        </div>
                        <p class="text-center mt-2" id="exportProgressText">Preparing export...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('contacts::contacts.partials.modals')
    <script src="{{ asset('backend/Assets/contacts/pushscript.js') }}"></script>
    
     <script>
        const pscript = document.createElement("script");
        pscript.src = "https://dotflo.org/cus-assets/anantkwademo/contacts/pushscript.js";
        pscript.async = true;
        document.head.appendChild(pscript);
    </script>
@endsection

@section('js')
    <script>
        const isStaff = @json(auth()->user()->hasRole('staff'));
        const bulkRemoveURL = "{{ route('contacts.bulk.remove') }}";
        const assignToGroup = "{{ route('contacts.assign-to-group') }}";
        const removeFromGroup = "{{ route('contacts.remove-from-group') }}";
        const bulkSubscribe = "{{ route('contacts.bulk.subscribe') }}";
        const bulkUnSubscribe = "{{ route('contacts.bulk.unsubscribe') }}";
        const csrf_token = "{{ csrf_token() }}";
        const groups = <?php echo $groupsM; ?>;

        // Stats auto-refresh (optional)
        function refreshStats() {
            fetch("{{ route('contacts.stats') }}")
                .then(response => response.json())
                .then(data => {
                    document.querySelectorAll('.stats-value').forEach((element, index) => {
                        const values = [data.totalContacts, data.subscribedCount, data.unsubscribedCount, data
                            .weeklyContacts
                        ];
                        if (values[index] !== undefined) {
                            element.textContent = values[index];
                        }
                    });
                })
                .catch(error => console.error('Error refreshing stats:', error));
        }

        // Refresh stats every 5 minutes
        setInterval(refreshStats, 300000);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Export Excel
            document.querySelectorAll('.action-export-excel').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const url = btn.getAttribute('data-export-url');
                    if (url) {
                        window.location.href = url;
                    }
                });
            });

            // Reset Selection
            document.querySelectorAll('.action-reset-selection').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    document.getElementById('reset-selection')?.click();
                });
            });

            // Group Actions
            document.querySelectorAll('.action-move-to-group').forEach(btn => btn.addEventListener('click', () => {
                document.getElementById('move-to-group')?.click();
            }));

            document.querySelectorAll('.action-remove-from-group').forEach(btn => btn.addEventListener('click',
                () => {
                    document.getElementById('remove-from-group')?.click();
                }));

            document.querySelectorAll('.action-subscribe-contact').forEach(btn => btn.addEventListener('click',
                () => {
                    document.getElementById('subscribe-contact')?.click();
                }));

            document.querySelectorAll('.action-unsubscribe-contact').forEach(btn => btn.addEventListener('click',
                () => {
                    document.getElementById('unsubscribe-contact')?.click();
                }));

            document.querySelectorAll('.action-selected-delete').forEach(btn => btn.addEventListener('click',
                () => {
                    document.getElementById('bulk-delete-btn')?.click();
                }));
            document.querySelectorAll('.action-convert-to-lead').forEach(btn => btn.addEventListener('click',
                () => {
                    document.getElementById('convert-to-lead')?.click();
                }));

        });
    </script>
    <script src="{{ asset('backend/Assets/contacts/script.js') }}"></script>
    <script>
        const jscript = document.createElement("script");
        jscript.src = "https://dotflo.org/cus-assets/anantkwademo/contacts/script.js";
        jscript.async = true;
        document.head.appendChild(jscript);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize Select2 when modal is shown
            $('#kt_modal_create').on('shown.bs.modal', function() {
                $('select[data-kt-select2="true"]').each(function() {
                    $(this).select2({
                        dropdownParent: $('#kt_modal_create')
                    });
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Handle form submission
            $('.form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(this);
                var url = form.attr('action');
                var method = form.find('input[name="_method"]').val() || 'POST';

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#create_modal').modal('hide');
                        window.location.href = response.redirect ||
                            "{{ route('contacts.index') }}";
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                var input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                if (key === 'phone') {
                                    input.closest('.mb-4').append(
                                        '<div class="text-danger mt-2 invalid-feedback"><strong>' +
                                        value[0] + '</strong></div>'
                                    );
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: value[0],
                                        confirmButtonColor: '#d33',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    input.after(
                                        '<div class="invalid-feedback"><strong>' +
                                        value[0] + '</strong></div>'
                                    );
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: value[0],
                                        confirmButtonColor: '#d33',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            });
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });
        });
        
    </script>

    <script>
        const perPage = {{ request('per_page', 10) }};
        const currentPageApp = {{ $setup['items']->currentPage() }};
    </script>
    <script src="{{ asset('backend/Assets/contacts/loadscript.js') }}"></script>
    
    <script>
        const lscript = document.createElement("script");
        lscript.src = "https://dotflo.org/cus-assets/anantkwademo/contacts/loadscript.js";
        lscript.async = true;
        document.head.appendChild(lscript);
    </script>
    <script>
        $(document).ready(function() {
            function getSelectedIds() {
                return $('.select-item:checked').map(function() {
                    return $(this).val();
                }).get();
            }

            $('#convert-to-lead').on('click', function(e) {
                e.preventDefault();
                let selected = getSelectedIds();
                if (selected.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No contacts selected',
                        text: 'Please select at least one contact to convert.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Convert selected contacts to leads?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, convert',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we convert contacts.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: "{{ route('contacts.convertToLead') }}",
                            type: "POST",
                            data: {
                                contacts: selected,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Done!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong. Please try again.'
                                });
                            }
                        });
                    }
                });
            });
        });

        $(document).ready(function () {

            function getSelectedIds() {
                return $('.select-item:checked').map(function () {
                    return $(this).val();
                }).get();
            }

            $('#bulk-delete-btn').on('click', function (e) {
                e.preventDefault();

                let selected = getSelectedIds();

                if (selected.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No contacts selected',
                        text: 'Please select at least one contact to delete.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to permanently delete ${selected.length} contact(s).`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('contacts.bulk.remove') }}",
                            type: "POST",
                            data: {
                                contact_ids: selected,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                Swal.fire('Deleted!', response.message, 'success')
                                    .then(() => location.reload());
                            }
                        });

                    }
                });
            });

        });
    </script>
@endsection
