@extends('layouts.app')
@section('admin_title')
    {{__('Logs')}}
@endsection
@section('content')
    <div class="card pt-4 ">
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
            <table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5" id="kt_table_customers_logs">
                <!--begin::Table body-->
                <tbody>
                                                                    <!--begin::Table row-->
                        <tr>
                            <!--begin::Badge--->
                            <td class="min-w-70px">
                                <div class="badge badge-light-warning">404 WRN</div>
                            </td>
                            <!--end::Badge--->
 
                            <!--begin::Status--->
                            <td>
                               POST /v1/customer/c_658ca353a5a2d/not_found                            </td>
                            <!--end::Status--->

                            <!--begin::Timestamp--->
                            <td class="pe-0 text-end min-w-200px">
                                25 Jul 2023, 8:43 pm                            </td>
                            <!--end::Timestamp--->
                        </tr>
                        <!--end::Table row-->
                                                                    <!--begin::Table row-->
                        <tr>
                            <!--begin::Badge--->
                            <td class="min-w-70px">
                                <div class="badge badge-light-warning">404 WRN</div>
                            </td>
                            <!--end::Badge--->
 
                            <!--begin::Status--->
                            <td>
                               POST /v1/customer/c_658ca353a5a30/not_found                            </td>
                            <!--end::Status--->

                            <!--begin::Timestamp--->
                            <td class="pe-0 text-end min-w-200px">
                                20 Jun 2023, 5:20 pm                            </td>
                            <!--end::Timestamp--->
                        </tr>
                        <!--end::Table row-->
                                                                    <!--begin::Table row-->
                        <tr>
                            <!--begin::Badge--->
                            <td class="min-w-70px">
                                <div class="badge badge-light-success">200 OK</div>
                            </td>
                            <!--end::Badge--->
 
                            <!--begin::Status--->
                            <td>
                               POST /v1/invoices/in_4252_6925/payment                            </td>
                            <!--end::Status--->

                            <!--begin::Timestamp--->
                            <td class="pe-0 text-end min-w-200px">
                                21 Feb 2023, 6:43 am                            </td>
                            <!--end::Timestamp--->
                        </tr>
                        <!--end::Table row-->
                                                                    <!--begin::Table row-->
                        <tr>
                            <!--begin::Badge--->
                            <td class="min-w-70px">
                                <div class="badge badge-light-success">200 OK</div>
                            </td>
                            <!--end::Badge--->
 
                            <!--begin::Status--->
                            <td>
                               POST /v1/invoices/in_2684_3144/payment                            </td>
                            <!--end::Status--->

                            <!--begin::Timestamp--->
                            <td class="pe-0 text-end min-w-200px">
                                10 Mar 2023, 11:05 am                            </td>
                            <!--end::Timestamp--->
                        </tr>
                        <!--end::Table row-->
                                                                    <!--begin::Table row-->
                        <tr>
                            <!--begin::Badge--->
                            <td class="min-w-70px">
                                <div class="badge badge-light-success">200 OK</div>
                            </td>
                            <!--end::Badge--->
 
                            <!--begin::Status--->
                            <td>
                               POST /v1/invoices/in_7069_1242/payment                            </td>
                            <!--end::Status--->

                            <!--begin::Timestamp--->
                            <td class="pe-0 text-end min-w-200px">
                                20 Jun 2023, 2:40 pm                            </td>
                            <!--end::Timestamp--->
                        </tr>
                        <!--end::Table row-->
                                                                    <!--begin::Table row-->
                        <tr>
                            <!--begin::Badge--->
                            <td class="min-w-70px">
                                <div class="badge badge-light-success">200 OK</div>
                            </td>
                            <!--end::Badge--->
 
                            <!--begin::Status--->
                            <td>
                               POST /v1/invoices/in_2684_3144/payment                            </td>
                            <!--end::Status--->

                            <!--begin::Timestamp--->
                            <td class="pe-0 text-end min-w-200px">
                                10 Nov 2023, 10:10 pm                            </td>
                            <!--end::Timestamp--->
                        </tr>
                        <!--end::Table row-->
                                                                    <!--begin::Table row-->
                        <tr>
                            <!--begin::Badge--->
                            <td class="min-w-70px">
                                <div class="badge badge-light-warning">404 WRN</div>
                            </td>
                            <!--end::Badge--->
 
                            <!--begin::Status--->
                            <td>
                               POST /v1/customer/c_658ca353a5a31/not_found                            </td>
                            <!--end::Status--->

                            <!--begin::Timestamp--->
                            <td class="pe-0 text-end min-w-200px">
                                10 Mar 2023, 5:20 pm                            </td>
                            <!--end::Timestamp--->
                        </tr>
                        <!--end::Table row-->
                                                                    <!--begin::Table row-->
                        <tr>
                            <!--begin::Badge--->
                            <td class="min-w-70px">
                                <div class="badge badge-light-warning">404 WRN</div>
                            </td>
                            <!--end::Badge--->
 
                            <!--begin::Status--->
                            <td>
                               POST /v1/customer/c_658ca353a5a31/not_found                            </td>
                            <!--end::Status--->

                            <!--begin::Timestamp--->
                            <td class="pe-0 text-end min-w-200px">
                                10 Nov 2023, 10:10 pm                            </td>
                            <!--end::Timestamp--->
                        </tr>
                        <!--end::Table row-->
                                                                    <!--begin::Table row-->
                        <tr>
                            <!--begin::Badge--->
                            <td class="min-w-70px">
                                <div class="badge badge-light-success">200 OK</div>
                            </td>
                            <!--end::Badge--->
 
                            <!--begin::Status--->
                            <td>
                               POST /v1/invoices/in_4252_6925/payment                            </td>
                            <!--end::Status--->

                            <!--begin::Timestamp--->
                            <td class="pe-0 text-end min-w-200px">
                                24 Jun 2023, 2:40 pm                            </td>
                            <!--end::Timestamp--->
                        </tr>
                        <!--end::Table row-->
                                                                    <!--begin::Table row-->
                        <tr>
                            <!--begin::Badge--->
                            <td class="min-w-70px">
                                <div class="badge badge-light-success">200 OK</div>
                            </td>
                            <!--end::Badge--->
 
                            <!--begin::Status--->
                            <td>
                               POST /v1/invoices/in_7593_3460/payment                            </td>
                            <!--end::Status--->

                            <!--begin::Timestamp--->
                            <td class="pe-0 text-end min-w-200px">
                                22 Sep 2023, 11:05 am                            </td>
                            <!--end::Timestamp--->
                        </tr>
                        <!--end::Table row-->
                                    </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Table wrapper-->
    </div>
    <!--end::Card body-->
</div>
@endsection