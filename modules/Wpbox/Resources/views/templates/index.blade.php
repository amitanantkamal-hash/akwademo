@extends('layouts.app-client', ['title' => __('Template Management')])

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-xxl">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-message-text-2 fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    {{ __('Template Management') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $templates->total() }}
                    {{ __('Templates') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                @if ($templates->isNotEmpty())
                    <div class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <form method="GET" class="d-flex align-items-center position-relative">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4 text-gray-500">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" name="name" class="form-control form-control-solid ps-12 w-250px"
                                placeholder="Search templates..." value="{{ request('name') }}"
                                onkeydown="if(event.key === 'Enter') this.form.submit()">

                            @foreach (request()->except('name', 'page') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                        </form>
                    </div>
                @endif
                <a href="https://business.facebook.com/wa/manage/message-templates/" target="_blank"
                    class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>
                    {{ __('WhatsApp Manager') }}
                </a>
                <a href="{{ route('templates.create') }}" class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>
                    {{ __('New Template') }}
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        @if ($templates->isNotEmpty())
            <div class="row g-6 mb-7">
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #3699FF;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon me-4">
                                <i class="ki-duotone ki-message-text-2 fs-2hx text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $totalTemplates }}</span>
                                <span class="stats-label">{{ __('Total Templates') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #1BC5BD;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon me-4">
                                <i class="ki-duotone ki-check-circle fs-2hx text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $approvedTemplates }}</span>
                                <span class="stats-label">{{ __('Approved') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #FFA800;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon me-4">
                                <i class="ki-duotone ki-time fs-2hx text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $pendingTemplates }}</span>
                                <span class="stats-label">{{ __('Pending') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4 stats-card"
                        style="border-left-color: #F64E60;">
                        <div class="d-flex align-items-center w-100 px-4">
                            <div class="stats-icon me-4">
                                <i class="ki-duotone ki-cross-circle fs-2hx text-danger">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="stats-value">{{ $rejectedTemplates }}</span>
                                <span class="stats-label">{{ __('Rejected') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Templates Table Card -->
        <div class="card">
            @if ($templates->isNotEmpty())
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('All Templates') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted fs-7">{{ __('Filter by status:') }}</span>
                            <select class="form-select form-select-sm w-150px" id="status-filter">
                                <option value="">{{ __('All Statuses') }}</option>
                                <option value="APPROVED">{{ __('Approved') }}</option>
                                <option value="PENDING">{{ __('Pending') }}</option>
                                <option value="REJECTED">{{ __('Rejected') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="card-body border-bottom">
                    <form method="GET" action="{{ url()->current() }}">
                        <div class="row g-4 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label fs-7 fw-bold">{{ __('Category') }}</label>
                                <select class="form-select form-select-solid" name="category">
                                    <option value="">{{ __('All Categories') }}</option>
                                    @foreach ($distinctCategories as $cat)
                                        <option value="{{ $cat }}"
                                            {{ request('category') == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-7 fw-bold">{{ __('Language') }}</label>
                                <select class="form-select form-select-solid" name="language">
                                    <option value="">{{ __('All Languages') }}</option>
                                    @foreach ($distinctLanguages as $lang)
                                        <option value="{{ $lang }}"
                                            {{ request('language') == $lang ? 'selected' : '' }}>
                                            {{ $lang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-light-primary me-2">
                                    <i class="ki-duotone ki-filter fs-2 me-2"></i>
                                    {{ __('Apply Filters') }}
                                </button>
                                <a href="{{ url()->current() }}" class="btn btn-light-danger me-2">
                                    <i class="ki-duotone ki-arrows-circle fs-2 me-2"></i>
                                    {{ __('Reset') }}
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['refresh' => 'yes']) }}"
                                    class="btn btn-icon btn-light" data-bs-toggle="tooltip" title="Refresh">
                                    <i class="ki-duotone ki-arrows-circle fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6"
                            id="templates-table">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-250px">{{ __('Template') }}</th>
                                    <th class="min-w-100px">{{ __('Status') }}</th>
                                    <th class="min-w-100px">{{ __('Category') }}</th>
                                    <th class="min-w-100px">{{ __('Language') }}</th>
                                    <th class="min-w-150px text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($templates as $template)
                                    <tr data-template-status="{{ $template->status }}" class="template-row">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px symbol-circle me-5">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-message-text-2 fs-2 text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6 mb-1">{{ $template->name }}</span>
                                                    {{-- <span class="text-muted fs-7">ID: {{ $template->id }}</span> --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-light-{{ $template->status == 'APPROVED' ? 'success' : ($template->status == 'PENDING' ? 'warning' : 'danger') }} py-3 px-4 fs-7">
                                                <span
                                                    class="bullet bullet-vertical me-2 bg-{{ $template->status == 'APPROVED' ? 'success' : ($template->status == 'PENDING' ? 'warning' : 'danger') }}"></span>
                                                {{ $template->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">{{ $template->category }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-light-primary">{{ strtoupper($template->language) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2 align-items-center">
                                                <!-- Preview Button -->
                                                <a href="#templatePreviewModal"
                                                    class="btn btn-icon btn-light-info btn-sm preview-template"
                                                    data-id="{{ $template->id }}"
                                                    data-components='@json($template->components)' data-bs-toggle="modal"
                                                    title="{{ __('Preview') }}" data-bs-toggle="tooltip">
                                                    <i class="ki-duotone ki-eye fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </a>

                                                <!-- Delete Button -->
                                                <button class="btn btn-icon btn-light-danger btn-sm delete-template"
                                                    data-template-id="{{ $template->id }}"
                                                    data-template-name="{{ $template->name }}"
                                                    data-delete-url="{{ route('templates.destroy', $template->id) }}"
                                                    title="{{ __('Delete') }}" data-bs-toggle="tooltip">
                                                    <i class="ki-duotone ki-trash fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($templates->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center">
                            <span class="text-muted fs-7">
                                {{ __('Showing') }}
                                <strong>{{ $templates->firstItem() ?? 0 }}</strong>
                                {{ __('to') }}
                                <strong>{{ $templates->lastItem() ?? 0 }}</strong>
                                {{ __('of') }}
                                <strong>{{ $templates->total() }}</strong>
                                {{ __('entries') }}
                            </span>
                        </div>
                        <div class="d-flex flex-wrap py-2">
                            {{ $templates->links('vendor.pagination.metronic') }}
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
                                    <i class="ki-duotone ki-message-text-2 fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="fw-bolder mb-3">{{ __('No Templates Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('You haven\'t created any templates yet. Templates help you send consistent and professional messages to your contacts.') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <a href="{{ route('templates.create') }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    {{ __('Create Your First Template') }}
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
                                    {{ __('Templates allow you to create reusable message formats for different communication scenarios.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Template Preview Modal -->
    <div class="modal fade" id="templatePreviewModal" tabindex="-1" aria-labelledby="templatePreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="templatePreviewModalLabel">{{ __('Template Preview') }}</h5>
                    <button type="button" class="btn btn-sm btn-icon btn-light-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                </div>

                <!-- Make modal body scrollable -->
                <div class="modal-body p-0" style="max-height: 80vh; overflow-y: auto;">
                    <!-- WhatsApp-style background container -->
                    <div class="d-flex justify-content-center align-items-center py-10"
                        style="min-height: 500px; background: url('{{ asset('uploads/default/dotflo/bg.png') }}'); background-size: cover; background-position: center;">

                        <!-- Mobile-sized preview card -->
                        <div id="previewElement" class="card shadow-lg"
                            style="width: 360px; border-radius: 12px; overflow: hidden;">

                            <!-- Chat-like message container -->
                            <div class="card-body py-4 px-3" style="background-color: #ffffff;">
                                <div id="templatePreviewBody"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{ __('About Templates') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="mb-3">{{ __('Template Status') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('APPROVED') }}</span>
                                <span>{{ __('Template is approved and ready to use') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-warning me-3">{{ __('PENDING') }}</span>
                                <span>{{ __('Template is awaiting approval') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-danger me-3">{{ __('REJECTED') }}</span>
                                <span>{{ __('Template needs revision') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h4 class="mb-3">{{ __('Best Practices') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Use clear and descriptive template names') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Include helpful descriptions for future reference') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Categorize templates for better organization') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route('templates.create') }}" class="btn btn-primary">{{ __('Create Template') }}</a>
                </div>
            </div>
        </div>
    </div>
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

            // Status filter functionality
            const statusFilter = document.getElementById('status-filter');
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    const status = this.value;
                    const rows = document.querySelectorAll('.template-row');

                    rows.forEach(row => {
                        if (status === '' || row.getAttribute('data-template-status') === status) {
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
                    const statusFilterValue = statusFilter ? statusFilter.value : '';
                    const rows = document.querySelectorAll('.template-row');

                    if (searchTerm.length === 0) {
                        // Show all rows based on status filter
                        rows.forEach(row => {
                            if (statusFilterValue === '' || row.getAttribute(
                                    'data-template-status') === statusFilterValue) {
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
                        const description = row.querySelector('td:first-child span.text-muted')
                            .textContent.toLowerCase();

                        const matchesSearch = name.includes(searchTerm) || description.includes(
                            searchTerm);
                        const matchesStatus = statusFilterValue === '' || row.getAttribute(
                            'data-template-status') === statusFilterValue;

                        row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                    });
                });
            }

            // Template preview functionality
            function formatTemplateText(text) {
                if (!text) return '';
                let safeText = text
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");

                safeText = safeText.replace(/\*(.*?)\*/g, '<strong>$1</strong>');
                safeText = safeText.replace(/_(.*?)_/g, '<em>$1</em>');
                return safeText.replace(/\n/g, '<br>');
            }

            document.querySelectorAll('.preview-template').forEach(button => {
                button.addEventListener('click', function() {
                    let componentsRaw = this.dataset.components;
                    let components;

                    try {
                        components = JSON.parse(componentsRaw);
                        if (typeof components === 'string') {
                            components = JSON.parse(components);
                        }
                    } catch (e) {
                        console.error("Invalid components data", e);
                        return;
                    }

                    const container = document.getElementById('templatePreviewBody');
                    container.innerHTML = '';

                    components.forEach(comp => {
                        if (comp.type === 'HEADER') {
                            if (comp.format === 'TEXT') {
                                container.innerHTML +=
                                    `<h4 class="fw-bold mb-3">${formatTemplateText(comp.text)}</h4>`;
                            } else if (['IMAGE', 'VIDEO', 'DOCUMENT'].includes(comp
                                    .format)) {
                                const url = comp.example?.header_handle?.[0];
                                if (url) {
                                    if (comp.format === 'IMAGE') {
                                        container.innerHTML +=
                                            `<img src="${url}" class="img-fluid rounded mb-3"" />`;
                                    } else if (comp.format === 'VIDEO') {
                                        container.innerHTML +=
                                            `<video controls class="w-100 rounded mb-3" style="max-height: 200px;"><source src="${url}"></video>`;
                                    } else if (comp.format === 'DOCUMENT') {
                                        container.innerHTML +=
                                            `<a href="${url}" target="_blank" class="btn btn-info mb-3 w-100">View Document</a>`;
                                    }
                                }
                            }
                        }

                        if (comp.type === 'BODY') {
                            container.innerHTML +=
                                `<p class="fs-5 mb-3">${formatTemplateText(comp.text)}</p>`;
                        }

                        if (comp.type === 'FOOTER') {
                            container.innerHTML +=
                                `<p class="text-muted small mb-3">${formatTemplateText(comp.text)}</p>`;
                        }

                        if (comp.type === 'BUTTONS') {
                            const btnGroup = document.createElement('div');
                            btnGroup.className = 'd-flex flex-wrap gap-2 mt-3';

                            comp.buttons.forEach(btn => {
                                let html = '';
                                if (btn.type === 'PHONE_NUMBER') {
                                    html =
                                        `<a href="tel:${btn.phone_number}" class="btn btn-sm btn-light-primary w-100">${btn.text}</a>`;
                                } else if (btn.type === 'URL') {
                                    html =
                                        `<a href="${btn.url}" target="_blank" class="btn btn-sm btn-light-primary w-100">${btn.text}</a>`;
                                } else if (btn.type === 'QUICK_REPLY') {
                                    html =
                                        `<button class="btn btn-sm btn-light-primary w-100">${btn.text}</button>`;
                                }
                                btnGroup.innerHTML += html;
                            });

                            container.appendChild(btnGroup);
                        }
                    });
                });
            });

            // Delete template functionality
            const isStaff = @json(auth()->user()->hasRole('staff'));

            document.querySelectorAll('.delete-template').forEach(button => {
                button.addEventListener('click', function() {
                    if (isStaff) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Permission Denied',
                            text: 'You do not have rights to delete this template.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        return;
                    }

                    const templateId = this.getAttribute('data-template-id');
                    const templateName = this.getAttribute('data-template-name');
                    const deleteUrl = this.getAttribute('data-delete-url');

                    Swal.fire({
                        title: 'Delete Template?',
                        html: `<div class="text-center">
                            <i class="ki-duotone ki-question fs-2hx text-danger mb-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <p class="fs-5">Are you sure you want to delete<br><b>${templateName}</b>?</p>
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
                            Swal.fire({
                                title: 'Deleting...',
                                text: 'Please wait while we delete the template',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                didOpen: () => Swal.showLoading()
                            });

                            fetch(deleteUrl, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content,
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'Template has been deleted successfully!',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed!',
                                        text: 'Could not delete template. Please try again.',
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

        .bullet {
            display: inline-block;
            width: 4px;
            border-radius: 2px;
        }

        .bullet-vertical {
            height: 24px;
        }

        .template-row td {
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

            .template-row .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            #status-filter {
                width: 100% !important;
                margin-top: 1rem;
            }
        }
    </style>
@endpush
