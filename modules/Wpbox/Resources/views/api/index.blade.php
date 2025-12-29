@extends('wpbox::layouts.index-api-campaing', $setup)

@section('content')
    <div class="container-xxl">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center mb-4">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                    <i class="fas fa-code fs-2hx me-4 text-primary">
                    </i>
                    {{ __('API Campaigns Management') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $setup['items']->total() }}
                    {{ __('Campaigns') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                @if ($setup['items']->isNotEmpty())
                    <div class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="campaign-search" class="form-control form-control-solid w-250px ps-10"
                            placeholder="{{ __('Search campaigns...') }}">
                    </div>
                @endif

                <a href="{{ route('campaigns.create', ['type' => 'api']) }}" class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>
                    {{ __('Add New Campaign') }}
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        @if ($setup['items']->isNotEmpty())
            {{-- <div class="row g-6 mb-7">
                <div class="col-xl-4 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-dark">{{ $setup['items']->total() }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Total Campaigns') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-success">{{ $setup['items']->count() }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Active Campaigns') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-info">0</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Running Now') }}</span>
                    </div>
                </div>
            </div> --}}
        @endif

        <!-- Campaigns Table Card -->
        <div class="card">
            @if ($setup['items']->isNotEmpty())
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('All Campaigns') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted fs-7">{{ __('Sort by:') }}</span>
                            <select class="form-select form-select-sm w-150px" id="sort-campaigns">
                                <option value="name">{{ __('Name') }}</option>
                                <option value="id">{{ __('Campaign ID') }}</option>
                                <option value="recent">{{ __('Most Recent') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Campaigns List -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-250px">{{ __('Campaign') }}</th>
                                    <th class="min-w-150px">{{ __('Campaign ID') }}</th>
                                    <th class="min-w-200px text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($setup['items'] as $item)
                                    <tr class="campaign-row" data-campaign-id="{{ $item->id }}"
                                        data-campaign-name="{{ $item->name }}">
                                        <!-- Campaign Name & Details -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px symbol-circle me-5">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-abstract-41 fs-2 text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark fw-bolder fs-6 mb-1">{{ $item->name }}</span>
                                                    <span class="text-muted fs-7">{{ __('Created') }}:
                                                        {{ $item->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Campaign ID -->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-semibold fs-6">#{{ $item->id }}</span>
                                                <span class="text-muted fs-7">{{ __('Unique Identifier') }}</span>
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2 align-items-center">
                                                <!-- Analytics Button -->
                                                <a href="{{ route('campaigns.show', $item->id) }}"
                                                    class="btn btn-light-primary btn-sm me-2"
                                                    title="{{ __('View Analytics') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-abstract-45 me-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    {{ __('Analytics') }}
                                                </a>
                                                {{-- 
                                                <!-- Edit Button -->
                                                <a href=""
                                                    class="btn btn-icon btn-light-warning btn-sm me-2"
                                                    title="{{ __('Edit Campaign') }}" 
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-pencil fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a> --}}

                                                <!-- Delete Button -->
                                                @if (auth()->user()->hasRole('staff'))
                                                    <button class="btn btn-icon btn-light-danger btn-sm"
                                                        title="{{ __('Permission Denied') }}" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" onclick="showPermissionDenied()">
                                                        <i class="ki-duotone ki-trash-square fs-4">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-icon btn-light-danger btn-sm btn-delete-campaign"
                                                        data-campaign-id="{{ $item->id }}"
                                                        data-campaign-name="{{ $item->name }}"
                                                        title="{{ __('Delete Campaign') }}" data-bs-toggle="tooltip"
                                                        data-bs-placement="top">
                                                        <i class="ki-duotone ki-trash-square fs-4">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
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
                                    <i class="fas fa-code fs-2hx me-4 text-primary">
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="text-dark fw-bolder mb-3">{{ __('No API Campaigns Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('You haven\'t created any campaigns yet. Campaigns help you organize and track your marketing efforts and analytics.') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <a href="{{ route('campaigns.create', ['type' => 'api']) }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    {{ __('Create Your First API Campaign') }}
                                </a>
                                <a href="#" class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#campaignHelpModal">
                                    <i class="ki-duotone ki-information fs-2"></i>
                                    {{ __('Learn More') }}
                                </a>
                            </div>

                            <!-- Additional Help -->
                            <div class="mt-10">
                                <div class="d-flex align-items-center text-muted fs-7">
                                    <i class="ki-duotone ki-information fs-3 me-2"></i>
                                    {{ __('Campaigns allow you to track performance, analyze results, and optimize your marketing strategies.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Help Modal -->
    <div class="modal fade" id="campaignHelpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{ __('About Campaigns') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="text-dark mb-3">{{ __('What can you do with campaigns?') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Track marketing performance') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Analyze campaign results') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Monitor key metrics and KPIs') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Optimize your marketing strategies') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-dark mb-3">{{ __('Campaign Features') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-primary me-3">{{ __('Analytics') }}</span>
                                <span>{{ __('Detailed performance tracking and reporting') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('Management') }}</span>
                                <span>{{ __('Easy campaign creation and editing') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route($setup['webroute_path'] . 'create') }}"
                        class="btn btn-primary">{{ __('Create Campaign') }}</a>
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
            const searchInput = document.getElementById('campaign-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('.campaign-row');

                    if (searchTerm.length === 0) {
                        rows.forEach(row => row.style.display = '');
                        return;
                    }

                    rows.forEach(row => {
                        const name = row.querySelector('td:first-child span.text-dark').textContent
                            .toLowerCase();
                        const id = row.querySelector('td:nth-child(2) span.text-gray-800')
                            .textContent
                            .toLowerCase();

                        const matchesSearch = name.includes(searchTerm) || id.includes(searchTerm);
                        row.style.display = matchesSearch ? '' : 'none';
                    });
                });
            }

            // Sort functionality
            const sortSelect = document.getElementById('sort-campaigns');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    // Implement sorting logic here
                    console.log('Sort by:', this.value);
                    // You would typically reload the page with sort parameters or reorder via AJAX
                });
            }

            // Delete campaign functionality
            const deleteButtons = document.querySelectorAll('.btn-delete-campaign');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const campaignId = this.getAttribute('data-campaign-id');
                    const campaignName = this.getAttribute('data-campaign-name');

                    deleteCampaign(campaignId, campaignName);
                });
            });
        });

        function showPermissionDenied() {
            Swal.fire({
                icon: 'warning',
                title: 'Permission Denied',
                text: 'You do not have proper rights to delete this item.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        }

        function deleteCampaign(campaignId, campaignName) {
            Swal.fire({
                title: 'Are you sure?',
                html: `You are about to delete the campaign <strong>"${campaignName}"</strong>. This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX delete request
                    $.ajax({
                        url: "{{ route('campaigns.delete', ':id') }}".replace(':id', campaignId),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The campaign has been deleted successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong while deleting the campaign.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush

@push('css')
    <style>
        .campaign-avatar {
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

        .campaign-row td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .btn-delete-campaign {
            transition: all 0.3s ease;
        }

        .btn-delete-campaign:hover {
            transform: scale(1.05);
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

            .campaign-row .d-flex.gap-2 .btn {
                margin: 0;
                justify-content: center;
            }

            #sort-campaigns {
                width: 100% !important;
                margin-top: 1rem;
            }
        }
    </style>
@endpush
