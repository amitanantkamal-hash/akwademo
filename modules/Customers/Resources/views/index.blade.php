@extends('admin.app')

@section('admin_title')
    {{__('Customers')}}
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
                        <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Customers">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="ki-outline ki-filter fs-2"></i>Filter</button>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-4 text-gray-900 fw-bold">Filter Options</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Content-->
                            <div class="px-7 py-5">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-semibold mb-3">Month:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid fw-bold select2-hidden-accessible" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-customer-table-filter="month" data-dropdown-parent="#kt-toolbar-filter" data-select2-id="select2-data-7-udql" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                        <option data-select2-id="select2-data-9-ug4c"></option>
                                        <option value="aug">August</option>
                                        <option value="sep">September</option>
                                        <option value="oct">October</option>
                                        <option value="nov">November</option>
                                        <option value="dec">December</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-8-4tmo" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-x9ej-container" aria-controls="select2-x9ej-container"><span class="select2-selection__rendered" id="select2-x9ej-container" role="textbox" aria-readonly="true" title="Select option"><span class="select2-selection__placeholder">Select option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-semibold mb-3">Payment Type:</label>
                                    <!--end::Label-->
                                    <!--begin::Options-->
                                    <div class="d-flex flex-column flex-wrap fw-semibold" data-kt-customer-table-filter="payment_type">
                                        <!--begin::Option-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                            <input class="form-check-input" type="radio" name="payment_type" value="all" checked="checked">
                                            <span class="form-check-label text-gray-600">All</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                            <input class="form-check-input" type="radio" name="payment_type" value="visa">
                                            <span class="form-check-label text-gray-600">Visa</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" name="payment_type" value="mastercard">
                                            <span class="form-check-label text-gray-600">Mastercard</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" name="payment_type" value="american_express">
                                            <span class="form-check-label text-gray-600">American Express</span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end::Options-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset</button>
                                    <button type="submit" class="btn btn-info" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter">Apply</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                        <!--begin::Export-->
                        <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
                        <i class="ki-outline ki-exit-up fs-2"></i>Export</button>
                        <!--end::Export-->
                        <!--begin::Add customer-->
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer">Add Customer</button>
                        <!--end::Add customer-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                        <div class="fw-bold me-5">
                        <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div>
                        <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <div id="kt_customers_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_customers_table">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2 sorting_disabled" rowspan="1" colspan="1" style="width: 29.9px;" aria-label="">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" value="1">
                                        </div>
                                    </th>
                                    <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_customers_table" rowspan="1" colspan="1" style="width: 208.133px;" aria-label="Customer Name: activate to sort column ascending">{{__('Customer Name')}}</th>
                                    <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_customers_table" rowspan="1" colspan="1" style="width: 257.267px;" aria-label="Email: activate to sort column ascending">{{__('Email')}}</th>
                                    <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_customers_table" rowspan="1" colspan="1" style="width: 228.783px;" aria-label="Company: activate to sort column ascending">{{__('Company')}}</th>
                                    <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_customers_table" rowspan="1" colspan="1" style="width: 208.133px;" aria-label="Payment Method: activate to sort column ascending">{{__('Payment Method')}}</th>
                                    <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_customers_table" rowspan="1" colspan="1" style="width: 270.067px;" aria-label="Created Date: activate to sort column ascending">{{__('Created Date')}}</th>
                                    <th class="text-end min-w-70px sorting_disabled" rowspan="1" colspan="1" style="width: 160.217px;" aria-label="Actions">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                <tr class="odd">
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1">
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('customers.show', 1) }}" class="text-gray-800 text-hover-primary mb-1">Emma Smith</a>
                                    </td>
                                    <td>
                                        <a href="mailto:smith@kpmg.com" class="text-gray-600 text-hover-primary mb-1">smith@kpmg.com</a>
                                    </td>
                                    <td>-</td>
                                    <td data-filter="mastercard">
                                    <img src="{{ asset('media') }}/svg/card-logos/mastercard.svg" class="w-35px me-3" alt="">**** 8504</td>
                                    <td data-order="2020-12-14T20:43:00-04:00">14 Dec 2020, 8:43 pm</td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                                        <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('customers.show', 1) }}" class="menu-link px-3">View</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-kt-customer-table-filter="delete_row">Delete</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                            <div class="dataTables_length" id="kt_customers_table_length">
                                <label>
                                    <select name="kt_customers_table_length" aria-controls="kt_customers_table" class="form-select form-select-sm form-select-solid">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                            <div class="dataTables_paginate paging_simple_numbers" id="kt_customers_table_paginate">
                                <ul class="pagination">
                                    <li class="paginate_button page-item previous disabled" id="kt_customers_table_previous">
                                    <a href="#" aria-controls="kt_customers_table" data-dt-idx="0" tabindex="0" class="page-link">
                                    <i class="previous">
                                    </i>
                                </a>
                                </li>
                                    <li class="paginate_button page-item active">
                                    <a href="#" aria-controls="kt_customers_table" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                                </li>
                                    <li class="paginate_button page-item ">
                                    <a href="#" aria-controls="kt_customers_table" data-dt-idx="2" tabindex="0" class="page-link">2</a>
                                </li>
                                    <li class="paginate_button page-item ">
                                    <a href="#" aria-controls="kt_customers_table" data-dt-idx="3" tabindex="0" class="page-link">3</a>
                                </li>
                                    <li class="paginate_button page-item ">
                                    <a href="#" aria-controls="kt_customers_table" data-dt-idx="4" tabindex="0" class="page-link">4</a>
                                </li>
                                    <li class="paginate_button page-item next" id="kt_customers_table_next">
                                    <a href="#" aria-controls="kt_customers_table" data-dt-idx="5" tabindex="0" class="page-link">
                                    <i class="next">
                                    </i>
                                </a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        <!--begin::Modals-->
        <!--begin::Modal - Customers - Add-->
        <div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Form-->
                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#" id="kt_modal_add_customer_form" data-kt-redirect="apps/customers/list.html">
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_modal_add_customer_header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">Add a Customer</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                                <i class="ki-outline ki-cross fs-1"></i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body py-10 px-lg-17">
                            <!--begin::Scroll-->
                            <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px" style="max-height: 255px;">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7 fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="Sean Bean">
                                    <!--end::Input-->
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row mb-7 fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="required">Email</span>
                                        <span class="ms-1" data-bs-toggle="tooltip" aria-label="Email address must be active" data-bs-original-title="Email address must be active" data-kt-initialized="1">
                                            <i class="ki-outline ki-information fs-7"></i>
                                        </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="sean@dellito.com" style="background-size: auto, 25px; background-image: none, url(&quot;data:image/svg+xml;utf8,<svg width='26' height='28' viewBox='0 0 26 28' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M23.8958 6.1084L13.7365 0.299712C13.3797 0.103027 12.98 0 12.5739 0C12.1678 0 11.7682 0.103027 11.4113 0.299712L1.21632 6.1084C0.848276 6.31893 0.54181 6.62473 0.328154 6.99462C0.114498 7.36452 0.00129162 7.78529 7.13608e-05 8.21405V19.7951C-0.00323007 20.2248 0.108078 20.6474 0.322199 21.0181C0.53632 21.3888 0.845275 21.6938 1.21632 21.9008L11.3756 27.6732C11.7318 27.8907 12.1404 28.0037 12.556 27.9999C12.9711 27.9989 13.3784 27.8861 13.7365 27.6732L23.8958 21.9008C24.2638 21.6903 24.5703 21.3845 24.7839 21.0146C24.9976 20.6447 25.1108 20.2239 25.112 19.7951V8.21405C25.1225 7.78296 25.0142 7.35746 24.7994 6.98545C24.5845 6.61343 24.2715 6.30969 23.8958 6.1084Z' fill='url(%23paint0_linear_714_179)'/><path d='M5.47328 17.037L4.86515 17.4001C4.75634 17.4613 4.66062 17.5439 4.58357 17.643C4.50652 17.7421 4.4497 17.8558 4.4164 17.9775C4.3831 18.0991 4.374 18.2263 4.38963 18.3516C4.40526 18.4768 4.44531 18.5977 4.50743 18.707C4.58732 18.8586 4.70577 18.9857 4.85046 19.0751C4.99516 19.1645 5.16081 19.2129 5.33019 19.2153C5.49118 19.2139 5.64992 19.1767 5.79522 19.1064L6.40335 18.7434C6.51216 18.6822 6.60789 18.5996 6.68493 18.5004C6.76198 18.4013 6.8188 18.2876 6.8521 18.166C6.8854 18.0443 6.8945 17.9171 6.87887 17.7919C6.86324 17.6666 6.82319 17.5458 6.76107 17.4364C6.70583 17.3211 6.62775 17.2185 6.53171 17.1352C6.43567 17.0518 6.32374 16.9895 6.20289 16.952C6.08205 16.9145 5.95489 16.9027 5.82935 16.9174C5.70382 16.932 5.5826 16.9727 5.47328 17.037ZM9.19357 14.8951L7.94155 15.6212C7.83273 15.6824 7.73701 15.7649 7.65996 15.8641C7.58292 15.9632 7.52609 16.0769 7.49279 16.1986C7.4595 16.3202 7.4504 16.4474 7.46603 16.5726C7.48166 16.6979 7.5217 16.8187 7.58383 16.9281C7.66371 17.0797 7.78216 17.2068 7.92686 17.2962C8.07155 17.3856 8.23721 17.434 8.40658 17.4364C8.56757 17.435 8.72631 17.3978 8.87162 17.3275L10.1236 16.6014C10.2325 16.5402 10.3282 16.4576 10.4052 16.3585C10.4823 16.2594 10.5391 16.1457 10.5724 16.024C10.6057 15.9024 10.6148 15.7752 10.5992 15.6499C10.5835 15.5247 10.5435 15.4038 10.4814 15.2944C10.4261 15.1791 10.348 15.0766 10.252 14.9932C10.156 14.9099 10.044 14.8475 9.92318 14.8101C9.80234 14.7726 9.67518 14.7608 9.54964 14.7754C9.42411 14.7901 9.30289 14.8308 9.19357 14.8951ZM14.2374 13.1198C14.187 13.0168 14.1167 12.9251 14.0307 12.8503C13.9446 12.7754 13.8446 12.7189 13.7366 12.6842V5.38336C13.7371 5.2545 13.7124 5.12682 13.6641 5.00768C13.6157 4.88854 13.5446 4.78029 13.4548 4.68917C13.365 4.59806 13.2583 4.52587 13.1409 4.47678C13.0235 4.42769 12.8977 4.40266 12.7708 4.40314C12.6457 4.40355 12.522 4.42946 12.407 4.47933C12.292 4.52919 12.188 4.602 12.1013 4.69343C12.0145 4.78485 11.9467 4.89304 11.902 5.01156C11.8572 5.13007 11.8364 5.25651 11.8407 5.38336V12.7168C11.7327 12.7516 11.6327 12.8081 11.5466 12.883C11.4606 12.9578 11.3903 13.0495 11.3399 13.1525C11.2727 13.2801 11.2346 13.4213 11.2284 13.5659C11.2222 13.7104 11.2481 13.8545 11.3041 13.9875C11.2481 14.1205 11.2222 14.2646 11.2284 14.4091C11.2346 14.5536 11.2727 14.6949 11.3399 14.8225C11.3903 14.9255 11.4606 15.0172 11.5466 15.092C11.6327 15.1669 11.7327 15.2233 11.8407 15.2581V22.5916C11.8407 22.8516 11.9425 23.1009 12.1236 23.2847C12.3047 23.4686 12.5504 23.5718 12.8065 23.5718C13.0627 23.5718 13.3084 23.4686 13.4895 23.2847C13.6706 23.1009 13.7724 22.8516 13.7724 22.5916V15.2218C13.8804 15.187 13.9804 15.1305 14.0664 15.0557C14.1525 14.9809 14.2228 14.8892 14.2732 14.7862C14.3404 14.6586 14.3785 14.5173 14.3847 14.3728C14.3909 14.2283 14.365 14.0842 14.309 13.9512C14.3917 13.6751 14.3661 13.3772 14.2374 13.1198ZM16.6735 10.6112L15.4215 11.3373C15.3127 11.3985 15.2169 11.481 15.1399 11.5802C15.0628 11.6793 15.006 11.793 14.9727 11.9147C14.9394 12.0363 14.9303 12.1635 14.946 12.2887C14.9616 12.414 15.0016 12.5348 15.0638 12.6442C15.1436 12.7958 15.2621 12.9229 15.4068 13.0123C15.5515 13.1017 15.7171 13.1501 15.8865 13.1525C16.0475 13.1511 16.2062 13.1139 16.3515 13.0436L17.6036 12.3175C17.7124 12.2563 17.8081 12.1737 17.8851 12.0746C17.9622 11.9755 18.019 11.8617 18.0523 11.7401C18.0856 11.6184 18.0947 11.4913 18.0791 11.366C18.0635 11.2408 18.0234 11.1199 17.9613 11.0105C17.906 10.8952 17.828 10.7927 17.7319 10.7093C17.6359 10.626 17.524 10.5636 17.4031 10.5261C17.2823 10.4887 17.1551 10.4769 17.0296 10.4915C16.904 10.5061 16.7828 10.5469 16.6735 10.6112ZM19.639 10.9742C19.8 10.9728 19.9587 10.9357 20.104 10.8653L20.7122 10.5023C20.8208 10.4406 20.9164 10.3578 20.9935 10.2586C21.0705 10.1593 21.1275 10.0456 21.1611 9.92394C21.1947 9.80228 21.2043 9.67508 21.1893 9.54965C21.1744 9.42421 21.1351 9.30302 21.0739 9.19302C21.0126 9.08303 20.9305 8.9864 20.8324 8.90869C20.7342 8.83098 20.6219 8.77372 20.5019 8.7402C20.3818 8.70667 20.2564 8.69755 20.1329 8.71335C20.0094 8.72915 19.8902 8.76957 19.7821 8.83227L19.174 9.19531C19.0651 9.25651 18.9694 9.33909 18.8924 9.43822C18.8153 9.53735 18.7585 9.65106 18.7252 9.77271C18.6919 9.89436 18.6828 10.0215 18.6984 10.1468C18.7141 10.272 18.7541 10.3929 18.8162 10.5023C18.8981 10.6494 19.018 10.7711 19.163 10.8543C19.308 10.9374 19.4725 10.9789 19.639 10.9742ZM20.7122 17.4001L20.104 17.037C19.8859 16.9133 19.6284 16.8823 19.3878 16.9508C19.1472 17.0193 18.9432 17.1816 18.8202 17.4024C18.6973 17.6231 18.6655 17.8843 18.7318 18.1288C18.798 18.3733 18.957 18.5812 19.174 18.707L19.7821 19.0701C19.9274 19.1404 20.0861 19.1776 20.2471 19.179C20.4165 19.1766 20.5821 19.1282 20.7268 19.0388C20.8715 18.9494 20.99 18.8223 21.0699 18.6707C21.1339 18.5648 21.1755 18.4466 21.1921 18.3235C21.2087 18.2003 21.1999 18.0751 21.1662 17.9556C21.1326 17.8361 21.0749 17.7251 20.9967 17.6294C20.9185 17.5338 20.8216 17.4557 20.7122 17.4001ZM17.6 15.6212L16.348 14.8951C16.2399 14.8324 16.1207 14.792 15.9971 14.7762C15.8736 14.7604 15.7482 14.7695 15.6282 14.803C15.5082 14.8365 15.3958 14.8938 15.2977 14.9715C15.1995 15.0492 15.1174 15.1458 15.0562 15.2558C14.9949 15.3658 14.9557 15.487 14.9407 15.6125C14.9257 15.7379 14.9353 15.8651 14.9689 15.9868C15.0026 16.1084 15.0595 16.2221 15.1366 16.3214C15.2136 16.4206 15.3092 16.5035 15.4179 16.5651L16.6699 17.2912C16.8152 17.3615 16.974 17.3987 17.135 17.4001C17.3043 17.3977 17.47 17.3493 17.6147 17.2599C17.7594 17.1705 17.8778 17.0434 17.9577 16.8918C18.0228 16.7862 18.0653 16.6679 18.0825 16.5445C18.0997 16.4212 18.0911 16.2955 18.0574 16.1757C18.0237 16.0559 17.9655 15.9447 17.8867 15.8491C17.8079 15.7536 17.7103 15.6759 17.6 15.6212ZM7.94155 12.2812L9.19357 13.0073C9.33888 13.0776 9.49761 13.1148 9.6586 13.1162C9.82798 13.1138 9.99363 13.0654 10.1383 12.976C10.283 12.8866 10.4015 12.7595 10.4814 12.6079C10.5435 12.4985 10.5835 12.3777 10.5992 12.2524C10.6148 12.1272 10.6057 12 10.5724 11.8784C10.5391 11.7567 10.4823 11.643 10.4052 11.5439C10.3282 11.4447 10.2325 11.3622 10.1236 11.301L8.87162 10.5749C8.76383 10.5118 8.64476 10.4712 8.52134 10.4553C8.39792 10.4395 8.27262 10.4487 8.15275 10.4825C8.03288 10.5163 7.92084 10.574 7.82317 10.6521C7.72549 10.7303 7.64413 10.8275 7.58383 10.9379C7.46399 11.166 7.43428 11.4319 7.50073 11.6814C7.56719 11.9309 7.72481 12.1454 7.94155 12.2812ZM6.40335 9.19531L5.79522 8.83227C5.68714 8.76957 5.56791 8.72915 5.44439 8.71335C5.32087 8.69755 5.19549 8.70667 5.07546 8.7402C4.95542 8.77372 4.8431 8.83098 4.74493 8.90869C4.64676 8.9864 4.56469 9.08303 4.50343 9.19302C4.44217 9.30302 4.40293 9.42421 4.38796 9.54965C4.37299 9.67508 4.38259 9.80228 4.4162 9.92394C4.44981 10.0456 4.50677 10.1593 4.58382 10.2586C4.66087 10.3578 4.75647 10.4406 4.86515 10.5023L5.47328 10.8653C5.61859 10.9357 5.77732 10.9728 5.93831 10.9742C6.10769 10.9718 6.27334 10.9234 6.41804 10.834C6.56273 10.7447 6.68118 10.6176 6.76107 10.466C6.82193 10.3592 6.861 10.2411 6.87592 10.1187C6.89085 9.99635 6.88134 9.87216 6.84796 9.75358C6.81457 9.635 6.758 9.52446 6.68161 9.42854C6.60523 9.33263 6.51059 9.25331 6.40335 9.19531Z' fill='%2320133A'/><defs><linearGradient id='paint0_linear_714_179' x1='7.13608e-05' y1='14.001' x2='25.1156' y2='14.001' gradientUnits='userSpaceOnUse'><stop stop-color='%239059FF'/><stop offset='1' stop-color='%23F770FF'/></linearGradient></defs></svg>&quot;); background-repeat: repeat, no-repeat; background-position: 0% 0%, right calc(50% + 0px); background-origin: padding-box, content-box;">
                                    <!--end::Input-->
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div><button type="button" style="border: 0px; clip: rect(0px, 0px, 0px, 0px); clip-path: inset(50%); height: 1px; margin: 0px -1px -1px 0px; overflow: hidden; padding: 0px; position: absolute; width: 1px; white-space: nowrap;">Generate new mask</button></div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row mb-15">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Description</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="" name="description">
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Billing toggle-->
                                <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_add_customer_billing_info" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">Shipping Information 
                                <span class="ms-2 rotate-180">
                                    <i class="ki-outline ki-down fs-3"></i>
                                </span></div>
                                <!--end::Billing toggle-->
                                <!--begin::Billing form-->
                                <div id="kt_modal_add_customer_billing_info" class="collapse show">
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Address Line 1</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="address1" value="101, Collins Street">
                                        <!--end::Input-->
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Address Line 2</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="address2" value="">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Town</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="city" value="Melbourne">
                                        <!--end::Input-->
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row g-9 mb-7">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-semibold mb-2">State / Province</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" placeholder="" name="state" value="Victoria">
                                            <!--end::Input-->
                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-semibold mb-2">Post Code</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" placeholder="" name="postcode" value="3000">
                                            <!--end::Input-->
                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="required">Country</span>
                                            <span class="ms-1" data-bs-toggle="tooltip" aria-label="Country of origination" data-bs-original-title="Country of origination" data-kt-initialized="1">
                                                <i class="ki-outline ki-information fs-7"></i>
                                            </span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="country" aria-label="Select a Country" data-control="select2" data-placeholder="Select a Country..." data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold select2-hidden-accessible" data-select2-id="select2-data-10-nxje" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                            <option value="">Select a Country...</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AX">Aland Islands</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                            <option value="AR">Argentina</option>
                                            <option value="AM">Armenia</option>
                                            <option value="AW">Aruba</option>
                                            <option value="AU">Australia</option>
                                            <option value="AT">Austria</option>
                                            <option value="AZ">Azerbaijan</option>
                                            <option value="BS">Bahamas</option>
                                            <option value="BH">Bahrain</option>
                                            <option value="BD">Bangladesh</option>
                                            <option value="BB">Barbados</option>
                                            <option value="BY">Belarus</option>
                                            <option value="BE">Belgium</option>
                                            <option value="BZ">Belize</option>
                                            <option value="BJ">Benin</option>
                                            <option value="BM">Bermuda</option>
                                            <option value="BT">Bhutan</option>
                                            <option value="BO">Bolivia, Plurinational State of</option>
                                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                            <option value="BA">Bosnia and Herzegovina</option>
                                            <option value="BW">Botswana</option>
                                            <option value="BR">Brazil</option>
                                            <option value="IO">British Indian Ocean Territory</option>
                                            <option value="BN">Brunei Darussalam</option>
                                            <option value="BG">Bulgaria</option>
                                            <option value="BF">Burkina Faso</option>
                                            <option value="BI">Burundi</option>
                                            <option value="KH">Cambodia</option>
                                            <option value="CM">Cameroon</option>
                                            <option value="CA">Canada</option>
                                            <option value="CV">Cape Verde</option>
                                            <option value="KY">Cayman Islands</option>
                                            <option value="CF">Central African Republic</option>
                                            <option value="TD">Chad</option>
                                            <option value="CL">Chile</option>
                                            <option value="CN">China</option>
                                            <option value="CX">Christmas Island</option>
                                            <option value="CC">Cocos (Keeling) Islands</option>
                                            <option value="CO">Colombia</option>
                                            <option value="KM">Comoros</option>
                                            <option value="CK">Cook Islands</option>
                                            <option value="CR">Costa Rica</option>
                                            <option value="CI">Côte d'Ivoire</option>
                                            <option value="HR">Croatia</option>
                                            <option value="CU">Cuba</option>
                                            <option value="CW">Curaçao</option>
                                            <option value="CZ">Czech Republic</option>
                                            <option value="DK">Denmark</option>
                                            <option value="DJ">Djibouti</option>
                                            <option value="DM">Dominica</option>
                                            <option value="DO">Dominican Republic</option>
                                            <option value="EC">Ecuador</option>
                                            <option value="EG">Egypt</option>
                                            <option value="SV">El Salvador</option>
                                            <option value="GQ">Equatorial Guinea</option>
                                            <option value="ER">Eritrea</option>
                                            <option value="EE">Estonia</option>
                                            <option value="ET">Ethiopia</option>
                                            <option value="FK">Falkland Islands (Malvinas)</option>
                                            <option value="FJ">Fiji</option>
                                            <option value="FI">Finland</option>
                                            <option value="FR">France</option>
                                            <option value="PF">French Polynesia</option>
                                            <option value="GA">Gabon</option>
                                            <option value="GM">Gambia</option>
                                            <option value="GE">Georgia</option>
                                            <option value="DE">Germany</option>
                                            <option value="GH">Ghana</option>
                                            <option value="GI">Gibraltar</option>
                                            <option value="GR">Greece</option>
                                            <option value="GL">Greenland</option>
                                            <option value="GD">Grenada</option>
                                            <option value="GU">Guam</option>
                                            <option value="GT">Guatemala</option>
                                            <option value="GG">Guernsey</option>
                                            <option value="GN">Guinea</option>
                                            <option value="GW">Guinea-Bissau</option>
                                            <option value="HT">Haiti</option>
                                            <option value="VA">Holy See (Vatican City State)</option>
                                            <option value="HN">Honduras</option>
                                            <option value="HK">Hong Kong</option>
                                            <option value="HU">Hungary</option>
                                            <option value="IS">Iceland</option>
                                            <option value="IN">India</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="IR">Iran, Islamic Republic of</option>
                                            <option value="IQ">Iraq</option>
                                            <option value="IE">Ireland</option>
                                            <option value="IM">Isle of Man</option>
                                            <option value="IL">Israel</option>
                                            <option value="IT">Italy</option>
                                            <option value="JM">Jamaica</option>
                                            <option value="JP">Japan</option>
                                            <option value="JE">Jersey</option>
                                            <option value="JO">Jordan</option>
                                            <option value="KZ">Kazakhstan</option>
                                            <option value="KE">Kenya</option>
                                            <option value="KI">Kiribati</option>
                                            <option value="KP">Korea, Democratic People's Republic of</option>
                                            <option value="KW">Kuwait</option>
                                            <option value="KG">Kyrgyzstan</option>
                                            <option value="LA">Lao People's Democratic Republic</option>
                                            <option value="LV">Latvia</option>
                                            <option value="LB">Lebanon</option>
                                            <option value="LS">Lesotho</option>
                                            <option value="LR">Liberia</option>
                                            <option value="LY">Libya</option>
                                            <option value="LI">Liechtenstein</option>
                                            <option value="LT">Lithuania</option>
                                            <option value="LU">Luxembourg</option>
                                            <option value="MO">Macao</option>
                                            <option value="MG">Madagascar</option>
                                            <option value="MW">Malawi</option>
                                            <option value="MY">Malaysia</option>
                                            <option value="MV">Maldives</option>
                                            <option value="ML">Mali</option>
                                            <option value="MT">Malta</option>
                                            <option value="MH">Marshall Islands</option>
                                            <option value="MQ">Martinique</option>
                                            <option value="MR">Mauritania</option>
                                            <option value="MU">Mauritius</option>
                                            <option value="MX">Mexico</option>
                                            <option value="FM">Micronesia, Federated States of</option>
                                            <option value="MD">Moldova, Republic of</option>
                                            <option value="MC">Monaco</option>
                                            <option value="MN">Mongolia</option>
                                            <option value="ME">Montenegro</option>
                                            <option value="MS">Montserrat</option>
                                            <option value="MA">Morocco</option>
                                            <option value="MZ">Mozambique</option>
                                            <option value="MM">Myanmar</option>
                                            <option value="NA">Namibia</option>
                                            <option value="NR">Nauru</option>
                                            <option value="NP">Nepal</option>
                                            <option value="NL">Netherlands</option>
                                            <option value="NZ">New Zealand</option>
                                            <option value="NI">Nicaragua</option>
                                            <option value="NE">Niger</option>
                                            <option value="NG">Nigeria</option>
                                            <option value="NU">Niue</option>
                                            <option value="NF">Norfolk Island</option>
                                            <option value="MP">Northern Mariana Islands</option>
                                            <option value="NO">Norway</option>
                                            <option value="OM">Oman</option>
                                            <option value="PK">Pakistan</option>
                                            <option value="PW">Palau</option>
                                            <option value="PS">Palestinian Territory, Occupied</option>
                                            <option value="PA">Panama</option>
                                            <option value="PG">Papua New Guinea</option>
                                            <option value="PY">Paraguay</option>
                                            <option value="PE">Peru</option>
                                            <option value="PH">Philippines</option>
                                            <option value="PL">Poland</option>
                                            <option value="PT">Portugal</option>
                                            <option value="PR">Puerto Rico</option>
                                            <option value="QA">Qatar</option>
                                            <option value="RO">Romania</option>
                                            <option value="RU">Russian Federation</option>
                                            <option value="RW">Rwanda</option>
                                            <option value="BL">Saint Barthélemy</option>
                                            <option value="KN">Saint Kitts and Nevis</option>
                                            <option value="LC">Saint Lucia</option>
                                            <option value="MF">Saint Martin (French part)</option>
                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                            <option value="WS">Samoa</option>
                                            <option value="SM">San Marino</option>
                                            <option value="ST">Sao Tome and Principe</option>
                                            <option value="SA">Saudi Arabia</option>
                                            <option value="SN">Senegal</option>
                                            <option value="RS">Serbia</option>
                                            <option value="SC">Seychelles</option>
                                            <option value="SL">Sierra Leone</option>
                                            <option value="SG">Singapore</option>
                                            <option value="SX">Sint Maarten (Dutch part)</option>
                                            <option value="SK">Slovakia</option>
                                            <option value="SI">Slovenia</option>
                                            <option value="SB">Solomon Islands</option>
                                            <option value="SO">Somalia</option>
                                            <option value="ZA">South Africa</option>
                                            <option value="KR">South Korea</option>
                                            <option value="SS">South Sudan</option>
                                            <option value="ES">Spain</option>
                                            <option value="LK">Sri Lanka</option>
                                            <option value="SD">Sudan</option>
                                            <option value="SR">Suriname</option>
                                            <option value="SZ">Swaziland</option>
                                            <option value="SE">Sweden</option>
                                            <option value="CH">Switzerland</option>
                                            <option value="SY">Syrian Arab Republic</option>
                                            <option value="TW">Taiwan, Province of China</option>
                                            <option value="TJ">Tajikistan</option>
                                            <option value="TZ">Tanzania, United Republic of</option>
                                            <option value="TH">Thailand</option>
                                            <option value="TG">Togo</option>
                                            <option value="TK">Tokelau</option>
                                            <option value="TO">Tonga</option>
                                            <option value="TT">Trinidad and Tobago</option>
                                            <option value="TN">Tunisia</option>
                                            <option value="TR">Turkey</option>
                                            <option value="TM">Turkmenistan</option>
                                            <option value="TC">Turks and Caicos Islands</option>
                                            <option value="TV">Tuvalu</option>
                                            <option value="UG">Uganda</option>
                                            <option value="UA">Ukraine</option>
                                            <option value="AE">United Arab Emirates</option>
                                            <option value="GB">United Kingdom</option>
                                            <option value="US" selected="selected" data-select2-id="select2-data-12-eyui">United States</option>
                                            <option value="UY">Uruguay</option>
                                            <option value="UZ">Uzbekistan</option>
                                            <option value="VU">Vanuatu</option>
                                            <option value="VE">Venezuela, Bolivarian Republic of</option>
                                            <option value="VN">Vietnam</option>
                                            <option value="VI">Virgin Islands</option>
                                            <option value="YE">Yemen</option>
                                            <option value="ZM">Zambia</option>
                                            <option value="ZW">Zimbabwe</option>
                                        </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-11-vxmg" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-country-vd-container" aria-controls="select2-country-vd-container"><span class="select2-selection__rendered" id="select2-country-vd-container" role="textbox" aria-readonly="true" title="United States">United States</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                        <!--end::Input-->
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack">
                                            <!--begin::Label-->
                                            <div class="me-5">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold">Use as a billing adderess?</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="fs-7 fw-semibold text-muted">If you need more info, please check budget planning</div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <!--begin::Input-->
                                                <input class="form-check-input" name="billing" type="checkbox" value="1" id="kt_modal_add_customer_billing" checked="checked">
                                                <!--end::Input-->
                                                <!--begin::Label-->
                                                <span class="form-check-label fw-semibold text-muted" for="kt_modal_add_customer_billing">Yes</span>
                                                <!--end::Label-->
                                            </label>
                                            <!--end::Switch-->
                                        </div>
                                        <!--begin::Wrapper-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Billing form-->
                            </div>
                            <!--end::Scroll-->
                        </div>
                        <!--end::Modal body-->
                        <!--begin::Modal footer-->
                        <div class="modal-footer flex-center">
                            <!--begin::Button-->
                            <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3">Discard</button>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-info">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                        <!--end::Modal footer-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <!--end::Modal - Customers - Add-->
        <!--begin::Modal - Adjust Balance-->
        <div class="modal fade" id="kt_customers_export_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Export Customers</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_customers_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <!--begin::Form-->
                        <form id="kt_customers_export_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select data-control="select2" data-placeholder="Select a format" data-hide-search="true" name="format" class="form-select form-select-solid select2-hidden-accessible" data-select2-id="select2-data-13-rvpd" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                    <option value="excell" data-select2-id="select2-data-15-morb">Excel</option>
                                    <option value="pdf">PDF</option>
                                    <option value="cvs">CVS</option>
                                    <option value="zip">ZIP</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-14-94p4" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-format-op-container" aria-controls="select2-format-op-container"><span class="select2-selection__rendered" id="select2-format-op-container" role="textbox" aria-readonly="true" title="Excel">Excel</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
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
                                <button type="reset" id="kt_customers_export_cancel" class="btn btn-light me-3">Discard</button>
                                <button type="submit" id="kt_customers_export_submit" class="btn btn-info">
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
