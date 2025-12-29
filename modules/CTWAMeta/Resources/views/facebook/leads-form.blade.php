@extends('layouts.app-client')

@section('title', 'Manage Facebook Forms')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <h3 class="fw-bold m-0">Forms for Page: {{ $page->name }}</h3>
                </div>
                <!--end::Card title-->
                
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Form-->
                    <form action="{{ route('facebook.forms.fetchAll', [$pageId, $companyId]) }}" method="POST">
                        @csrf
                        <!--begin::Button-->
                        <button type="submit" class="btn btn-sm btn-light-primary">
                            <i class="ki-duotone ki-repeat fs-3 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Fetch Forms
                        </button>
                        <!--end::Button-->
                    </form>

                    <!-- Back Button -->
                    <a href="{{ route('ctwameta.index') }}" class="btn btn-primary btn-sm ms-2">
                        <i class="ki-outline ki-arrow-left fs-3 me-1"></i> Back
                    </a>
                    <!--end::Form-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body py-4">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($forms->isEmpty())
                    <!--begin::Alert-->
                    <div class="alert alert-info d-flex align-items-center p-5">
                        <i class="ki-duotone ki-information fs-2hx me-4 text-info">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-info">No forms found</h4>
                            <span>No forms saved for this page. Click <b>Fetch Forms</b> to load.</span>
                        </div>
                    </div>
                    <!--end::Alert-->
                @else
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-4">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-150px">Form Name</th>
                                <th class="min-w-100px">Form ID</th>
                                <th class="min-w-100px">Created</th>
                                <th class="min-w-200px">Webhook URL</th>
                                <th class="min-w-250px text-end">Actions</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            @foreach ($forms as $form)
                                <tr>
                                    <td>
                                        <span class="text-gray-800 text-hover-primary">{{ $form->name ?? 'Unnamed' }}</span>
                                    </td>
                                    <td>{{ $form->form_id }}</td>
                                    <td>{{ $form->created_time ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="text-truncate me-2" style="max-width: 200px" data-bs-toggle="tooltip" title="{{ $form->webhook_url ?? 'Not Set' }}">
                                                {{ $form->webhook_url ?? 'Not Set' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <form id="save-webhook-form-{{ $form->form_id }}" action="{{ route('facebook.forms.webhook', $form->form_id) }}" method="POST" class="d-flex align-items-center me-3">
                                                @csrf
                                                <input type="url" name="webhook_url" class="form-control form-control-solid me-2 w-200px" placeholder="Webhook URL" value="{{ $form->webhook_url }}">
                                                <button type="button" class="btn btn-sm btn-success save-webhook-btn" data-form-id="{{ $form->form_id }}">
                                                    <i class="ki-duotone ki-check fs-3 me-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    Save
                                                </button>
                                            </form>
                                            
                                            @if($form->webhook_url)
                                            <form id="remove-webhook-form-{{ $form->form_id }}" action="{{ route('facebook.forms.removeWebhook', $form->form_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger remove-webhook-btn" data-form-id="{{ $form->form_id }}">
                                                    <i class="ki-duotone ki-trash fs-3 me-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                    Remove
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                    
                    <!--begin::Pagination-->
                    <div class="d-flex flex-stack flex-wrap pt-10">
                        <div class="fs-6 fw-semibold text-gray-700">
                            Showing {{ $forms->firstItem() }} to {{ $forms->lastItem() }} of {{ $forms->total() }} entries
                        </div>
                        
                        <!--begin::Pages-->
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($forms->onFirstPage())
                                <li class="page-item previous disabled">
                                    <a href="#" class="page-link"><i class="previous"></i></a>
                                </li>
                            @else
                                <li class="page-item previous">
                                    <a href="{{ $forms->previousPageUrl() }}" class="page-link"><i class="previous"></i></a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($forms->getUrlRange(1, $forms->lastPage()) as $page => $url)
                                @if ($page == $forms->currentPage())
                                    <li class="page-item active">
                                        <a href="#" class="page-link">{{ $page }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($forms->hasMorePages())
                                <li class="page-item next">
                                    <a href="{{ $forms->nextPageUrl() }}" class="page-link"><i class="next"></i></a>
                                </li>
                            @else
                                <li class="page-item next disabled">
                                    <a href="#" class="page-link"><i class="next"></i></a>
                                </li>
                            @endif
                        </ul>
                        <!--end::Pages-->
                    </div>
                    <!--end::Pagination-->
                @endif
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle save webhook button clicks
        document.querySelectorAll('.save-webhook-btn').forEach(button => {
            button.addEventListener('click', function() {
                const formId = this.getAttribute('data-form-id');
                const form = document.getElementById(`save-webhook-form-${formId}`);
                const webhookUrl = form.querySelector('input[name="webhook_url"]').value;
                
                Swal.fire({
                    title: 'Set Webhook URL',
                    text: `Are you sure you want to set the webhook URL to: ${webhookUrl}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, set it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Handle remove webhook button clicks
        document.querySelectorAll('.remove-webhook-btn').forEach(button => {
            button.addEventListener('click', function() {
                const formId = this.getAttribute('data-form-id');
                const form = document.getElementById(`remove-webhook-form-${formId}`);
                
                Swal.fire({
                    title: 'Remove Webhook URL',
                    text: 'Are you sure you want to remove this webhook?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection