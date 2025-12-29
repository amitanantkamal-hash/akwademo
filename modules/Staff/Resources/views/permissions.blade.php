@extends('admin.app')

@section('admin_title')
    {{__('Permissions')}}
@endsection

@section('content')
<!--begin::Card-->
<div class="card card-flush mt-8">
    <!--begin::Card header-->
    <div class="card-header mt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1 me-5">
                <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>                <input type="text" data-kt-permissions-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Permissions">
            </div>
            <!--end::Search-->
        </div>
        <!--end::Card title-->

        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Button-->
            <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_permission">
                <i class="ki-outline ki-plus-square fs-3"></i>                Add Permission
            </button>
            <!--end::Button-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table-->
        <div id="kt_permissions_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table class="table align-middle table-row-dashed fs-6 gy-5 mb-0 dataTable no-footer" id="kt_permissions_table">
            <thead>
                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0"><th class="min-w-125px sorting" tabindex="0" aria-controls="kt_permissions_table" rowspan="1" colspan="1" style="width: 291.117px;" aria-label="Name: activate to sort column ascending">Name</th><th class="min-w-250px sorting_disabled" rowspan="1" colspan="1" style="width: 642.15px;" aria-label="Assigned to">Assigned to</th><th class="min-w-125px sorting" tabindex="0" aria-controls="kt_permissions_table" rowspan="1" colspan="1" style="width: 280.817px;" aria-label="Created Date: activate to sort column ascending">Created Date</th><th class="text-end min-w-100px sorting_disabled" rowspan="1" colspan="1" style="width: 174.417px;" aria-label="Actions">Actions</th></tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                            <tr class="odd">
                        <td>User Management</td>
                        <td>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-info fs-7 m-1">Administrator</a>
                                                    </td>
                        <td data-order="2023-06-20T11:30:00-04:00">
                            20 Jun 2023, 11:30 am                        </td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                <i class="ki-outline ki-setting-3 fs-3"></i>                            </button>
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                <i class="ki-outline ki-trash fs-3"></i>                            </button>
                        </td>
                    </tr><tr class="even">
                        <td>Content Management</td>
                        <td>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-info fs-7 m-1">Administrator</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-danger fs-7 m-1">Developer</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-success fs-7 m-1">Analyst</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-info fs-7 m-1">Support</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-warning fs-7 m-1">Trial</a>
                                                    </td>
                        <td data-order="2023-12-20T11:05:00-04:00">
                            20 Dec 2023, 11:05 am                        </td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                <i class="ki-outline ki-setting-3 fs-3"></i>                            </button>
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                <i class="ki-outline ki-trash fs-3"></i>                            </button>
                        </td>
                    </tr><tr class="odd">
                        <td>Financial Management</td>
                        <td>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-info fs-7 m-1">Administrator</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-success fs-7 m-1">Analyst</a>
                                                    </td>
                        <td data-order="2023-03-10T10:30:00-04:00">
                            10 Mar 2023, 10:30 am                        </td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                <i class="ki-outline ki-setting-3 fs-3"></i>                            </button>
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                <i class="ki-outline ki-trash fs-3"></i>                            </button>
                        </td>
                    </tr><tr class="even">
                        <td>Reporting</td>
                        <td>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-info fs-7 m-1">Administrator</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-success fs-7 m-1">Analyst</a>
                                                    </td>
                        <td data-order="2023-08-19T14:40:00-04:00">
                            19 Aug 2023, 2:40 pm                        </td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                <i class="ki-outline ki-setting-3 fs-3"></i>                            </button>
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                <i class="ki-outline ki-trash fs-3"></i>                            </button>
                        </td>
                    </tr><tr class="odd">
                        <td>Payroll</td>
                        <td>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-info fs-7 m-1">Administrator</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-success fs-7 m-1">Analyst</a>
                                                    </td>
                        <td data-order="2023-06-24T14:40:00-04:00">
                            24 Jun 2023, 2:40 pm                        </td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                <i class="ki-outline ki-setting-3 fs-3"></i>                            </button>
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                <i class="ki-outline ki-trash fs-3"></i>                            </button>
                        </td>
                    </tr><tr class="even">
                        <td>Disputes Management</td>
                        <td>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-info fs-7 m-1">Administrator</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-danger fs-7 m-1">Developer</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-info fs-7 m-1">Support</a>
                                                    </td>
                        <td data-order="2023-12-20T22:10:00-04:00">
                            20 Dec 2023, 10:10 pm                        </td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                <i class="ki-outline ki-setting-3 fs-3"></i>                            </button>
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                <i class="ki-outline ki-trash fs-3"></i>                            </button>
                        </td>
                    </tr><tr class="odd">
                        <td>API Controls</td>
                        <td>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-info fs-7 m-1">Administrator</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-danger fs-7 m-1">Developer</a>
                                                    </td>
                        <td data-order="2023-08-19T06:43:00-04:00">
                            19 Aug 2023, 6:43 am                        </td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                <i class="ki-outline ki-setting-3 fs-3"></i>                            </button>
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                <i class="ki-outline ki-trash fs-3"></i>                            </button>
                        </td>
                    </tr><tr class="even">
                        <td>Database Management</td>
                        <td>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-info fs-7 m-1">Administrator</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-danger fs-7 m-1">Developer</a>
                                                    </td>
                        <td data-order="2023-04-15T20:43:00-04:00">
                            15 Apr 2023, 8:43 pm                        </td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                <i class="ki-outline ki-setting-3 fs-3"></i>                            </button>
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                <i class="ki-outline ki-trash fs-3"></i>                            </button>
                        </td>
                    </tr><tr class="odd">
                        <td>Repository Management</td>
                        <td>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-info fs-7 m-1">Administrator</a>
                                                            <a href="/metronic8/demo39/../demo39/apps/user-management/roles/view.html" class="badge badge-light-danger fs-7 m-1">Developer</a>
                                                    </td>
                        <td data-order="2023-03-10T10:30:00-04:00">
                            10 Mar 2023, 10:30 am                        </td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                <i class="ki-outline ki-setting-3 fs-3"></i>                            </button>
                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                <i class="ki-outline ki-trash fs-3"></i>                            </button>
                        </td>
                    </tr></tbody>
        </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"><div class="dataTables_length" id="kt_permissions_table_length"><label><select name="kt_permissions_table_length" aria-controls="kt_permissions_table" class="form-select form-select-sm form-select-solid"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select></label></div></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_permissions_table_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_permissions_table_previous"><a href="#" aria-controls="kt_permissions_table" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_permissions_table" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item next disabled" id="kt_permissions_table_next"><a href="#" aria-controls="kt_permissions_table" data-dt-idx="2" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

<!--begin::Modals-->
<!--begin::Modal - Add permissions-->
<div class="modal fade" id="kt_modal_add_permission" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add a Permission</h2>
                <!--end::Modal title-->

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-permissions-modal-action="close">
                    <i class="ki-outline ki-cross fs-1"></i>                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="kt_modal_add_permission_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">Permission Name</span>

                            <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Permission names is required to be unique." data-kt-initialized="1">
                                <i class="ki-outline ki-information fs-7"></i>                            </span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Enter a permission name" name="permission_name">
                        <!--end::Input-->
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Checkbox-->
                        <label class="form-check form-check-custom form-check-solid me-9">
                            <input class="form-check-input" type="checkbox" value="" name="permissions_core" id="kt_permissions_core">
                            <span class="form-check-label" for="kt_permissions_core">
                                Set as core permission
                            </span>
                        </label>
                        <!--end::Checkbox-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Disclaimer-->
                    <div class="text-gray-600">Permission set as a <strong class="me-1">Core Permission</strong> will be locked and <strong class="me-1">not editable</strong> in future</div>
                    <!--end::Disclaimer-->

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-permissions-modal-action="cancel">
                            Discard
                        </button>

                        <button type="submit" class="btn btn-info" data-kt-permissions-modal-action="submit">
                            <span class="indicator-label">
                                Submit
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
<!--end::Modal - Add permissions--><!--begin::Modal - Update permissions-->
<div class="modal fade" id="kt_modal_update_permission" tabindex="-1" style="display: none;" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Update Permission</h2>
                <!--end::Modal title-->

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-permissions-modal-action="close">
                    <i class="ki-outline ki-cross fs-1"></i>                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Notice-->
                
<!--begin::Notice-->
<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
            <!--begin::Icon-->
        <i class="ki-outline ki-information fs-2tx text-warning me-4"></i>        <!--end::Icon-->
    
    <!--begin::Wrapper-->
    <div class="d-flex flex-stack flex-grow-1 ">
                    <!--begin::Content-->
            <div class=" fw-semibold">
                
                                    <div class="fs-6 text-gray-700 "><strong class="me-1">Warning!</strong> By editing the permission name, you might break the system permissions functionality. Please ensure you're absolutely certain before proceeding.</div>
                            </div>
            <!--end::Content-->
        
            </div>
    <!--end::Wrapper-->  
</div>
<!--end::Notice-->
                <!--end::Notice-->

                <!--begin::Form-->
                <form id="kt_modal_update_permission_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">Permission Name</span>

                            <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Permission names is required to be unique." data-kt-initialized="1">
                                <i class="ki-outline ki-information fs-7"></i>                            </span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Enter a permission name" name="permission_name">
                        <!--end::Input-->
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-permissions-modal-action="cancel">
                            Discard
                        </button>

                        <button type="submit" class="btn btn-info" data-kt-permissions-modal-action="submit">
                            <span class="indicator-label">
                                Submit
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
<!--end::Modal - Update permissions--><!--end::Modals-->
@endsection