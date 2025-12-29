@extends('layouts.app-client')

@section('title', 'Facebook Leads')

@section('content')
    <div class="container-xxl">
        <div class="card card-flush">
            <!-- Card Header -->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5 d-flex justify-content-between flex-wrap">
                <h3 class="card-title">
                    <i class="ki-outline ki-facebook fs-2 me-2 text-primary"></i>
                    Facebook Leads
                </h3>

                <div class="card-toolbar">
                    <!-- Filter Button -->
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="ki-outline ki-filter fs-3 me-1"></i> Filter
                    </button>

                    <!-- Back Button -->
                    <a href="{{ route('ctwameta.index') }}" class="btn btn-light btn-sm ms-2">
                        <i class="ki-outline ki-arrow-left fs-3 me-1"></i> Back
                    </a>
                </div>
            </div>

            <!-- Leads Table Card -->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 table-hover">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-150px">
                                    <i class="ki-outline ki-user fs-3 me-1"></i> Name
                                </th>
                                <th class="min-w-150px">
                                    <i class="ki-outline ki-phone fs-3 me-1"></i> Phone
                                </th>
                                <th class="min-w-200px">
                                    <i class="ki-outline ki-mail fs-3 me-1"></i> Email
                                </th>
                                <th class="min-w-100px">
                                    <i class="ki-outline ki-id-card fs-3 me-1"></i> Form ID
                                </th>
                                <th class="min-w-150px">
                                    <i class="ki-outline ki-calendar fs-3 me-1"></i> FB Created At
                                </th>
                                <th class="min-w-150px">
                                    <i class="ki-outline ki-clock fs-3 me-1"></i> System Received At
                                </th>
                                <th class="min-w-150px">
                                    <i class="ki-outline ki-setting-3 fs-3 me-1"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                            @forelse ($leads as $lead)
                                @php
                                    $fields = $lead->field_data ?? [];
                                    $name = $fields['full_name'] ?? '-';
                                    $phone = $fields['phone_number'] ?? '-';
                                    $email = $fields['email'] ?? '-';
                                    $fbCreated = isset($fields['created_time'])
                                        ? \Carbon\Carbon::parse($fields['created_time'])->format('d M Y H:i')
                                        : '-';
                                    $receivedAt = optional($lead->received_at)->format('d M Y H:i') ?? '-';
                                    $createdAt = optional($lead->created_at)->format('d M Y H:i') ?? '-';
                                @endphp
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td>{{ $phone }}</td>
                                    <td>{{ $email }}</td>
                                    <td>
                                        <span class="badge badge-success">{{ $lead->form_id ?? '-' }}</span>
                                    </td>
                                    <td>{{ $receivedAt }}</td>
                                    <td>{{ $createdAt }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary view-lead-btn"
                                            data-bs-toggle="modal" data-bs-target="#leadModal"
                                            data-fields='@json($fields)' data-leadid="{{ $lead->leadgen_id }}"
                                            data-adid="{{ $lead->ad_id ?? '-' }}" data-adname="{{ $lead->ad_name ?? '-' }}"
                                            data-pageid="{{ $pageId }}" data-pagename="{{ $pageName }}"
                                            data-receivedat="{{ $receivedAt }}">
                                            <i class="ki-outline ki-eye fs-3 me-1"></i> View
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted fw-bold py-4">
                                        <i class="ki-outline ki-inbox fs-2 d-block mb-2"></i>
                                        No leads found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-5">
                    <div class="text-muted fs-7">
                        Showing {{ $leads->firstItem() ?? 0 }} to {{ $leads->lastItem() ?? 0 }} of {{ $leads->total() }}
                        entries
                    </div>
                    <div class="mt-3 mt-sm-0">
                        {{ $leads->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('facebook.pages.leads', $pageId) }}" method="GET" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ki-outline ki-filter fs-3 me-2 text-primary"></i> Filter Leads
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                                placeholder="Enter name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ request('phone') }}" class="form-control"
                                placeholder="Enter phone number">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" value="{{ request('email') }}" class="form-control"
                                placeholder="Enter email address">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('facebook.pages.leads', $pageId) }}" class="btn btn-secondary">
                            <i class="ki-outline ki-refresh fs-3 me-1"></i> Reset
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ki-outline ki-search fs-3 me-1"></i> Apply
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lead Modal -->
        <div class="modal fade" id="leadModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ki-outline ki-information fs-3 me-2 text-primary"></i>
                            Lead Details - <span id="modalLeadID"></span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="lead-detail">
                                    <strong>Page ID:</strong>
                                    <span id="modalPageID"></span>
                                </div>
                                <div class="lead-detail">
                                    <strong>Page Name:</strong>
                                    <span id="modalPageName"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="lead-detail">
                                    <strong>Ad ID:</strong>
                                    <span id="modalAdID"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="lead-detail">
                                    <strong>Ad Name:</strong>
                                    <span id="modalAdName"></span>
                                </div>
                            </div>
                        </div>

                        <div class="lead-detail">
                            <strong>System Received At:</strong>
                            <span id="modalReceivedAt"></span>
                        </div>

                        <div class="nav-divider my-4"></div>

                        <h6 class="mb-3">
                            Lead Fields
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Field</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody id="lead-fields-list">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('css')
    <style>
        .card {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            border: 0;
            border-radius: 12px;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #EFF2F5;
            padding: 1.5rem 1.5rem;
            font-weight: 600;
            font-size: 1.35rem;
            color: #181C32;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn-primary {
            background-color: #7239EA;
            border-color: #7239EA;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #5d2bc8;
            border-color: #5d2bc8;
        }

        .btn-light {
            background-color: #F5F8FA;
            border-color: #EFF2F5;
            color: #7E8299;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-light:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
            color: #181C32;
        }

        .table th {
            font-weight: 600;
            color: #7E8299;
            font-size: 0.9rem;
            text-transform: uppercase;
            border-top: 0;
            padding: 1rem 0.75rem;
        }

        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-color: #EFF2F5;
        }

        .table-hover tbody tr:hover {
            background-color: #F8F5FF;
        }

        .modal-header {
            border-bottom: 1px solid #EFF2F5;
            padding: 1.25rem;
        }

        .modal-footer {
            border-top: 1px solid #EFF2F5;
            padding: 1rem 1.25rem;
        }

        .modal-title {
            font-weight: 600;
            color: #181C32;
        }

        .form-control {
            border: 1px solid #EFF2F5;
            border-radius: 6px;
            padding: 0.65rem 1rem;
        }

        .form-control:focus {
            border-color: #7239EA;
            box-shadow: 0 0 0 3px rgba(114, 57, 234, 0.1);
        }

        .badge-success {
            background-color: #50CD89;
            padding: 0.5em 0.75em;
            border-radius: 6px;
            font-weight: 500;
        }

        .lead-detail {
            padding: 0.5rem 0;
            border-bottom: 1px solid #EFF2F5;
        }

        .lead-detail:last-child {
            border-bottom: 0;
        }

        .nav-divider {
            border-top: 1px solid #EFF2F5;
            margin: 1rem 0;
        }
    </style>
@endpush

@push('js')
    <script>
        document.querySelectorAll('.view-lead-btn').forEach(button => {
            button.addEventListener('click', function() {
                const fields = JSON.parse(this.dataset.fields || '{}');
                document.getElementById('modalLeadID').textContent = this.dataset.leadid;
                document.getElementById('modalAdID').textContent = this.dataset.adid;
                document.getElementById('modalAdName').textContent = this.dataset.adname;
                document.getElementById('modalPageName').textContent = this.dataset.pagename;
                document.getElementById('modalPageID').textContent = this.dataset.pageid;
                document.getElementById('modalReceivedAt').textContent = this.dataset.receivedat;

                const tbody = document.getElementById('lead-fields-list');
                tbody.innerHTML = '';

                for (const [key, value] of Object.entries(fields)) {
                    if (['full_name', 'phone_number', 'email', 'created_time'].includes(key)) continue;
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td><strong>${key.replace(/_/g,' ')}</strong></td>
                    <td>${Array.isArray(value) ? value.join(', ') : value}</td>
                `;
                    tbody.appendChild(tr);
                }
            });
        });
    </script>
@endpush
