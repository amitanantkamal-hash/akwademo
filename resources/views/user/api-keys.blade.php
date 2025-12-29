@extends('layouts.app')
@section('admin_title')
    {{__('Manage API Keys')}}
@endsection
@section('content')
<div class="card mb-5 mb-xxl-10">
    <!--begin::Header-->
    <div class="card-header">   
        <!--begin::Title-->
        <div class="card-title">
            <h3>API Overview</h3>
        </div>
        <!--end::Title-->

        <!--begin::Toolbar-->
        <div class="card-toolbar">
            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" checked="checked" value="1">
                <span class="form-check-label text-muted">
                    Test mode
                </span>
            </label>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body py-10">
        <!--begin::Row-->
        <div class="row mb-10">
            <!--begin::Col-->
            <div class="col-md-6 pb-10 pb-lg-0">
                <h2>How to set API</h2>

                <p class="fs-6 fw-semibold text-gray-600 py-2">
                    Use images to enhance your post, improve its flow, add humor <br> and explain complex topics
                </p>

                <a href="#" class="btn btn-light btn-active-light-primary keychainify-checked">Get Started</a>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-md-6">
                <h2>Developer Tools</h2>

                <p class="fs-6 fw-semibold text-gray-600 py-2">
                    Plan your blog post by choosing a topic, creating an outline conduct <br> research, and checking facts
                </p>

                <a href="#" class="btn btn-light btn-active-light-primary keychainify-checked">Create Rule</a>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

        <!--begin::Notice-->
        
<!--begin::Notice-->
<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed  p-6">
            <!--begin::Icon-->
        <i class="ki-outline ki-design-1 fs-2tx text-primary me-4"></i>        <!--end::Icon-->
    
    <!--begin::Wrapper-->
    <div class="d-flex flex-stack flex-grow-1 ">
                    <!--begin::Content-->
            <div class=" fw-semibold">
                
                                    <div class="fs-6 text-gray-700 ">Two-factor authentication adds an extra layer of security to your account. 
                            To log in, in you'll need to provide a 4 digit amazing and create outstanding products to serve your clients <a class="fw-bold keychainify-checked" href="#">Learn More</a>.</div>
                            </div>
            <!--end::Content-->
        
            </div>
    <!--end::Wrapper-->  
</div>
<!--end::Notice-->
        <!--end::Notice-->
    </div>
    <!--end::Body-->
</div>

<div class="card ">
    <!--begin::Header-->
    <div class="card-header card-header-stretch">
        <!--begin::Title-->
        <div class="card-title">
            <h3>API Keys</h3>
        </div>
        <!--end::Title-->
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body p-0">
        <!--begin::Table wrapper-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9" id="kt_api_keys_table">
                <!--begin::Thead-->
                <thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
                    <tr>
                        <th class="min-w-175px ps-9">Label</th>
                        <th class="min-w-250px px-0">API Keys</th>                        
                        <th class="min-w-100px">Created</th>
                        <th class="min-w-100px">Status</th>
                        <th class="w-100px"></th>
                        <th class="w-100px"></th>
                    </tr>
                </thead>
                <!--end::Thead-->

                <!--begin::Tbody-->
                <tbody class="fs-6 fw-semibold text-gray-600">
                                            <tr>
                            <td class="ps-9">
                                none set                            </td>

                            <td data-bs-target="license" class="ps-0">
                                fftt456765gjkkjhi83093985                            </td>
                            
                            <td>
                                <button data-action="copy" class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                    <i class="ki-outline ki-copy fs-2"></i>                                </button>
                            </td>
                            
                            <td>
                                Nov 01, 2020                            </td>
                            
                            <td>
                                <span class="badge badge-light-success fs-7 fw-semibold">Active</span>
                            </td>
                            
                            <td class="pe-9">  
                                <div class="w-100px position-relative">
                                    <select class="form-select form-select-sm form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Options" data-hide-search="true" data-select2-id="select2-data-10-5hb3" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option value="" data-select2-id="select2-data-12-a145"></option>
                                        <option value="2">Options 1</option>
                                        <option value="3">Options 2</option>
                                        <option value="4">Options 3</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-11-5f0x" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-sm form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-6w9n-container" aria-controls="select2-6w9n-container"><span class="select2-selection__rendered" id="select2-6w9n-container" role="textbox" aria-readonly="true" title="Options"><span class="select2-selection__placeholder">Options</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>    
                                </div>                        
                            </td>

                            <td>
                                <button data-action="copy" class="btn btn-color-gray-500 btn-active-color-primary btn-icon btn-sm btn-outline-light">
                                    <i class="ki-solid ki-copy fs-2"></i>                                </button>
                            </td>
                        </tr>
                                            <tr>
                            <td class="ps-9">
                                Navitare                            </td>

                            <td data-bs-target="license" class="ps-0">
                                jk076590ygghgh324vd33                            </td>
                            
                            <td>
                                <button data-action="copy" class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                    <i class="ki-outline ki-copy fs-2"></i>                                </button>
                            </td>
                            
                            <td>
                                Sep 27, 2020                            </td>
                            
                            <td>
                                <span class="badge badge-light-info fs-7 fw-semibold">Review</span>
                            </td>
                            
                            <td class="pe-9">  
                                <div class="w-100px position-relative">
                                    <select class="form-select form-select-sm form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Options" data-hide-search="true" data-select2-id="select2-data-13-9aj1" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option value="" data-select2-id="select2-data-15-x5su"></option>
                                        <option value="2">Options 1</option>
                                        <option value="3">Options 2</option>
                                        <option value="4">Options 3</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-14-cl2v" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-sm form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-g2l5-container" aria-controls="select2-g2l5-container"><span class="select2-selection__rendered" id="select2-g2l5-container" role="textbox" aria-readonly="true" title="Options"><span class="select2-selection__placeholder">Options</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>    
                                </div>                        
                            </td>

                            <td>
                                <button data-action="copy" class="btn btn-color-gray-500 btn-active-color-primary btn-icon btn-sm btn-outline-light">
                                    <i class="ki-solid ki-copy fs-2"></i>                                </button>
                            </td>
                        </tr>
                                            <tr>
                            <td class="ps-9">
                                Docs API Key                            </td>

                            <td data-bs-target="license" class="ps-0">
                                fftt456765gjkkjhi83093985                            </td>
                            
                            <td>
                                <button data-action="copy" class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                    <i class="ki-outline ki-copy fs-2"></i>                                </button>
                            </td>
                            
                            <td>
                                Jul 09, 2020                            </td>
                            
                            <td>
                                <span class="badge badge-light-danger fs-7 fw-semibold">Inactive</span>
                            </td>
                            
                            <td class="pe-9">  
                                <div class="w-100px position-relative">
                                    <select class="form-select form-select-sm form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Options" data-hide-search="true" data-select2-id="select2-data-16-2goc" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option value="" data-select2-id="select2-data-18-zc5a"></option>
                                        <option value="2">Options 1</option>
                                        <option value="3">Options 2</option>
                                        <option value="4">Options 3</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-17-o95t" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-sm form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-mcd7-container" aria-controls="select2-mcd7-container"><span class="select2-selection__rendered" id="select2-mcd7-container" role="textbox" aria-readonly="true" title="Options"><span class="select2-selection__placeholder">Options</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>    
                                </div>                        
                            </td>

                            <td>
                                <button data-action="copy" class="btn btn-color-gray-500 btn-active-color-primary btn-icon btn-sm btn-outline-light">
                                    <i class="ki-solid ki-copy fs-2"></i>                                </button>
                            </td>
                        </tr>
                                            <tr>
                            <td class="ps-9">
                                Identity Key                            </td>

                            <td data-bs-target="license" class="ps-0">
                                jk076590ygghgh324vd3568                            </td>
                            
                            <td>
                                <button data-action="copy" class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                    <i class="ki-outline ki-copy fs-2"></i>                                </button>
                            </td>
                            
                            <td>
                                May 14, 2020                            </td>
                            
                            <td>
                                <span class="badge badge-light-success fs-7 fw-semibold">Active</span>
                            </td>
                            
                            <td class="pe-9">  
                                <div class="w-100px position-relative">
                                    <select class="form-select form-select-sm form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Options" data-hide-search="true" data-select2-id="select2-data-19-bhhz" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option value="" data-select2-id="select2-data-21-95b7"></option>
                                        <option value="2">Options 1</option>
                                        <option value="3">Options 2</option>
                                        <option value="4">Options 3</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-20-v656" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-sm form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-6mkr-container" aria-controls="select2-6mkr-container"><span class="select2-selection__rendered" id="select2-6mkr-container" role="textbox" aria-readonly="true" title="Options"><span class="select2-selection__placeholder">Options</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>    
                                </div>                        
                            </td>

                            <td>
                                <button data-action="copy" class="btn btn-color-gray-500 btn-active-color-primary btn-icon btn-sm btn-outline-light">
                                    <i class="ki-solid ki-copy fs-2"></i>                                </button>
                            </td>
                        </tr>
                                            <tr>
                            <td class="ps-9">
                                Remore Interface                            </td>

                            <td data-bs-target="license" class="ps-0">
                                hhet6454788gfg555hhh4                            </td>
                            
                            <td>
                                <button data-action="copy" class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                    <i class="ki-outline ki-copy fs-2"></i>                                </button>
                            </td>
                            
                            <td>
                                Dec 30, 2019                            </td>
                            
                            <td>
                                <span class="badge badge-light-success fs-7 fw-semibold">Active</span>
                            </td>
                            
                            <td class="pe-9">  
                                <div class="w-100px position-relative">
                                    <select class="form-select form-select-sm form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Options" data-hide-search="true" data-select2-id="select2-data-22-8vxw" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option value="" data-select2-id="select2-data-24-1ctm"></option>
                                        <option value="2">Options 1</option>
                                        <option value="3">Options 2</option>
                                        <option value="4">Options 3</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-23-m8wh" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-sm form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-z0jf-container" aria-controls="select2-z0jf-container"><span class="select2-selection__rendered" id="select2-z0jf-container" role="textbox" aria-readonly="true" title="Options"><span class="select2-selection__placeholder">Options</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>    
                                </div>                        
                            </td>

                            <td>
                                <button data-action="copy" class="btn btn-color-gray-500 btn-active-color-primary btn-icon btn-sm btn-outline-light">
                                    <i class="ki-solid ki-copy fs-2"></i>                                </button>
                            </td>
                        </tr>
                                            <tr>
                            <td class="ps-9">
                                none set                            </td>

                            <td data-bs-target="license" class="ps-0">
                                fftt456765gjkkjhi83093985                            </td>
                            
                            <td>
                                <button data-action="copy" class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                    <i class="ki-outline ki-copy fs-2"></i>                                </button>
                            </td>
                            
                            <td>
                                Inactive                            </td>
                            
                            <td>
                                <span class="badge badge-light-danger fs-7 fw-semibold">Active</span>
                            </td>
                            
                            <td class="pe-9">  
                                <div class="w-100px position-relative">
                                    <select class="form-select form-select-sm form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Options" data-hide-search="true" data-select2-id="select2-data-25-dvu4" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option value="" data-select2-id="select2-data-27-g7vv"></option>
                                        <option value="2">Options 1</option>
                                        <option value="3">Options 2</option>
                                        <option value="4">Options 3</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-26-6in6" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-sm form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-wiur-container" aria-controls="select2-wiur-container"><span class="select2-selection__rendered" id="select2-wiur-container" role="textbox" aria-readonly="true" title="Options"><span class="select2-selection__placeholder">Options</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>    
                                </div>                        
                            </td>

                            <td>
                                <button data-action="copy" class="btn btn-color-gray-500 btn-active-color-primary btn-icon btn-sm btn-outline-light">
                                    <i class="ki-solid ki-copy fs-2"></i>                                </button>
                            </td>
                        </tr>
                                            <tr>
                            <td class="ps-9">
                                Test App                            </td>

                            <td data-bs-target="license" class="ps-0">
                                jk076590ygghgh324vd33                            </td>
                            
                            <td>
                                <button data-action="copy" class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                    <i class="ki-outline ki-copy fs-2"></i>                                </button>
                            </td>
                            
                            <td>
                                Apr 03, 2019                            </td>
                            
                            <td>
                                <span class="badge badge-light-success fs-7 fw-semibold">Active</span>
                            </td>
                            
                            <td class="pe-9">  
                                <div class="w-100px position-relative">
                                    <select class="form-select form-select-sm form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Options" data-hide-search="true" data-select2-id="select2-data-28-znqp" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option value="" data-select2-id="select2-data-30-psqv"></option>
                                        <option value="2">Options 1</option>
                                        <option value="3">Options 2</option>
                                        <option value="4">Options 3</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-29-pv08" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-sm form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-yetr-container" aria-controls="select2-yetr-container"><span class="select2-selection__rendered" id="select2-yetr-container" role="textbox" aria-readonly="true" title="Options"><span class="select2-selection__placeholder">Options</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>    
                                </div>                        
                            </td>

                            <td>
                                <button data-action="copy" class="btn btn-color-gray-500 btn-active-color-primary btn-icon btn-sm btn-outline-light">
                                    <i class="ki-solid ki-copy fs-2"></i>                                </button>
                            </td>
                        </tr>
                                          
                </tbody>
                <!--end::Tbody-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Table wrapper-->
    </div>
    <!--end::Body-->
</div>
@endsection