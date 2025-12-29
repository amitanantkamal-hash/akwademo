@if (session('status'))
    <!--begin::Alert-->
    <div class="alert alert-dismissible bg-light-success d-flex flex-column flex-sm-row p-5 mb-10">
        <!--begin::Icon-->
        <i class="ki-duotone ki-check-circle fs-2hx text-success me-4 mb-5 mb-sm-0">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        <!--end::Icon-->
        
        <!--begin::Content-->
        <div class="d-flex flex-column pe-0 pe-sm-10">
            <h5 class="mb-1">{{ __('Success') }}</h5>
            <span>{{ session('status') }}</span>
        </div>
        <!--end::Content-->
        
        <!--begin::Close-->
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-success">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </button>
        <!--end::Close-->
    </div>
    <!--end::Alert-->
@endif

@if (session('error'))
    <!--begin::Alert-->
    <div class="alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-5 mb-10">
        <!--begin::Icon-->
        <i class="ki-duotone ki-cross-circle fs-2hx text-danger me-4 mb-5 mb-sm-0">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        <!--end::Icon-->
        
        <!--begin::Content-->
        <div class="d-flex flex-column pe-0 pe-sm-10">
            <h5 class="mb-1">{{ __('Error') }}</h5>
            <span>{{ session('error') }}</span>
        </div>
        <!--end::Content-->
        
        <!--begin::Close-->
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-danger">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </button>
        <!--end::Close-->
    </div>
    <!--end::Alert-->
@endif