@extends('layouts.app-client')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        .stage-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
        }

        .lead-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f3f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #3699ff;
        }
    </style>
@endsection

@section('content')
    @php
        $filtersApplied = request()->except('page'); // check if any filter params exist
    @endphp
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-chart-simple fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Lead Manager
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $leads->total() ?? 0 }}
                    {{ __('Leads') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                @if ($leads->isNotEmpty())
                    <div class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="table-search" class="form-control form-control-solid w-250px ps-10"
                            placeholder="{{ __('Search leads...') }}">
                    </div>
                @endif

                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="ki-duotone ki-plus fs-2 me-2"></i>
                        {{ __('Add Lead') }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('leads.create') }}">Add Single Lead</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#importModal">Import Leads</a></li>
                    </ul>
                </div>

                <a href="{{ route('leads.kanban') }}" class="btn btn-light-primary">
                    <i class="ki-duotone ki-columns-vertical fs-2 me-2"></i>
                    {{ __('Kanban View') }}
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        @if ($leads->isNotEmpty())
            <div class="row g-6 mb-7">
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #3699FF;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-primary me-4">
                                <i class="ki-duotone ki-abstract-42 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $totalLeads }}</span>
                                <span class="stats-label">{{ __('Total Leads') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #1BC5BD;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-success me-4">
                                <i class="ki-duotone ki-abstract-42 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $wonLeads }}</span>
                                <span class="stats-label">{{ __('Won Leads') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #FFA800;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-warning me-4">
                                <i class="ki-duotone ki-abstract-42 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $inProgressLeads + $newLeads }}</span>
                                <span class="stats-label">{{ __('Active Leads') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #F64E60;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-danger me-4">
                                <i class="ki-duotone ki-abstract-42 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $lostLeads }}</span>
                                <span class="stats-label">{{ __('Lost Leads') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            {{-- <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #F64E60;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon bg-light-danger me-4">
                                <i class="ki-duotone ki-dollar fs-2hx text-danger">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">${{ number_format($totalValue) }}</span>
                                <span class="stats-label">{{ __('Total Value') }}</span>
                            </div>
                        </div>
                    </div>
                </div> --}}
    </div>
    @endif

    <!-- Leads Table Card -->
    <div class="card">
        @if ($leads->isNotEmpty())
            <!-- Card Header -->
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h3 class="fw-bolder m-0">{{ __('All Leads') }}</h3>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted fs-7">{{ __('Filter by stage:') }}</span>
                        <select class="form-select form-select-sm w-150px" id="stage-filter">
                            <option value="">{{ __('All Stages') }}</option>
                            <option value="New">{{ __('New') }}</option>
                            <option value="In Progress">{{ __('In Progress') }}</option>
                            <option value="Won">{{ __('Won') }}</option>
                            <option value="Lost">{{ __('Lost') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="card-body border-bottom">
                <form method="GET" action="{{ route('leads.index') }}">
                    <div class="row g-4 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fs-7 fw-bold">{{ __('Stage') }}</label>
                            <select name="stage" class="form-control" onchange="this.form.submit()">
                                <option value="all">All Stages</option>
                                <option value="_default"
                                    {{ request()->has('stage') ? (request('stage') == '_default' ? 'selected' : '') : 'selected' }}>
                                    Default (New + Follow-up + In Progress)
                                </option>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage }}"
                                        {{ request('stage') == $stage ? 'selected' : '' }}>
                                        {{ $stage }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fs-7 fw-bold">{{ __('Agent') }}</label>
                            <select name="agent_id" class="form-select form-select-solid" onchange="this.form.submit()">
                                <option value="">{{ __('All Agents') }}</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}"
                                        {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fs-7 fw-bold">{{ __('Start Date') }}</label>
                            <input type="date" name="start_date" class="form-control form-control-solid"
                                value="{{ request('start_date') }}" onchange="this.form.submit()">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fs-7 fw-bold">{{ __('End Date') }}</label>
                            <input type="date" name="end_date" class="form-control form-control-solid"
                                value="{{ request('end_date') }}" onchange="this.form.submit()">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-light-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#advancedSearchModal">
                                <i class="ki-duotone ki-filter fs-2 me-2"></i>
                                {{ __('Advanced') }}
                            </button>
                            <a href="{{ route('leads.index') }}" class="btn btn-light-danger">
                                <i class="ki-duotone ki-arrows-circle fs-2 me-2"></i>
                                {{ __('Reset') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="card-body border-bottom" id="bulk-actions" style="display:none;">
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold text-gray-600" id="selected-count">0 leads selected</span>
                    <div class="dropdown">
                        <button class="btn btn-light-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="ki-duotone ki-abstract-41 fs-2 me-2"></i>
                            {{ __('Bulk Actions') }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#bulkAddTagModal">Add Tag</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#bulkRemoveTagModal">Remove Tag</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#bulkAddGroupModal">Add to Group</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#bulkRemoveGroupModal">Remove from Group</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6" id="leads-table">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                    </div>
                                </th>
                                <th class="min-w-200px">{{ __('Lead') }}</th>
                                <th class="min-w-120px">{{ __('Contact Info') }}</th>
                                <th class="min-w-120px">{{ __('Source') }}</th>
                                <th class="min-w-100px">{{ __('Stage') }}</th>
                                <th class="min-w-120px">{{ __('Agent') }}</th>
                                <th class="min-w-150px">{{ __('Next Follow-up') }}</th>
                                <th class="min-w-120px">{{ __('Created') }}</th>
                                <th class="min-w-150px text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                            @foreach ($leads as $lead)
                                <tr data-lead-stage="{{ $lead->stage }}" class="lead-row">
                                    <td class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input lead-checkbox" type="checkbox"
                                                value="{{ $lead->contact->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40px symbol-circle me-3">
                                                <div class="symbol-label bg-light-primary">
                                                    <span
                                                        class="text-primary fw-bolder">{{ substr($lead->contact->name ?? 'U', 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="fw-bolder fs-6 mb-1">{{ $lead->contact->name ?? 'Unknown' }}</span>

                                                @php
                                                    $tags = is_array($lead->contact->tags)
                                                        ? $lead->contact->tags
                                                        : json_decode($lead->contact->tags, true) ?? [];
                                                    $groups = is_array($lead->contact->groups)
                                                        ? $lead->contact->groups
                                                        : json_decode($lead->contact->groups, true) ?? [];
                                                @endphp

                                                @if (!empty($tags))
                                                    <div class="mt-1">
                                                        @foreach ($tags as $tag)
                                                            <span
                                                                class="badge badge-success me-1 mb-1">{{ is_array($tag) ? $tag['name'] ?? '' : $tag }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if (!empty($groups))
                                                    <div class="mt-1">
                                                        @foreach ($groups as $group)
                                                            <span
                                                                class="badge badge-info fw-bold me-1">{{ is_array($group) ? $group['name'] ?? '' : $group }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="text-gray-800 fw-semibold fs-6">{{ $lead->contact->phone }}</span>
                                            <span class="text-muted fs-7">{{ $lead->contact->email ?? 'No email' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-light-info">{{ $lead->source?->name ?? 'Not specified' }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-light-{{ $lead->stage == 'Won' ? 'success' : ($lead->stage == 'Lost' ? 'danger' : 'primary') }} stage-badge">
                                            {{ $lead->stage }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-800 fw-semibold fs-6">{{ $lead->contact->user->name ?? 'Unassigned' }}</span>
                                    </td>
                                    <td>
                                        @php $nextFollowup = $lead->nextFollowup(); @endphp
                                        <span class="text-muted fs-7">
                                            {{ $nextFollowup ? $nextFollowup->scheduled_at->format('M d, Y H:i') : 'Not scheduled' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted fs-7">
                                            {{ $lead->created_at ? $lead->created_at->format('M d, Y') : '-' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 align-items-center">
                                            <!-- Chat Button -->
                                            <a href="{{ route('campaigns.create', ['contact_id' => $lead->contact_id]) }}"
                                                class="btn btn-icon btn-light-primary btn-sm" title="{{ __('Chat') }}"
                                                data-bs-toggle="tooltip" target="_blank">
                                                <i class="ki-duotone ki-messages fs-4">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>

                                            <!-- View Button -->
                                            <a href="{{ route('leads.show', $lead->id) }}"
                                                class="btn btn-icon btn-light-info btn-sm" title="{{ __('View') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="ki-duotone ki-eye fs-4">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('leads.edit', $lead->id) }}"
                                                class="btn btn-icon btn-light-warning btn-sm" title="{{ __('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="ki-duotone ki-pencil fs-4">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
                                                class="delete-lead-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-light-danger btn-sm"
                                                    title="{{ __('Delete') }}" data-bs-toggle="tooltip">
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
            @if ($leads->hasPages())
                <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center">
                        <span class="text-muted fs-7">
                            {{ __('Showing') }}
                            <strong>{{ $leads->firstItem() ?? 0 }}</strong>
                            {{ __('to') }}
                            <strong>{{ $leads->lastItem() ?? 0 }}</strong>
                            {{ __('of') }}
                            <strong>{{ $leads->total() }}</strong>
                            {{ __('entries') }}
                        </span>
                    </div>
                    <div class="d-flex flex-wrap py-2">
                        {{ $leads->links('vendor.pagination.metronic') }}
                    </div>
                </div>
            @endif
        @else
            @if (!empty($filtersApplied))
                <!-- No Leads under filter -->
                <div class="card-body">
                    <div class="text-center py-10">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <!-- Icon -->
                            <div class="symbol symbol-100px symbol-circle mb-5">
                                <div class="symbol-label bg-light-warning">
                                    <i class="ki-duotone ki-abstract-42 fs-2hx">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="fw-bolder mb-3">{{ __('No Leads Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('No leads match your selected filters. Try adjusting or resetting the filters to see more leads.') }}
                            </p>

                            <!-- Reset Button -->
                            <div class="d-flex gap-3">
                                <a href="{{ route('leads.index') }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-refresh fs-2"></i>
                                    {{ __('Reset Filters') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State (No filters, first time) -->
                <div class="card-body">
                    <div class="text-center py-10">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <!-- Icon -->
                            <div class="symbol symbol-100px symbol-circle mb-5">
                                <div class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="fw-bolder mb-3">{{ __('No Leads Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('You haven\'t added any leads yet. Leads help you track potential customers and manage your sales pipeline.') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <a href="{{ route('leads.create') }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    {{ __('Create Your First Lead') }}
                                </a>
                                <a href="#" class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#helpModal">
                                    <i class="ki-duotone ki-information fs-2"></i>
                                    {{ __('Learn More') }}
                                </a>
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
                    <h2 class="modal-title">{{ __('About Leads') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="mb-3">{{ __('Lead Stages') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-primary me-3">{{ __('New') }}</span>
                                <span>{{ __('Recently added leads that need initial contact') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-warning me-3">{{ __('In Progress') }}</span>
                                <span>{{ __('Leads currently being worked on') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('Won') }}</span>
                                <span>{{ __('Successfully converted leads') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-danger me-3">{{ __('Lost') }}</span>
                                <span>{{ __('Leads that did not convert') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route('leads.create') }}" class="btn btn-primary">{{ __('Create Lead') }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('lead-manager::leads.bulk-modals')
    @include('lead-manager::leads.advanced-search-modal')
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Bulk selection functionality
            let selectedContacts = [];

            function updateSelectedContacts() {
                selectedContacts = Array.from(document.querySelectorAll('.lead-checkbox:checked')).map(checkbox =>
                    checkbox.value);
                const bulkActions = document.getElementById('bulk-actions');
                const selectedCount = document.getElementById('selected-count');

                if (bulkActions && selectedCount) {
                    bulkActions.style.display = selectedContacts.length > 0 ? 'block' : 'none';
                    selectedCount.textContent = `${selectedContacts.length} leads selected`;
                }
            }

            // Select all functionality
            const selectAll = document.getElementById('select-all');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.lead-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSelectedContacts();
                });
            }

            // Individual checkbox functionality
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('lead-checkbox')) {
                    updateSelectedContacts();
                }
            });

            // Stage filter functionality
            const stageFilter = document.getElementById('stage-filter');
            if (stageFilter) {
                stageFilter.addEventListener('change', function() {
                    const stage = this.value;
                    const rows = document.querySelectorAll('.lead-row');

                    rows.forEach(row => {
                        if (stage === '' || row.getAttribute('data-lead-stage') === stage) {
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
                    const stageFilterValue = stageFilter ? stageFilter.value : '';
                    const rows = document.querySelectorAll('.lead-row');

                    if (searchTerm.length === 0) {
                        // Show all rows based on stage filter
                        rows.forEach(row => {
                            if (stageFilterValue === '' || row.getAttribute('data-lead-stage') ===
                                stageFilterValue) {
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
                        const phone = row.querySelector('td:nth-child(3) span.text-gray-800')
                            .textContent.toLowerCase();
                        const email = row.querySelector('td:nth-child(3) span.text-muted')
                            .textContent.toLowerCase();

                        const matchesSearch = name.includes(searchTerm) || phone.includes(
                            searchTerm) || email.includes(searchTerm);
                        const matchesStage = stageFilterValue === '' || row.getAttribute(
                            'data-lead-stage') === stageFilterValue;

                        row.style.display = (matchesSearch && matchesStage) ? '' : 'none';
                    });
                });
            }

            // Delete lead functionality
            document.querySelectorAll('.delete-lead-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const isStaff = @json(auth()->user()->hasRole('staff'));
                    if (isStaff) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Permission Denied',
                            text: 'You do not have rights to delete this lead.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This lead will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Initialize Select2 for modals
            const initSelect2 = (modalId) => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.addEventListener('shown.bs.modal', function() {
                        $(this).find('.select2').select2({
                            width: '100%',
                            dropdownParent: $(this)
                        });
                    });
                }
            };

            // Initialize all modals
            initSelect2('advancedSearchModal');
            initSelect2('bulkAddTagModal');
            initSelect2('bulkRemoveTagModal');
            initSelect2('bulkAddGroupModal');
            initSelect2('bulkRemoveGroupModal');
        });
    </script>
@endsection
