@extends('layouts.app-client')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!-- Main Content -->
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <!-- Flash Messages -->
                @include('partials.flash')

                <!-- Organizations Table -->
                <div class="card card-custom">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <h3 class="card-label">{{ __('Organizations List') }}</h3>
                        </div>
                        <div class="card-toolbar">
                            @if (config('settings.enable_create_company', true))
                                <button type="button" data-bs-toggle="modal" data-bs-target="#myModal">
                                
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                    {{ __('Add new') }}
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">{{ __('Name') }}</th>
                                        @if (config('settings.show_company_logo'))
                                            <th class="min-w-125px">{{ __('Logo') }}</th>
                                        @endif
                                        <th class="min-w-125px">{{ __('Status') }}</th>
                                        <th class="text-end min-w-125px">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @foreach (auth()->user()->companies->where('active', 1) as $company)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.organizations.edit', $company) }}"
                                                    class="text-gray-800 text-hover-primary fs-5 fw-bold">
                                                    {{ $company->name }}
                                                </a>
                                            </td>
                                            @if (config('settings.show_company_logo'))
                                                <td>
                                                    <div class="symbol symbol-50px symbol-circle">
                                                        <img src="{{ $company->icon }}" alt="{{ $company->name }}" class="img-fluid rounded-circle" width="50" height="50">
                                                    </div>
                                                </td>
                                            @endif
                                            <td>
                                                <span class="badge badge-light-success">{{ __('Active') }}</span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.organizations.edit', $company) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                </a>
                                                <a href="{{ route('admin.companies.switch', $company) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="currentColor"></path>
                                                            <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                </a>
                                                @if ($company->id != auth()->user()->company_id)
                                                    <form action="{{ route('admin.companies.destroy', $company) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm"
                                                            onclick="return confirm('{{ __('Are you sure you want to delete this organization?') }}')">
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                                                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
                                                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </button>
                                                    </form>
                                                @endif
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
    </div>

    <!-- Create Organization Modal -->
    <div class="modal fade" id="createOrgModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">{{ __('Create new organization') }}</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body py-10 px-4">
                    <form action="{{ route('admin.organizations.create') }}" method="POST">
                        @csrf
                        <div class="fv-row mb-10">
                            <input type="text" class="form-control form-control-solid" id="organization_name" placeholder="{{ __('Organization name') }}" name="name" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-info">
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M10.3 14.3L11 13.6L7.70002 10.3C7.30002 9.9 6.7 9.9 6.3 10.3C5.9 10.7 5.9 11.3 6.3 11.7L10.3 15.7C10.7 16.1 11.3 16.1 11.7 15.7C12.1 15.3 12.1 14.7 11.7 14.3H10.3Z" fill="currentColor"></path>
                                        <path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM11.7 15.7C11.3 16.1 10.7 16.1 10.3 15.7L6.3 11.7C5.9 11.3 5.9 10.7 6.3 10.3C6.7 9.9 7.30002 9.9 7.70002 10.3L11 13.6L10.3 14.3H11.7C12.1 14.7 12.1 15.3 11.7 15.7Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                {{ __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('topjs')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script> --}}
@endsection