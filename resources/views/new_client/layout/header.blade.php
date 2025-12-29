<div id="kt_app_header" class="app-header" style="background-color: #02145d; height: 55px;">
    <div class="app-container container-fluid d-flex justify-content-between flex-stack" id="kt_app_header_container">
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-solid ki-abstract-14 fs-2 fs-md-1"></i>
            </div>
        </div>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="?page=index" class="d-lg-none">
                <img alt="Logo" src="{{ asset('custom/imgs/icono-dark.png') }}" class="h-20px theme-dark-show" />
                <img alt="Logo" src="{{ asset('custom/imgs/icono-light.png') }}" class="h-20px theme-light-show" />
            </a>
        </div>
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            @include('new_client.layout.partials_header.menu')
            @include('new_client.layout.navbar')
        </div>
    </div>
</div>
