@extends('layouts.app', ['title' => __('Organization')])
@section('admin_title')
    {{ $company->name }}
@endsection
@section('head')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('content')
    <div class="header pb-6 pt-5 pt-md-8">
        <div class="container-fluid">


            <div class="nav-wrapper">
                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">

                    {{-- <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab"
                            href="#menagment" role="tab" aria-controls="menagment" aria-selected="true"><i
                                class="ni ni-badge mr-2"></i>{{ __('Organization Management') }}</a>
                    </li> --}}
                    @if (count($appFields) > 0 || (auth()->user()->hasRole('admin') && config('settings.enable_pricing', true)))
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab"
                                href="#menagment" role="tab" aria-controls="menagment" aria-selected="true"><i
                                    class="ni ni-badge mr-2"></i>{{ __('Organization Management') }}</a>
                        </li>
                    @endif
                    @if (count($appFields) > 0)
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-apps" data-toggle="tab" href="#apps"
                                role="tab" aria-controls="apps" aria-selected="falae"><i
                                    class="ni ni-spaceship mr-2"></i>{{ __('Apps') }}</a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('admin') && config('settings.enable_pricing', true))
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-menagment-plan" data-toggle="tab" href="#plan"
                                role="tab" aria-controls="plan" aria-selected="false"><i
                                    class="ni ni-money-coins mr-2"></i>{{ __('Plans') }}</a>
                        </li>
                    @endif

                    @if (isset($companyConfig))
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-whatsappconfig" data-toggle="tab"
                                href="#whatsappconfig" role="tab" aria-controls="whatsappconfig"
                                aria-selected="falae"><i class="ni ni-spaceship mr-2"></i>{{ __('WhatsApp Config') }}</a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
    </div>



    <div class="container-fluid mt--7">




        <div class="row">
            <div class="col-12">
                <br />

                @include('partials.flash')

                <div class="tab-content" id="tabs">


                    <!-- Tab Managment -->
                    <div class="tab-pane fade show active" id="menagment" role="tabpanel" aria-labelledby="menagment">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Company Management') }}</h3>
                                        @if (config('settings.wildcard_domain_ready'))
                                            <span class="blockquote-footer">{{ $company->getLinkAttribute() }}</span>
                                        @endif
                                    </div>
                                    <div class="col-4 text-right">

                                        @if (auth()->user()->hasRole('admin'))
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger remove-no-use-data"
                                                data-url="{{ route('admin.companies.remove.no.use.data', ['company_id' => $company->id]) }}">
                                                <i class="ni ni-fat-remove"></i> Remove no-use data
                                            </a>
                                            <span class="loader" id="remove-no-use-data-loader" style="display: none;">
                                                <i class="fa fa-spinner fa-spin"></i> Processing...
                                            </span>

                                                <a href="{{ route('admin.companies.index') }}"
                                                    class="btn btn-sm btn-info">{{ __('Back to list') }}</a>
                                            @endif
                                            @if (config('settings.show_company_page', true))
                                                @if (config('settings.wildcard_domain_ready'))
                                                    <a target="_blank" href="{{ $company->getLinkAttribute() }}"
                                                        class="btn btn-sm btn-success">{{ __('View it') }}</a>
                                                @else
                                                    <a target="_blank" href="{{ route('vendor', $company->subdomain) }}"
                                                        class="btn btn-sm btn-success">{{ __('View it') }}</a>
                                                @endif
                                            @endif
                                            @if ($hasCloner)
                                                <a href="{{ route('admin.companies.create') . '?cloneWith=' . $company->id }}"
                                                    class="btn btn-sm btn-warning text-white">{{ __('Clone it') }}</a>
                                            @endif
                                            <a class="btn btn-sm btn-success text-white"
                                                href="{{ route('admin.companies.loginas', $company) }}">{{ __('Login as') }}</a>


                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="heading-small text-muted mb-4">{{ __('Company information') }}</h6>

                                @include('companies.partials.info')
                                <hr />
                                @include('companies.partials.owner')
                            </div>
                        </div>
                    </div>

                    <!-- Tab Apps -->
                    @if (count($appFields) > 0)
                        <div class="tab-pane fade show" id="apps" role="tabpanel" aria-labelledby="apps">
                            @include('companies.partials.apps')
                        </div>
                    @endif




                    <!-- Tab Plans -->
                    @if (auth()->user()->hasRole('admin') && config('settings.enable_pricing', true))
                        <div class="tab-pane fade show" id="plan" role="tabpanel" aria-labelledby="plan">
                            @include('companies.partials.plan')
                        </div>
                    @endif


                    @if (isset($companyConfig))
                        <div class="tab-pane fade show" id="whatsappconfig" role="tabpanel"
                            aria-labelledby="whatsappconfig">
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                    <h5 class="h3 mb-0">{{ __('WhatApp Config') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">

                                            @include('partials.fields', [
                                                'fields' => [
                                                    [
                                                        'ftype' => 'input',
                                                        'name' => 'WhatsApp Permenent Token',
                                                        'id' => 'whatsapp_permanent_access_token',
                                                        'placeholder' => 'N/A',
                                                        'required' => true,
                                                        'value' =>
                                                            $companyConfig['whatsapp_permanent_access_token'] ??
                                                            '',
                                                        'readonly' => true,
                                                    ],
                                                    [
                                                        'ftype' => 'input',
                                                        'name' => 'WhatsApp Phone ID',
                                                        'id' => 'whatsapp_phone_number_id',
                                                        'placeholder' => 'N/A',
                                                        'required' => true,
                                                        'value' =>
                                                            $companyConfig['whatsapp_phone_number_id'] ?? '',
                                                        'readonly' => true,
                                                    ],
                                                    [
                                                        'ftype' => 'input',
                                                        'name' => 'WhatsApp business id',
                                                        'id' => 'whatsapp_business_account_id',
                                                        'placeholder' => 'N/A',
                                                        'required' => true,
                                                        'value' =>
                                                            $companyConfig['whatsapp_business_account_id'] ?? '',
                                                        'readonly' => true,
                                                    ],
                                            
                                                    [
                                                        'ftype' => 'input',
                                                        'name' => 'WhatsApp Number',
                                                        'id' => 'address',
                                                        'placeholder' => 'N/A',
                                                        'required' => true,
                                                        'value' => $companyConfig['display_phone_number'] ?? '',
                                                        'readonly' => true,
                                                    ],
                                            
                                                    [
                                                        'ftype' => 'input',
                                                        'name' => 'Verified Name',
                                                        'id' => 'verified_name',
                                                        'placeholder' => 'N/A',
                                                        'required' => true,
                                                        'value' => $companyConfig['verified_name'] ?? '',
                                                        'readonly' => true,
                                                    ],
                                                ],
                                            ])

                                            <div class="text-center">
                                            </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
@section('topjs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $(".remove-no-use-data").click(function() {
            let url = $(this).data("url");
            let button = $(this);
            let loader = $("#remove-no-use-data-loader");

            Swal.fire({
                title: "Are you sure?",
                text: "This will permanently delete unused data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    button.hide();
                    loader.show();

                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(response) {
                            Swal.fire("Deleted!", response.message, "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire("Error", xhr.responseText, "error");
                        },
                        complete: function() {
                            button.show();
                            loader.hide();
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
