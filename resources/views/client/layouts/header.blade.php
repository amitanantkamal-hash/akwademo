<!--begin::Header style="height: 70px;" -->
<div id="kt_app_header" class="app-header" style="background-color: var(--theme-color-header); height: 55px;">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex justify-content-between flex-stack" id="kt_app_header_container">
        <!--begin::Sidebar toggle-->
        <div class="d-flex align-items-center d-block justify-content-between flex-wrap gap-3 mb-6 mb-lg-0" >
            <div class="d-flex mt-2 mt-lg-0">
                <div class="app-header-logo mt-6 mt-lg-0 text-center d-none align-items-center justify-content-center d-lg-flex" style="width: 80px;">
                    <!--begin::Logo image-->
                    <a href="/dashboard">
                        {{-- Required for anantkamalwademo --}}
                        @php
                            $app_logo = asset('img/sendinai-icon.svg');
                            //  $app_logo = asset('backend/Assets/img/logo.png');

                            $partner_id = auth()->user()->created_by;
                            if ($partner_id != 1) {
                                $partner_data = \App\Models\Partner::where('user_id', $partner_id)->first();

                                if ($partner_data) {
                                    if ($partner_data->is_active == 1) {
                                        $app_logo = asset($partner_data->logo);
                                    }
                                }
                            }
                        @endphp
                        <img alt="Logo" src="{{ $app_logo }}" class="h-40px" />
                    </a>
                    <!--end::Logo image-->
                </div>
                <div class="btn btn-icon mt-4 w-35px h-35px me-2 d-block d-lg-none active d-flex align-items-center justify-content-center" id="kt_app_sidebar_mobile_toggle">
                    <i class="ki-outline ki-abstract-14 fs-2 text-white"></i>
                </div>

            </div>
        </div>
        
        <!--begin::Navbar-->
        @include('client.layouts.navbars.navbar')
        <!--end::Navbar-->

        <!--begin::Separator-->
        <div class="app-navbar-separator separator d-none d-lg-flex"></div>
        <!--end::Separator-->
    </div>
    <!--end::Header container-->
</div>
<!--end::Header-->

