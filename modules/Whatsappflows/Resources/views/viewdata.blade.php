@extends('layouts.app-client')

@section('title', __('Flow Data - ' . $setup['flow_name']))

@section('content')
    <div class="container-xxl">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-chart-line fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    {{ __('Flow Data') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ count($setup['rows']) }}
                    {{ __('Entries') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                @if (!empty($setup['rows']))
                    <div class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="table-search" class="form-control form-control-solid w-250px ps-10"
                            placeholder="{{ __('Search data...') }}">
                    </div>
                @endif

                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="ki-duotone ki-setting-3 fs-2"></i>
                        {{ __('Actions') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if (!empty($setup['rows']))
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

        <!-- Flow Info Card -->
        <div class="card mb-7">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-60px symbol-circle me-5">
                                <div class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-message-text-2 fs-2 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="text-gray-600 fs-7">{{ __('Flow Name') }}</span>
                                <span class="text-dark fw-bolder fs-4">{{ $setup['flow_name'] }}</span>
                                @if (isset($setup['entity_id']))
                                    <span class="text-muted fs-8 mt-1">ID: {{ $setup['entity_id'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="d-flex flex-column">
                            <span class="text-gray-600 fs-7">{{ __('Total Entries') }}</span>
                            <span class="text-dark fw-bolder fs-2">{{ count($setup['rows']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="card">
            @if (!empty($setup['rows']))
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('Flow Data Entries') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <span class="text-muted fs-7">
                            {{ __('Showing') }} <strong>{{ count($setup['rows']) }}</strong>
                            {{ __('entries') }}
                        </span>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6"
                            id="flow-data-table">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">#</th>
                                    @foreach ($setup['headers'] as $header)
                                        <th class="min-w-150px">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($setup['rows'] as $index => $row)
                                    <tr class="data-row">
                                        <td class="text-dark fw-bolder">{{ $loop->iteration }}</td>
                                        @foreach ($row as $cell)
                                            <td class="pe-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="text-truncate" style="max-width: 200px"
                                                        data-bs-toggle="tooltip" title="{{ $cell }}">
                                                        {{ $cell }}
                                                    </span>
                                                    @if (strlen($cell) > 30)
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-light ms-2 copy-cell"
                                                            data-text="{{ $cell }}" data-bs-toggle="tooltip"
                                                            title="{{ __('Copy to clipboard') }}">
                                                            <i class="ki-duotone ki-copy fs-4">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Data Summary -->
                    {{-- <div class="mt-6 p-4 bg-light-primary rounded">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <span class="text-gray-600 fs-7 d-block">{{ __('Total Columns') }}</span>
                                <span class="text-dark fw-bolder fs-3">{{ count($setup['headers']) }}</span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-gray-600 fs-7 d-block">{{ __('Total Rows') }}</span>
                                <span class="text-dark fw-bolder fs-3">{{ count($setup['rows']) }}</span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-gray-600 fs-7 d-block">{{ __('Last Updated') }}</span>
                                <span class="text-dark fw-bolder fs-7">{{ now()->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                    </div> --}}
                </div>
            @else
                <!-- Empty State -->
                <div class="card-body">
                    <div class="text-center py-10">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <!-- Icon -->
                            <div class="symbol symbol-100px symbol-circle mb-5">
                                <div class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-chart-line fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="text-dark fw-bolder mb-3">{{ __('No Data Available') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('No data has been collected for this flow yet. Data will appear here once users start interacting with your WhatsApp flow.') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <a href="{{ route('whatsapp-flows.index') }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-arrow-left fs-2"></i>
                                    {{ __('Back to Flows') }}
                                </a>
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
                                    {{ __('Flow data is automatically collected when users complete your WhatsApp flow forms.') }}
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
                    <h2 class="modal-title">{{ __('About Flow Data') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="text-dark mb-3">{{ __('What is flow data?') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Responses collected from your WhatsApp flow') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('User inputs from form fields and interactions') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Automatically recorded when flows are completed') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-dark mb-3">{{ __('Data Management') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-primary me-3">{{ __('Export') }}</span>
                                <span>{{ __('Download data as Excel for analysis') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-info me-3">{{ __('Search') }}</span>
                                <span>{{ __('Find specific entries quickly') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('Copy') }}</span>
                                <span>{{ __('Copy individual cell values to clipboard') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route('whatsapp-flows.create') }}" class="btn btn-primary">{{ __('Create Flow') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        const entity_id = {{ $setup['entity_id'] }};

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Search functionality
            const searchInput = document.getElementById('table-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('.data-row');

                    if (searchTerm.length === 0) {
                        rows.forEach(row => row.style.display = '');
                        return;
                    }

                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        let matches = false;

                        cells.forEach(cell => {
                            if (cell.textContent.toLowerCase().includes(searchTerm)) {
                                matches = true;
                            }
                        });

                        row.style.display = matches ? '' : 'none';
                    });
                });
            }

            // Copy cell functionality
            document.querySelectorAll('.copy-cell').forEach(button => {
                button.addEventListener('click', async function() {
                    const text = this.getAttribute('data-text');

                    try {
                        await navigator.clipboard.writeText(text);

                        // Show success feedback
                        const originalTitle = this.getAttribute('title');
                        this.setAttribute('title', '{{ __('Copied!') }}');
                        const tooltip = bootstrap.Tooltip.getInstance(this);
                        if (tooltip) {
                            tooltip.show();
                        }

                        setTimeout(() => {
                            this.setAttribute('title', originalTitle);
                            if (tooltip) {
                                tooltip.hide();
                            }
                        }, 2000);

                    } catch (err) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: '{{ __('Failed to copy to clipboard') }}',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                });
            });

            // Export functionality

            // Auto-resize table columns on window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Trigger tooltip update on resize
                    tooltipList.forEach(tooltip => {
                        tooltip.update();
                    });
                }, 250);
            });
        });
    </script>
    <script>
        const setup = @json($setup);

        document.querySelectorAll('.export-btn').forEach(button => {
            button.addEventListener('click', function() {
                Swal.fire({
                    title: '{{ __('Exporting Data') }}',
                    html: '{{ __('Preparing your Excel file...') }}',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    // Create workbook
                    const wb = XLSX.utils.book_new();

                    const exportData = [
                        [...setup.headers],
                        ...setup.rows
                    ];

                    // Create worksheet
                    const ws = XLSX.utils.aoa_to_sheet(exportData);

                    // Add worksheet to workbook
                    XLSX.utils.book_append_sheet(wb, ws, 'Flow Data');

                    // Generate file name
                    const fileName = (setup.entity_id ?? 'flow_data') + '_' + new Date().toISOString()
                        .split('T')[0] + '.xlsx';

                    // Export file
                    XLSX.writeFile(wb, fileName);

                    Swal.fire({
                        icon: 'success',
                        title: '{{ __('Exported!') }}',
                        text: '{{ __('Your Excel file has been downloaded.') }}',
                        confirmButtonText: '{{ __('OK') }}'
                    });

                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('Export Failed') }}',
                        text: error.message || '{{ __('Something went wrong during export.') }}',
                        confirmButtonText: '{{ __('OK') }}'
                    });
                }
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .data-table-container {
            max-height: 600px;
            overflow: auto;
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

        .data-row td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #e4e6ef;
        }

        .data-row:hover td {
            background-color: #f8f9fa;
        }

        .bg-light-primary {
            background-color: #f1faff !important;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .copy-cell {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .data-row:hover .copy-cell {
            opacity: 1;
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

            .table-responsive {
                font-size: 0.875rem;
            }

            .data-row td {
                padding: 0.75rem 0.5rem;
            }

            .copy-cell {
                opacity: 1;
                /* Always show on mobile */
            }
        }

        /* Custom scrollbar for table */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
@endpush
