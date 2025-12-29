@extends('layouts.app-client')

@section('title', __('WhatsApp Flow Submissions'))

@section('content')
    <div class="container-xxl">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-table fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    {{ __('WhatsApp Flow Submissions') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $setup['rows']->total() }}
                    {{ __('Submissions') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                @if ($setup['rows']->isNotEmpty())
                    <div class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <form action="{{ route('whatsapp.submissions') }}" method="GET" class="d-flex">
                            <input type="text" name="q" value="{{ request('q') }}"
                                class="form-control form-control-solid w-250px ps-10"
                                placeholder="{{ __('Search submissions...') }}"
                                onkeydown="if(event.key === 'Enter') this.form.submit()">
                        </form>
                    </div>
                @endif

                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="ki-duotone ki-setting-3 fs-2"></i>
                        {{ __('Actions') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if ($setup['rows']->count())
                            <li>
                                <button class="dropdown-item export-btn" type="button">
                                    <i class="ki-duotone ki-file-download fs-2 me-2"></i>
                                    {{ __('Export to Excel') }}
                                </button>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('whatsapp-flows.index') }}" class="dropdown-item">
                                <i class="ki-duotone ki-arrow-left fs-2 me-2"></i>
                                {{ __('Back to Flows') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        @if ($setup['rows']->isNotEmpty())
            @php
                $todayCount = $setup['rows']->filter(function($row) {
                    return \Carbon\Carbon::parse($row['created_at'])->isToday();
                })->count();
                
                $weekCount = $setup['rows']->filter(function($row) {
                    return \Carbon\Carbon::parse($row['created_at'])->gt(now()->subWeek());
                })->count();
                
                $uniqueFlows = $setup['rows']->pluck('flow_name')->unique()->count();
            @endphp
            <div class="row g-6 mb-7">
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-dark">{{ $setup['rows']->total() }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Total Submissions') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-success">{{ $todayCount }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Today') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-warning">{{ $weekCount }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('This Week') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-info">{{ $uniqueFlows }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Unique Flows') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Submissions Table Card -->
        <div class="card">
            @if ($setup['rows']->isNotEmpty())
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('All Submissions') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <span class="text-muted fs-7">
                            {{ __('Showing') }} {{ $setup['rows']->firstItem() }} - {{ $setup['rows']->lastItem() }} 
                            {{ __('of') }} {{ $setup['rows']->total() }}
                        </span>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">#</th>
                                    <th class="min-w-200px">{{ __('Flow') }}</th>
                                    <th class="min-w-300px">{{ __('Form Data') }}</th>
                                    <th class="min-w-150px">{{ __('Submitted') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($setup['rows'] as $index => $row)
                                    <tr class="submission-row">
                                        <td>{{ $index + $setup['rows']->firstItem() }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px symbol-circle me-5">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-message-text-2 fs-3 text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    @php
                                                        $fullFlowName = $row['flow_name'] ?? 'N/A';
                                                        $isLong = strlen($fullFlowName) > 35;
                                                        $shortFlowName = $isLong ? Str::limit($fullFlowName, 35, '...') : $fullFlowName;
                                                        $rowId = 'flowName' . $index;
                                                    @endphp
                                                    <span class="text-dark fw-bolder fs-6 mb-1" 
                                                          id="{{ $rowId }}_short"
                                                          style="{{ $isLong ? '' : 'display:block;' }}">
                                                        {{ $shortFlowName }}
                                                    </span>
                                                    @if ($isLong)
                                                        <span class="text-dark fw-bolder fs-6 mb-1 d-none" 
                                                              id="{{ $rowId }}_full">
                                                            {{ $fullFlowName }}
                                                        </span>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-light-primary mt-1 toggle-flow-btn"
                                                                data-target="{{ $rowId }}">
                                                            {{ __('Show More') }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-data-container">
                                                @foreach ($row['form_data'] as $key => $value)
                                                    <div class="d-flex align-items-center mb-2 p-2 bg-light rounded">
                                                        <span class="badge badge-light-info me-3 text-uppercase fs-7 fw-bold px-3 py-2 min-w-100px text-center">
                                                            {{ $key }}
                                                        </span>
                                                        <span class="text-gray-800 fs-6">{{ $value }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark fw-bolder">{{ \Carbon\Carbon::parse($row['created_at'])->format('d M, Y') }}</span>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($row['created_at'])->format('h:i A') }}</small>
                                                <span class="text-muted fs-7 mt-1">{{ \Carbon\Carbon::parse($row['created_at'])->diffForHumans() }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($setup['rows']->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center">
                            <span class="text-muted fs-7">
                                {{ __('Showing') }}
                                <strong>{{ $setup['rows']->firstItem() ?? 0 }}</strong>
                                {{ __('to') }}
                                <strong>{{ $setup['rows']->lastItem() ?? 0 }}</strong>
                                {{ __('of') }}
                                <strong>{{ $setup['rows']->total() }}</strong>
                                {{ __('entries') }}
                            </span>
                        </div>
                        <div class="d-flex flex-wrap py-2">
                            {{ $setup['rows']->withQueryString()->links() }}
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
                                    <i class="ki-duotone ki-table fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="text-dark fw-bolder mb-3">{{ __('No Submissions Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('No form submissions have been recorded yet. Submissions will appear here once users start interacting with your WhatsApp flows.') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <a href="{{ route('whatsapp-flows.index') }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-arrow-left fs-2"></i>
                                    {{ __('Back to Flows') }}
                                </a>
                                <a href="{{ route('whatsapp-flows.create') }}" class="btn btn-light">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    {{ __('Create New Flow') }}
                                </a>
                            </div>

                            <!-- Additional Help -->
                            <div class="mt-10">
                                <div class="d-flex align-items-center text-muted fs-7">
                                    <i class="ki-duotone ki-information fs-3 me-2"></i>
                                    {{ __('Submissions are automatically recorded when users complete your WhatsApp flows.') }}
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
                    <h2 class="modal-title">{{ __('About Submissions') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="text-dark mb-3">{{ __('What are submissions?') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Data collected from WhatsApp flow interactions') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('User responses to your flow questions') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Automatically recorded when flows are completed') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-dark mb-3">{{ __('Submission Data') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-info me-3">{{ __('Flow Name') }}</span>
                                <span>{{ __('Which flow the submission came from') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-primary me-3">{{ __('Form Data') }}</span>
                                <span>{{ __('All the information submitted by the user') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('Timestamp') }}</span>
                                <span>{{ __('When the submission was received') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route('whatsapp-flows.create') }}"
                        class="btn btn-primary">{{ __('Create Flow') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle flow name functionality
            document.querySelectorAll('.toggle-flow-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const target = this.getAttribute('data-target');
                    const shortEl = document.getElementById(target + '_short');
                    const fullEl = document.getElementById(target + '_full');

                    if (shortEl.style.display === 'none') {
                        shortEl.style.display = 'block';
                        fullEl.style.display = 'none';
                        this.textContent = '{{ __('Show More') }}';
                    } else {
                        shortEl.style.display = 'none';
                        fullEl.style.display = 'block';
                        this.textContent = '{{ __('Show Less') }}';
                    }
                });
            });

            // Export functionality
            document.querySelectorAll('.export-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const search = new URLSearchParams(window.location.search).get('q') || '';

                    Swal.fire({
                        title: '{{ __('Exporting...') }}',
                        html: '{{ __('Please wait while we prepare your file.') }}',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const downloadUrl = `{{ route('whatsapp.submissions.export') }}?q=${encodeURIComponent(search)}`;

                    fetch(downloadUrl, {
                            headers: {
                                'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error("{{ __('Failed to export') }}");
                            return response.blob();
                        })
                        .then(blob => {
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = 'whatsapp_submissions_{{ now()->format("Y_m_d") }}.xlsx';
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);

                            Swal.fire({
                                icon: 'success',
                                title: '{{ __('Exported!') }}',
                                text: '{{ __('Your Excel file has been downloaded.') }}',
                            });
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('Error') }}',
                                text: error.message || '{{ __('Something went wrong during export.') }}'
                            });
                        });
                });
            });

            // Search form submission on enter
            const searchInput = document.querySelector('input[name="q"]');
            if (searchInput) {
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        this.form.submit();
                    }
                });
            }
        });
    </script>
@endpush

@push('css')
    <style>
        .submission-avatar {
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

        .submission-row td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .form-data-container {
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #e4e6ef;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .form-data-container .bg-light {
            background-color: #f1faff !important;
            border-left: 3px solid #3699ff;
        }

        .badge-light-info {
            background-color: #f8f5ff;
            color: #8950fc;
        }

        .badge-light-primary {
            background-color: #f1faff;
            color: #3699ff;
        }

        .toggle-flow-btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .min-w-100px {
            min-width: 100px;
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

            .form-data-container .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .form-data-container .badge {
                margin-bottom: 0.5rem;
                width: 100%;
                text-align: center;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }
    </style>
@endpush