@extends('layouts.app-client')

@section('content')
    <!-- Begin: Header Section -->
    @include('partials.flash')

    <div class="card card-custom gutter-b bg-light">
        <div class="card-header border-0 py-5">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <span class="svg-icon svg-icon-2x me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    <h3 class="card-label fw-bolder">{{ __('Organization Management') }}</h3>
                </div>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('admin.organizations.manage') }}" class="btn btn-info">
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M9.60001 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13H9.60001V11Z" fill="currentColor"></path>
                            <path opacity="0.3" d="M9.6 20V4L2.3 11.3C1.9 11.7 1.9 12.3 2.3 12.7L9.6 20Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    {{ __('Back to list') }}
                </a>
            </div>
        </div>
    </div>
    <!-- End: Header Section -->

    <!-- Begin: Tab Navigation -->
    {{-- <div class="card card-custom gutter-b">
        <div class="card-body pt-0">
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-bold">
                @if (count($appFields) > 0 || (auth()->user()->hasRole('admin') && config('settings.enable_pricing', true)))
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#menagment">
                            <span class="svg-icon svg-icon-2 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                </svg>
                            </span>
                            {{ __('Organization Management') }}
                        </a>
                    </li>
                @endif
                @if (count($appFields) > 0)
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#apps">
                            <span class="svg-icon svg-icon-2 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="currentColor"></path>
                                    <path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.2 14.9 2.9 14.7L5.2 12.4C5.5 12.2 5.8 12.3 5.9 12.6C6.9 14.8 9.1 16 11.5 16C13.9 16 16.1 14.8 17.1 12.6C17.2 12.4 17.5 12.2 17.7 12.4L20.1 14.7C19.8 14.9 19.4 15 20 15Z" fill="currentColor"></path>
                                </svg>
                            </span>
                            {{ __('Apps') }}
                        </a>
                    </li>
                @endif
                @if (auth()->user()->hasRole('admin') && config('settings.enable_pricing', true)))
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#plan">
                            <span class="svg-icon svg-icon-2 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M18.041 22.041C18.5932 22.041 19.041 21.5932 19.041 21.041C19.041 20.4887 18.5932 20.041 18.041 20.041C17.4887 20.041 17.041 20.4887 17.041 21.041C17.041 21.5932 17.4887 22.041 18.041 22.041Z" fill="currentColor"></path>
                                    <path opacity="0.3" d="M6.04095 22.041C6.59324 22.041 7.04095 21.5932 7.04095 21.041C7.04095 20.4887 6.59324 20.041 6.04095 20.041C5.48867 20.041 5.04095 20.4887 5.04095 21.041C5.04095 21.5932 5.48867 22.041 6.04095 22.041Z" fill="currentColor"></path>
                                    <path opacity="0.3" d="M7.04095 16.041L19.1409 15.041C19.7409 15.041 20.141 14.441 19.841 13.941C19.641 13.541 19.041 13.241 18.441 13.241H6.04095C5.74095 13.241 5.34094 13.541 5.14094 13.941C4.94094 14.441 5.34095 15.041 5.94095 15.041L7.04095 16.041Z" fill="currentColor"></path>
                                    <path opacity="0.3" d="M19.141 11.041L5.94101 12.041C5.34101 12.041 4.94101 11.441 5.24101 10.941C5.44101 10.541 6.04101 10.241 6.64101 10.241H19.041C19.341 10.241 19.741 10.541 19.941 10.941C20.241 11.441 19.741 11.041 19.141 11.041Z" fill="currentColor"></path>
                                    <path d="M6.04095 8.04103L19.1409 7.04103C19.7409 7.04103 20.141 6.44103 19.841 5.94103C19.641 5.54103 19.041 5.24103 18.441 5.24103H6.04095C5.74095 5.24103 5.34094 5.54103 5.14094 5.94103C4.94094 6.44103 5.34095 7.04103 5.94095 7.04103L6.04095 8.04103Z" fill="currentColor"></path>
                                </svg>
                            </span>
                            {{ __('Plans') }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div> --}}
    <!-- End: Tab Navigation -->

    <!-- Begin: Tab Content -->
    <div class="tab-content mt-5">
        <!-- Organization Management Tab -->
        <div class="tab-pane fade show active" id="menagment" role="tabpanel">
            <div class="card card-custom gutter-b">
                {{-- <div class="card-header">
                    <div class="card-toolbar">
                        @if (auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.companies.index') }}" class="btn btn-info">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M9.60001 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13H9.60001V11Z" fill="currentColor"></path>
                                        <path opacity="0.3" d="M9.6 20V4L2.3 11.3C1.9 11.7 1.9 12.3 2.3 12.7L9.6 20Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                {{ __('Back to list') }}
                            </a>
                        @else
                            <a href="{{ route('admin.organizations.manage') }}" class="btn btn-info">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M9.60001 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13H9.60001V11Z" fill="currentColor"></path>
                                        <path opacity="0.3" d="M9.6 20V4L2.3 11.3C1.9 11.7 1.9 12.3 2.3 12.7L9.6 20Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                {{ __('Back to list') }}
                            </a>
                        @endif
                        @if (config('settings.show_company_page', true))
                            <a href="{{ config('settings.wildcard_domain_ready') ? $company->getLinkAttribute() : route('vendor', $company->subdomain) }}" 
                               target="_blank" class="btn btn-success">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor"></path>
                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                {{ __('View it') }}
                            </a>
                        @endif
                    </div>
                </div> --}}
                <div class="card-body">
                    <div class="d-flex align-items-center mb-7">
                        <span class="svg-icon svg-icon-1 me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                            </svg>
                        </span>
                        <h2 class="fw-bolder m-0">{{ __('Organization information') }}</h2>
                    </div>
                    @include('companies.partials.info-org')
                    {{-- <hr />
                    @include('companies.partials.owner') --}}
                </div>
            </div>
        </div>

        <!-- Apps Tab -->
        {{-- @if (count($appFields) > 0)
            <div class="tab-pane fade" id="apps" role="tabpanel">
                <div class="card card-custom gutter-b">
                    @include('companies.partials.apps')
                </div>
            </div>
        @endif

        <!-- Plans Tab -->
        @if (auth()->user()->hasRole('admin') && config('settings.enable_pricing', true))
            <div class="tab-pane fade" id="plan" role="tabpanel">
                <div class="card card-custom gutter-b">
                    @include('companies.partials.plan')
                </div>
            </div>
        @endif --}}
    </div>
    <!-- End: Tab Content -->
@endsection