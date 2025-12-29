@extends('layouts.app-client')

@section('title', 'CTWA Analytics')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2>Analytics for {{ $account->name }}</h2>
                </div>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end">
                        <div class="me-4">
                            <label class="form-label fw-bold">Date Range:</label>
                            <span class="text-muted">{{ $startDate }} to {{ $endDate }}</span>
                        </div>
                    </div>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Summary Cards-->
                <div class="row g-6 g-xl-9 mb-6">
                    <!-- Impressions -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card bg-light-success card-xl-stretch">
                            <div class="card-body">
                                <i class="fas fa-eye fs-2x text-success"></i>
                                <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">
                                    {{ number_format(
                                        $analytics->sum(function ($item) {
                                            return $item->metrics['basic']['impressions'] ?? 0;
                                        }),
                                    ) }}
                                </div>
                                <div class="fw-bold text-gray-600">Total Impressions</div>
                            </div>
                        </div>
                    </div>

                    <!-- Reach -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card bg-light-primary card-xl-stretch">
                            <div class="card-body">
                                <i class="fas fa-users fs-2x text-primary"></i>
                                <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">
                                    {{ number_format(
                                        $analytics->sum(function ($item) {
                                            return $item->metrics['basic']['reach'] ?? 0;
                                        }),
                                    ) }}
                                </div>
                                <div class="fw-bold text-gray-600">Total Reach</div>
                            </div>
                        </div>
                    </div>

                    <!-- Spend -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card bg-light-danger card-xl-stretch">
                            <div class="card-body">
                                <i class="fas fa-rupee-sign fs-2x text-danger"></i>
                                <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">
                                    ₹{{ number_format(
                                        $analytics->sum(function ($item) {
                                            return $item->metrics['basic']['spend'] ?? 0;
                                        }),
                                        2,
                                    ) }}
                                </div>
                                <div class="fw-bold text-gray-600">Total Spend</div>
                            </div>
                        </div>
                    </div>

                    <!-- Leads -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card bg-light-warning card-xl-stretch">
                            <div class="card-body">
                                <i class="fas fa-user-plus fs-2x text-warning"></i>
                                <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">
                                    @php
                                        $totalLeads = $analytics->sum(function ($item) {
                                            $actions = $item->metrics['actions'] ?? [];
                                            $leads = 0;
                                            foreach ($actions as $type => $value) {
                                                if (
                                                    str_contains($type, 'lead') ||
                                                    str_contains($type, 'onsite_conversion.lead_grouped')
                                                ) {
                                                    $leads += $value;
                                                }
                                            }
                                            return $leads;
                                        });
                                    @endphp
                                    {{ number_format($totalLeads) }}
                                </div>
                                <div class="fw-bold text-gray-600">Total Leads</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Summary Cards-->

                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th>Date</th>
                                <th class="text-end">Impressions</th>
                                <th class="text-end">Reach</th>
                                <th class="text-end">Spend</th>
                                <th class="text-end">CPM</th>
                                <th class="text-end">CTR</th>
                                <th class="text-end">Clicks</th>
                                <th class="text-end">Leads</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($analytics as $analytic)
                                <tr>
                                    <td>{{ $analytic->date }}</td>
                                    <td class="text-end">
                                        {{ number_format($analytic->metrics['basic']['impressions'] ?? 0) }}</td>
                                    <td class="text-end">{{ number_format($analytic->metrics['basic']['reach'] ?? 0) }}</td>
                                    <td class="text-end">₹{{ number_format($analytic->metrics['basic']['spend'] ?? 0, 2) }}
                                    </td>
                                    <td class="text-end">₹{{ number_format($analytic->metrics['basic']['cpm'] ?? 0, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format($analytic->metrics['basic']['ctr'] ?? 0, 2) }}%
                                    </td>
                                    <td class="text-end">{{ number_format($analytic->metrics['basic']['clicks'] ?? 0) }}
                                    </td>
                                    <td class="text-end">
                                        @php
                                            $leads = 0;
                                            $actions = $analytic->metrics['actions'] ?? [];
                                            foreach ($actions as $type => $value) {
                                                if (
                                                    str_contains($type, 'lead') ||
                                                    str_contains($type, 'onsite_conversion.lead_grouped')
                                                ) {
                                                    $leads += $value;
                                                }
                                            }
                                        @endphp
                                        {{ $leads }}
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary"
                                            onclick="showActionsModal({{ json_encode($analytic->metrics['actions'] ?? []) }}, {{ json_encode($analytic->metrics['cost_per_action'] ?? []) }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->

    <!--begin::Modal - Actions-->
    <div class="modal fade" id="actionsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bolder">Action Details</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_actions">Actions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_costs">Costs</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="kt_tab_actions" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th>Action Type</th>
                                            <th class="text-end">Count</th>
                                        </tr>
                                    </thead>
                                    <tbody id="actionsTableBody">
                                        <!-- Will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_tab_costs" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th>Action Type</th>
                                            <th class="text-end">Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody id="costsTableBody">
                                        <!-- Will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal - Actions-->

    @push('scripts')
        <script>
            function showActionsModal(actions, costs) {
                // Populate actions tab
                const actionsTableBody = document.getElementById('actionsTableBody');
                actionsTableBody.innerHTML = '';

                if (actions && Object.keys(actions).length > 0) {
                    for (const [type, value] of Object.entries(actions)) {
                        const row = document.createElement('tr');

                        const typeCell = document.createElement('td');
                        typeCell.textContent = formatActionType(type);

                        const valueCell = document.createElement('td');
                        valueCell.className = 'text-end';
                        valueCell.textContent = value;

                        row.appendChild(typeCell);
                        row.appendChild(valueCell);
                        actionsTableBody.appendChild(row);
                    }
                } else {
                    const row = document.createElement('tr');
                    const cell = document.createElement('td');
                    cell.colSpan = 2;
                    cell.className = 'text-center text-muted';
                    cell.textContent = 'No actions recorded';
                    row.appendChild(cell);
                    actionsTableBody.appendChild(row);
                }

                // Populate costs tab
                const costsTableBody = document.getElementById('costsTableBody');
                costsTableBody.innerHTML = '';

                if (costs && Object.keys(costs).length > 0) {
                    for (const [type, value] of Object.entries(costs)) {
                        const row = document.createElement('tr');

                        const typeCell = document.createElement('td');
                        typeCell.textContent = formatActionType(type);

                        const valueCell = document.createElement('td');
                        valueCell.className = 'text-end';
                        valueCell.textContent = '$' + parseFloat(value).toFixed(2);

                        row.appendChild(typeCell);
                        row.appendChild(valueCell);
                        costsTableBody.appendChild(row);
                    }
                } else {
                    const row = document.createElement('tr');
                    const cell = document.createElement('td');
                    cell.colSpan = 2;
                    cell.className = 'text-center text-muted';
                    cell.textContent = 'No cost data recorded';
                    row.appendChild(cell);
                    costsTableBody.appendChild(row);
                }

                const modal = new bootstrap.Modal(document.getElementById('actionsModal'));
                modal.show();
            }

            function formatActionType(type) {
                // Convert snake_case to readable format
                return type
                    .replace(/onsite_conversion\./g, '')
                    .replace(/_/g, ' ')
                    .replace(/\b\w/g, l => l.toUpperCase());
            }
        </script>
    @endpush
@endsection
