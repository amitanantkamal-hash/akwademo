@extends('layouts.app', ['title' => __('Organization')])
@section('content')
    @include('companies.partials.modals')
    <div class="header pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <h1 class="mb-3 mt--3">🏢 {{ __('Organization') }}</h1>
                <div class="row align-items-center pt-2">
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <!-- Filter form and buttons (unchanged) -->
                        <div class="tab-content orders-filters">
                            <form>
                                <div class="row">
                                    <div id="form-group-name" class="form-group col-md-4 col-lg-3">
                                        <label class="form-control-label" for="name">Name</label>
                                        <div class="input-group">
                                            <input type="text" name="name" id="name"
                                                class="form-control form-control" placeholder="Enter name"
                                                value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                                        </div>
                                    </div>
                                    <div id="form-group-phone" class="form-group col-md-4 col-lg-3">
                                        <label class="form-control-label" for="phone">Phone</label>
                                        <div class="input-group">
                                            <input type="phone" name="phone" id="phone"
                                                class="form-control form-control" placeholder="Enter phone"
                                                value="{{ isset($_GET['phone']) ? $_GET['phone'] : '' }}">
                                        </div>
                                    </div>
                                    <div id="form-group-partner" class="form-group col-md-4 col-lg-3">
                                        <label class="form-control-label" for="partner_id">Partner</label>
                                        <div class="input-group">
                                            <select id="partner_id" name="partner_id"
                                                class="form-control form-control-alternative">
                                                <option value="">{{ __('Select a Partner') }}</option>
                                                @foreach ($partners as $user_id => $business_name)
                                                    <option value="{{ $user_id }}"
                                                        {{ request('partner_id') == $user_id ? 'selected' : '' }}>
                                                        {{ $business_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-lg-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-sm btn-primary mr-2">Filter</button>
                                        <a href="{{ route('admin.companies.index') }}" class="btn btn-sm btn-success">Clear
                                            Filter</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-12 col-md-8">
                                <h3 class="mb-0">Organizations List</h3>
                            </div>
                            <div class="col-12 col-md-4 text-right">
                                <a href="{{ route('admin.companies.create') }}"
                                    class="btn btn-sm btn-primary mb-2 mb-md-0">Add new</a>
                                <a href="{{ route('admin.companies.index') }}?downlodcsv=true"
                                    class="btn btn-sm btn-outline-primary mb-2 mb-md-0">{{ __('Export CSV') }}</a>
                                @if (auth()->user()->hasRole('admin') && config('settings.enable_import_csv'))
                                    <button type="button" class="btn btn-sm btn-primary mb-2 mb-md-0"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-import-companies">{{ __('Import from CSV') }}</button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        @include('partials.flash')
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-left">{{ __('Actions') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    @if (config('settings.show_company_logo'))
                                        <th scope="col" class="d-none d-md-table-cell">{{ __('Logo') }}</th>
                                    @endif
                                    <th scope="col" class="d-none d-lg-table-cell">{{ __('Owner') }}</th>
                                    <th scope="col" class="d-none d-lg-table-cell">{{ __('Owner email') }}</th>
                                    <th scope="col">{{ __('Phone') }}</th>
                                    @if (config('settings.enable_pricing'))
                                        <th scope="col">{{ __('Plan') }}</th>
                                    @endif
                                    <th scope="col" class="d-none d-xl-table-cell">{{ __('Creation Date') }}</th>
                                    <th scope="col" class="d-none d-xl-table-cell">{{ __('Created by') }}</th>
                                    <th scope="col" class="d-none d-xl-table-cell">{{ __('Account type') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col" class="text-right">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $userTypes = [
                                        1 => 'Admin',
                                        2 => 'User',
                                        3 => 'Partner',
                                    ];
                                @endphp
                                @foreach ($companies as $company)
                                    <tr>
                                        <td>
                                                    <a class="btn btn-sm btn-success mb-2 mb-md-0"
                                                        href="{{ route('admin.companies.loginas', $company) }}">{{ __('Login as') }}</a>
                                                     <a class="btn btn-sm btn-outline-primary mb-2 mb-md-0"
                                                        href="{{ route('admin.companies.edit', $company) }}">{{ __('Edit') }}</a>
                                        </td>
                                        <td>
                                            @if (auth()->user()->hasRole('manager'))
                                                <a
                                                    href="{{ route('admin.companies.loginas', $company) }}">{{ $company->name }}</a>
                                            @else
                                                <a
                                                    href="{{ route('admin.companies.edit', $company) }}">{{ $company->name }}</a>
                                            @endif
                                        </td>

                                        @if (config('settings.show_company_logo'))
                                            <td class="d-none d-md-table-cell">
                                                <img class="rounded" src={{ $company->icon }} width="50px"
                                                    height="50px">
                                            </td>
                                        @endif

                                        <td class="d-none d-lg-table-cell">
                                            {{ $company->user ? $company->user->name : __('Deleted') }}</td>
                                        <td class="d-none d-lg-table-cell">
                                            <a
                                                href="mailto: {{ $company->user ? $company->user->email : '' }}">{{ $company->user ? $company->user->email : __('Deleted') }}</a>
                                        </td>
                                        <td>
                                            <a href="tel:{{ $company->phone }}">{{ $company->phone }}</a>
                                        </td>
                                        @if (config('settings.enable_pricing'))
                                            <td>
                                                @if (isset($plans) && isset($company->user) && isset($company->user->plan_id) && isset($plans[$company->user->plan_id]))
                                                    {{ $plans[$company->user->plan_id] }}
                                                @else
                                                    No plan
                                                @endif
                                            </td>
                                        @endif
                                        <td class="d-none d-xl-table-cell">
                                            {{ $company->created_at->locale(Config::get('app.locale'))->isoFormat('LLLL') }}
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            {{ $company->user->creator->name_company ?? 'N/A' }}
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            {{ isset($company->user) ? $userTypes[$company->user->type] ?? 'Unknown' : 'Unknown' }}
                                        </td>
                                        <td>
                                            @if ($company->active == 1)
                                                <span class="badge badge-success">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge badge-warning">{{ __('Not active') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#"
                                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                    </svg>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.companies.edit', $company) }}">{{ __('Edit') }}</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.companies.loginas', $company) }}">{{ __('Login as') }}</a>
                                                    @if ($hasCloner)
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.companies.create') . '?cloneWith=' . $company->id }}">{{ __('Clone it') }}</a>
                                                    @endif
                                                    <form action="{{ route('admin.companies.destroy', $company) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        @if ($company->active == 0)
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.company.activate', $company) }}">{{ __('Activate') }}</a>
                                                        @else
                                                            <button type="button" class="dropdown-item"
                                                                onclick="confirm('{{ __('Are you sure you want to deactivate this company?') }}') ? this.parentElement.submit() : ''">
                                                                {{ __('Deactivate') }}
                                                            </button>
                                                        @endif
                                                    </form>
                                                    <a class="dropdown-item text-danger delete-company"
                                                        href="{{ route('admin.company.remove', $company) }}"
                                                        data-name="{{ $company->name }}">
                                                        {{ __('Delete') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $companies->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script type="text/javascript">
        var resUrl = "{{ route('admin.companies.edit', 0) }}";
    </script>
@endsection

@push('js')
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete company links
            const deleteLinks = document.querySelectorAll('.delete-company');

            deleteLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const companyName = this.getAttribute('data-name');
                    const deleteUrl = this.getAttribute('href');

                    Swal.fire({
                        title: 'Are you sure?',
                        html: `You are about to delete <strong>${companyName}</strong> from the database.<br><br>This will also delete all data related to it. This is an irreversible step.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'btn btn-danger',
                            cancelButton: 'btn btn-secondary'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to delete URL
                            window.location.href = deleteUrl;
                        }
                    });
                });
            });

            // Also update the deactivation confirmation
            const deactivateButtons = document.querySelectorAll('.dropdown-item[onclick*="deactivate"]');
            deactivateButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.parentElement;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Are you sure you want to deactivate this company?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, deactivate it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'btn btn-warning',
                            cancelButton: 'btn btn-secondary'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
