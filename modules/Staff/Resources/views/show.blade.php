@extends('admin.app')

@section('admin_title')
    {{ __('User Details') }}
@endsection

@section('content')
    <!--begin::Layout-->
    <div class="d-flex flex-column flex-lg-row mt-8">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">

            <!--begin::Card-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Summary-->


                    <!--begin::User Info-->
                    <div class="d-flex flex-center flex-column py-5">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            <img src="{{ asset('media') }}/avatars/300-6.jpg" alt="image">
                        </div>
                        <!--end::Avatar-->

                        <!--begin::Name-->
                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">
                            Emma Smith </a>
                        <!--end::Name-->

                        <!--begin::Position-->
                        <div class="mb-9">
                            <!--begin::Badge-->
                            <div class="badge badge-lg badge-light-primary d-inline">Administrator</div>
                            <!--begin::Badge-->
                        </div>
                        <!--end::Position-->

                        <!--begin::Info-->
                        <!--begin::Info heading-->
                        <div class="fw-bold mb-3">
                            Assigned Tickets

                            <span class="ms-2" ddata-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true"
                                data-bs-content="Number of support tickets assigned, closed and pending this week.">
                                <i class="ki-outline ki-information fs-7"></i> </span>
                        </div>
                        <!--end::Info heading-->

                        <div class="d-flex flex-wrap flex-center">
                            <!--begin::Stats-->
                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                <div class="fs-4 fw-bold text-gray-700">
                                    <span class="w-75px">243</span>
                                    <i class="ki-outline ki-arrow-up fs-3 text-success"></i>
                                </div>
                                <div class="fw-semibold text-muted">Total</div>
                            </div>
                            <!--end::Stats-->

                            <!--begin::Stats-->
                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
                                <div class="fs-4 fw-bold text-gray-700">
                                    <span class="w-50px">56</span>
                                    <i class="ki-outline ki-arrow-down fs-3 text-danger"></i>
                                </div>
                                <div class="fw-semibold text-muted">Solved</div>
                            </div>
                            <!--end::Stats-->

                            <!--begin::Stats-->
                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                <div class="fs-4 fw-bold text-gray-700">
                                    <span class="w-50px">188</span>
                                    <i class="ki-outline ki-arrow-up fs-3 text-success"></i>
                                </div>
                                <div class="fw-semibold text-muted">Open</div>
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User Info--> <!--end::Summary-->

                    <!--begin::Details toggle-->
                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details"
                            role="button" aria-expanded="false" aria-controls="kt_user_view_details">
                            Details
                            <span class="ms-2 rotate-180">
                                <i class="ki-outline ki-down fs-3"></i> </span>
                        </div>

                        <span data-bs-toggle="tooltip" data-bs-trigger="hover"
                            data-bs-original-title="Edit customer details" data-kt-initialized="1">
                            <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_update_details">
                                Edit
                            </a>
                        </span>
                    </div>
                    <!--end::Details toggle-->

                    <div class="separator"></div>

                    <!--begin::Details content-->
                    <div id="kt_user_view_details" class="collapse show">
                        <div class="pb-5 fs-6">
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Account ID</div>
                            <div class="text-gray-600">ID-45453423</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Email</div>
                            <div class="text-gray-600"><a href="#"
                                    class="text-gray-600 text-hover-primary">info@keenthemes.com</a></div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Address</div>
                            <div class="text-gray-600">101 Collin Street, <br>Melbourne 3000 VIC<br>Australia</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Language</div>
                            <div class="text-gray-600">English</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Last Login</div>
                            <div class="text-gray-600">19 Aug 2023, 8:43 pm</div>
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
                        <i class="ki-outline ki-design-1 fs-2tx text-primary me-4"></i> <!--end::Icon-->

                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1 ">
                            <!--begin::Content-->
                            <div class=" fw-semibold">

                                <div class="fs-6 text-gray-700 ">By connecting an account, you hereby agree to our <a
                                        href="#" class="me-1">privacy policy</a> and <a href="#">terms of
                                        use</a>.</div>
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
                                <img src="{{ asset('media') }}/svg/brand-logos/google-icon.svg" class="w-30px me-6"
                                    alt="">

                                <div class="d-flex flex-column">
                                    <a href="#" class="fs-5 text-gray-900 text-hover-primary fw-bold">Google</a>
                                    <div class="fs-6 fw-semibold text-muted">Plan properly your workflow</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <!--begin::Switch-->
                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input" name="google" type="checkbox" value="1"
                                        id="kt_modal_connected_accounts_google" checked="checked">
                                    <!--end::Input-->

                                    <!--begin::Label-->
                                    <span class="form-check-label fw-semibold text-muted"
                                        for="kt_modal_connected_accounts_google"></span>
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
                                <img src="{{ asset('media') }}/svg/brand-logos/github.svg" class="w-30px me-6"
                                    alt="">

                                <div class="d-flex flex-column">
                                    <a href="#" class="fs-5 text-gray-900 text-hover-primary fw-bold">Github</a>
                                    <div class="fs-6 fw-semibold text-muted">Keep eye on on your Repositories</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <!--begin::Switch-->
                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input" name="github" type="checkbox" value="1"
                                        id="kt_modal_connected_accounts_github" checked="checked">
                                    <!--end::Input-->

                                    <!--begin::Label-->
                                    <span class="form-check-label fw-semibold text-muted"
                                        for="kt_modal_connected_accounts_github"></span>
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
                                <img src="{{ asset('media') }}/svg/brand-logos/slack-icon.svg" class="w-30px me-6"
                                    alt="">

                                <div class="d-flex flex-column">
                                    <a href="#" class="fs-5 text-gray-900 text-hover-primary fw-bold">Slack</a>
                                    <div class="fs-6 fw-semibold text-muted">Integrate Projects Discussions</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <!--begin::Switch-->
                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input" name="slack" type="checkbox" value="1"
                                        id="kt_modal_connected_accounts_slack">
                                    <!--end::Input-->

                                    <!--begin::Label-->
                                    <span class="form-check-label fw-semibold text-muted"
                                        for="kt_modal_connected_accounts_slack"></span>
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
                    <button class="btn btn-sm  btn-light-primary">Save Changes</button>
                </div>
                <!--end::Card footer-->
            </div>
            <!--end::Connected Accounts-->
        </div>
        <!--end::Sidebar-->

        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8"
                role="tablist">
                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                        href="#kt_user_view_overview_tab" aria-selected="true" role="tab">Overview</a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                        href="#kt_user_view_overview_security" data-kt-initialized="1" aria-selected="false"
                        role="tab" tabindex="-1">Security</a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                        href="#kt_user_view_overview_events_and_logs_tab" aria-selected="false" role="tab"
                        tabindex="-1">Events &amp; Logs</a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item ms-auto">
                    <!--begin::Action menu-->
                    <a href="#" class="btn btn-info ps-7" data-kt-menu-trigger="click"
                        data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        Actions
                        <i class="ki-outline ki-down fs-2 me-0"></i> </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6"
                        data-kt-menu="true" style="">
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">
                                Payments
                            </div>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5">
                                Create invoice
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link flex-stack px-5">
                                Create payments

                                <span class="ms-2" data-bs-toggle="tooltip"
                                    aria-label="Specify a target name for future usage and reference"
                                    data-bs-original-title="Specify a target name for future usage and reference"
                                    data-kt-initialized="1">
                                    <i class="ki-outline ki-information fs-7"></i> </span>
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">
                            <a href="#" class="menu-link px-5">
                                <span class="menu-title">Subscription</span>
                                <span class="menu-arrow"></span>
                            </a>

                            <!--begin::Menu sub-->
                            <div class="menu-sub menu-sub-dropdown w-175px py-4" style="">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-5">
                                        Apps
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-5">
                                        Billing
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-5">
                                        Statements
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu separator-->
                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content px-3">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input w-30px h-20px" type="checkbox" value=""
                                                name="notifications" checked="" id="kt_user_menu_notifications">
                                            <span class="form-check-label text-muted fs-6"
                                                for="kt_user_menu_notifications">
                                                Notifications
                                            </span>
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
                            <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">
                                Account
                            </div>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5">
                                Reports
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-5 my-1">
                            <a href="#" class="menu-link px-5">
                                Account Settings
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link text-danger px-5">
                                Delete customer
                            </a>
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
                <div class="tab-pane fade active show" id="kt_user_view_overview_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">User's Schedule</h2>

                                <div class="fs-6 fw-semibold text-muted">2 upcoming meetings</div>
                            </div>
                            <!--end::Card title-->

                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-light-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_add_schedule">
                                    <i class="ki-outline ki-brush fs-3"></i> Add Schedule
                                </button>
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body p-9 pt-4">
                            <!--begin::Dates-->
                            <ul class="nav nav-pills d-flex flex-nowrap hover-scroll-x py-2" role="tablist">

                                <!--begin::Date-->
                                <li class="nav-item me-1" role="presentation">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary "
                                        data-bs-toggle="tab" href="#kt_schedule_day_0" aria-selected="false"
                                        tabindex="-1" role="tab">

                                        <span class="opacity-50 fs-7 fw-semibold">Su</span>
                                        <span class="fs-6 fw-bolder">21</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1" role="presentation">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary active"
                                        data-bs-toggle="tab" href="#kt_schedule_day_1" aria-selected="true"
                                        role="tab">

                                        <span class="opacity-50 fs-7 fw-semibold">Mo</span>
                                        <span class="fs-6 fw-bolder">22</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1" role="presentation">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary "
                                        data-bs-toggle="tab" href="#kt_schedule_day_2" aria-selected="false"
                                        tabindex="-1" role="tab">

                                        <span class="opacity-50 fs-7 fw-semibold">Tu</span>
                                        <span class="fs-6 fw-bolder">23</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1" role="presentation">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary "
                                        data-bs-toggle="tab" href="#kt_schedule_day_3" aria-selected="false"
                                        tabindex="-1" role="tab">

                                        <span class="opacity-50 fs-7 fw-semibold">We</span>
                                        <span class="fs-6 fw-bolder">24</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1" role="presentation">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary "
                                        data-bs-toggle="tab" href="#kt_schedule_day_4" aria-selected="false"
                                        tabindex="-1" role="tab">

                                        <span class="opacity-50 fs-7 fw-semibold">Th</span>
                                        <span class="fs-6 fw-bolder">25</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1" role="presentation">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary "
                                        data-bs-toggle="tab" href="#kt_schedule_day_5" aria-selected="false"
                                        tabindex="-1" role="tab">

                                        <span class="opacity-50 fs-7 fw-semibold">Fr</span>
                                        <span class="fs-6 fw-bolder">26</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1" role="presentation">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary "
                                        data-bs-toggle="tab" href="#kt_schedule_day_6" aria-selected="false"
                                        tabindex="-1" role="tab">

                                        <span class="opacity-50 fs-7 fw-semibold">Sa</span>
                                        <span class="fs-6 fw-bolder">27</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1" role="presentation">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary "
                                        data-bs-toggle="tab" href="#kt_schedule_day_7" aria-selected="false"
                                        tabindex="-1" role="tab">

                                        <span class="opacity-50 fs-7 fw-semibold">Su</span>
                                        <span class="fs-6 fw-bolder">28</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1" role="presentation">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary "
                                        data-bs-toggle="tab" href="#kt_schedule_day_8" aria-selected="false"
                                        tabindex="-1" role="tab">

                                        <span class="opacity-50 fs-7 fw-semibold">Mo</span>
                                        <span class="fs-6 fw-bolder">29</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1" role="presentation">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary "
                                        data-bs-toggle="tab" href="#kt_schedule_day_9" aria-selected="false"
                                        tabindex="-1" role="tab">

                                        <span class="opacity-50 fs-7 fw-semibold">Tu</span>
                                        <span class="fs-6 fw-bolder">30</span>
                                    </a>
                                </li>
                                <!--end::Date-->

                                <!--begin::Date-->
                                <li class="nav-item me-1" role="presentation">
                                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary "
                                        data-bs-toggle="tab" href="#kt_schedule_day_10" aria-selected="false"
                                        tabindex="-1" role="tab">

                                        <span class="opacity-50 fs-7 fw-semibold">We</span>
                                        <span class="fs-6 fw-bolder">31</span>
                                    </a>
                                </li>
                                <!--end::Date-->
                            </ul>
                            <!--end::Dates-->

                            <!--begin::Tab Content-->
                            <div class="tab-content">
                                <!--begin::Day-->
                                <div id="kt_schedule_day_0" class="tab-pane fade show " role="tabpanel">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Dashboard UI/UX Design Review </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Yannis Gloverson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Sales Pitch Proposal </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Sean Bean</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Weekly Team Stand-Up </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Bob Harris</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Sales Pitch Proposal </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Walter White</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_1" class="tab-pane fade show active" role="tabpanel">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Dashboard UI/UX Design Review </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Michael Walters</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Sales Pitch Proposal </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Caleb Donaldson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Development Team Capacity Review </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">David Stevenson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                12:00 - 13:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Lunch &amp; Learn Catch Up </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Terry Robins</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_2" class="tab-pane fade show " role="tabpanel">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Team Backlog Grooming Session </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Michael Walters</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                12:00 - 13:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Sales Pitch Proposal </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Kendell Trevor</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Project Review &amp; Testing </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Terry Robins</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_3" class="tab-pane fade show " role="tabpanel">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                16:30 - 17:30
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Creative Content Initiative </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Naomi Hayabusa</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Marketing Campaign Discussion </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Kendell Trevor</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Lunch &amp; Learn Catch Up </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Kendell Trevor</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Project Review &amp; Testing </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Naomi Hayabusa</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Committee Review Approvals </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Karina Clarke</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_4" class="tab-pane fade show " role="tabpanel">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Sales Pitch Proposal </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Karina Clarke</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Team Backlog Grooming Session </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Caleb Donaldson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                9 Degree Project Estimation Meeting </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Peter Marcus</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                12:00 - 13:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Weekly Team Stand-Up </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Peter Marcus</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_5" class="tab-pane fade show " role="tabpanel">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Creative Content Initiative </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Yannis Gloverson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Dashboard UI/UX Design Review </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Peter Marcus</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Creative Content Initiative </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Sean Bean</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_6" class="tab-pane fade show " role="tabpanel">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Development Team Capacity Review </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Sean Bean</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Committee Review Approvals </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Karina Clarke</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                14:30 - 15:30
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Team Backlog Grooming Session </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">David Stevenson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Sales Pitch Proposal </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Karina Clarke</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Creative Content Initiative </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Sean Bean</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_7" class="tab-pane fade show " role="tabpanel">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                14:30 - 15:30
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Committee Review Approvals </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Peter Marcus</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                14:30 - 15:30
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Weekly Team Stand-Up </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Naomi Hayabusa</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                16:30 - 17:30
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Marketing Campaign Discussion </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Yannis Gloverson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Weekly Team Stand-Up </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Yannis Gloverson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Marketing Campaign Discussion </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Caleb Donaldson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_8" class="tab-pane fade show " role="tabpanel">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Creative Content Initiative </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Terry Robins</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                12:00 - 13:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Development Team Capacity Review </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Caleb Donaldson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Sales Pitch Proposal </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Terry Robins</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                16:30 - 17:30
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Team Backlog Grooming Session </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Sean Bean</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_9" class="tab-pane fade show " role="tabpanel">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Dashboard UI/UX Design Review </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Naomi Hayabusa</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                13:00 - 14:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Committee Review Approvals </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Naomi Hayabusa</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Creative Content Initiative </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">David Stevenson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Sales Pitch Proposal </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Mark Randall</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                9 Degree Project Estimation Meeting </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Mark Randall</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                                <!--begin::Day-->
                                <div id="kt_schedule_day_10" class="tab-pane fade show " role="tabpanel">
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                9 Degree Project Estimation Meeting </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Kendell Trevor</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                16:30 - 17:30
                                                <span class="fs-7 text-muted text-uppercase">
                                                    pm </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Marketing Campaign Discussion </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Caleb Donaldson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                9:00 - 10:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Dashboard UI/UX Design Review </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Bob Harris</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                11:00 - 11:45
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Marketing Campaign Discussion </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">Naomi Hayabusa</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                    <!--begin::Time-->
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <!--begin::Bar-->
                                        <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                        </div>
                                        <!--end::Bar-->

                                        <!--begin::Info-->
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Time-->
                                            <div class="fs-7 mb-1">
                                                10:00 - 11:00
                                                <span class="fs-7 text-muted text-uppercase">
                                                    am </span>
                                            </div>
                                            <!--end::Time-->

                                            <!--begin::Title-->
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                Team Backlog Grooming Session </a>
                                            <!--end::Title-->

                                            <!--begin::User-->
                                            <div class="fs-7 text-muted">
                                                Lead by <a href="#">David Stevenson</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Time-->
                                </div>
                                <!--end::Day-->
                            </div>
                            <!--end::Tab Content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->

                    <!--begin::Tasks-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">User's Tasks</h2>

                                <div class="fs-6 fw-semibold text-muted">Total 25 tasks in backlog</div>
                            </div>
                            <!--end::Card title-->

                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-light-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_add_task">
                                    <i class="ki-outline ki-add-files fs-3"></i> Add Task
                                </button>
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-column">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->

                                <!--begin::Details-->
                                <div class="fw-semibold ms-5">
                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Create
                                        FureStibe branding logo</a>

                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        Due in 1 day <a href="#">Karina Clark</a>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->

                                <!--begin::Menu-->
                                <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                    <i class="ki-outline ki-setting-3 fs-3"></i> </button>

                                <!--begin::Task menu-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                    data-kt-menu-id="kt-users-tasks">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-gray-900 fw-bold">Update Status</div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Form-->
                                    <form class="form px-7 py-5 fv-plugins-bootstrap5 fv-plugins-framework"
                                        data-kt-menu-id="kt-users-tasks-form">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10 fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="form-label fs-6 fw-semibold">Status:</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <select class="form-select form-select-solid select2-hidden-accessible"
                                                name="task_status" data-kt-select2="true"
                                                data-placeholder="Select option" data-allow-clear="true"
                                                data-hide-search="true" data-select2-id="select2-data-7-nbry"
                                                tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                                <option data-select2-id="select2-data-9-laef"></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="3">In Process</option>
                                                <option value="4">Rejected</option>
                                            </select><span class="select2 select2-container select2-container--bootstrap5"
                                                dir="ltr" data-select2-id="select2-data-8-1cmm"
                                                style="width: 100%;"><span class="selection"><span
                                                        class="select2-selection select2-selection--single form-select form-select-solid"
                                                        role="combobox" aria-haspopup="true" aria-expanded="false"
                                                        tabindex="0" aria-disabled="false"
                                                        aria-labelledby="select2-task_status-3z-container"
                                                        aria-controls="select2-task_status-3z-container"><span
                                                            class="select2-selection__rendered"
                                                            id="select2-task_status-3z-container" role="textbox"
                                                            aria-readonly="true" title="Select option"><span
                                                                class="select2-selection__placeholder">Select
                                                                option</span></span><span class="select2-selection__arrow"
                                                            role="presentation"><b
                                                                role="presentation"></b></span></span></span><span
                                                    class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            <!--end::Input-->
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="button"
                                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                data-kt-users-update-task-status="reset">Reset</button>

                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-kt-users-update-task-status="submit">
                                                <span class="indicator-label">
                                                    Apply
                                                </span>
                                                <span class="indicator-progress">
                                                    Please wait... <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Task menu--> <!--end::Menu-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->

                                <!--begin::Details-->
                                <div class="fw-semibold ms-5">
                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Schedule a
                                        meeting with FireBear CTO John</a>

                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        Due in 3 days <a href="#">Rober Doe</a>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->

                                <!--begin::Menu-->
                                <button type="button"
                                    class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                    <i class="ki-outline ki-setting-3 fs-3"></i> </button>

                                <!--begin::Task menu-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                    data-kt-menu-id="kt-users-tasks">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-gray-900 fw-bold">Update Status</div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Form-->
                                    <form class="form px-7 py-5 fv-plugins-bootstrap5 fv-plugins-framework"
                                        data-kt-menu-id="kt-users-tasks-form">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10 fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="form-label fs-6 fw-semibold">Status:</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <select class="form-select form-select-solid select2-hidden-accessible"
                                                name="task_status" data-kt-select2="true"
                                                data-placeholder="Select option" data-allow-clear="true"
                                                data-hide-search="true" data-select2-id="select2-data-10-i212"
                                                tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                                <option data-select2-id="select2-data-12-1yt8"></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="3">In Process</option>
                                                <option value="4">Rejected</option>
                                            </select><span class="select2 select2-container select2-container--bootstrap5"
                                                dir="ltr" data-select2-id="select2-data-11-bi2n"
                                                style="width: 100%;"><span class="selection"><span
                                                        class="select2-selection select2-selection--single form-select form-select-solid"
                                                        role="combobox" aria-haspopup="true" aria-expanded="false"
                                                        tabindex="0" aria-disabled="false"
                                                        aria-labelledby="select2-task_status-8v-container"
                                                        aria-controls="select2-task_status-8v-container"><span
                                                            class="select2-selection__rendered"
                                                            id="select2-task_status-8v-container" role="textbox"
                                                            aria-readonly="true" title="Select option"><span
                                                                class="select2-selection__placeholder">Select
                                                                option</span></span><span class="select2-selection__arrow"
                                                            role="presentation"><b
                                                                role="presentation"></b></span></span></span><span
                                                    class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            <!--end::Input-->
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="button"
                                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                data-kt-users-update-task-status="reset">Reset</button>

                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-kt-users-update-task-status="submit">
                                                <span class="indicator-label">
                                                    Apply
                                                </span>
                                                <span class="indicator-progress">
                                                    Please wait... <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Task menu--> <!--end::Menu-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->

                                <!--begin::Details-->
                                <div class="fw-semibold ms-5">
                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">9 Degree
                                        Project Estimation</a>

                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        Due in 1 week <a href="#">Neil Owen</a>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->

                                <!--begin::Menu-->
                                <button type="button"
                                    class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                    <i class="ki-outline ki-setting-3 fs-3"></i> </button>

                                <!--begin::Task menu-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                    data-kt-menu-id="kt-users-tasks">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-gray-900 fw-bold">Update Status</div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Form-->
                                    <form class="form px-7 py-5 fv-plugins-bootstrap5 fv-plugins-framework"
                                        data-kt-menu-id="kt-users-tasks-form">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10 fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="form-label fs-6 fw-semibold">Status:</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <select class="form-select form-select-solid select2-hidden-accessible"
                                                name="task_status" data-kt-select2="true"
                                                data-placeholder="Select option" data-allow-clear="true"
                                                data-hide-search="true" data-select2-id="select2-data-13-iqzg"
                                                tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                                <option data-select2-id="select2-data-15-1nnj"></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="3">In Process</option>
                                                <option value="4">Rejected</option>
                                            </select><span class="select2 select2-container select2-container--bootstrap5"
                                                dir="ltr" data-select2-id="select2-data-14-zssk"
                                                style="width: 100%;"><span class="selection"><span
                                                        class="select2-selection select2-selection--single form-select form-select-solid"
                                                        role="combobox" aria-haspopup="true" aria-expanded="false"
                                                        tabindex="0" aria-disabled="false"
                                                        aria-labelledby="select2-task_status-yh-container"
                                                        aria-controls="select2-task_status-yh-container"><span
                                                            class="select2-selection__rendered"
                                                            id="select2-task_status-yh-container" role="textbox"
                                                            aria-readonly="true" title="Select option"><span
                                                                class="select2-selection__placeholder">Select
                                                                option</span></span><span class="select2-selection__arrow"
                                                            role="presentation"><b
                                                                role="presentation"></b></span></span></span><span
                                                    class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            <!--end::Input-->
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="button"
                                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                data-kt-users-update-task-status="reset">Reset</button>

                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-kt-users-update-task-status="submit">
                                                <span class="indicator-label">
                                                    Apply
                                                </span>
                                                <span class="indicator-progress">
                                                    Please wait... <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Task menu--> <!--end::Menu-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->

                                <!--begin::Details-->
                                <div class="fw-semibold ms-5">
                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Dashboard UI
                                        &amp; UX for Leafr CRM</a>

                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        Due in 1 week <a href="#">Olivia Wild</a>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->

                                <!--begin::Menu-->
                                <button type="button"
                                    class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                    <i class="ki-outline ki-setting-3 fs-3"></i> </button>

                                <!--begin::Task menu-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                    data-kt-menu-id="kt-users-tasks">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-gray-900 fw-bold">Update Status</div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Form-->
                                    <form class="form px-7 py-5 fv-plugins-bootstrap5 fv-plugins-framework"
                                        data-kt-menu-id="kt-users-tasks-form">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10 fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="form-label fs-6 fw-semibold">Status:</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <select class="form-select form-select-solid select2-hidden-accessible"
                                                name="task_status" data-kt-select2="true"
                                                data-placeholder="Select option" data-allow-clear="true"
                                                data-hide-search="true" data-select2-id="select2-data-16-h1dj"
                                                tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                                <option data-select2-id="select2-data-18-xjcd"></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="3">In Process</option>
                                                <option value="4">Rejected</option>
                                            </select><span class="select2 select2-container select2-container--bootstrap5"
                                                dir="ltr" data-select2-id="select2-data-17-9grm"
                                                style="width: 100%;"><span class="selection"><span
                                                        class="select2-selection select2-selection--single form-select form-select-solid"
                                                        role="combobox" aria-haspopup="true" aria-expanded="false"
                                                        tabindex="0" aria-disabled="false"
                                                        aria-labelledby="select2-task_status-qf-container"
                                                        aria-controls="select2-task_status-qf-container"><span
                                                            class="select2-selection__rendered"
                                                            id="select2-task_status-qf-container" role="textbox"
                                                            aria-readonly="true" title="Select option"><span
                                                                class="select2-selection__placeholder">Select
                                                                option</span></span><span class="select2-selection__arrow"
                                                            role="presentation"><b
                                                                role="presentation"></b></span></span></span><span
                                                    class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            <!--end::Input-->
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="button"
                                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                data-kt-users-update-task-status="reset">Reset</button>

                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-kt-users-update-task-status="submit">
                                                <span class="indicator-label">
                                                    Apply
                                                </span>
                                                <span class="indicator-progress">
                                                    Please wait... <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Task menu--> <!--end::Menu-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative ">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->

                                <!--begin::Details-->
                                <div class="fw-semibold ms-5">
                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Mivy App
                                        R&amp;D, Meeting with clients</a>

                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        Due in 2 weeks <a href="#">Sean Bean</a>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->

                                <!--begin::Menu-->
                                <button type="button"
                                    class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                    <i class="ki-outline ki-setting-3 fs-3"></i> </button>

                                <!--begin::Task menu-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                    data-kt-menu-id="kt-users-tasks">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-gray-900 fw-bold">Update Status</div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Form-->
                                    <form class="form px-7 py-5 fv-plugins-bootstrap5 fv-plugins-framework"
                                        data-kt-menu-id="kt-users-tasks-form">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10 fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="form-label fs-6 fw-semibold">Status:</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <select class="form-select form-select-solid select2-hidden-accessible"
                                                name="task_status" data-kt-select2="true"
                                                data-placeholder="Select option" data-allow-clear="true"
                                                data-hide-search="true" data-select2-id="select2-data-19-e1a8"
                                                tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                                <option data-select2-id="select2-data-21-x8r1"></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="3">In Process</option>
                                                <option value="4">Rejected</option>
                                            </select><span class="select2 select2-container select2-container--bootstrap5"
                                                dir="ltr" data-select2-id="select2-data-20-5p3h"
                                                style="width: 100%;"><span class="selection"><span
                                                        class="select2-selection select2-selection--single form-select form-select-solid"
                                                        role="combobox" aria-haspopup="true" aria-expanded="false"
                                                        tabindex="0" aria-disabled="false"
                                                        aria-labelledby="select2-task_status-jq-container"
                                                        aria-controls="select2-task_status-jq-container"><span
                                                            class="select2-selection__rendered"
                                                            id="select2-task_status-jq-container" role="textbox"
                                                            aria-readonly="true" title="Select option"><span
                                                                class="select2-selection__placeholder">Select
                                                                option</span></span><span class="select2-selection__arrow"
                                                            role="presentation"><b
                                                                role="presentation"></b></span></span></span><span
                                                    class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            <!--end::Input-->
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="button"
                                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                data-kt-users-update-task-status="reset">Reset</button>

                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-kt-users-update-task-status="submit">
                                                <span class="indicator-label">
                                                    Apply
                                                </span>
                                                <span class="indicator-progress">
                                                    Please wait... <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Task menu--> <!--end::Menu-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Tasks-->
                </div>
                <!--end:::Tab pane-->

                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_user_view_overview_security" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Profile</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed gy-5"
                                    id="kt_table_users_login_session">
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        <tr>
                                            <td>Email</td>
                                            <td>smith@kpmg.com</td>
                                            <td class="text-end">
                                                <button type="button"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_email">
                                                    <i class="ki-outline ki-pencil fs-3"></i> </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Password</td>
                                            <td>******</td>
                                            <td class="text-end">
                                                <button type="button"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_password">
                                                    <i class="ki-outline ki-pencil fs-3"></i> </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Role</td>
                                            <td>Administrator</td>
                                            <td class="text-end">
                                                <button type="button"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                                                    <i class="ki-outline ki-pencil fs-3"></i> </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
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
                            <div class="card-title flex-column">
                                <h2 class="mb-1">Two Step Authentication</h2>

                                <div class="fs-6 fw-semibold text-muted">Keep your account extra secure with a second
                                    authentication step.</div>
                            </div>
                            <!--end::Card title-->

                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Add-->
                                <button type="button" class="btn btn-light-primary btn-sm"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-outline ki-fingerprint-scanning fs-3"></i> Add Authentication Step
                                </button>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-6 w-200px py-4"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_add_auth_app">
                                            Use authenticator app
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_add_one_time_password">
                                            Enable one-time password
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                <!--end::Add-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pb-5">
                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Content-->
                                <div class="d-flex flex-column">
                                    <span>SMS</span>
                                    <span class="text-muted fs-6">+61 412 345 678</span>
                                </div>
                                <!--end::Content-->

                                <!--begin::Action-->
                                <div class="d-flex justify-content-end align-items-center">
                                    <!--begin::Button-->
                                    <button type="button"
                                        class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto me-5"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_add_one_time_password">
                                        <i class="ki-outline ki-pencil fs-3"></i> </button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <button type="button"
                                        class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                        id="kt_users_delete_two_step">
                                        <i class="ki-outline ki-trash fs-3"></i> </button>
                                    <!--end::Button-->
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Item-->

                            <!--begin:Separator-->
                            <div class="separator separator-dashed my-5"></div>
                            <!--end:Separator-->

                            <!--begin::Disclaimer-->
                            <div class="text-gray-600">
                                If you lose your mobile device or security key, you can <a href="#"
                                    class="me-1">generate a backup code</a> to sign in to your account.
                            </div>
                            <!--end::Disclaimer-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->

                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2>Email Notifications</h2>

                                <div class="fs-6 fw-semibold text-muted">Choose what messages you’d like to receive for
                                    each of your accounts.</div>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Form-->
                            <form class="form" id="kt_users_email_notification_form">
                                <!--begin::Item-->
                                <div class="d-flex">
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="email_notification_0"
                                            type="checkbox" value="0" id="kt_modal_update_email_notification_0"
                                            checked="checked">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_0">
                                            <div class="fw-bold">Successful Payments</div>
                                            <div class="text-gray-600">Receive a notification for every successful
                                                payment.</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->
                                </div>
                                <!--end::Item-->

                                <div class="separator separator-dashed my-5"></div> <!--begin::Item-->
                                <div class="d-flex">
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="email_notification_1"
                                            type="checkbox" value="1" id="kt_modal_update_email_notification_1">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_1">
                                            <div class="fw-bold">Payouts</div>
                                            <div class="text-gray-600">Receive a notification for every initiated payout.
                                            </div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->
                                </div>
                                <!--end::Item-->

                                <div class="separator separator-dashed my-5"></div> <!--begin::Item-->
                                <div class="d-flex">
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="email_notification_2"
                                            type="checkbox" value="2" id="kt_modal_update_email_notification_2">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_2">
                                            <div class="fw-bold">Application fees</div>
                                            <div class="text-gray-600">Receive a notification each time you collect a fee
                                                from an account.</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->
                                </div>
                                <!--end::Item-->

                                <div class="separator separator-dashed my-5"></div> <!--begin::Item-->
                                <div class="d-flex">
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="email_notification_3"
                                            type="checkbox" value="3" id="kt_modal_update_email_notification_3"
                                            checked="checked">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_3">
                                            <div class="fw-bold">Disputes</div>
                                            <div class="text-gray-600">Receive a notification if a payment is disputed by
                                                a customer and for dispute resolutions.</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->
                                </div>
                                <!--end::Item-->

                                <div class="separator separator-dashed my-5"></div> <!--begin::Item-->
                                <div class="d-flex">
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="email_notification_4"
                                            type="checkbox" value="4" id="kt_modal_update_email_notification_4"
                                            checked="checked">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_4">
                                            <div class="fw-bold">Payment reviews</div>
                                            <div class="text-gray-600">Receive a notification if a payment is marked as an
                                                elevated risk.</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->
                                </div>
                                <!--end::Item-->

                                <div class="separator separator-dashed my-5"></div> <!--begin::Item-->
                                <div class="d-flex">
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="email_notification_5"
                                            type="checkbox" value="5" id="kt_modal_update_email_notification_5">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_5">
                                            <div class="fw-bold">Mentions</div>
                                            <div class="text-gray-600">Receive a notification if a teammate mentions you
                                                in a note.</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->
                                </div>
                                <!--end::Item-->

                                <div class="separator separator-dashed my-5"></div> <!--begin::Item-->
                                <div class="d-flex">
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="email_notification_6"
                                            type="checkbox" value="6" id="kt_modal_update_email_notification_6">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_6">
                                            <div class="fw-bold">Invoice Mispayments</div>
                                            <div class="text-gray-600">Receive a notification if a customer sends an
                                                incorrect amount to pay their invoice.</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->
                                </div>
                                <!--end::Item-->

                                <div class="separator separator-dashed my-5"></div> <!--begin::Item-->
                                <div class="d-flex">
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="email_notification_7"
                                            type="checkbox" value="7" id="kt_modal_update_email_notification_7">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_7">
                                            <div class="fw-bold">Webhooks</div>
                                            <div class="text-gray-600">Receive notifications about consistently failing
                                                webhook endpoints.</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->
                                </div>
                                <!--end::Item-->

                                <div class="separator separator-dashed my-5"></div> <!--begin::Item-->
                                <div class="d-flex">
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="email_notification_8"
                                            type="checkbox" value="8" id="kt_modal_update_email_notification_8">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_8">
                                            <div class="fw-bold">Trial</div>
                                            <div class="text-gray-600">Receive helpful tips when you try out our products.
                                            </div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->
                                </div>
                                <!--end::Item-->


                                <!--begin::Action buttons-->
                                <div class="d-flex justify-content-end align-items-center mt-12">
                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-light me-5"
                                        id="kt_users_email_notification_cancel">
                                        Cancel
                                    </button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-info"
                                        id="kt_users_email_notification_submit">
                                        <span class="indicator-label">
                                            Save
                                        </span>
                                        <span class="indicator-progress">
                                            Please wait... <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                                <!--begin::Action buttons-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Card body-->

                        <!--begin::Card footer-->

                        <!--end::Card footer-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end:::Tab pane-->

                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_user_view_overview_events_and_logs_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Login Sessions</h2>
                            </div>
                            <!--end::Card title-->

                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Filter-->
                                <button type="button" class="btn btn-sm btn-flex btn-light-primary"
                                    id="kt_modal_sign_out_sesions">
                                    <i class="ki-outline ki-entrance-right fs-3"></i> Sign out all sessions
                                </button>
                                <!--end::Filter-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed gy-5"
                                    id="kt_table_users_login_session">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th class="min-w-100px">Location</th>
                                            <th>Device</th>
                                            <th>IP Address</th>
                                            <th class="min-w-125px">Time</th>
                                            <th class="min-w-70px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        <tr>
                                            <td>
                                                Australia </td>
                                            <td>
                                                Chome - Windows </td>
                                            <td>
                                                207.32.46.275 </td>
                                            <td>
                                                23 seconds ago </td>
                                            <td>
                                                Current session </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Australia </td>
                                            <td>
                                                Safari - iOS </td>
                                            <td>
                                                207.41.40.184 </td>
                                            <td>
                                                3 days ago </td>
                                            <td>
                                                <a href="#" data-kt-users-sign-out="single_user">Sign out</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Australia </td>
                                            <td>
                                                Chrome - Windows </td>
                                            <td>
                                                207.27.49.344 </td>
                                            <td>
                                                last week </td>
                                            <td>
                                                Expired </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
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
                                <h2>Logs</h2>
                            </div>
                            <!--end::Card title-->

                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Button-->
                                <button type="button" class="btn btn-sm btn-light-primary">
                                    <i class="ki-outline ki-cloud-download fs-3"></i>
                                    Download Report
                                </button>
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
                                <table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5"
                                    id="kt_table_users_logs">
                                    <tbody>
                                        <tr>
                                            <td class="min-w-70px">
                                                <div class="badge badge-light-danger">500 ERR</div>
                                            </td>
                                            <td>
                                                POST /v1/invoice/in_1602_3613/invalid </td>
                                            <td class="pe-0 text-end min-w-200px">
                                                25 Oct 2023, 11:30 am </td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-70px">
                                                <div class="badge badge-light-success">200 OK</div>
                                            </td>
                                            <td>
                                                POST /v1/invoices/in_3887_2828/payment </td>
                                            <td class="pe-0 text-end min-w-200px">
                                                20 Jun 2023, 11:30 am </td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-70px">
                                                <div class="badge badge-light-warning">404 WRN</div>
                                            </td>
                                            <td>
                                                POST /v1/customer/c_658f81b359093/not_found </td>
                                            <td class="pe-0 text-end min-w-200px">
                                                19 Aug 2023, 5:30 pm </td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-70px">
                                                <div class="badge badge-light-success">200 OK</div>
                                            </td>
                                            <td>
                                                POST /v1/invoices/in_5055_6280/payment </td>
                                            <td class="pe-0 text-end min-w-200px">
                                                20 Jun 2023, 2:40 pm </td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-70px">
                                                <div class="badge badge-light-warning">404 WRN</div>
                                            </td>
                                            <td>
                                                POST /v1/customer/c_658f81b359092/not_found </td>
                                            <td class="pe-0 text-end min-w-200px">
                                                19 Aug 2023, 11:05 am </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
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
                                    <i class="ki-outline ki-cloud-download fs-3"></i>
                                    Download Report
                                </button>
                                <!--end::Button-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body py-0">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-5"
                                id="kt_table_customers_events">
                                <tbody>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Max
                                                Smith</a> has made payment to <a href="#"
                                                class="fw-bold text-gray-900 text-hover-primary">#SDK-45670</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            25 Oct 2023, 10:10 pm </td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Invoice <a href="#"
                                                class="fw-bold text-gray-900 text-hover-primary me-1">#KIO-45656</a>
                                            status has changed from <span class="badge badge-light-succees me-1">In
                                                Transit</span> to <span class="badge badge-light-success">Approved</span>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            22 Sep 2023, 6:05 pm </td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Invoice <a href="#"
                                                class="fw-bold text-gray-900 text-hover-primary me-1">#DER-45645</a>
                                            status has changed from <span class="badge badge-light-info me-1">In
                                                Progress</span> to <span class="badge badge-light-info">In Transit</span>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            10 Mar 2023, 9:23 pm </td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Emma
                                                Smith</a> has made payment to <a href="#"
                                                class="fw-bold text-gray-900 text-hover-primary">#XRS-45670</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            19 Aug 2023, 11:30 am </td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Melody
                                                Macy</a> has made payment to <a href="#"
                                                class="fw-bold text-gray-900 text-hover-primary">#XRS-45670</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            25 Oct 2023, 2:40 pm </td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Emma
                                                Smith</a> has made payment to <a href="#"
                                                class="fw-bold text-gray-900 text-hover-primary">#XRS-45670</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            25 Jul 2023, 11:30 am </td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Invoice <a href="#"
                                                class="fw-bold text-gray-900 text-hover-primary me-1">#LOP-45640</a> has
                                            been <span class="badge badge-light-danger">Declined</span>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            10 Mar 2023, 5:30 pm </td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Brian
                                                Cox</a> has made payment to <a href="#"
                                                class="fw-bold text-gray-900 text-hover-primary">#OLP-45690</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            20 Jun 2023, 11:05 am </td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Brian
                                                Cox</a> has made payment to <a href="#"
                                                class="fw-bold text-gray-900 text-hover-primary">#OLP-45690</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            15 Apr 2023, 11:30 am </td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Invoice <a href="#"
                                                class="fw-bold text-gray-900 text-hover-primary me-1">#WER-45670</a> is
                                            <span class="badge badge-light-info">In Progress</span>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            19 Aug 2023, 5:20 pm </td>
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
            </div>
            <!--end:::Tab content-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Layout-->

    <!--begin::Modals-->
    <!--begin::Modal - Update user details-->
    <div class="modal fade" id="kt_modal_update_details" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                <form class="form" action="#" id="kt_modal_update_user_form">
                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_modal_update_user_header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Update User Details</h2>
                        <!--end::Modal title-->

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->

                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                            data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_user_header"
                            data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px"
                            style="max-height: 255px;">
                            <!--begin::User toggle-->
                            <div class="fw-bolder fs-3 rotate collapsible mb-7" data-bs-toggle="collapse"
                                href="#kt_modal_update_user_user_info" role="button" aria-expanded="false"
                                aria-controls="kt_modal_update_user_user_info">
                                User Information
                                <span class="ms-2 rotate-180">
                                    <i class="ki-outline ki-down fs-3"></i> </span>
                            </div>
                            <!--end::User toggle-->

                            <!--begin::User form-->
                            <div id="kt_modal_update_user_user_info" class="collapse show">
                                <!--begin::Input group-->
                                <div class="mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span>Update Avatar</span>

                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            aria-label="Allowed file types: png, jpg, jpeg."
                                            data-bs-original-title="Allowed file types: png, jpg, jpeg."
                                            data-kt-initialized="1">
                                            <i class="ki-outline ki-information fs-7"></i> </span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Image input wrapper-->
                                    <div class="mt-1">

                                        <!--begin::Image placeholder-->
                                        <style>
                                            .image-input-placeholder {
                                                background-image: url('{{ asset('media') }}/svg/avatars/blank.svg');
                                            }

                                            [data-bs-theme="dark"] .image-input-placeholder {
                                                background-image: url('{{ asset('media') }}/svg/avatars/blank-dark.svg');
                                            }
                                        </style>
                                        <!--end::Image placeholder-->
                                        <!--begin::Image input-->
                                        <div class="image-input image-input-outline image-input-placeholder"
                                            data-kt-image-input="true">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-125px h-125px"
                                                style="background-image: url({{ asset('media') }}/avatars/300-6.jpg">
                                            </div>
                                            <!--end::Preview existing avatar-->

                                            <!--begin::Edit-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                aria-label="Change avatar" data-bs-original-title="Change avatar"
                                                data-kt-initialized="1">
                                                <i class="ki-outline ki-pencil fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                                <input type="hidden" name="avatar_remove">
                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Edit-->

                                            <!--begin::Cancel-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                aria-label="Cancel avatar" data-bs-original-title="Cancel avatar"
                                                data-kt-initialized="1">
                                                <i class="ki-outline ki-cross fs-2"></i> </span>
                                            <!--end::Cancel-->

                                            <!--begin::Remove-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                aria-label="Remove avatar" data-bs-original-title="Remove avatar"
                                                data-kt-initialized="1">
                                                <i class="ki-outline ki-cross fs-2"></i> </span>
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
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="name" value="Emma Smith">
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span>Email</span>

                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            aria-label="Email address must be active"
                                            data-bs-original-title="Email address must be active"
                                            data-kt-initialized="1">
                                            <i class="ki-outline ki-information fs-7"></i> </span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input type="email" class="form-control form-control-solid" placeholder=""
                                        name="email" value="smith@kpmg.com"
                                        style="background-size: auto, 25px; background-image: none, url(&quot;data:image/svg+xml;utf8,<svg width='26' height='28' viewBox='0 0 26 28' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M23.8958 6.1084L13.7365 0.299712C13.3797 0.103027 12.98 0 12.5739 0C12.1678 0 11.7682 0.103027 11.4113 0.299712L1.21632 6.1084C0.848276 6.31893 0.54181 6.62473 0.328154 6.99462C0.114498 7.36452 0.00129162 7.78529 7.13608e-05 8.21405V19.7951C-0.00323007 20.2248 0.108078 20.6474 0.322199 21.0181C0.53632 21.3888 0.845275 21.6938 1.21632 21.9008L11.3756 27.6732C11.7318 27.8907 12.1404 28.0037 12.556 27.9999C12.9711 27.9989 13.3784 27.8861 13.7365 27.6732L23.8958 21.9008C24.2638 21.6903 24.5703 21.3845 24.7839 21.0146C24.9976 20.6447 25.1108 20.2239 25.112 19.7951V8.21405C25.1225 7.78296 25.0142 7.35746 24.7994 6.98545C24.5845 6.61343 24.2715 6.30969 23.8958 6.1084Z' fill='url(%23paint0_linear_714_179)'/><path d='M5.47328 17.037L4.86515 17.4001C4.75634 17.4613 4.66062 17.5439 4.58357 17.643C4.50652 17.7421 4.4497 17.8558 4.4164 17.9775C4.3831 18.0991 4.374 18.2263 4.38963 18.3516C4.40526 18.4768 4.44531 18.5977 4.50743 18.707C4.58732 18.8586 4.70577 18.9857 4.85046 19.0751C4.99516 19.1645 5.16081 19.2129 5.33019 19.2153C5.49118 19.2139 5.64992 19.1767 5.79522 19.1064L6.40335 18.7434C6.51216 18.6822 6.60789 18.5996 6.68493 18.5004C6.76198 18.4013 6.8188 18.2876 6.8521 18.166C6.8854 18.0443 6.8945 17.9171 6.87887 17.7919C6.86324 17.6666 6.82319 17.5458 6.76107 17.4364C6.70583 17.3211 6.62775 17.2185 6.53171 17.1352C6.43567 17.0518 6.32374 16.9895 6.20289 16.952C6.08205 16.9145 5.95489 16.9027 5.82935 16.9174C5.70382 16.932 5.5826 16.9727 5.47328 17.037ZM9.19357 14.8951L7.94155 15.6212C7.83273 15.6824 7.73701 15.7649 7.65996 15.8641C7.58292 15.9632 7.52609 16.0769 7.49279 16.1986C7.4595 16.3202 7.4504 16.4474 7.46603 16.5726C7.48166 16.6979 7.5217 16.8187 7.58383 16.9281C7.66371 17.0797 7.78216 17.2068 7.92686 17.2962C8.07155 17.3856 8.23721 17.434 8.40658 17.4364C8.56757 17.435 8.72631 17.3978 8.87162 17.3275L10.1236 16.6014C10.2325 16.5402 10.3282 16.4576 10.4052 16.3585C10.4823 16.2594 10.5391 16.1457 10.5724 16.024C10.6057 15.9024 10.6148 15.7752 10.5992 15.6499C10.5835 15.5247 10.5435 15.4038 10.4814 15.2944C10.4261 15.1791 10.348 15.0766 10.252 14.9932C10.156 14.9099 10.044 14.8475 9.92318 14.8101C9.80234 14.7726 9.67518 14.7608 9.54964 14.7754C9.42411 14.7901 9.30289 14.8308 9.19357 14.8951ZM14.2374 13.1198C14.187 13.0168 14.1167 12.9251 14.0307 12.8503C13.9446 12.7754 13.8446 12.7189 13.7366 12.6842V5.38336C13.7371 5.2545 13.7124 5.12682 13.6641 5.00768C13.6157 4.88854 13.5446 4.78029 13.4548 4.68917C13.365 4.59806 13.2583 4.52587 13.1409 4.47678C13.0235 4.42769 12.8977 4.40266 12.7708 4.40314C12.6457 4.40355 12.522 4.42946 12.407 4.47933C12.292 4.52919 12.188 4.602 12.1013 4.69343C12.0145 4.78485 11.9467 4.89304 11.902 5.01156C11.8572 5.13007 11.8364 5.25651 11.8407 5.38336V12.7168C11.7327 12.7516 11.6327 12.8081 11.5466 12.883C11.4606 12.9578 11.3903 13.0495 11.3399 13.1525C11.2727 13.2801 11.2346 13.4213 11.2284 13.5659C11.2222 13.7104 11.2481 13.8545 11.3041 13.9875C11.2481 14.1205 11.2222 14.2646 11.2284 14.4091C11.2346 14.5536 11.2727 14.6949 11.3399 14.8225C11.3903 14.9255 11.4606 15.0172 11.5466 15.092C11.6327 15.1669 11.7327 15.2233 11.8407 15.2581V22.5916C11.8407 22.8516 11.9425 23.1009 12.1236 23.2847C12.3047 23.4686 12.5504 23.5718 12.8065 23.5718C13.0627 23.5718 13.3084 23.4686 13.4895 23.2847C13.6706 23.1009 13.7724 22.8516 13.7724 22.5916V15.2218C13.8804 15.187 13.9804 15.1305 14.0664 15.0557C14.1525 14.9809 14.2228 14.8892 14.2732 14.7862C14.3404 14.6586 14.3785 14.5173 14.3847 14.3728C14.3909 14.2283 14.365 14.0842 14.309 13.9512C14.3917 13.6751 14.3661 13.3772 14.2374 13.1198ZM16.6735 10.6112L15.4215 11.3373C15.3127 11.3985 15.2169 11.481 15.1399 11.5802C15.0628 11.6793 15.006 11.793 14.9727 11.9147C14.9394 12.0363 14.9303 12.1635 14.946 12.2887C14.9616 12.414 15.0016 12.5348 15.0638 12.6442C15.1436 12.7958 15.2621 12.9229 15.4068 13.0123C15.5515 13.1017 15.7171 13.1501 15.8865 13.1525C16.0475 13.1511 16.2062 13.1139 16.3515 13.0436L17.6036 12.3175C17.7124 12.2563 17.8081 12.1737 17.8851 12.0746C17.9622 11.9755 18.019 11.8617 18.0523 11.7401C18.0856 11.6184 18.0947 11.4913 18.0791 11.366C18.0635 11.2408 18.0234 11.1199 17.9613 11.0105C17.906 10.8952 17.828 10.7927 17.7319 10.7093C17.6359 10.626 17.524 10.5636 17.4031 10.5261C17.2823 10.4887 17.1551 10.4769 17.0296 10.4915C16.904 10.5061 16.7828 10.5469 16.6735 10.6112ZM19.639 10.9742C19.8 10.9728 19.9587 10.9357 20.104 10.8653L20.7122 10.5023C20.8208 10.4406 20.9164 10.3578 20.9935 10.2586C21.0705 10.1593 21.1275 10.0456 21.1611 9.92394C21.1947 9.80228 21.2043 9.67508 21.1893 9.54965C21.1744 9.42421 21.1351 9.30302 21.0739 9.19302C21.0126 9.08303 20.9305 8.9864 20.8324 8.90869C20.7342 8.83098 20.6219 8.77372 20.5019 8.7402C20.3818 8.70667 20.2564 8.69755 20.1329 8.71335C20.0094 8.72915 19.8902 8.76957 19.7821 8.83227L19.174 9.19531C19.0651 9.25651 18.9694 9.33909 18.8924 9.43822C18.8153 9.53735 18.7585 9.65106 18.7252 9.77271C18.6919 9.89436 18.6828 10.0215 18.6984 10.1468C18.7141 10.272 18.7541 10.3929 18.8162 10.5023C18.8981 10.6494 19.018 10.7711 19.163 10.8543C19.308 10.9374 19.4725 10.9789 19.639 10.9742ZM20.7122 17.4001L20.104 17.037C19.8859 16.9133 19.6284 16.8823 19.3878 16.9508C19.1472 17.0193 18.9432 17.1816 18.8202 17.4024C18.6973 17.6231 18.6655 17.8843 18.7318 18.1288C18.798 18.3733 18.957 18.5812 19.174 18.707L19.7821 19.0701C19.9274 19.1404 20.0861 19.1776 20.2471 19.179C20.4165 19.1766 20.5821 19.1282 20.7268 19.0388C20.8715 18.9494 20.99 18.8223 21.0699 18.6707C21.1339 18.5648 21.1755 18.4466 21.1921 18.3235C21.2087 18.2003 21.1999 18.0751 21.1662 17.9556C21.1326 17.8361 21.0749 17.7251 20.9967 17.6294C20.9185 17.5338 20.8216 17.4557 20.7122 17.4001ZM17.6 15.6212L16.348 14.8951C16.2399 14.8324 16.1207 14.792 15.9971 14.7762C15.8736 14.7604 15.7482 14.7695 15.6282 14.803C15.5082 14.8365 15.3958 14.8938 15.2977 14.9715C15.1995 15.0492 15.1174 15.1458 15.0562 15.2558C14.9949 15.3658 14.9557 15.487 14.9407 15.6125C14.9257 15.7379 14.9353 15.8651 14.9689 15.9868C15.0026 16.1084 15.0595 16.2221 15.1366 16.3214C15.2136 16.4206 15.3092 16.5035 15.4179 16.5651L16.6699 17.2912C16.8152 17.3615 16.974 17.3987 17.135 17.4001C17.3043 17.3977 17.47 17.3493 17.6147 17.2599C17.7594 17.1705 17.8778 17.0434 17.9577 16.8918C18.0228 16.7862 18.0653 16.6679 18.0825 16.5445C18.0997 16.4212 18.0911 16.2955 18.0574 16.1757C18.0237 16.0559 17.9655 15.9447 17.8867 15.8491C17.8079 15.7536 17.7103 15.6759 17.6 15.6212ZM7.94155 12.2812L9.19357 13.0073C9.33888 13.0776 9.49761 13.1148 9.6586 13.1162C9.82798 13.1138 9.99363 13.0654 10.1383 12.976C10.283 12.8866 10.4015 12.7595 10.4814 12.6079C10.5435 12.4985 10.5835 12.3777 10.5992 12.2524C10.6148 12.1272 10.6057 12 10.5724 11.8784C10.5391 11.7567 10.4823 11.643 10.4052 11.5439C10.3282 11.4447 10.2325 11.3622 10.1236 11.301L8.87162 10.5749C8.76383 10.5118 8.64476 10.4712 8.52134 10.4553C8.39792 10.4395 8.27262 10.4487 8.15275 10.4825C8.03288 10.5163 7.92084 10.574 7.82317 10.6521C7.72549 10.7303 7.64413 10.8275 7.58383 10.9379C7.46399 11.166 7.43428 11.4319 7.50073 11.6814C7.56719 11.9309 7.72481 12.1454 7.94155 12.2812ZM6.40335 9.19531L5.79522 8.83227C5.68714 8.76957 5.56791 8.72915 5.44439 8.71335C5.32087 8.69755 5.19549 8.70667 5.07546 8.7402C4.95542 8.77372 4.8431 8.83098 4.74493 8.90869C4.64676 8.9864 4.56469 9.08303 4.50343 9.19302C4.44217 9.30302 4.40293 9.42421 4.38796 9.54965C4.37299 9.67508 4.38259 9.80228 4.4162 9.92394C4.44981 10.0456 4.50677 10.1593 4.58382 10.2586C4.66087 10.3578 4.75647 10.4406 4.86515 10.5023L5.47328 10.8653C5.61859 10.9357 5.77732 10.9728 5.93831 10.9742C6.10769 10.9718 6.27334 10.9234 6.41804 10.834C6.56273 10.7447 6.68118 10.6176 6.76107 10.466C6.82193 10.3592 6.861 10.2411 6.87592 10.1187C6.89085 9.99635 6.88134 9.87216 6.84796 9.75358C6.81457 9.635 6.758 9.52446 6.68161 9.42854C6.60523 9.33263 6.51059 9.25331 6.40335 9.19531Z' fill='%2320133A'/><defs><linearGradient id='paint0_linear_714_179' x1='7.13608e-05' y1='14.001' x2='25.1156' y2='14.001' gradientUnits='userSpaceOnUse'><stop stop-color='%239059FF'/><stop offset='1' stop-color='%23F770FF'/></linearGradient></defs></svg>&quot;); background-repeat: repeat, no-repeat; background-position: 0% 0%, right calc(50% + 0px); background-origin: padding-box, content-box;">
                                    <!--end::Input-->
                                    <button type="button"
                                        style="border: 0px; clip: rect(0px, 0px, 0px, 0px); clip-path: inset(50%); height: 1px; margin: 0px -1px -1px 0px; overflow: hidden; padding: 0px; position: absolute; width: 1px; white-space: nowrap;">Generate
                                        new mask</button>
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Description</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="description">
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="fv-row mb-15">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Language</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <select name="language" aria-label="Select a Language" data-control="select2"
                                        data-placeholder="Select a Language..."
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-dropdown-parent="#kt_modal_update_details"
                                        data-select2-id="select2-data-22-4ubt" tabindex="-1" aria-hidden="true"
                                        data-kt-initialized="1">
                                        <option data-select2-id="select2-data-24-l0qw"></option>
                                        <option value="id">Bahasa Indonesia - Indonesian</option>
                                        <option value="msa">Bahasa Melayu - Malay</option>
                                        <option value="ca">Català - Catalan</option>
                                        <option value="cs">Čeština - Czech</option>
                                        <option value="da">Dansk - Danish</option>
                                        <option value="de">Deutsch - German</option>
                                        <option value="en">English</option>
                                        <option value="en-gb">English UK - British English</option>
                                        <option value="es">Español - Spanish</option>
                                        <option value="fil">Filipino</option>
                                        <option value="fr">Français - French</option>
                                        <option value="ga">Gaeilge - Irish (beta)</option>
                                        <option value="gl">Galego - Galician (beta)</option>
                                        <option value="hr">Hrvatski - Croatian</option>
                                        <option value="it">Italiano - Italian</option>
                                        <option value="hu">Magyar - Hungarian</option>
                                        <option value="nl">Nederlands - Dutch</option>
                                        <option value="no">Norsk - Norwegian</option>
                                        <option value="pl">Polski - Polish</option>
                                        <option value="pt">Português - Portuguese</option>
                                        <option value="ro">Română - Romanian</option>
                                        <option value="sk">Slovenčina - Slovak</option>
                                        <option value="fi">Suomi - Finnish</option>
                                        <option value="sv">Svenska - Swedish</option>
                                        <option value="vi">Tiếng Việt - Vietnamese</option>
                                        <option value="tr">Türkçe - Turkish</option>
                                        <option value="el">Ελληνικά - Greek</option>
                                        <option value="bg">Български език - Bulgarian</option>
                                        <option value="ru">Русский - Russian</option>
                                        <option value="sr">Српски - Serbian</option>
                                        <option value="uk">Українська мова - Ukrainian</option>
                                        <option value="he">עִבְרִית - Hebrew</option>
                                        <option value="ur">اردو - Urdu (beta)</option>
                                        <option value="ar">العربية - Arabic</option>
                                        <option value="fa">فارسی - Persian</option>
                                        <option value="mr">मराठी - Marathi</option>
                                        <option value="hi">हिन्दी - Hindi</option>
                                        <option value="bn">বাংলা - Bangla</option>
                                        <option value="gu">ગુજરાતી - Gujarati</option>
                                        <option value="ta">தமிழ் - Tamil</option>
                                        <option value="kn">ಕನ್ನಡ - Kannada</option>
                                        <option value="th">ภาษาไทย - Thai</option>
                                        <option value="ko">한국어 - Korean</option>
                                        <option value="ja">日本語 - Japanese</option>
                                        <option value="zh-cn">简体中文 - Simplified Chinese</option>
                                        <option value="zh-tw">繁體中文 - Traditional Chinese</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5"
                                        dir="ltr" data-select2-id="select2-data-23-vnq1"
                                        style="width: 100%;"><span class="selection"><span
                                                class="select2-selection select2-selection--single form-select form-select-solid"
                                                role="combobox" aria-haspopup="true" aria-expanded="false"
                                                tabindex="0" aria-disabled="false"
                                                aria-labelledby="select2-language-ef-container"
                                                aria-controls="select2-language-ef-container"><span
                                                    class="select2-selection__rendered"
                                                    id="select2-language-ef-container" role="textbox"
                                                    aria-readonly="true" title="Select a Language..."><span
                                                        class="select2-selection__placeholder">Select a
                                                        Language...</span></span><span class="select2-selection__arrow"
                                                    role="presentation"><b
                                                        role="presentation"></b></span></span></span><span
                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::User form-->

                            <!--begin::Address toggle-->
                            <div class="fw-bolder fs-3 rotate collapsible mb-7" data-bs-toggle="collapse"
                                href="#kt_modal_update_user_address" role="button" aria-expanded="false"
                                aria-controls="kt_modal_update_user_address">
                                Address Details
                                <span class="ms-2 rotate-180">
                                    <i class="ki-outline ki-down fs-3"></i> </span>
                            </div>
                            <!--end::Address toggle-->

                            <!--begin::Address form-->
                            <div id="kt_modal_update_user_address" class="collapse show">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-7 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Address Line 1</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="" name="address1"
                                        value="101, Collins Street">
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
                                    <input class="form-control form-control-solid" placeholder="" name="city"
                                        value="Melbourne">
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
                                        <input class="form-control form-control-solid" placeholder="" name="state"
                                            value="Victoria">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Post Code</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="postcode"
                                            value="3000">
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

                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            aria-label="Country of origination"
                                            data-bs-original-title="Country of origination" data-kt-initialized="1">
                                            <i class="ki-outline ki-information fs-7"></i> </span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <select name="country" aria-label="Select a Country" data-control="select2"
                                        data-placeholder="Select a Country..."
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-dropdown-parent="#kt_modal_update_details"
                                        data-select2-id="select2-data-25-q6ak" tabindex="-1" aria-hidden="true"
                                        data-kt-initialized="1">
                                        <option value="" data-select2-id="select2-data-27-f8ko">Select a
                                            Country...</option>
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
                                    </select><span class="select2 select2-container select2-container--bootstrap5"
                                        dir="ltr" data-select2-id="select2-data-26-el81"
                                        style="width: 100%;"><span class="selection"><span
                                                class="select2-selection select2-selection--single form-select form-select-solid"
                                                role="combobox" aria-haspopup="true" aria-expanded="false"
                                                tabindex="0" aria-disabled="false"
                                                aria-labelledby="select2-country-yr-container"
                                                aria-controls="select2-country-yr-container"><span
                                                    class="select2-selection__rendered"
                                                    id="select2-country-yr-container" role="textbox"
                                                    aria-readonly="true" title="Select a Country..."><span
                                                        class="select2-selection__placeholder">Select a
                                                        Country...</span></span><span class="select2-selection__arrow"
                                                    role="presentation"><b
                                                        role="presentation"></b></span></span></span><span
                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Address form-->
                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->

                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                            Discard
                        </button>
                        <!--end::Button-->

                        <!--begin::Button-->
                        <button type="submit" class="btn btn-info" data-kt-users-modal-action="submit">
                            <span class="indicator-label">
                                Submit
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Modal - Update user details--><!--begin::Modal - Add schedule-->
    <div class="modal fade" id="kt_modal_add_schedule" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add an Event</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_schedule_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                        action="#">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Event Name</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="event_name"
                                value="">
                            <!--end::Input-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-2">
                                <span class="required">Date &amp; Time</span>

                                <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover"
                                    data-bs-html="true" data-bs-content="Select a date &amp; time."
                                    data-kt-initialized="1">
                                    <i class="ki-outline ki-information fs-7"></i> </span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input class="form-control form-control-solid flatpickr-input"
                                placeholder="Pick date &amp; time" name="event_datetime"
                                id="kt_modal_add_schedule_datepicker" type="text" readonly="readonly">
                            <!--end::Input-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Event Organiser</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="event_org"
                                value="">
                            <!--end::Input-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Send Event Details To</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <tags class="tagify  form-control form-control-solid" tabindex="-1">
                                <tag title="smith@kpmg.com" contenteditable="false" spellcheck="false"
                                    tabindex="-1" class="tagify__tag tagify--noAnim" value="smith@kpmg.com">
                                    <x title="" class="tagify__tag__removeBtn" role="button"
                                        aria-label="remove tag"></x>
                                    <div><span class="tagify__tag-text">smith@kpmg.com</span></div>
                                </tag>
                                <tag title="melody@altbox.com" contenteditable="false" spellcheck="false"
                                    tabindex="-1" class="tagify__tag tagify--noAnim" value="melody@altbox.com">
                                    <x title="" class="tagify__tag__removeBtn" role="button"
                                        aria-label="remove tag"></x>
                                    <div><span class="tagify__tag-text">melody@altbox.com</span></div>
                                </tag><span contenteditable="" tabindex="0" data-placeholder="​"
                                    aria-placeholder="" class="tagify__input" role="textbox"
                                    aria-autocomplete="both" aria-multiline="false"></span>
                                ​
                            </tags><input id="kt_modal_add_schedule_tagify" type="text"
                                class="form-control form-control-solid" name="event_invitees"
                                value="smith@kpmg.com, melody@altbox.com" tabindex="-1">
                            <!--end::Input-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                                Discard
                            </button>

                            <button type="submit" class="btn btn-info" data-kt-users-modal-action="submit">
                                <span class="indicator-label">
                                    Submit
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
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
    <!--end::Modal - Add schedule--><!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_add_task" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add a Task</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_task_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                        action="#">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Task Name</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="task_name"
                                value="">
                            <!--end::Input-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-2">
                                <span class="required">Task Due Date</span>

                                <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover"
                                    data-bs-html="true" data-bs-content="Select a due date." data-kt-initialized="1">
                                    <i class="ki-outline ki-information fs-7"></i> </span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input class="form-control form-control-solid flatpickr-input" placeholder="Pick date"
                                name="task_duedate" id="kt_modal_add_task_datepicker" type="text"
                                readonly="readonly">
                            <!--end::Input-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-2">Task Description</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <textarea class="form-control form-control-solid rounded-3"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                                Discard
                            </button>

                            <button type="submit" class="btn btn-info" data-kt-users-modal-action="submit">
                                <span class="indicator-label">
                                    Submit
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
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
    <!--end::Modal - Add task--><!--begin::Modal - Update email-->
    <div class="modal fade" id="kt_modal_update_email" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Update Email Address</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_update_email_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                        action="#">
                        <!--begin::Notice-->

                        <!--begin::Notice-->
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                            <!--begin::Icon-->
                            <i class="ki-outline ki-information fs-2tx text-primary me-4"></i> <!--end::Icon-->

                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1 ">
                                <!--begin::Content-->
                                <div class=" fw-semibold">

                                    <div class="fs-6 text-gray-700 ">Please note that a valid email address is required to
                                        complete the email verification.</div>
                                </div>
                                <!--end::Content-->

                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Notice-->
                        <!--end::Notice-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-2">
                                <span class="required">Email Address</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input class="form-control form-control-solid" placeholder="" name="profile_email"
                                value="smith@kpmg.com">
                            <!--end::Input-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                                Discard
                            </button>

                            <button type="submit" class="btn btn-info" data-kt-users-modal-action="submit">
                                <span class="indicator-label">
                                    Submit
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
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
    <!--end::Modal - Update email--><!--begin::Modal - Update password-->
    <div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Update Password</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_update_password_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                        action="#">

                        <!--begin::Input group--->
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <label class="required form-label fs-6 mb-2">Current Password</label>

                            <input class="form-control form-control-lg form-control-solid" type="password"
                                placeholder="" name="current_password" autocomplete="off">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group--->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container" data-kt-password-meter="true">
                            <!--begin::Wrapper-->
                            <div class="mb-1">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold fs-6 mb-2">
                                    New Password
                                </label>
                                <!--end::Label-->

                                <!--begin::Input wrapper-->
                                <div class="position-relative mb-3">
                                    <input class="form-control form-control-lg form-control-solid" type="password"
                                        placeholder="" name="new_password" autocomplete="off">

                                    <span
                                        class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                        data-kt-password-meter-control="visibility">
                                        <i class="ki-outline ki-eye-slash fs-1"></i> <i
                                            class="ki-outline ki-eye d-none fs-1"></i> </span>
                                </div>
                                <!--end::Input wrapper-->

                                <!--begin::Meter-->
                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                </div>
                                <!--end::Meter-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Hint-->
                            <div class="text-muted">
                                Use 8 or more characters with a mix of letters, numbers &amp; symbols.
                            </div>
                            <!--end::Hint-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group--->

                        <!--begin::Input group--->
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <label class="form-label fw-semibold fs-6 mb-2">Confirm New Password</label>

                            <input class="form-control form-control-lg form-control-solid" type="password"
                                placeholder="" name="confirm_password" autocomplete="off">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group--->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                                Discard
                            </button>

                            <button type="submit" class="btn btn-info" data-kt-users-modal-action="submit">
                                <span class="indicator-label">
                                    Submit
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
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
    <!--end::Modal - Update password-->
    <!--begin::Modal - Update role-->
    <div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Update User Role</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_update_role_form" class="form" action="#">
                        <!--begin::Notice-->

                        <!--begin::Notice-->
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                            <!--begin::Icon-->
                            <i class="ki-outline ki-information fs-2tx text-primary me-4"></i> <!--end::Icon-->

                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1 ">
                                <!--begin::Content-->
                                <div class=" fw-semibold">

                                    <div class="fs-6 text-gray-700 ">Please note that reducing a user role rank, that user
                                        will lose all priviledges that was assigned to the previous role.</div>
                                </div>
                                <!--end::Content-->

                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Notice-->
                        <!--end::Notice-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-5">
                                <span class="required">Select a user role</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input row-->
                            <div class="d-flex">
                                <!--begin::Radio-->
                                <div class="form-check form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input me-3" name="user_role" type="radio"
                                        value="0" id="kt_modal_update_role_option_0" checked="checked">
                                    <!--end::Input-->

                                    <!--begin::Label-->
                                    <label class="form-check-label" for="kt_modal_update_role_option_0">
                                        <div class="fw-bold text-gray-800">Administrator</div>
                                        <div class="text-gray-600">Best for business owners and company administrators
                                        </div>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <!--end::Radio-->
                            </div>
                            <!--end::Input row-->

                            <div class="separator separator-dashed my-5"></div> <!--begin::Input row-->
                            <div class="d-flex">
                                <!--begin::Radio-->
                                <div class="form-check form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input me-3" name="user_role" type="radio"
                                        value="1" id="kt_modal_update_role_option_1">
                                    <!--end::Input-->

                                    <!--begin::Label-->
                                    <label class="form-check-label" for="kt_modal_update_role_option_1">
                                        <div class="fw-bold text-gray-800">Developer</div>
                                        <div class="text-gray-600">Best for developers or people primarily using the API
                                        </div>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <!--end::Radio-->
                            </div>
                            <!--end::Input row-->

                            <div class="separator separator-dashed my-5"></div> <!--begin::Input row-->
                            <div class="d-flex">
                                <!--begin::Radio-->
                                <div class="form-check form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input me-3" name="user_role" type="radio"
                                        value="2" id="kt_modal_update_role_option_2">
                                    <!--end::Input-->

                                    <!--begin::Label-->
                                    <label class="form-check-label" for="kt_modal_update_role_option_2">
                                        <div class="fw-bold text-gray-800">Analyst</div>
                                        <div class="text-gray-600">Best for people who need full access to analytics data,
                                            but don't need to update business settings</div>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <!--end::Radio-->
                            </div>
                            <!--end::Input row-->

                            <div class="separator separator-dashed my-5"></div> <!--begin::Input row-->
                            <div class="d-flex">
                                <!--begin::Radio-->
                                <div class="form-check form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input me-3" name="user_role" type="radio"
                                        value="3" id="kt_modal_update_role_option_3">
                                    <!--end::Input-->

                                    <!--begin::Label-->
                                    <label class="form-check-label" for="kt_modal_update_role_option_3">
                                        <div class="fw-bold text-gray-800">Support</div>
                                        <div class="text-gray-600">Best for employees who regularly refund payments and
                                            respond to disputes</div>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <!--end::Radio-->
                            </div>
                            <!--end::Input row-->

                            <div class="separator separator-dashed my-5"></div> <!--begin::Input row-->
                            <div class="d-flex">
                                <!--begin::Radio-->
                                <div class="form-check form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input me-3" name="user_role" type="radio"
                                        value="4" id="kt_modal_update_role_option_4">
                                    <!--end::Input-->

                                    <!--begin::Label-->
                                    <label class="form-check-label" for="kt_modal_update_role_option_4">
                                        <div class="fw-bold text-gray-800">Trial</div>
                                        <div class="text-gray-600">Best for people who need to preview content data, but
                                            don't need to make any updates</div>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <!--end::Radio-->
                            </div>
                            <!--end::Input row-->

                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                                Discard
                            </button>

                            <button type="submit" class="btn btn-info" data-kt-users-modal-action="submit">
                                <span class="indicator-label">
                                    Submit
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
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
    <!--end::Modal - Update role--><!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_add_auth_app" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add Authenticator App</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Content-->
                    <div class="fw-bold d-flex flex-column justify-content-center mb-5">
                        <!--begin::Label-->
                        <div class="text-center mb-5" data-kt-add-auth-action="qr-code-label">
                            Download the <a href="#">Authenticator app</a>, add a new account, then scan this
                            barcode to set up your account.
                        </div>
                        <div class="text-center mb-5 d-none" data-kt-add-auth-action="text-code-label">
                            Download the <a href="#">Authenticator app</a>, add a new account, then enter this code
                            to set up your account.
                        </div>
                        <!--end::Label-->

                        <!--begin::QR code-->
                        <div class="d-flex flex-center" data-kt-add-auth-action="qr-code">
                            <img src="{{ asset('media') }}/misc/qr.png" alt="Scan this QR code">
                        </div>
                        <!--end::QR code-->

                        <!--begin::Text code-->
                        <div class="border rounded p-5 d-flex flex-center d-none" data-kt-add-auth-action="text-code">
                            <div class="fs-1">gi2kdnb54is709j</div>
                        </div>
                        <!--end::Text code-->
                    </div>
                    <!--end::Content-->

                    <!--begin::Action-->
                    <div class="d-flex flex-center">
                        <div class="btn btn-light-primary" data-kt-add-auth-action="text-code-button">Enter code
                            manually</div>
                        <div class="btn btn-light-primary d-none" data-kt-add-auth-action="qr-code-button">Scan barcode
                            instead</div>
                    </div>
                    <!--end::Action-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task--><!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_add_one_time_password" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Enable One Time Password</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework"
                        id="kt_modal_add_one_time_password_form">
                        <!--begin::Label-->
                        <div class="fw-bold mb-9">
                            Enter the new phone number to receive an SMS to when you log in.
                        </div>
                        <!--end::Label-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-2">
                                <span class="required">Mobile number</span>

                                <span class="ms-2" data-bs-toggle="tooltip"
                                    aria-label="A valid mobile number is required to receive the one-time password to validate your account login."
                                    data-bs-original-title="A valid mobile number is required to receive the one-time password to validate your account login."
                                    data-kt-initialized="1">
                                    <i class="ki-outline ki-information fs-7"></i> </span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="otp_mobile_number"
                                placeholder="+6123 456 789" value="">
                            <!--end::Input-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Separator-->
                        <div class="separator saperator-dashed my-5"></div>
                        <!--end::Separator-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-2">
                                <span class="required">Email</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="email" class="form-control form-control-solid" name="otp_email"
                                value="smith@kpmg.com" readonly=""
                                style="background-size: auto, 25px; background-image: none, url(&quot;data:image/svg+xml;utf8,<svg width='26' height='28' viewBox='0 0 26 28' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M23.8958 6.1084L13.7365 0.299712C13.3797 0.103027 12.98 0 12.5739 0C12.1678 0 11.7682 0.103027 11.4113 0.299712L1.21632 6.1084C0.848276 6.31893 0.54181 6.62473 0.328154 6.99462C0.114498 7.36452 0.00129162 7.78529 7.13608e-05 8.21405V19.7951C-0.00323007 20.2248 0.108078 20.6474 0.322199 21.0181C0.53632 21.3888 0.845275 21.6938 1.21632 21.9008L11.3756 27.6732C11.7318 27.8907 12.1404 28.0037 12.556 27.9999C12.9711 27.9989 13.3784 27.8861 13.7365 27.6732L23.8958 21.9008C24.2638 21.6903 24.5703 21.3845 24.7839 21.0146C24.9976 20.6447 25.1108 20.2239 25.112 19.7951V8.21405C25.1225 7.78296 25.0142 7.35746 24.7994 6.98545C24.5845 6.61343 24.2715 6.30969 23.8958 6.1084Z' fill='url(%23paint0_linear_714_179)'/><path d='M5.47328 17.037L4.86515 17.4001C4.75634 17.4613 4.66062 17.5439 4.58357 17.643C4.50652 17.7421 4.4497 17.8558 4.4164 17.9775C4.3831 18.0991 4.374 18.2263 4.38963 18.3516C4.40526 18.4768 4.44531 18.5977 4.50743 18.707C4.58732 18.8586 4.70577 18.9857 4.85046 19.0751C4.99516 19.1645 5.16081 19.2129 5.33019 19.2153C5.49118 19.2139 5.64992 19.1767 5.79522 19.1064L6.40335 18.7434C6.51216 18.6822 6.60789 18.5996 6.68493 18.5004C6.76198 18.4013 6.8188 18.2876 6.8521 18.166C6.8854 18.0443 6.8945 17.9171 6.87887 17.7919C6.86324 17.6666 6.82319 17.5458 6.76107 17.4364C6.70583 17.3211 6.62775 17.2185 6.53171 17.1352C6.43567 17.0518 6.32374 16.9895 6.20289 16.952C6.08205 16.9145 5.95489 16.9027 5.82935 16.9174C5.70382 16.932 5.5826 16.9727 5.47328 17.037ZM9.19357 14.8951L7.94155 15.6212C7.83273 15.6824 7.73701 15.7649 7.65996 15.8641C7.58292 15.9632 7.52609 16.0769 7.49279 16.1986C7.4595 16.3202 7.4504 16.4474 7.46603 16.5726C7.48166 16.6979 7.5217 16.8187 7.58383 16.9281C7.66371 17.0797 7.78216 17.2068 7.92686 17.2962C8.07155 17.3856 8.23721 17.434 8.40658 17.4364C8.56757 17.435 8.72631 17.3978 8.87162 17.3275L10.1236 16.6014C10.2325 16.5402 10.3282 16.4576 10.4052 16.3585C10.4823 16.2594 10.5391 16.1457 10.5724 16.024C10.6057 15.9024 10.6148 15.7752 10.5992 15.6499C10.5835 15.5247 10.5435 15.4038 10.4814 15.2944C10.4261 15.1791 10.348 15.0766 10.252 14.9932C10.156 14.9099 10.044 14.8475 9.92318 14.8101C9.80234 14.7726 9.67518 14.7608 9.54964 14.7754C9.42411 14.7901 9.30289 14.8308 9.19357 14.8951ZM14.2374 13.1198C14.187 13.0168 14.1167 12.9251 14.0307 12.8503C13.9446 12.7754 13.8446 12.7189 13.7366 12.6842V5.38336C13.7371 5.2545 13.7124 5.12682 13.6641 5.00768C13.6157 4.88854 13.5446 4.78029 13.4548 4.68917C13.365 4.59806 13.2583 4.52587 13.1409 4.47678C13.0235 4.42769 12.8977 4.40266 12.7708 4.40314C12.6457 4.40355 12.522 4.42946 12.407 4.47933C12.292 4.52919 12.188 4.602 12.1013 4.69343C12.0145 4.78485 11.9467 4.89304 11.902 5.01156C11.8572 5.13007 11.8364 5.25651 11.8407 5.38336V12.7168C11.7327 12.7516 11.6327 12.8081 11.5466 12.883C11.4606 12.9578 11.3903 13.0495 11.3399 13.1525C11.2727 13.2801 11.2346 13.4213 11.2284 13.5659C11.2222 13.7104 11.2481 13.8545 11.3041 13.9875C11.2481 14.1205 11.2222 14.2646 11.2284 14.4091C11.2346 14.5536 11.2727 14.6949 11.3399 14.8225C11.3903 14.9255 11.4606 15.0172 11.5466 15.092C11.6327 15.1669 11.7327 15.2233 11.8407 15.2581V22.5916C11.8407 22.8516 11.9425 23.1009 12.1236 23.2847C12.3047 23.4686 12.5504 23.5718 12.8065 23.5718C13.0627 23.5718 13.3084 23.4686 13.4895 23.2847C13.6706 23.1009 13.7724 22.8516 13.7724 22.5916V15.2218C13.8804 15.187 13.9804 15.1305 14.0664 15.0557C14.1525 14.9809 14.2228 14.8892 14.2732 14.7862C14.3404 14.6586 14.3785 14.5173 14.3847 14.3728C14.3909 14.2283 14.365 14.0842 14.309 13.9512C14.3917 13.6751 14.3661 13.3772 14.2374 13.1198ZM16.6735 10.6112L15.4215 11.3373C15.3127 11.3985 15.2169 11.481 15.1399 11.5802C15.0628 11.6793 15.006 11.793 14.9727 11.9147C14.9394 12.0363 14.9303 12.1635 14.946 12.2887C14.9616 12.414 15.0016 12.5348 15.0638 12.6442C15.1436 12.7958 15.2621 12.9229 15.4068 13.0123C15.5515 13.1017 15.7171 13.1501 15.8865 13.1525C16.0475 13.1511 16.2062 13.1139 16.3515 13.0436L17.6036 12.3175C17.7124 12.2563 17.8081 12.1737 17.8851 12.0746C17.9622 11.9755 18.019 11.8617 18.0523 11.7401C18.0856 11.6184 18.0947 11.4913 18.0791 11.366C18.0635 11.2408 18.0234 11.1199 17.9613 11.0105C17.906 10.8952 17.828 10.7927 17.7319 10.7093C17.6359 10.626 17.524 10.5636 17.4031 10.5261C17.2823 10.4887 17.1551 10.4769 17.0296 10.4915C16.904 10.5061 16.7828 10.5469 16.6735 10.6112ZM19.639 10.9742C19.8 10.9728 19.9587 10.9357 20.104 10.8653L20.7122 10.5023C20.8208 10.4406 20.9164 10.3578 20.9935 10.2586C21.0705 10.1593 21.1275 10.0456 21.1611 9.92394C21.1947 9.80228 21.2043 9.67508 21.1893 9.54965C21.1744 9.42421 21.1351 9.30302 21.0739 9.19302C21.0126 9.08303 20.9305 8.9864 20.8324 8.90869C20.7342 8.83098 20.6219 8.77372 20.5019 8.7402C20.3818 8.70667 20.2564 8.69755 20.1329 8.71335C20.0094 8.72915 19.8902 8.76957 19.7821 8.83227L19.174 9.19531C19.0651 9.25651 18.9694 9.33909 18.8924 9.43822C18.8153 9.53735 18.7585 9.65106 18.7252 9.77271C18.6919 9.89436 18.6828 10.0215 18.6984 10.1468C18.7141 10.272 18.7541 10.3929 18.8162 10.5023C18.8981 10.6494 19.018 10.7711 19.163 10.8543C19.308 10.9374 19.4725 10.9789 19.639 10.9742ZM20.7122 17.4001L20.104 17.037C19.8859 16.9133 19.6284 16.8823 19.3878 16.9508C19.1472 17.0193 18.9432 17.1816 18.8202 17.4024C18.6973 17.6231 18.6655 17.8843 18.7318 18.1288C18.798 18.3733 18.957 18.5812 19.174 18.707L19.7821 19.0701C19.9274 19.1404 20.0861 19.1776 20.2471 19.179C20.4165 19.1766 20.5821 19.1282 20.7268 19.0388C20.8715 18.9494 20.99 18.8223 21.0699 18.6707C21.1339 18.5648 21.1755 18.4466 21.1921 18.3235C21.2087 18.2003 21.1999 18.0751 21.1662 17.9556C21.1326 17.8361 21.0749 17.7251 20.9967 17.6294C20.9185 17.5338 20.8216 17.4557 20.7122 17.4001ZM17.6 15.6212L16.348 14.8951C16.2399 14.8324 16.1207 14.792 15.9971 14.7762C15.8736 14.7604 15.7482 14.7695 15.6282 14.803C15.5082 14.8365 15.3958 14.8938 15.2977 14.9715C15.1995 15.0492 15.1174 15.1458 15.0562 15.2558C14.9949 15.3658 14.9557 15.487 14.9407 15.6125C14.9257 15.7379 14.9353 15.8651 14.9689 15.9868C15.0026 16.1084 15.0595 16.2221 15.1366 16.3214C15.2136 16.4206 15.3092 16.5035 15.4179 16.5651L16.6699 17.2912C16.8152 17.3615 16.974 17.3987 17.135 17.4001C17.3043 17.3977 17.47 17.3493 17.6147 17.2599C17.7594 17.1705 17.8778 17.0434 17.9577 16.8918C18.0228 16.7862 18.0653 16.6679 18.0825 16.5445C18.0997 16.4212 18.0911 16.2955 18.0574 16.1757C18.0237 16.0559 17.9655 15.9447 17.8867 15.8491C17.8079 15.7536 17.7103 15.6759 17.6 15.6212ZM7.94155 12.2812L9.19357 13.0073C9.33888 13.0776 9.49761 13.1148 9.6586 13.1162C9.82798 13.1138 9.99363 13.0654 10.1383 12.976C10.283 12.8866 10.4015 12.7595 10.4814 12.6079C10.5435 12.4985 10.5835 12.3777 10.5992 12.2524C10.6148 12.1272 10.6057 12 10.5724 11.8784C10.5391 11.7567 10.4823 11.643 10.4052 11.5439C10.3282 11.4447 10.2325 11.3622 10.1236 11.301L8.87162 10.5749C8.76383 10.5118 8.64476 10.4712 8.52134 10.4553C8.39792 10.4395 8.27262 10.4487 8.15275 10.4825C8.03288 10.5163 7.92084 10.574 7.82317 10.6521C7.72549 10.7303 7.64413 10.8275 7.58383 10.9379C7.46399 11.166 7.43428 11.4319 7.50073 11.6814C7.56719 11.9309 7.72481 12.1454 7.94155 12.2812ZM6.40335 9.19531L5.79522 8.83227C5.68714 8.76957 5.56791 8.72915 5.44439 8.71335C5.32087 8.69755 5.19549 8.70667 5.07546 8.7402C4.95542 8.77372 4.8431 8.83098 4.74493 8.90869C4.64676 8.9864 4.56469 9.08303 4.50343 9.19302C4.44217 9.30302 4.40293 9.42421 4.38796 9.54965C4.37299 9.67508 4.38259 9.80228 4.4162 9.92394C4.44981 10.0456 4.50677 10.1593 4.58382 10.2586C4.66087 10.3578 4.75647 10.4406 4.86515 10.5023L5.47328 10.8653C5.61859 10.9357 5.77732 10.9728 5.93831 10.9742C6.10769 10.9718 6.27334 10.9234 6.41804 10.834C6.56273 10.7447 6.68118 10.6176 6.76107 10.466C6.82193 10.3592 6.861 10.2411 6.87592 10.1187C6.89085 9.99635 6.88134 9.87216 6.84796 9.75358C6.81457 9.635 6.758 9.52446 6.68161 9.42854C6.60523 9.33263 6.51059 9.25331 6.40335 9.19531Z' fill='%2320133A'/><defs><linearGradient id='paint0_linear_714_179' x1='7.13608e-05' y1='14.001' x2='25.1156' y2='14.001' gradientUnits='userSpaceOnUse'><stop stop-color='%239059FF'/><stop offset='1' stop-color='%23F770FF'/></linearGradient></defs></svg>&quot;); background-repeat: repeat, no-repeat; background-position: 0% 0%, right calc(50% + 0px); background-origin: padding-box, content-box;">
                            <!--end::Input-->
                            <button type="button"
                                style="border: 0px; clip: rect(0px, 0px, 0px, 0px); clip-path: inset(50%); height: 1px; margin: 0px -1px -1px 0px; overflow: hidden; padding: 0px; position: absolute; width: 1px; white-space: nowrap;">Generate
                                new mask</button>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-2">
                                <span class="required">Confirm password</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="password" class="form-control form-control-solid" name="otp_confirm_password"
                                value="">
                            <!--end::Input-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                                Cancel
                            </button>

                            <button type="submit" class="btn btn-info" data-kt-users-modal-action="submit">
                                <span class="indicator-label">
                                    Submit
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
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
    <!--end::Modal - Add task--><!--end::Modals-->
    <!--end::Content container-->
@endsection
