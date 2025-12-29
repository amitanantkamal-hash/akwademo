@extends('admin.app')

@section('admin_title')
    {{__('Integrations Marketplace')}}
@endsection

@section('content')
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="mt-8 container-fluid">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Integrations">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-8">
                <div class="my-8 text-center w-75 w-lg-50 w-xl-25 mx-auto">
                    <img src="{{ asset('media') }}/illustrations/sigma-1/21.png" class="w-100" alt="">
                    <h4 class="text-center">{{__('We have no integrations available yet.')}}</h4>
                    <h5 class="text-muted text-center">{{__('Stay tuned, they\'re comming soon!')}}</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
