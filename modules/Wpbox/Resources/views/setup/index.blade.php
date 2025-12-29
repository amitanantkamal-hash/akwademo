@extends('layouts.app-client', ['title' => __('Whatsapp Setup')]) {{-- Assuming you have a Metronic layout --}}

@section('content')
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Header-->
        <div class="d-flex align-items-center justify-content-between mb-7">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                <i class="ki-duotone ki-whatsapp fs-2 text-success me-3">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                {{ __('WhatsApp Cloud API Setup') }}
            </h1>
        </div>
        <!--end::Header-->

        <!--begin::Card-->
        <div class="card">
            <div class="card-body">
                @include('partials.flash') {{-- Make sure this is compatible with Metronic alerts --}}

                <form method="POST" action="{{ route('whatsapp.store') }}" class="form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-7">
                            @include('wpbox::setup.step1')
                            @include('wpbox::setup.step2')
                            @include('wpbox::setup.step3')
                        </div>
                        <div class="col-lg-4 col-md-5">
                            @include('wpbox::setup.verified')
                            @include('wpbox::info_verified')
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
@endsection