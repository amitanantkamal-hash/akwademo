@extends('admin.app')

@section('admin_title')
    {{__('Subscriptions')}}
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
                        <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Subscriptions">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="ki-outline ki-filter fs-2"></i>Filter</button>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Content-->
                            <div class="px-7 py-5" data-kt-subscription-table-filter="form">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Month:</label>
                                    <select class="form-select form-select-solid fw-bold select2-hidden-accessible" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-subscription-table-filter="month" data-hide-search="true" data-select2-id="select2-data-7-8fuf" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option data-select2-id="select2-data-9-d1ym"></option>
                                        <option value="jan">January</option>
                                        <option value="feb">February</option>
                                        <option value="mar">March</option>
                                        <option value="apr">April</option>
                                        <option value="may">May</option>
                                        <option value="jun">June</option>
                                        <option value="jul">July</option>
                                        <option value="aug">August</option>
                                        <option value="sep">September</option>
                                        <option value="oct">October</option>
                                        <option value="nov">November</option>
                                        <option value="dec">December</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-8-enxw" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-lgt7-container" aria-controls="select2-lgt7-container"><span class="select2-selection__rendered" id="select2-lgt7-container" role="textbox" aria-readonly="true" title="Select option"><span class="select2-selection__placeholder">Select option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Status:</label>
                                    <select class="form-select form-select-solid fw-bold select2-hidden-accessible" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-subscription-table-filter="status" data-hide-search="true" data-select2-id="select2-data-10-w14g" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option data-select2-id="select2-data-12-4ekf"></option>
                                        <option value="Active">Active</option>
                                        <option value="Expiring">Expiring</option>
                                        <option value="Suspended">Suspended</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-11-97ap" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-55v6-container" aria-controls="select2-55v6-container"><span class="select2-selection__rendered" id="select2-55v6-container" role="textbox" aria-readonly="true" title="Select option"><span class="select2-selection__placeholder">Select option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Billing Method:</label>
                                    <select class="form-select form-select-solid fw-bold select2-hidden-accessible" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-subscription-table-filter="billing" data-hide-search="true" data-select2-id="select2-data-13-7lsn" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option data-select2-id="select2-data-15-gq9m"></option>
                                        <option value="Auto-debit">Auto-debit</option>
                                        <option value="Manual - Credit Card">Manual - Credit Card</option>
                                        <option value="Manual - Cash">Manual - Cash</option>
                                        <option value="Manual - Paypal">Manual - Paypal</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-14-jeo6" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-qes6-container" aria-controls="select2-qes6-container"><span class="select2-selection__rendered" id="select2-qes6-container" role="textbox" aria-readonly="true" title="Select option"><span class="select2-selection__placeholder">Select option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Product:</label>
                                    <select class="form-select form-select-solid fw-bold select2-hidden-accessible" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-subscription-table-filter="product" data-hide-search="true" data-select2-id="select2-data-16-eytf" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option data-select2-id="select2-data-18-tu6o"></option>
                                        <option value="Basic">Basic</option>
                                        <option value="Basic Bundle">Basic Bundle</option>
                                        <option value="Teams">Teams</option>
                                        <option value="Teams Bundle">Teams Bundle</option>
                                        <option value="Enterprise">Enterprise</option>
                                        <option value=" Enterprise Bundle">Enterprise Bundle</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-17-rx8u" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-wdqi-container" aria-controls="select2-wdqi-container"><span class="select2-selection__rendered" id="select2-wdqi-container" role="textbox" aria-readonly="true" title="Select option"><span class="select2-selection__placeholder">Select option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-subscription-table-filter="reset">Reset</button>
                                    <button type="submit" class="btn btn-info fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-subscription-table-filter="filter">Apply</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                        <!--begin::Export-->
                        <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_subscriptions_export_modal">
                        <i class="ki-outline ki-exit-up fs-2"></i>Export</button>
                        <!--end::Export-->
                        <!--begin::Add subscription-->
                        <a href="{{ route('customers.subscription', 1)}}" class="btn btn-info">
                        <i class="ki-outline ki-plus fs-2"></i>Add Subscription</a>
                        <!--end::Add subscription-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-subscription-table-toolbar="selected">
                        <div class="fw-bold me-5">
                        <span class="me-2" data-kt-subscription-table-select="selected_count"></span>Selected</div>
                        <button type="button" class="btn btn-danger" data-kt-subscription-table-select="delete_selected">Delete Selected</button>
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <div id="kt_subscriptions_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_subscriptions_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"><th class="w-10px pe-2 sorting_disabled" rowspan="1" colspan="1" style="width: 29.9px;" aria-label="">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_subscriptions_table .form-check-input" value="1">
                                </div>
                            </th><th class="min-w-125px sorting" tabindex="0" aria-controls="kt_subscriptions_table" rowspan="1" colspan="1" style="width: 227.2px;" aria-label="Customer: activate to sort column ascending">Customer</th><th class="min-w-125px sorting" tabindex="0" aria-controls="kt_subscriptions_table" rowspan="1" colspan="1" style="width: 227.2px;" aria-label="Status: activate to sort column ascending">Status</th><th class="min-w-125px sorting" tabindex="0" aria-controls="kt_subscriptions_table" rowspan="1" colspan="1" style="width: 242.7px;" aria-label="Billing: activate to sort column ascending">Billing</th><th class="min-w-125px sorting" tabindex="0" aria-controls="kt_subscriptions_table" rowspan="1" colspan="1" style="width: 233.183px;" aria-label="Product: activate to sort column ascending">Product</th><th class="min-w-125px sorting" tabindex="0" aria-controls="kt_subscriptions_table" rowspan="1" colspan="1" style="width: 227.2px;" aria-label="Created Date: activate to sort column ascending">Created Date</th><th class="text-end min-w-70px sorting_disabled" rowspan="1" colspan="1" style="width: 175.117px;" aria-label="Actions">Actions</th></tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        <tr class="odd">
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('customers.show', 1)}}" class="text-gray-800 text-hover-primary mb-1">Emma Smith</a>
                            </td>
                            <td>
                                <div class="badge badge-light-success">Active</div>
                            </td>
                            <td>
                                <div class="badge badge-light">Auto-debit</div>
                            </td>
                            <td>Basic</td>
                            <td data-order="2023-01-19T00:00:00-04:00">Aug 19, 2023</td>
                            <td class="text-end">
                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                                <i class="ki-outline ki-down fs-5 m-0"></i></a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="{{ route('customers.subscription', 1)}}" class="menu-link px-3">View</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="{{ route('customers.subscription', 1)}}" class="menu-link px-3">Edit</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" data-kt-subscriptions-table-filter="delete_row" class="menu-link px-3">Delete</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </td>
                        </tr>
                    </tbody>
                </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_subscriptions_table_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_subscriptions_table_previous"><a href="#" aria-controls="kt_subscriptions_table" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_subscriptions_table" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_subscriptions_table" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="kt_subscriptions_table_next"><a href="#" aria-controls="kt_subscriptions_table" data-dt-idx="3" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        <!--begin::Modals-->
        <!--begin::Modal - Adjust Balance-->
        <div class="modal fade" id="kt_subscriptions_export_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Export Subscriptions</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_subscriptions_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <!--begin::Form-->
                        <form id="kt_subscriptions_export_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select data-control="select2" data-placeholder="Select a format" data-hide-search="true" name="format" class="form-select form-select-solid select2-hidden-accessible" data-select2-id="select2-data-19-gkdz" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                    <option value="excell" data-select2-id="select2-data-21-9yjy">Excel</option>
                                    <option value="pdf">PDF</option>
                                    <option value="cvs">CVS</option>
                                    <option value="zip">ZIP</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-20-mcrz" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-format-6h-container" aria-controls="select2-format-6h-container"><span class="select2-selection__rendered" id="select2-format-6h-container" role="textbox" aria-readonly="true" title="Excel">Excel</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold form-label mb-5">Select Date Range:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid flatpickr-input" placeholder="Pick a date" name="date" type="hidden"><input class="form-control form-control-solid form-control input" placeholder="Pick a date" tabindex="0" type="text" readonly="readonly">
                                <!--end::Input-->
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                            <!--end::Input group-->
                            <!--begin::Row-->
                            <div class="row fv-row mb-15">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold form-label mb-5">Payment Type:</label>
                                <!--end::Label-->
                                <!--begin::Radio group-->
                                <div class="d-flex flex-column">
                                    <!--begin::Radio button-->
                                    <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" checked="checked" name="payment_type">
                                        <span class="form-check-label text-gray-600 fw-semibold">All</span>
                                    </label>
                                    <!--end::Radio button-->
                                    <!--begin::Radio button-->
                                    <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" value="2" checked="checked" name="payment_type">
                                        <span class="form-check-label text-gray-600 fw-semibold">Visa</span>
                                    </label>
                                    <!--end::Radio button-->
                                    <!--begin::Radio button-->
                                    <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" value="3" name="payment_type">
                                        <span class="form-check-label text-gray-600 fw-semibold">Mastercard</span>
                                    </label>
                                    <!--end::Radio button-->
                                    <!--begin::Radio button-->
                                    <label class="form-check form-check-custom form-check-sm form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="4" name="payment_type">
                                        <span class="form-check-label text-gray-600 fw-semibold">American Express</span>
                                    </label>
                                    <!--end::Radio button-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Actions-->
                            <div class="text-center">
                                <button type="reset" id="kt_subscriptions_export_cancel" class="btn btn-light me-3">Discard</button>
                                <button type="submit" id="kt_subscriptions_export_submit" class="btn btn-info">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait... 
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - New Card-->
        <!--end::Modals-->
    </div>
    <!--end::Content container-->
@endsection