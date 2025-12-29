@extends('admin.app')

@section('admin_title')
    {{__('Customer Details')}}
@endsection

@section('content')
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="mt-8 container-fluid px-4">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card body-->
                    <div class="card-body pt-15">
                        <!--begin::Summary-->
                        <div class="d-flex flex-center flex-column mb-5">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-100px symbol-circle mb-7">
                                <img src="{{ asset('media') }}/avatars/300-1.jpg" alt="image">
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Name-->
                            <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">Max Smith</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="fs-5 fw-semibold text-muted mb-6">Software Enginer</div>
                            <!--end::Position-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap flex-center">
                                <!--begin::Stats-->
                                <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                    <div class="fs-4 fw-bold text-gray-700">
                                        <span class="w-75px">6,900</span>
                                        <i class="ki-outline ki-arrow-up fs-3 text-success"></i>
                                    </div>
                                    <div class="fw-semibold text-muted">Earnings</div>
                                </div>
                                <!--end::Stats-->
                                <!--begin::Stats-->
                                <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
                                    <div class="fs-4 fw-bold text-gray-700">
                                        <span class="w-50px">130</span>
                                        <i class="ki-outline ki-arrow-down fs-3 text-danger"></i>
                                    </div>
                                    <div class="fw-semibold text-muted">Tasks</div>
                                </div>
                                <!--end::Stats-->
                                <!--begin::Stats-->
                                <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                    <div class="fs-4 fw-bold text-gray-700">
                                        <span class="w-50px">500</span>
                                        <i class="ki-outline ki-arrow-up fs-3 text-success"></i>
                                    </div>
                                    <div class="fw-semibold text-muted">Hours</div>
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Summary-->
                        <!--begin::Details toggle-->
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_customer_view_details" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">Details 
                            <span class="ms-2 rotate-180">
                                <i class="ki-outline ki-down fs-3"></i>
                            </span></div>
                            <span data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-original-title="Edit customer details" data-kt-initialized="1">
                                <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_customer">Edit</a>
                            </span>
                        </div>
                        <!--end::Details toggle-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--begin::Details content-->
                        <div id="kt_customer_view_details" class="collapse show">
                            <div class="py-5 fs-6">
                                <!--begin::Badge-->
                                <div class="badge badge-light-info d-inline">Premium user</div>
                                <!--begin::Badge-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">Account ID</div>
                                <div class="text-gray-600">ID-45453423</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">Billing Email</div>
                                <div class="text-gray-600">
                                    <a href="#" class="text-gray-600 text-hover-primary">info@keenthemes.com</a>
                                </div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">Billing Address</div>
                                <div class="text-gray-600">101 Collin Street, 
                                <br>Melbourne 3000 VIC
                                <br>Australia</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">Language</div>
                                <div class="text-gray-600">English</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">Upcoming Invoice</div>
                                <div class="text-gray-600">54238-8693</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">Tax ID</div>
                                <div class="text-gray-600">TX-8674</div>
                                <!--begin::Details item-->
                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Connected Accounts-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <div class="card-title">
                            <h3 class="fw-bold m-0">Connected Accounts</h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-2">
                        <!--begin::Notice-->
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                            <!--begin::Icon-->
                            <i class="ki-outline ki-design-1 fs-2tx text-primary me-4"></i>
                            <!--end::Icon-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <div class="fs-6 text-gray-700">By connecting an account, you hereby agree to our 
                                    <a href="#" class="me-1">privacy policy</a>and 
                                    <a href="#">terms of use</a>.</div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Notice-->
                        <!--begin::Items-->
                        <div class="py-2">
                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <div class="d-flex">
                                    <img src="{{ asset('media') }}/svg/brand-logos/google-icon.svg" class="w-30px me-6" alt="">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="fs-5 text-gray-900 text-hover-primary fw-bold">Google</a>
                                        <div class="fs-6 fw-semibold text-muted">Plan properly your workflow</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <!--begin::Switch-->
                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input" name="google" type="checkbox" value="1" id="kt_modal_connected_accounts_google" checked="checked">
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <span class="form-check-label fw-semibold text-muted" for="kt_modal_connected_accounts_google"></span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Switch-->
                                </div>
                            </div>
                            <!--end::Item-->
                            <div class="separator separator-dashed my-5"></div>
                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <div class="d-flex">
                                    <img src="{{ asset('media') }}/svg/brand-logos/github.svg" class="w-30px me-6" alt="">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="fs-5 text-gray-900 text-hover-primary fw-bold">Github</a>
                                        <div class="fs-6 fw-semibold text-muted">Keep eye on on your Repositories</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <!--begin::Switch-->
                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input" name="github" type="checkbox" value="1" id="kt_modal_connected_accounts_github" checked="checked">
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <span class="form-check-label fw-semibold text-muted" for="kt_modal_connected_accounts_github"></span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Switch-->
                                </div>
                            </div>
                            <!--end::Item-->
                            <div class="separator separator-dashed my-5"></div>
                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <div class="d-flex">
                                    <img src="{{ asset('media') }}/svg/brand-logos/slack-icon.svg" class="w-30px me-6" alt="">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="fs-5 text-gray-900 text-hover-primary fw-bold">Slack</a>
                                        <div class="fs-6 fw-semibold text-muted">Integrate Projects Discussions</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <!--begin::Switch-->
                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input" name="slack" type="checkbox" value="1" id="kt_modal_connected_accounts_slack">
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <span class="form-check-label fw-semibold text-muted" for="kt_modal_connected_accounts_slack"></span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Switch-->
                                </div>
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Items-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer border-0 d-flex justify-content-center pt-0">
                        <button class="btn btn-sm btn-light-primary">Save Changes</button>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Connected Accounts-->
            </div>
            <!--end::Sidebar-->
            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8" role="tablist">
                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_customer_view_overview_tab" aria-selected="false" role="tab" tabindex="-1">Overview</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_customer_view_overview_events_and_logs_tab" aria-selected="false" role="tab" tabindex="-1">Events &amp; Logs</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_customer_view_overview_statements" data-kt-initialized="1" aria-selected="true" role="tab">Statements</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item ms-auto">
                        <!--begin::Action menu-->
                        <a href="#" class="btn btn-info ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">Actions 
                        <i class="ki-outline ki-down fs-2 me-0"></i></a>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">Payments</div>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link px-5">Create invoice</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link flex-stack px-5">Create payments 
                                <span class="ms-2" data-bs-toggle="tooltip" aria-label="Specify a target name for future usage and reference" data-bs-original-title="Specify a target name for future usage and reference" data-kt-initialized="1">
                                    <i class="ki-outline ki-information fs-7"></i>
                                </span></a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">
                                <a href="#" class="menu-link px-5">
                                    <span class="menu-title">Subscription</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <!--begin::Menu sub-->
                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-5">Apps</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-5">Billing</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-5">Statements</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu separator-->
                                    <div class="separator my-2"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content px-3">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input w-30px h-20px" type="checkbox" value="" name="notifications" checked="checked" id="kt_user_menu_notifications">
                                                <span class="form-check-label text-muted fs-6" for="kt_user_menu_notifications">Notifications</span>
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu sub-->
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu separator-->
                            <div class="separator my-3"></div>
                            <!--end::Menu separator-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">Account</div>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link px-5">Reports</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5 my-1">
                                <a href="#" class="menu-link px-5">Account Settings</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link text-danger px-5">Delete customer</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                        <!--end::Menu-->
                    </li>
                    <!--end:::Tab item-->
                </ul>
                <!--end:::Tabs-->
                <!--begin:::Tab content-->
                <div class="tab-content" id="myTabContent">
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade active show" id="kt_customer_view_overview_tab" role="tabpanel">
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Payment Records</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Filter-->
                                    <button type="button" class="btn btn-sm btn-flex btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_payment">
                                    <i class="ki-outline ki-plus-square fs-3"></i>Add payment</button>
                                    <!--end::Filter-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0 pb-5">
                                <!--begin::Table-->
                                <div id="kt_table_customers_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table class="table align-middle table-row-dashed gy-5 dataTable no-footer" id="kt_table_customers_payment">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                        <tr class="text-start text-muted text-uppercase gs-0"><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_table_customers_payment" rowspan="1" colspan="1" style="width: 178.35px;" aria-label="Invoice No.: activate to sort column ascending">Invoice No.</th><th class="sorting" tabindex="0" aria-controls="kt_table_customers_payment" rowspan="1" colspan="1" style="width: 153.617px;" aria-label="Status: activate to sort column ascending">Status</th><th class="sorting" tabindex="0" aria-controls="kt_table_customers_payment" rowspan="1" colspan="1" style="width: 148.417px;" aria-label="Amount: activate to sort column ascending">Amount</th><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_table_customers_payment" rowspan="1" colspan="1" style="width: 300.2px;" aria-label="Date: activate to sort column ascending">Date</th><th class="text-end min-w-100px pe-4 sorting_disabled" rowspan="1" colspan="1" style="width: 196.167px;" aria-label="Actions">Actions</th></tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                    <tr class="odd">
                                            <td>
                                                <a href="#" class="text-gray-600 text-hover-primary mb-1">4429-8737</a>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-success">Successful</span>
                                            </td>
                                            <td>$1,200.00</td>
                                            <td data-order="2020-12-14T20:43:00-04:00">14 Dec 2020, 8:43 pm</td>
                                            <td class="pe-0 text-end">
                                                <a href="#" class="btn btn-sm btn-light image.png btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                                                <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="apps/customers/view.html" class="menu-link px-3">View</a>
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
                                        </tr><tr class="even">
                                            <td>
                                                <a href="#" class="text-gray-600 text-hover-primary mb-1">2297-3641</a>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-success">Successful</span>
                                            </td>
                                            <td>$79.00</td>
                                            <td data-order="2020-12-01T10:12:00-04:00">01 Dec 2020, 10:12 am</td>
                                            <td class="pe-0 text-end">
                                                <a href="#" class="btn btn-sm btn-light image.png btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                                                <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="apps/customers/view.html" class="menu-link px-3">View</a>
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
                                        </tr><tr class="odd">
                                            <td>
                                                <a href="#" class="text-gray-600 text-hover-primary mb-1">7561-2664</a>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-success">Successful</span>
                                            </td>
                                            <td>$5,500.00</td>
                                            <td data-order="2020-11-12T14:01:00-04:00">12 Nov 2020, 2:01 pm</td>
                                            <td class="pe-0 text-end">
                                                <a href="#" class="btn btn-sm btn-light image.png btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                                                <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="apps/customers/view.html" class="menu-link px-3">View</a>
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
                                        </tr><tr class="even">
                                            <td>
                                                <a href="#" class="text-gray-600 text-hover-primary mb-1">2909-8797</a>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-warning">Pending</span>
                                            </td>
                                            <td>$880.00</td>
                                            <td data-order="2020-10-21T17:54:00-04:00">21 Oct 2020, 5:54 pm</td>
                                            <td class="pe-0 text-end">
                                                <a href="#" class="btn btn-sm btn-light image.png btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                                                <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="apps/customers/view.html" class="menu-link px-3">View</a>
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
                                        </tr><tr class="odd">
                                            <td>
                                                <a href="#" class="text-gray-600 text-hover-primary mb-1">6374-8682</a>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-success">Successful</span>
                                            </td>
                                            <td>$7,650.00</td>
                                            <td data-order="2020-10-19T07:32:00-04:00">19 Oct 2020, 7:32 am</td>
                                            <td class="pe-0 text-end">
                                                <a href="#" class="btn btn-sm btn-light image.png btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                                                <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="apps/customers/view.html" class="menu-link px-3">View</a>
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
                                        </tr></tbody>
                                    <!--end::Table body-->
                                </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_table_customers_payment_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_table_customers_payment_previous"><a href="#" aria-controls="kt_table_customers_payment" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_table_customers_payment" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_table_customers_payment" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="kt_table_customers_payment_next"><a href="#" aria-controls="kt_table_customers_payment" data-dt-idx="3" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
                                <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2 class="fw-bold mb-0">Payment Methods</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <a href="#" class="btn btn-sm btn-flex btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">
                                    <i class="ki-outline ki-plus-square fs-3"></i>Add new method</a>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div id="kt_customer_view_payment_method" class="card-body pt-0">
                                <!--begin::Option-->
                                <div class="py-0" data-kt-customer-payment-method="row">
                                    <!--begin::Header-->
                                    <div class="py-3 d-flex flex-stack flex-wrap">
                                        <!--begin::Toggle-->
                                        <div class="d-flex align-items-center collapsible rotate" data-bs-toggle="collapse" href="#kt_customer_view_payment_method_1" role="button" aria-expanded="false" aria-controls="kt_customer_view_payment_method_1">
                                            <!--begin::Arrow-->
                                            <div class="me-3 rotate-90">
                                                <i class="ki-outline ki-right fs-3"></i>
                                            </div>
                                            <!--end::Arrow-->
                                            <!--begin::Logo-->
                                            <img src="{{ asset('media') }}/svg/card-logos/mastercard.svg" class="w-40px me-3" alt="">
                                            <!--end::Logo-->
                                            <!--begin::Summary-->
                                            <div class="me-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="text-gray-800 fw-bold">Mastercard</div>
                                                    <div class="badge badge-light-info ms-5">Primary</div>
                                                </div>
                                                <div class="text-muted">Expires Dec 2024</div>
                                            </div>
                                            <!--end::Summary-->
                                        </div>
                                        <!--end::Toggle-->
                                        <!--begin::Toolbar-->
                                        <div class="d-flex my-3 ms-9">
                                            <!--begin::Edit-->
                                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">
                                                <span data-bs-toggle="tooltip" data-bs-trigger="hover" aria-label="Edit" data-bs-original-title="Edit" data-kt-initialized="1">
                                                    <i class="ki-outline ki-pencil fs-3"></i>
                                                </span>
                                            </a>
                                            <!--end::Edit-->
                                            <!--begin::Delete-->
                                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="tooltip" data-kt-customer-payment-method="delete" aria-label="Delete" data-bs-original-title="Delete" data-kt-initialized="1">
                                                <i class="ki-outline ki-trash fs-3"></i>
                                            </a>
                                            <!--end::Delete-->
                                            <!--begin::More-->
                                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" aria-label="More Options" data-bs-original-title="More Options" data-kt-initialized="1">
                                                <i class="ki-outline ki-setting-3 fs-3"></i>
                                            </a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold w-150px py-3" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3" data-kt-payment-mehtod-action="set_as_primary">Set as Primary</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                            <!--end::More-->
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div id="kt_customer_view_payment_method_1" class="collapse show fs-6 ps-10" data-bs-parent="#kt_customer_view_payment_method">
                                        <!--begin::Details-->
                                        <div class="d-flex flex-wrap py-5">
                                            <!--begin::Col-->
                                            <div class="flex-equal me-5">
                                                <table class="table table-flush fw-semibold gy-1">
                                                    <tbody><tr>
                                                        <td class="text-muted min-w-125px w-125px">Name</td>
                                                        <td class="text-gray-800">Emma Smith</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Number</td>
                                                        <td class="text-gray-800">**** 4870</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Expires</td>
                                                        <td class="text-gray-800">12/2024</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Type</td>
                                                        <td class="text-gray-800">Mastercard credit card</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Issuer</td>
                                                        <td class="text-gray-800">VICBANK</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">ID</td>
                                                        <td class="text-gray-800">id_4325df90sdf8</td>
                                                    </tr>
                                                </tbody></table>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="flex-equal">
                                                <table class="table table-flush fw-semibold gy-1">
                                                    <tbody><tr>
                                                        <td class="text-muted min-w-125px w-125px">Billing address</td>
                                                        <td class="text-gray-800">AU</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Phone</td>
                                                        <td class="text-gray-800">No phone provided</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Email</td>
                                                        <td class="text-gray-800">
                                                            <a href="#" class="text-gray-900 text-hover-primary">smith@kpmg.com</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Origin</td>
                                                        <td class="text-gray-800">Australia 
                                                        <div class="symbol symbol-20px symbol-circle ms-2">
                                                            <img src="{{ asset('media') }}/flags/australia.svg">
                                                        </div></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">CVC check</td>
                                                        <td class="text-gray-800">Passed 
                                                        <i class="ki-outline ki-check-circle fs-2 text-success"></i></td>
                                                    </tr>
                                                </tbody></table>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Option-->
                                <div class="separator separator-dashed"></div>
                                <!--begin::Option-->
                                <div class="py-0" data-kt-customer-payment-method="row">
                                    <!--begin::Header-->
                                    <div class="py-3 d-flex flex-stack flex-wrap">
                                        <!--begin::Toggle-->
                                        <div class="d-flex align-items-center collapsible collapsed rotate" data-bs-toggle="collapse" href="#kt_customer_view_payment_method_2" role="button" aria-expanded="false" aria-controls="kt_customer_view_payment_method_2">
                                            <!--begin::Arrow-->
                                            <div class="me-3 rotate-90">
                                                <i class="ki-outline ki-right fs-3"></i>
                                            </div>
                                            <!--end::Arrow-->
                                            <!--begin::Logo-->
                                            <img src="{{ asset('media') }}/svg/card-logos/visa.svg" class="w-40px me-3" alt="">
                                            <!--end::Logo-->
                                            <!--begin::Summary-->
                                            <div class="me-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="text-gray-800 fw-bold">Visa</div>
                                                </div>
                                                <div class="text-muted">Expires Feb 2022</div>
                                            </div>
                                            <!--end::Summary-->
                                        </div>
                                        <!--end::Toggle-->
                                        <!--begin::Toolbar-->
                                        <div class="d-flex my-3 ms-9">
                                            <!--begin::Edit-->
                                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">
                                                <span data-bs-toggle="tooltip" data-bs-trigger="hover" aria-label="Edit" data-bs-original-title="Edit" data-kt-initialized="1">
                                                    <i class="ki-outline ki-pencil fs-3"></i>
                                                </span>
                                            </a>
                                            <!--end::Edit-->
                                            <!--begin::Delete-->
                                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="tooltip" data-kt-customer-payment-method="delete" aria-label="Delete" data-bs-original-title="Delete" data-kt-initialized="1">
                                                <i class="ki-outline ki-trash fs-3"></i>
                                            </a>
                                            <!--end::Delete-->
                                            <!--begin::More-->
                                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" aria-label="More Options" data-bs-original-title="More Options" data-kt-initialized="1">
                                                <i class="ki-outline ki-setting-3 fs-3"></i>
                                            </a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold w-150px py-3" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3" data-kt-payment-mehtod-action="set_as_primary">Set as Primary</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                            <!--end::More-->
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div id="kt_customer_view_payment_method_2" class="collapse fs-6 ps-10" data-bs-parent="#kt_customer_view_payment_method">
                                        <!--begin::Details-->
                                        <div class="d-flex flex-wrap py-5">
                                            <!--begin::Col-->
                                            <div class="flex-equal me-5">
                                                <table class="table table-flush fw-semibold gy-1">
                                                    <tbody><tr>
                                                        <td class="text-muted min-w-125px w-125px">Name</td>
                                                        <td class="text-gray-800">Melody Macy</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Number</td>
                                                        <td class="text-gray-800">**** 9365</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Expires</td>
                                                        <td class="text-gray-800">02/2022</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Type</td>
                                                        <td class="text-gray-800">Visa credit card</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Issuer</td>
                                                        <td class="text-gray-800">ENBANK</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">ID</td>
                                                        <td class="text-gray-800">id_w2r84jdy723</td>
                                                    </tr>
                                                </tbody></table>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="flex-equal">
                                                <table class="table table-flush fw-semibold gy-1">
                                                    <tbody><tr>
                                                        <td class="text-muted min-w-125px w-125px">Billing address</td>
                                                        <td class="text-gray-800">UK</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Phone</td>
                                                        <td class="text-gray-800">No phone provided</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Email</td>
                                                        <td class="text-gray-800">
                                                            <a href="#" class="text-gray-900 text-hover-primary">melody@altbox.com</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Origin</td>
                                                        <td class="text-gray-800">United Kingdom 
                                                        <div class="symbol symbol-20px symbol-circle ms-2">
                                                            <img src="{{ asset('media') }}/flags/united-kingdom.svg">
                                                        </div></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">CVC check</td>
                                                        <td class="text-gray-800">Passed 
                                                        <i class="ki-outline ki-check fs-2 text-success"></i></td>
                                                    </tr>
                                                </tbody></table>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Option-->
                                <div class="separator separator-dashed"></div>
                                <!--begin::Option-->
                                <div class="py-0" data-kt-customer-payment-method="row">
                                    <!--begin::Header-->
                                    <div class="py-3 d-flex flex-stack flex-wrap">
                                        <!--begin::Toggle-->
                                        <div class="d-flex align-items-center collapsible collapsed rotate" data-bs-toggle="collapse" href="#kt_customer_view_payment_method_3" role="button" aria-expanded="false" aria-controls="kt_customer_view_payment_method_3">
                                            <!--begin::Arrow-->
                                            <div class="me-3 rotate-90">
                                                <i class="ki-outline ki-right fs-3"></i>
                                            </div>
                                            <!--end::Arrow-->
                                            <!--begin::Logo-->
                                            <img src="{{ asset('media') }}/svg/card-logos/american-express.svg" class="w-40px me-3" alt="">
                                            <!--end::Logo-->
                                            <!--begin::Summary-->
                                            <div class="me-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="text-gray-800 fw-bold">American Express</div>
                                                    <div class="badge badge-light-danger ms-5">Expired</div>
                                                </div>
                                                <div class="text-muted">Expires Aug 2021</div>
                                            </div>
                                            <!--end::Summary-->
                                        </div>
                                        <!--end::Toggle-->
                                        <!--begin::Toolbar-->
                                        <div class="d-flex my-3 ms-9">
                                            <!--begin::Edit-->
                                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">
                                                <span data-bs-toggle="tooltip" data-bs-trigger="hover" aria-label="Edit" data-bs-original-title="Edit" data-kt-initialized="1">
                                                    <i class="ki-outline ki-pencil fs-3"></i>
                                                </span>
                                            </a>
                                            <!--end::Edit-->
                                            <!--begin::Delete-->
                                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="tooltip" data-kt-customer-payment-method="delete" aria-label="Delete" data-bs-original-title="Delete" data-kt-initialized="1">
                                                <i class="ki-outline ki-trash fs-3"></i>
                                            </a>
                                            <!--end::Delete-->
                                            <!--begin::More-->
                                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" aria-label="More Options" data-bs-original-title="More Options" data-kt-initialized="1">
                                                <i class="ki-outline ki-setting-3 fs-3"></i>
                                            </a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold w-150px py-3" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3" data-kt-payment-mehtod-action="set_as_primary">Set as Primary</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                            <!--end::More-->
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div id="kt_customer_view_payment_method_3" class="collapse fs-6 ps-10" data-bs-parent="#kt_customer_view_payment_method">
                                        <!--begin::Details-->
                                        <div class="d-flex flex-wrap py-5">
                                            <!--begin::Col-->
                                            <div class="flex-equal me-5">
                                                <table class="table table-flush fw-semibold gy-1">
                                                    <tbody><tr>
                                                        <td class="text-muted min-w-125px w-125px">Name</td>
                                                        <td class="text-gray-800">Max Smith</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Number</td>
                                                        <td class="text-gray-800">**** 4997</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Expires</td>
                                                        <td class="text-gray-800">08/2021</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Type</td>
                                                        <td class="text-gray-800">American express credit card</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Issuer</td>
                                                        <td class="text-gray-800">USABANK</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">ID</td>
                                                        <td class="text-gray-800">id_89457jcje63</td>
                                                    </tr>
                                                </tbody></table>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="flex-equal">
                                                <table class="table table-flush fw-semibold gy-1">
                                                    <tbody><tr>
                                                        <td class="text-muted min-w-125px w-125px">Billing address</td>
                                                        <td class="text-gray-800">US</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Phone</td>
                                                        <td class="text-gray-800">No phone provided</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Email</td>
                                                        <td class="text-gray-800">
                                                            <a href="#" class="text-gray-900 text-hover-primary">max@kt.com</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">Origin</td>
                                                        <td class="text-gray-800">United States of America 
                                                        <div class="symbol symbol-20px symbol-circle ms-2">
                                                            <img src="{{ asset('media') }}/flags/united-states.svg">
                                                        </div></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted min-w-125px w-125px">CVC check</td>
                                                        <td class="text-gray-800">Failed 
                                                        <i class="ki-outline ki-cross fs-2 text-danger"></i></td>
                                                    </tr>
                                                </tbody></table>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Option-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2 class="fw-bold">Credit Balance</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <a href="#" class="btn btn-sm btn-flex btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_adjust_balance">
                                    <i class="ki-outline ki-pencil fs-3"></i>Adjust Balance</a>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="fw-bold fs-2">$32,487.57 
                                <span class="text-muted fs-4 fw-semibold">USD</span>
                                <div class="fs-7 fw-normal text-muted">Balance will increase the amount due on the customer's next invoice.</div></div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!--begin::Card-->
                        <div class="card pt-2 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Invoices</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Toolbar-->
                                <div class="card-toolbar m-0">
                                    <!--begin::Tab nav-->
                                    <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs nav-line-tabs-2x border-transparent" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a id="kt_referrals_year_tab" class="nav-link text-active-primary active" data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_1" aria-selected="true">This Year</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a id="kt_referrals_2019_tab" class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_2" aria-selected="false" tabindex="-1">2020</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a id="kt_referrals_2018_tab" class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_3" aria-selected="false" tabindex="-1">2019</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a id="kt_referrals_2017_tab" class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_4" aria-selected="false" tabindex="-1">2018</a>
                                        </li>
                                    </ul>
                                    <!--end::Tab nav-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Tab Content-->
                                <div id="kt_referred_users_tab_content" class="tab-content">
                                    <!--begin::Tab panel-->
                                    <div id="kt_customer_details_invoices_1" class="py-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_referrals_year_tab">
                                        <!--begin::Table-->
                                        <div id="kt_customer_details_invoices_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table id="kt_customer_details_invoices_table_1" class="table align-middle table-row-dashed fs-6 fw-bold gy-5 dataTable no-footer">
                                            <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                                <tr class="text-start text-muted gs-0"><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_1" rowspan="1" colspan="1" style="width: 175.333px;" aria-label="Order ID: activate to sort column ascending">Order ID</th><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_1" rowspan="1" colspan="1" style="width: 182.667px;" aria-label="Amount: activate to sort column ascending">Amount</th><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_1" rowspan="1" colspan="1" style="width: 182.683px;" aria-label="Status: activate to sort column ascending">Status</th><th class="min-w-125px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_1" rowspan="1" colspan="1" style="width: 226.5px;" aria-label="Date: activate to sort column ascending">Date</th><th class="min-w-100px text-end pe-7 sorting_disabled" rowspan="1" colspan="1" style="width: 199.817px;" aria-label="Invoice">Invoice</th></tr>
                                            </thead>
                                            <tbody class="fs-6 fw-semibold text-gray-600">
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                            <tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td class="text-success">$38.00</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                                    </td>
                                                    <td class="text-danger">$-2.60</td>
                                                    <td>
                                                        <span class="badge badge-light-success">Approved</span>
                                                    </td>
                                                    <td>Oct 24, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td class="text-success">$76.00</td>
                                                    <td>
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    </td>
                                                    <td>Oct 08, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td class="text-success">$5.00</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>Sep 15, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                                    </td>
                                                    <td class="text-danger">$-1.30</td>
                                                    <td>
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    </td>
                                                    <td>May 30, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr></tbody>
                                        </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_customer_details_invoices_table_1_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_customer_details_invoices_table_1_previous"><a href="#" aria-controls="kt_customer_details_invoices_table_1" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_customer_details_invoices_table_1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_customer_details_invoices_table_1" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="kt_customer_details_invoices_table_1_next"><a href="#" aria-controls="kt_customer_details_invoices_table_1" data-dt-idx="3" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Tab panel-->
                                    <!--begin::Tab panel-->
                                    <div id="kt_customer_details_invoices_2" class="py-0 tab-pane fade" role="tabpanel" aria-labelledby="kt_referrals_2019_tab">
                                        <!--begin::Table-->
                                        <div id="kt_customer_details_invoices_table_2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table id="kt_customer_details_invoices_table_2" class="table align-middle table-row-dashed fs-6 fw-bold gy-5 dataTable no-footer">
                                            <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                                <tr class="text-start text-muted gs-0"><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_2" rowspan="1" colspan="1" style="width: 0px;" aria-label="Order ID: activate to sort column ascending">Order ID</th><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_2" rowspan="1" colspan="1" style="width: 0px;" aria-label="Amount: activate to sort column ascending">Amount</th><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_2" rowspan="1" colspan="1" style="width: 0px;" aria-label="Status: activate to sort column ascending">Status</th><th class="min-w-125px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_2" rowspan="1" colspan="1" style="width: 0px;" aria-label="Date: activate to sort column ascending">Date</th><th class="min-w-100px text-end pe-7 sorting_disabled" rowspan="1" colspan="1" style="width: 0px;" aria-label="Invoice">Invoice</th></tr>
                                            </thead>
                                            <tbody class="fs-6 fw-semibold text-gray-600">
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                            <tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                                    </td>
                                                    <td class="text-danger">$-1.30</td>
                                                    <td>
                                                        <span class="badge badge-light-success">Approved</span>
                                                    </td>
                                                    <td>May 30, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                                    </td>
                                                    <td class="text-success">$204.00</td>
                                                    <td>
                                                        <span class="badge badge-light-success">Approved</span>
                                                    </td>
                                                    <td>Apr 22, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td class="text-success">$31.00</td>
                                                    <td>
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    </td>
                                                    <td>Feb 09, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                                    </td>
                                                    <td class="text-success">$52.00</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                                    </td>
                                                    <td class="text-danger">$-0.80</td>
                                                    <td>
                                                        <span class="badge badge-light-warning">Pending</span>
                                                    </td>
                                                    <td>Jan 04, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr></tbody>
                                        </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_customer_details_invoices_table_2_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_customer_details_invoices_table_2_previous"><a href="#" aria-controls="kt_customer_details_invoices_table_2" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_customer_details_invoices_table_2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_customer_details_invoices_table_2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="kt_customer_details_invoices_table_2_next"><a href="#" aria-controls="kt_customer_details_invoices_table_2" data-dt-idx="3" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Tab panel-->
                                    <!--begin::Tab panel-->
                                    <div id="kt_customer_details_invoices_3" class="py-0 tab-pane fade" role="tabpanel" aria-labelledby="kt_referrals_2018_tab">
                                        <!--begin::Table-->
                                        <div id="kt_customer_details_invoices_table_3_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table id="kt_customer_details_invoices_table_3" class="table align-middle table-row-dashed fs-6 fw-bold gy-5 dataTable no-footer">
                                            <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                                <tr class="text-start text-muted gs-0"><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3" rowspan="1" colspan="1" style="width: 0px;" aria-label="Order ID: activate to sort column ascending">Order ID</th><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3" rowspan="1" colspan="1" style="width: 0px;" aria-label="Amount: activate to sort column ascending">Amount</th><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3" rowspan="1" colspan="1" style="width: 0px;" aria-label="Status: activate to sort column ascending">Status</th><th class="min-w-125px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3" rowspan="1" colspan="1" style="width: 0px;" aria-label="Date: activate to sort column ascending">Date</th><th class="min-w-100px text-end pe-7 sorting_disabled" rowspan="1" colspan="1" style="width: 0px;" aria-label="Invoice">Invoice</th></tr>
                                            </thead>
                                            <tbody class="fs-6 fw-semibold text-gray-600">
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                            <tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td class="text-success">$31.00</td>
                                                    <td>
                                                        <span class="badge badge-light-success">Approved</span>
                                                    </td>
                                                    <td>Feb 09, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                                    </td>
                                                    <td class="text-success">$52.00</td>
                                                    <td>
                                                        <span class="badge badge-light-success">Approved</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                                    </td>
                                                    <td class="text-danger">$-0.80</td>
                                                    <td>
                                                        <span class="badge badge-light-warning">Pending</span>
                                                    </td>
                                                    <td>Jan 04, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td class="text-success">$5.00</td>
                                                    <td>
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    </td>
                                                    <td>Sep 15, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td class="text-success">$38.00</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr></tbody>
                                        </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_customer_details_invoices_table_3_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_customer_details_invoices_table_3_previous"><a href="#" aria-controls="kt_customer_details_invoices_table_3" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_customer_details_invoices_table_3" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_customer_details_invoices_table_3" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="kt_customer_details_invoices_table_3_next"><a href="#" aria-controls="kt_customer_details_invoices_table_3" data-dt-idx="3" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Tab panel-->
                                    <!--begin::Tab panel-->
                                    <div id="kt_customer_details_invoices_4" class="py-0 tab-pane fade" role="tabpanel" aria-labelledby="kt_referrals_2017_tab">
                                        <!--begin::Table-->
                                        <div id="kt_customer_details_invoices_table_4_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table id="kt_customer_details_invoices_table_4" class="table align-middle table-row-dashed fs-6 fw-bold gy-5 dataTable no-footer">
                                            <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                                <tr class="text-start text-muted gs-0"><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_4" rowspan="1" colspan="1" style="width: 0px;" aria-label="Order ID: activate to sort column ascending">Order ID</th><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_4" rowspan="1" colspan="1" style="width: 0px;" aria-label="Amount: activate to sort column ascending">Amount</th><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_4" rowspan="1" colspan="1" style="width: 0px;" aria-label="Status: activate to sort column ascending">Status</th><th class="min-w-125px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_4" rowspan="1" colspan="1" style="width: 0px;" aria-label="Date: activate to sort column ascending">Date</th><th class="min-w-100px text-end pe-7 sorting_disabled" rowspan="1" colspan="1" style="width: 0px;" aria-label="Invoice">Invoice</th></tr>
                                            </thead>
                                            <tbody class="fs-6 fw-semibold text-gray-600">
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                            <tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td class="text-success">$38.00</td>
                                                    <td>
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                                    </td>
                                                    <td class="text-danger">$-2.60</td>
                                                    <td>
                                                        <span class="badge badge-light-warning">Pending</span>
                                                    </td>
                                                    <td>Oct 24, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td class="text-success">$38.00</td>
                                                    <td>
                                                        <span class="badge badge-light-warning">Pending</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                                    </td>
                                                    <td class="text-danger">$-2.60</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>Oct 24, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="Invalid date">
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td class="text-success">$31.00</td>
                                                    <td>
                                                        <span class="badge badge-light-warning">Pending</span>
                                                    </td>
                                                    <td>Feb 09, 2020</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr></tbody>
                                        </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_customer_details_invoices_table_4_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_customer_details_invoices_table_4_previous"><a href="#" aria-controls="kt_customer_details_invoices_table_4" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_customer_details_invoices_table_4" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_customer_details_invoices_table_4" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="kt_customer_details_invoices_table_4_next"><a href="#" aria-controls="kt_customer_details_invoices_table_4" data-dt-idx="3" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Tab panel-->
                                </div>
                                <!--end::Tab Content-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end:::Tab pane-->
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade" id="kt_customer_view_overview_events_and_logs_tab" role="tabpanel">
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Logs</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-sm btn-light-primary">
                                    <i class="ki-outline ki-cloud-download fs-3"></i>Download Report</button>
                                    <!--end::Button-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body py-0">
                                <!--begin::Table wrapper-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5" id="kt_table_customers_logs">
                                        <tbody>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-success">200 OK</div>
                                                </td>
                                                <td>POST /v1/invoices/in_1913_9652/payment</td>
                                                <td class="pe-0 text-end min-w-200px">20 Jun 2023, 11:05 am</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-warning">404 WRN</div>
                                                </td>
                                                <td>POST /v1/customer/c_654c84c3601b3/not_found</td>
                                                <td class="pe-0 text-end min-w-200px">20 Jun 2023, 2:40 pm</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-success">200 OK</div>
                                                </td>
                                                <td>POST /v1/invoices/in_7938_6697/payment</td>
                                                <td class="pe-0 text-end min-w-200px">25 Oct 2023, 9:23 pm</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-success">200 OK</div>
                                                </td>
                                                <td>POST /v1/invoices/in_1913_9652/payment</td>
                                                <td class="pe-0 text-end min-w-200px">22 Sep 2023, 5:20 pm</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-success">200 OK</div>
                                                </td>
                                                <td>POST /v1/invoices/in_1913_9652/payment</td>
                                                <td class="pe-0 text-end min-w-200px">25 Jul 2023, 5:30 pm</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-warning">404 WRN</div>
                                                </td>
                                                <td>POST /v1/customer/c_654c84c3601b2/not_found</td>
                                                <td class="pe-0 text-end min-w-200px">19 Aug 2023, 2:40 pm</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-success">200 OK</div>
                                                </td>
                                                <td>POST /v1/invoices/in_2344_3497/payment</td>
                                                <td class="pe-0 text-end min-w-200px">10 Nov 2023, 10:30 am</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-warning">404 WRN</div>
                                                </td>
                                                <td>POST /v1/customer/c_654c84c3601b1/not_found</td>
                                                <td class="pe-0 text-end min-w-200px">21 Feb 2023, 10:30 am</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-success">200 OK</div>
                                                </td>
                                                <td>POST /v1/invoices/in_8055_5566/payment</td>
                                                <td class="pe-0 text-end min-w-200px">25 Oct 2023, 10:10 pm</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-success">200 OK</div>
                                                </td>
                                                <td>POST /v1/invoices/in_3596_8298/payment</td>
                                                <td class="pe-0 text-end min-w-200px">15 Apr 2023, 6:05 pm</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table wrapper-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Events</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-sm btn-light-primary">
                                    <i class="ki-outline ki-cloud-download fs-3"></i>Download Report</button>
                                    <!--end::Button-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body py-0">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-5" id="kt_table_customers_events">
                                    <tbody>
                                        <tr>
                                            <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Emma Smith</a>has made payment to 
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary">#XRS-45670</a></td>
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">25 Oct 2023, 5:30 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-400px">Invoice 
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary me-1">#SEP-45656</a>status has changed from 
                                            <span class="badge badge-light-warning me-1">Pending</span>to 
                                            <span class="badge badge-light-info">In Progress</span></td>
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">10 Nov 2023, 2:40 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Brian Cox</a>has made payment to 
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary">#OLP-45690</a></td>
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">19 Aug 2023, 11:05 am</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-400px">Invoice 
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary me-1">#KIO-45656</a>status has changed from 
                                            <span class="badge badge-light-succees me-1">In Transit</span>to 
                                            <span class="badge badge-light-success">Approved</span></td>
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">24 Jun 2023, 6:05 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-400px">Invoice 
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary me-1">#LOP-45640</a>has been 
                                            <span class="badge badge-light-danger">Declined</span></td>
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">19 Aug 2023, 5:30 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Melody Macy</a>has made payment to 
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary">#XRS-45670</a></td>
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">21 Feb 2023, 11:05 am</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-400px">Invoice 
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary me-1">#DER-45645</a>status has changed from 
                                            <span class="badge badge-light-info me-1">In Progress</span>to 
                                            <span class="badge badge-light-info">In Transit</span></td>
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">20 Dec 2023, 5:30 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-400px">Invoice 
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary me-1">#KIO-45656</a>status has changed from 
                                            <span class="badge badge-light-succees me-1">In Transit</span>to 
                                            <span class="badge badge-light-success">Approved</span></td>
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">25 Jul 2023, 10:30 am</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-400px">Invoice 
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary me-1">#DER-45645</a>status has changed from 
                                            <span class="badge badge-light-info me-1">In Progress</span>to 
                                            <span class="badge badge-light-info">In Transit</span></td>
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">05 May 2023, 10:10 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Sean Bean</a>has made payment to 
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary">#XRS-45670</a></td>
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">10 Nov 2023, 10:10 pm</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end:::Tab pane-->
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade" id="kt_customer_view_overview_statements" role="tabpanel">
                        <!--begin::Earnings-->
                        <div class="card mb-6 mb-xl-9">
                            <!--begin::Header-->
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h2>Earnings</h2>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-0">
                                <div class="fs-5 fw-semibold text-gray-500 mb-4">Last 30 day earnings calculated. Apart from arranging the order of topics.</div>
                                <!--begin::Left Section-->
                                <div class="d-flex flex-wrap flex-stack mb-5">
                                    <!--begin::Row-->
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Col-->
                                        <div class="border border-dashed border-gray-300 w-150px rounded my-3 p-4 me-6">
                                            <span class="fs-1 fw-bold text-gray-800 lh-1">
                                                <span data-kt-countup="true" data-kt-countup-value="6,840" data-kt-countup-prefix="$" class="counted" data-kt-initialized="1">$6,840</span>
                                                <i class="ki-outline ki-arrow-up fs-1 text-success"></i>
                                            </span>
                                            <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Net Earnings</span>
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="border border-dashed border-gray-300 w-125px rounded my-3 p-4 me-6">
                                            <span class="fs-1 fw-bold text-gray-800 lh-1">
                                            <span class="counted" data-kt-countup="true" data-kt-countup-value="16" data-kt-initialized="1">16</span>% 
                                            <i class="ki-outline ki-arrow-down fs-1 text-danger"></i></span>
                                            <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Change</span>
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="border border-dashed border-gray-300 w-150px rounded my-3 p-4 me-6">
                                            <span class="fs-1 fw-bold text-gray-800 lh-1">
                                                <span data-kt-countup="true" data-kt-countup-value="1,240" data-kt-countup-prefix="$" class="counted" data-kt-initialized="1">$1,240</span>
                                                <span class="text-primary">--</span>
                                            </span>
                                            <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Fees</span>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                    <a href="#" class="btn btn-sm btn-light-primary flex-shrink-0">Withdraw Earnings</a>
                                </div>
                                <!--end::Left Section-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Earnings-->
                        <!--begin::Statements-->
                        <div class="card mb-6 mb-xl-9">
                            <!--begin::Header-->
                            <div class="card-header">
                                <!--begin::Title-->
                                <div class="card-title">
                                    <h2>Statement</h2>
                                </div>
                                <!--end::Title-->
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Tab nav-->
                                    <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs nav-line-tabs-2x border-transparent" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-active-primary active" data-bs-toggle="tab" role="tab" href="#kt_customer_view_statement_1" aria-selected="true">This Year</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab" href="#kt_customer_view_statement_2" aria-selected="false" tabindex="-1">2020</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab" href="#kt_customer_view_statement_3" aria-selected="false" tabindex="-1">2019</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab" href="#kt_customer_view_statement_4" aria-selected="false" tabindex="-1">2018</a>
                                        </li>
                                    </ul>
                                    <!--end::Tab nav-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body pb-5">
                                <!--begin::Tab Content-->
                                <div id="kt_customer_view_statement_tab_content" class="tab-content">
                                    <!--begin::Tab panel-->
                                    <div id="kt_customer_view_statement_1" class="py-0 tab-pane fade show active" role="tabpanel">
                                        <!--begin::Table-->
                                        <div id="kt_customer_view_statement_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table id="kt_customer_view_statement_table_1" class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4 dataTable no-footer">
                                            <thead class="border-bottom border-gray-200">
                                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"><th class="w-125px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_1" rowspan="1" colspan="1" style="width: 125px;" aria-label="Date: activate to sort column ascending">Date</th><th class="w-100px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_1" rowspan="1" colspan="1" style="width: 100px;" aria-label="Order ID: activate to sort column ascending">Order ID</th><th class="w-300px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_1" rowspan="1" colspan="1" style="width: 300px;" aria-label="Details: activate to sort column ascending">Details</th><th class="w-100px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_1" rowspan="1" colspan="1" style="width: 100px;" aria-label="Amount: activate to sort column ascending">Amount</th><th class="w-100px text-end pe-7 sorting_disabled" rowspan="1" colspan="1" style="width: 100px;" aria-label="Invoice">Invoice</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr class="odd">
                                                    <td data-order="2021-01-01T00:00:00-04:00">Nov 01, 2021</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td>Darknight transparency 36 Icons Pack</td>
                                                    <td class="text-success">$38.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2021-01-24T00:00:00-04:00">Oct 24, 2021</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-2.60</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2021-01-08T00:00:00-04:00">Oct 08, 2021</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td>Cartoon Mobile Emoji Phone Pack</td>
                                                    <td class="text-success">$76.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2021-01-15T00:00:00-04:00">Sep 15, 2021</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                                    <td class="text-success">$5.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2021-01-30T00:00:00-04:00">May 30, 2021</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-1.30</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2021-01-22T00:00:00-04:00">Apr 22, 2021</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                                    </td>
                                                    <td>Parcel Shipping / Delivery Service App</td>
                                                    <td class="text-success">$204.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2021-01-09T00:00:00-04:00">Feb 09, 2021</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td>Visual Design Illustration</td>
                                                    <td class="text-success">$31.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2021-01-01T00:00:00-04:00">Nov 01, 2021</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                                    </td>
                                                    <td>Abstract Vusial Pack</td>
                                                    <td class="text-success">$52.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2021-01-04T00:00:00-04:00">Jan 04, 2021</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-0.80</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2021-01-01T00:00:00-04:00">Nov 01, 2021</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td>Darknight transparency 36 Icons Pack</td>
                                                    <td class="text-success">$38.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr></tbody>
                                        </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_customer_view_statement_table_1_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_customer_view_statement_table_1_previous"><a href="#" aria-controls="kt_customer_view_statement_table_1" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_customer_view_statement_table_1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_customer_view_statement_table_1" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="kt_customer_view_statement_table_1_next"><a href="#" aria-controls="kt_customer_view_statement_table_1" data-dt-idx="3" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Tab panel-->
                                    <!--begin::Tab panel-->
                                    <div id="kt_customer_view_statement_2" class="py-0 tab-pane fade" role="tabpanel">
                                        <!--begin::Table-->
                                        <div id="kt_customer_view_statement_table_2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table id="kt_customer_view_statement_table_2" class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4 dataTable no-footer">
                                            <thead class="border-bottom border-gray-200">
                                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"><th class="w-125px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_2" rowspan="1" colspan="1" style="width: 125px;" aria-label="Date: activate to sort column ascending">Date</th><th class="w-100px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_2" rowspan="1" colspan="1" style="width: 100px;" aria-label="Order ID: activate to sort column ascending">Order ID</th><th class="w-300px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_2" rowspan="1" colspan="1" style="width: 300px;" aria-label="Details: activate to sort column ascending">Details</th><th class="w-100px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_2" rowspan="1" colspan="1" style="width: 100px;" aria-label="Amount: activate to sort column ascending">Amount</th><th class="w-100px text-end pe-7 sorting_disabled" rowspan="1" colspan="1" style="width: 100px;" aria-label="Invoice">Invoice</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr class="odd">
                                                    <td data-order="2020-01-30T00:00:00-04:00">May 30, 2020</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-1.30</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2020-01-22T00:00:00-04:00">Apr 22, 2020</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                                    </td>
                                                    <td>Parcel Shipping / Delivery Service App</td>
                                                    <td class="text-success">$204.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2020-01-09T00:00:00-04:00">Feb 09, 2020</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td>Visual Design Illustration</td>
                                                    <td class="text-success">$31.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2020-01-01T00:00:00-04:00">Nov 01, 2020</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                                    </td>
                                                    <td>Abstract Vusial Pack</td>
                                                    <td class="text-success">$52.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2020-01-04T00:00:00-04:00">Jan 04, 2020</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-0.80</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2020-01-01T00:00:00-04:00">Nov 01, 2020</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td>Darknight transparency 36 Icons Pack</td>
                                                    <td class="text-success">$38.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2020-01-24T00:00:00-04:00">Oct 24, 2020</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-2.60</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2020-01-08T00:00:00-04:00">Oct 08, 2020</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td>Cartoon Mobile Emoji Phone Pack</td>
                                                    <td class="text-success">$76.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2020-01-15T00:00:00-04:00">Sep 15, 2020</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                                    <td class="text-success">$5.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2020-01-30T00:00:00-04:00">May 30, 2020</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-1.30</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr></tbody>
                                        </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_customer_view_statement_table_2_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_customer_view_statement_table_2_previous"><a href="#" aria-controls="kt_customer_view_statement_table_2" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_customer_view_statement_table_2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_customer_view_statement_table_2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="kt_customer_view_statement_table_2_next"><a href="#" aria-controls="kt_customer_view_statement_table_2" data-dt-idx="3" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Tab panel-->
                                    <!--begin::Tab panel-->
                                    <div id="kt_customer_view_statement_3" class="py-0 tab-pane fade" role="tabpanel">
                                        <!--begin::Table-->
                                        <div id="kt_customer_view_statement_table_3_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table id="kt_customer_view_statement_table_3" class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4 dataTable no-footer">
                                            <thead class="border-bottom border-gray-200">
                                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"><th class="w-125px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_3" rowspan="1" colspan="1" style="width: 125px;" aria-label="Date: activate to sort column ascending">Date</th><th class="w-100px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_3" rowspan="1" colspan="1" style="width: 100px;" aria-label="Order ID: activate to sort column ascending">Order ID</th><th class="w-300px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_3" rowspan="1" colspan="1" style="width: 300px;" aria-label="Details: activate to sort column ascending">Details</th><th class="w-100px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_3" rowspan="1" colspan="1" style="width: 100px;" aria-label="Amount: activate to sort column ascending">Amount</th><th class="w-100px text-end pe-7 sorting_disabled" rowspan="1" colspan="1" style="width: 100px;" aria-label="Invoice">Invoice</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr class="odd">
                                                    <td data-order="2019-01-09T00:00:00-04:00">Feb 09, 2019</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td>Visual Design Illustration</td>
                                                    <td class="text-success">$31.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2019-01-01T00:00:00-04:00">Nov 01, 2019</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                                    </td>
                                                    <td>Abstract Vusial Pack</td>
                                                    <td class="text-success">$52.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2019-01-04T00:00:00-04:00">Jan 04, 2019</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-0.80</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2019-01-15T00:00:00-04:00">Sep 15, 2019</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                                    <td class="text-success">$5.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2019-01-01T00:00:00-04:00">Nov 01, 2019</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td>Darknight transparency 36 Icons Pack</td>
                                                    <td class="text-success">$38.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2019-01-24T00:00:00-04:00">Oct 24, 2019</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-2.60</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2019-01-08T00:00:00-04:00">Oct 08, 2019</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td>Cartoon Mobile Emoji Phone Pack</td>
                                                    <td class="text-success">$76.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2019-01-30T00:00:00-04:00">May 30, 2019</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-1.30</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2019-01-22T00:00:00-04:00">Apr 22, 2019</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                                    </td>
                                                    <td>Parcel Shipping / Delivery Service App</td>
                                                    <td class="text-success">$204.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2019-01-09T00:00:00-04:00">Feb 09, 2019</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td>Visual Design Illustration</td>
                                                    <td class="text-success">$31.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr></tbody>
                                        </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_customer_view_statement_table_3_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_customer_view_statement_table_3_previous"><a href="#" aria-controls="kt_customer_view_statement_table_3" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_customer_view_statement_table_3" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_customer_view_statement_table_3" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="kt_customer_view_statement_table_3_next"><a href="#" aria-controls="kt_customer_view_statement_table_3" data-dt-idx="3" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Tab panel-->
                                    <!--begin::Tab panel-->
                                    <div id="kt_customer_view_statement_4" class="py-0 tab-pane fade" role="tabpanel">
                                        <!--begin::Table-->
                                        <div id="kt_customer_view_statement_table_4_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table id="kt_customer_view_statement_table_4" class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4 dataTable no-footer">
                                            <thead class="border-bottom border-gray-200">
                                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"><th class="w-125px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_4" rowspan="1" colspan="1" style="width: 125px;" aria-label="Date: activate to sort column ascending">Date</th><th class="w-100px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_4" rowspan="1" colspan="1" style="width: 100px;" aria-label="Order ID: activate to sort column ascending">Order ID</th><th class="w-300px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_4" rowspan="1" colspan="1" style="width: 300px;" aria-label="Details: activate to sort column ascending">Details</th><th class="w-100px sorting" tabindex="0" aria-controls="kt_customer_view_statement_table_4" rowspan="1" colspan="1" style="width: 100px;" aria-label="Amount: activate to sort column ascending">Amount</th><th class="w-100px text-end pe-7 sorting_disabled" rowspan="1" colspan="1" style="width: 100px;" aria-label="Invoice">Invoice</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr class="odd">
                                                    <td data-order="2018-01-01T00:00:00-04:00">Nov 01, 2018</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td>Darknight transparency 36 Icons Pack</td>
                                                    <td class="text-success">$38.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2018-01-24T00:00:00-04:00">Oct 24, 2018</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-2.60</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2018-01-01T00:00:00-04:00">Nov 01, 2018</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td>Darknight transparency 36 Icons Pack</td>
                                                    <td class="text-success">$38.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2018-01-24T00:00:00-04:00">Oct 24, 2018</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-2.60</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2018-01-09T00:00:00-04:00">Feb 09, 2018</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td>Visual Design Illustration</td>
                                                    <td class="text-success">$31.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2018-01-01T00:00:00-04:00">Nov 01, 2018</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                                    </td>
                                                    <td>Abstract Vusial Pack</td>
                                                    <td class="text-success">$52.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2018-01-04T00:00:00-04:00">Jan 04, 2018</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                                    </td>
                                                    <td>Seller Fee</td>
                                                    <td class="text-danger">$-0.80</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2018-01-08T00:00:00-04:00">Oct 08, 2018</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td>Cartoon Mobile Emoji Phone Pack</td>
                                                    <td class="text-success">$76.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="odd">
                                                    <td data-order="2018-01-08T00:00:00-04:00">Oct 08, 2018</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td>Cartoon Mobile Emoji Phone Pack</td>
                                                    <td class="text-success">$76.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr><tr class="even">
                                                    <td data-order="2019-01-09T00:00:00-04:00">Feb 09, 2019</td>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td>Visual Design Illustration</td>
                                                    <td class="text-success">$31.00</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr></tbody>
                                        </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_customer_view_statement_table_4_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_customer_view_statement_table_4_previous"><a href="#" aria-controls="kt_customer_view_statement_table_4" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_customer_view_statement_table_4" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_customer_view_statement_table_4" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="kt_customer_view_statement_table_4_next"><a href="#" aria-controls="kt_customer_view_statement_table_4" data-dt-idx="3" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Tab panel-->
                                </div>
                                <!--end::Tab Content-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Statements-->
                    </div>
                    <!--end:::Tab pane-->
                </div>
                <!--end:::Tab content-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
        <!--begin::Modals-->
        <!--begin::Modal - Add Payment-->
        <div class="modal fade" id="kt_modal_add_payment" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Add a Payment Record</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_modal_add_payment_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <!--begin::Form-->
                        <form id="kt_modal_add_payment_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Invoice Number</span>
                                    <span class="ms-2" data-bs-toggle="tooltip" aria-label="The invoice number must be unique." data-bs-original-title="The invoice number must be unique." data-kt-initialized="1">
                                        <i class="ki-outline ki-information fs-7"></i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="invoice" value="">
                                <!--end::Input-->
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold form-label mb-2">Status</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select form-select-solid fw-bold select2-hidden-accessible" name="status" data-control="select2" data-placeholder="Select an option" data-hide-search="true" data-select2-id="select2-data-7-4e5p" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                    <option data-select2-id="select2-data-9-v1ax"></option>
                                    <option value="0">Approved</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Rejected</option>
                                    <option value="3">In progress</option>
                                    <option value="4">Completed</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-8-tar8" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-status-0d-container" aria-controls="select2-status-0d-container"><span class="select2-selection__rendered" id="select2-status-0d-container" role="textbox" aria-readonly="true" title="Select an option"><span class="select2-selection__placeholder">Select an option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                <!--end::Input-->
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold form-label mb-2">Invoice Amount</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="amount" value="">
                                <!--end::Input-->
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-15">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Additional Information</span>
                                    <span class="ms-2" data-bs-toggle="tooltip" aria-label="Information such as description of invoice or product purchased." data-bs-original-title="Information such as description of invoice or product purchased." data-kt-initialized="1">
                                        <i class="ki-outline ki-information fs-7"></i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea class="form-control form-control-solid rounded-3" name="additional_info"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="text-center">
                                <button type="reset" id="kt_modal_add_payment_cancel" class="btn btn-light me-3">Discard</button>
                                <button type="submit" id="kt_modal_add_payment_submit" class="btn btn-info">
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
        <!--begin::Modal - Adjust Balance-->
        <div class="modal fade" id="kt_modal_adjust_balance" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Adjust Balance</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_modal_adjust_balance_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <!--begin::Balance preview-->
                        <div class="d-flex text-center mb-9">
                            <div class="w-50 border border-dashed border-gray-300 rounded mx-2 p-4">
                                <div class="fs-6 fw-semibold mb-2 text-muted">Current Balance</div>
                                <div class="fs-2 fw-bold" kt-modal-adjust-balance="current_balance">US$ 32,487.57</div>
                            </div>
                            <div class="w-50 border border-dashed border-gray-300 rounded mx-2 p-4">
                                <div class="fs-6 fw-semibold mb-2 text-muted">New Balance 
                                <span class="ms-2" data-bs-toggle="tooltip" aria-label="Enter an amount to preview the new balance." data-bs-original-title="Enter an amount to preview the new balance." data-kt-initialized="1">
                                    <i class="ki-outline ki-information fs-7"></i>
                                </span></div>
                                <div class="fs-2 fw-bold" kt-modal-adjust-balance="new_balance">--</div>
                            </div>
                        </div>
                        <!--end::Balance preview-->
                        <!--begin::Form-->
                        <form id="kt_modal_adjust_balance_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold form-label mb-2">Adjustment type</label>
                                <!--end::Label-->
                                <!--begin::Dropdown-->
                                <select class="form-select form-select-solid fw-bold select2-hidden-accessible" name="adjustment" aria-label="Select an option" data-control="select2" data-dropdown-parent="#kt_modal_adjust_balance" data-placeholder="Select an option" data-hide-search="true" data-select2-id="select2-data-10-sd55" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                    <option data-select2-id="select2-data-12-68c1"></option>
                                    <option value="1">Credit</option>
                                    <option value="2">Debit</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-11-227b" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-adjustment-2g-container" aria-controls="select2-adjustment-2g-container"><span class="select2-selection__rendered" id="select2-adjustment-2g-container" role="textbox" aria-readonly="true" title="Select an option"><span class="select2-selection__placeholder">Select an option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                <!--end::Dropdown-->
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold form-label mb-2">Amount</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="kt_modal_inputmask" type="text" class="form-control form-control-solid" name="amount" value="" inputmode="text">
                                <!--end::Input-->
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">Add adjustment note</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea class="form-control form-control-solid rounded-3 mb-5"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Disclaimer-->
                            <div class="fs-7 text-muted mb-15">Please be aware that all manual balance changes will be audited by the financial team every fortnight. Please maintain your invoices and receipts until then. Thank you.</div>
                            <!--end::Disclaimer-->
                            <!--begin::Actions-->
                            <div class="text-center">
                                <button type="reset" id="kt_modal_adjust_balance_cancel" class="btn btn-light me-3">Discard</button>
                                <button type="submit" id="kt_modal_adjust_balance_submit" class="btn btn-info">
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
        <!--begin::Modal - New Address-->
        <div class="modal fade" id="kt_modal_update_customer" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Form-->
                    <form class="form" action="#" id="kt_modal_update_customer_form">
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_modal_update_customer_header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">Update Customer</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div id="kt_modal_update_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                                <i class="ki-outline ki-cross fs-1"></i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body py-10 px-lg-17">
                            <!--begin::Scroll-->
                            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_customer_header" data-kt-scroll-wrappers="#kt_modal_update_customer_scroll" data-kt-scroll-offset="300px" style="max-height: 255px;">
                                <!--begin::Notice-->
                                <!--begin::Notice-->
                                <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                                    <!--begin::Icon-->
                                    <i class="ki-outline ki-information fs-2tx text-primary me-4"></i>
                                    <!--end::Icon-->
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack flex-grow-1">
                                        <!--begin::Content-->
                                        <div class="fw-semibold">
                                            <div class="fs-6 text-gray-700">Updating customer details will receive a privacy audit. For more info, please read our 
                                            <a href="#">Privacy Policy</a></div>
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Notice-->
                                <!--end::Notice-->
                                <!--begin::User toggle-->
                                <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_update_customer_user_info" role="button" aria-expanded="false" aria-controls="kt_modal_update_customer_user_info">User Information 
                                <span class="ms-2 rotate-180">
                                    <i class="ki-outline ki-down fs-3"></i>
                                </span></div>
                                <!--end::User toggle-->
                                <!--begin::User form-->
                                <div id="kt_modal_update_customer_user_info" class="collapse show">
                                    <!--begin::Input group-->
                                    <div class="mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span>Update Avatar</span>
                                            <span class="ms-1" data-bs-toggle="tooltip" aria-label="Allowed file types: png, jpg, jpeg." data-bs-original-title="Allowed file types: png, jpg, jpeg." data-kt-initialized="1">
                                                <i class="ki-outline ki-information fs-7"></i>
                                            </span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Image input wrapper-->
                                        <div class="mt-1">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{ asset('media') }}/svg/avatars/blank.svg')">
                                                <!--begin::Preview existing avatar-->
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ asset('media') }}/avatars/300-1.jpg)"></div>
                                                <!--end::Preview existing avatar-->
                                                <!--begin::Edit-->
                                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-bs-original-title="Change avatar" data-kt-initialized="1">
                                                    <i class="ki-outline ki-pencil fs-7"></i>
                                                    <!--begin::Inputs-->
                                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                                    <input type="hidden" name="avatar_remove">
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Edit-->
                                                <!--begin::Cancel-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar" data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                                                    <i class="ki-outline ki-cross fs-2"></i>
                                                </span>
                                                <!--end::Cancel-->
                                                <!--begin::Remove-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar" data-bs-original-title="Remove avatar" data-kt-initialized="1">
                                                    <i class="ki-outline ki-cross fs-2"></i>
                                                </span>
                                                <!--end::Remove-->
                                            </div>
                                            <!--end::Image input-->
                                        </div>
                                        <!--end::Image input wrapper-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="Sean Bean">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span>Email</span>
                                            <span class="ms-1" data-bs-toggle="tooltip" aria-label="Email address must be active" data-bs-original-title="Email address must be active" data-kt-initialized="1">
                                                <i class="ki-outline ki-information fs-7"></i>
                                            </span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="sean@dellito.com" style="background-size: auto, 25px; background-image: none, url(&quot;data:image/svg+xml;utf8,<svg width='26' height='28' viewBox='0 0 26 28' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M23.8958 6.1084L13.7365 0.299712C13.3797 0.103027 12.98 0 12.5739 0C12.1678 0 11.7682 0.103027 11.4113 0.299712L1.21632 6.1084C0.848276 6.31893 0.54181 6.62473 0.328154 6.99462C0.114498 7.36452 0.00129162 7.78529 7.13608e-05 8.21405V19.7951C-0.00323007 20.2248 0.108078 20.6474 0.322199 21.0181C0.53632 21.3888 0.845275 21.6938 1.21632 21.9008L11.3756 27.6732C11.7318 27.8907 12.1404 28.0037 12.556 27.9999C12.9711 27.9989 13.3784 27.8861 13.7365 27.6732L23.8958 21.9008C24.2638 21.6903 24.5703 21.3845 24.7839 21.0146C24.9976 20.6447 25.1108 20.2239 25.112 19.7951V8.21405C25.1225 7.78296 25.0142 7.35746 24.7994 6.98545C24.5845 6.61343 24.2715 6.30969 23.8958 6.1084Z' fill='url(%23paint0_linear_714_179)'/><path d='M5.47328 17.037L4.86515 17.4001C4.75634 17.4613 4.66062 17.5439 4.58357 17.643C4.50652 17.7421 4.4497 17.8558 4.4164 17.9775C4.3831 18.0991 4.374 18.2263 4.38963 18.3516C4.40526 18.4768 4.44531 18.5977 4.50743 18.707C4.58732 18.8586 4.70577 18.9857 4.85046 19.0751C4.99516 19.1645 5.16081 19.2129 5.33019 19.2153C5.49118 19.2139 5.64992 19.1767 5.79522 19.1064L6.40335 18.7434C6.51216 18.6822 6.60789 18.5996 6.68493 18.5004C6.76198 18.4013 6.8188 18.2876 6.8521 18.166C6.8854 18.0443 6.8945 17.9171 6.87887 17.7919C6.86324 17.6666 6.82319 17.5458 6.76107 17.4364C6.70583 17.3211 6.62775 17.2185 6.53171 17.1352C6.43567 17.0518 6.32374 16.9895 6.20289 16.952C6.08205 16.9145 5.95489 16.9027 5.82935 16.9174C5.70382 16.932 5.5826 16.9727 5.47328 17.037ZM9.19357 14.8951L7.94155 15.6212C7.83273 15.6824 7.73701 15.7649 7.65996 15.8641C7.58292 15.9632 7.52609 16.0769 7.49279 16.1986C7.4595 16.3202 7.4504 16.4474 7.46603 16.5726C7.48166 16.6979 7.5217 16.8187 7.58383 16.9281C7.66371 17.0797 7.78216 17.2068 7.92686 17.2962C8.07155 17.3856 8.23721 17.434 8.40658 17.4364C8.56757 17.435 8.72631 17.3978 8.87162 17.3275L10.1236 16.6014C10.2325 16.5402 10.3282 16.4576 10.4052 16.3585C10.4823 16.2594 10.5391 16.1457 10.5724 16.024C10.6057 15.9024 10.6148 15.7752 10.5992 15.6499C10.5835 15.5247 10.5435 15.4038 10.4814 15.2944C10.4261 15.1791 10.348 15.0766 10.252 14.9932C10.156 14.9099 10.044 14.8475 9.92318 14.8101C9.80234 14.7726 9.67518 14.7608 9.54964 14.7754C9.42411 14.7901 9.30289 14.8308 9.19357 14.8951ZM14.2374 13.1198C14.187 13.0168 14.1167 12.9251 14.0307 12.8503C13.9446 12.7754 13.8446 12.7189 13.7366 12.6842V5.38336C13.7371 5.2545 13.7124 5.12682 13.6641 5.00768C13.6157 4.88854 13.5446 4.78029 13.4548 4.68917C13.365 4.59806 13.2583 4.52587 13.1409 4.47678C13.0235 4.42769 12.8977 4.40266 12.7708 4.40314C12.6457 4.40355 12.522 4.42946 12.407 4.47933C12.292 4.52919 12.188 4.602 12.1013 4.69343C12.0145 4.78485 11.9467 4.89304 11.902 5.01156C11.8572 5.13007 11.8364 5.25651 11.8407 5.38336V12.7168C11.7327 12.7516 11.6327 12.8081 11.5466 12.883C11.4606 12.9578 11.3903 13.0495 11.3399 13.1525C11.2727 13.2801 11.2346 13.4213 11.2284 13.5659C11.2222 13.7104 11.2481 13.8545 11.3041 13.9875C11.2481 14.1205 11.2222 14.2646 11.2284 14.4091C11.2346 14.5536 11.2727 14.6949 11.3399 14.8225C11.3903 14.9255 11.4606 15.0172 11.5466 15.092C11.6327 15.1669 11.7327 15.2233 11.8407 15.2581V22.5916C11.8407 22.8516 11.9425 23.1009 12.1236 23.2847C12.3047 23.4686 12.5504 23.5718 12.8065 23.5718C13.0627 23.5718 13.3084 23.4686 13.4895 23.2847C13.6706 23.1009 13.7724 22.8516 13.7724 22.5916V15.2218C13.8804 15.187 13.9804 15.1305 14.0664 15.0557C14.1525 14.9809 14.2228 14.8892 14.2732 14.7862C14.3404 14.6586 14.3785 14.5173 14.3847 14.3728C14.3909 14.2283 14.365 14.0842 14.309 13.9512C14.3917 13.6751 14.3661 13.3772 14.2374 13.1198ZM16.6735 10.6112L15.4215 11.3373C15.3127 11.3985 15.2169 11.481 15.1399 11.5802C15.0628 11.6793 15.006 11.793 14.9727 11.9147C14.9394 12.0363 14.9303 12.1635 14.946 12.2887C14.9616 12.414 15.0016 12.5348 15.0638 12.6442C15.1436 12.7958 15.2621 12.9229 15.4068 13.0123C15.5515 13.1017 15.7171 13.1501 15.8865 13.1525C16.0475 13.1511 16.2062 13.1139 16.3515 13.0436L17.6036 12.3175C17.7124 12.2563 17.8081 12.1737 17.8851 12.0746C17.9622 11.9755 18.019 11.8617 18.0523 11.7401C18.0856 11.6184 18.0947 11.4913 18.0791 11.366C18.0635 11.2408 18.0234 11.1199 17.9613 11.0105C17.906 10.8952 17.828 10.7927 17.7319 10.7093C17.6359 10.626 17.524 10.5636 17.4031 10.5261C17.2823 10.4887 17.1551 10.4769 17.0296 10.4915C16.904 10.5061 16.7828 10.5469 16.6735 10.6112ZM19.639 10.9742C19.8 10.9728 19.9587 10.9357 20.104 10.8653L20.7122 10.5023C20.8208 10.4406 20.9164 10.3578 20.9935 10.2586C21.0705 10.1593 21.1275 10.0456 21.1611 9.92394C21.1947 9.80228 21.2043 9.67508 21.1893 9.54965C21.1744 9.42421 21.1351 9.30302 21.0739 9.19302C21.0126 9.08303 20.9305 8.9864 20.8324 8.90869C20.7342 8.83098 20.6219 8.77372 20.5019 8.7402C20.3818 8.70667 20.2564 8.69755 20.1329 8.71335C20.0094 8.72915 19.8902 8.76957 19.7821 8.83227L19.174 9.19531C19.0651 9.25651 18.9694 9.33909 18.8924 9.43822C18.8153 9.53735 18.7585 9.65106 18.7252 9.77271C18.6919 9.89436 18.6828 10.0215 18.6984 10.1468C18.7141 10.272 18.7541 10.3929 18.8162 10.5023C18.8981 10.6494 19.018 10.7711 19.163 10.8543C19.308 10.9374 19.4725 10.9789 19.639 10.9742ZM20.7122 17.4001L20.104 17.037C19.8859 16.9133 19.6284 16.8823 19.3878 16.9508C19.1472 17.0193 18.9432 17.1816 18.8202 17.4024C18.6973 17.6231 18.6655 17.8843 18.7318 18.1288C18.798 18.3733 18.957 18.5812 19.174 18.707L19.7821 19.0701C19.9274 19.1404 20.0861 19.1776 20.2471 19.179C20.4165 19.1766 20.5821 19.1282 20.7268 19.0388C20.8715 18.9494 20.99 18.8223 21.0699 18.6707C21.1339 18.5648 21.1755 18.4466 21.1921 18.3235C21.2087 18.2003 21.1999 18.0751 21.1662 17.9556C21.1326 17.8361 21.0749 17.7251 20.9967 17.6294C20.9185 17.5338 20.8216 17.4557 20.7122 17.4001ZM17.6 15.6212L16.348 14.8951C16.2399 14.8324 16.1207 14.792 15.9971 14.7762C15.8736 14.7604 15.7482 14.7695 15.6282 14.803C15.5082 14.8365 15.3958 14.8938 15.2977 14.9715C15.1995 15.0492 15.1174 15.1458 15.0562 15.2558C14.9949 15.3658 14.9557 15.487 14.9407 15.6125C14.9257 15.7379 14.9353 15.8651 14.9689 15.9868C15.0026 16.1084 15.0595 16.2221 15.1366 16.3214C15.2136 16.4206 15.3092 16.5035 15.4179 16.5651L16.6699 17.2912C16.8152 17.3615 16.974 17.3987 17.135 17.4001C17.3043 17.3977 17.47 17.3493 17.6147 17.2599C17.7594 17.1705 17.8778 17.0434 17.9577 16.8918C18.0228 16.7862 18.0653 16.6679 18.0825 16.5445C18.0997 16.4212 18.0911 16.2955 18.0574 16.1757C18.0237 16.0559 17.9655 15.9447 17.8867 15.8491C17.8079 15.7536 17.7103 15.6759 17.6 15.6212ZM7.94155 12.2812L9.19357 13.0073C9.33888 13.0776 9.49761 13.1148 9.6586 13.1162C9.82798 13.1138 9.99363 13.0654 10.1383 12.976C10.283 12.8866 10.4015 12.7595 10.4814 12.6079C10.5435 12.4985 10.5835 12.3777 10.5992 12.2524C10.6148 12.1272 10.6057 12 10.5724 11.8784C10.5391 11.7567 10.4823 11.643 10.4052 11.5439C10.3282 11.4447 10.2325 11.3622 10.1236 11.301L8.87162 10.5749C8.76383 10.5118 8.64476 10.4712 8.52134 10.4553C8.39792 10.4395 8.27262 10.4487 8.15275 10.4825C8.03288 10.5163 7.92084 10.574 7.82317 10.6521C7.72549 10.7303 7.64413 10.8275 7.58383 10.9379C7.46399 11.166 7.43428 11.4319 7.50073 11.6814C7.56719 11.9309 7.72481 12.1454 7.94155 12.2812ZM6.40335 9.19531L5.79522 8.83227C5.68714 8.76957 5.56791 8.72915 5.44439 8.71335C5.32087 8.69755 5.19549 8.70667 5.07546 8.7402C4.95542 8.77372 4.8431 8.83098 4.74493 8.90869C4.64676 8.9864 4.56469 9.08303 4.50343 9.19302C4.44217 9.30302 4.40293 9.42421 4.38796 9.54965C4.37299 9.67508 4.38259 9.80228 4.4162 9.92394C4.44981 10.0456 4.50677 10.1593 4.58382 10.2586C4.66087 10.3578 4.75647 10.4406 4.86515 10.5023L5.47328 10.8653C5.61859 10.9357 5.77732 10.9728 5.93831 10.9742C6.10769 10.9718 6.27334 10.9234 6.41804 10.834C6.56273 10.7447 6.68118 10.6176 6.76107 10.466C6.82193 10.3592 6.861 10.2411 6.87592 10.1187C6.89085 9.99635 6.88134 9.87216 6.84796 9.75358C6.81457 9.635 6.758 9.52446 6.68161 9.42854C6.60523 9.33263 6.51059 9.25331 6.40335 9.19531Z' fill='%2320133A'/><defs><linearGradient id='paint0_linear_714_179' x1='7.13608e-05' y1='14.001' x2='25.1156' y2='14.001' gradientUnits='userSpaceOnUse'><stop stop-color='%239059FF'/><stop offset='1' stop-color='%23F770FF'/></linearGradient></defs></svg>&quot;); background-repeat: repeat, no-repeat; background-position: 0% 0%, right calc(50% + 0px); background-origin: padding-box, content-box;">
                                        <!--end::Input-->
                                    <button type="button" style="border: 0px; clip: rect(0px, 0px, 0px, 0px); clip-path: inset(50%); height: 1px; margin: 0px -1px -1px 0px; overflow: hidden; padding: 0px; position: absolute; width: 1px; white-space: nowrap;">Generate new mask</button></div>
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
                                </div>
                                <!--end::User form-->
                                <!--begin::Billing toggle-->
                                <div class="fw-bold fs-3 rotate collapsible collapsed mb-7" data-bs-toggle="collapse" href="#kt_modal_update_customer_billing_info" role="button" aria-expanded="false" aria-controls="kt_modal_update_customer_billing_info">Shipping Information 
                                <span class="ms-2 rotate-180">
                                    <i class="ki-outline ki-down fs-3"></i>
                                </span></div>
                                <!--end::Billing toggle-->
                                <!--begin::Billing form-->
                                <div id="kt_modal_update_customer_billing_info" class="collapse">
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Address Line 1</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="address1" value="101, Collins Street">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Address Line 2</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="address2">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Town</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="city" value="Melbourne">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row g-9 mb-7">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2">State / Province</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" placeholder="" name="state" value="Victoria">
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2">Post Code</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" placeholder="" name="postcode" value="3000">
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span>Country</span>
                                            <span class="ms-1" data-bs-toggle="tooltip" aria-label="Country of origination" data-bs-original-title="Country of origination" data-kt-initialized="1">
                                                <i class="ki-outline ki-information fs-7"></i>
                                            </span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="country" aria-label="Select a Country" data-control="select2" data-placeholder="Select a Country..." data-dropdown-parent="#kt_modal_update_customer" class="form-select form-select-solid fw-bold select2-hidden-accessible" data-select2-id="select2-data-13-v1xd" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                            <option value="" data-select2-id="select2-data-15-wkcx">Select a Country...</option>
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
                                            <option value="US">United States</option>
                                            <option value="UY">Uruguay</option>
                                            <option value="UZ">Uzbekistan</option>
                                            <option value="VU">Vanuatu</option>
                                            <option value="VE">Venezuela, Bolivarian Republic of</option>
                                            <option value="VN">Vietnam</option>
                                            <option value="VI">Virgin Islands</option>
                                            <option value="YE">Yemen</option>
                                            <option value="ZM">Zambia</option>
                                            <option value="ZW">Zimbabwe</option>
                                        </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-14-c9w0" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-country-0v-container" aria-controls="select2-country-0v-container"><span class="select2-selection__rendered" id="select2-country-0v-container" role="textbox" aria-readonly="true" title="Select a Country..."><span class="select2-selection__placeholder">Select a Country...</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                        <!--end::Input-->
                                    </div>
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
                                                <input class="form-check-input" name="billing" type="checkbox" value="1" id="kt_modal_update_customer_billing" checked="checked">
                                                <!--end::Input-->
                                                <!--begin::Label-->
                                                <span class="form-check-label fw-semibold text-muted" for="kt_modal_update_customer_billing">Yes</span>
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
                            <button type="reset" id="kt_modal_update_customer_cancel" class="btn btn-light me-3">Discard</button>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_modal_update_customer_submit" class="btn btn-info">
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
        <!--end::Modal - New Address-->
        <!--begin::Modal - New Card-->
        <div class="modal fade" id="kt_modal_new_card" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add New Card</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <!--begin::Form-->
                        <form id="kt_modal_new_card_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Name On Card</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" aria-label="Specify a card holder's name" data-bs-original-title="Specify a card holder's name" data-kt-initialized="1">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid" placeholder="" name="card_name" value="Max Doe">
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold form-label mb-2">Card Number</label>
                                <!--end::Label-->
                                <!--begin::Input wrapper-->
                                <div class="position-relative">
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Enter card number" name="card_number" value="4111 1111 1111 1111">
                                    <!--end::Input-->
                                    <!--begin::Card logos-->
                                    <div class="position-absolute translate-middle-y top-50 end-0 me-5">
                                        <img src="{{ asset('media') }}/svg/card-logos/visa.svg" alt="" class="h-25px">
                                        <img src="{{ asset('media') }}/svg/card-logos/mastercard.svg" alt="" class="h-25px">
                                        <img src="{{ asset('media') }}/svg/card-logos/american-express.svg" alt="" class="h-25px">
                                    </div>
                                    <!--end::Card logos-->
                                </div>
                                <!--end::Input wrapper-->
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-10">
                                <!--begin::Col-->
                                <div class="col-md-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold form-label mb-2">Expiration Date</label>
                                    <!--end::Label-->
                                    <!--begin::Row-->
                                    <div class="row fv-row fv-plugins-icon-container">
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <select name="card_expiry_month" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Month" data-select2-id="select2-data-16-ksgf" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                                <option data-select2-id="select2-data-18-r6mq"></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-17-knsk" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-card_expiry_month-cw-container" aria-controls="select2-card_expiry_month-cw-container"><span class="select2-selection__rendered" id="select2-card_expiry_month-cw-container" role="textbox" aria-readonly="true" title="Month"><span class="select2-selection__placeholder">Month</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <select name="card_expiry_year" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Year" data-select2-id="select2-data-19-c7vu" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                                <option data-select2-id="select2-data-21-c0gr"></option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                                <option value="2031">2031</option>
                                                <option value="2032">2032</option>
                                                <option value="2033">2033</option>
                                            </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-20-da0k" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-card_expiry_year-nu-container" aria-controls="select2-card_expiry_year-nu-container"><span class="select2-selection__rendered" id="select2-card_expiry_year-nu-container" role="textbox" aria-readonly="true" title="Year"><span class="select2-selection__placeholder">Year</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-4 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                        <span class="required">CVV</span>
                                        <span class="ms-1" data-bs-toggle="tooltip" aria-label="Enter a card CVV code" data-bs-original-title="Enter a card CVV code" data-kt-initialized="1">
                                            <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                        </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input wrapper-->
                                    <div class="position-relative">
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" minlength="3" maxlength="4" placeholder="CVV" name="card_cvv">
                                        <!--end::Input-->
                                        <!--begin::CVV icon-->
                                        <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                                            <i class="ki-outline ki-credit-cart fs-2hx"></i>
                                        </div>
                                        <!--end::CVV icon-->
                                    </div>
                                    <!--end::Input wrapper-->
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-stack">
                                <!--begin::Label-->
                                <div class="me-5">
                                    <label class="fs-6 fw-semibold form-label">Save Card for further billing?</label>
                                    <div class="fs-7 fw-semibold text-muted">If you need more info, please check budget planning</div>
                                </div>
                                <!--end::Label-->
                                <!--begin::Switch-->
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" checked="checked">
                                    <span class="form-check-label fw-semibold text-muted">Save Card</span>
                                </label>
                                <!--end::Switch-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="text-center pt-15">
                                <button type="reset" id="kt_modal_new_card_cancel" class="btn btn-light me-3">Discard</button>
                                <button type="submit" id="kt_modal_new_card_submit" class="btn btn-info">
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