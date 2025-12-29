@extends('layouts.app-client')

@section('content')
<!--begin::Container-->
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Analytics for {{ $account->name }}
                <span class="d-block text-muted pt-2 font-size-sm">Account ID: {{ $account->account_id }}</span></h3>
            </div>
            <div class="card-toolbar">
                <span class="label label-lg label-inline {{ $account->type == 'ctwa' ? 'label-success' : 'label-secondary' }}">
                    {{ strtoupper($account->type) }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                                    <select class="form-control" id="kt_datatable_search_status">
                                        <option value="">All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Date Range:</label>
                                    <input class="form-control" id="kt_datepicker" readonly placeholder="Select date range" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                        <a href="#" class="btn btn-light-primary px-6 font-weight-bold" id="kt_datatable_reset">Reset</a>
                    </div>
                </div>
            </div>
            <!--end::Search Form-->
            
            <!--begin::Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            <!--end::Datatable-->
            
            <!--begin::Hidden Table (for server-side processing)-->
            <table class="table table-bordered table-hover table-checkable" id="analytics_table" style="display:none;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>CTWA Clicks</th>
                        <th>Leads</th>
                        <th>Impressions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($analytics as $data)
                    <tr>
                        <td>{{ $data['date_start'] ?? 'N/A' }}</td>
                        <td>{{ $data['ctwa_clicks'] ?? 0 }}</td>
                        <td>{{ $data['actions']['lead'] ?? 0 }}</td>
                        <td>{{ $data['impressions'] ?? 0 }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Hidden Table-->
        </div>
    </div>
    <!--end::Card-->
</div>
<!--end::Container-->
@endsection

@push('scripts')
<script>
    // Class definition
    var KTDatatable = function() {
        // Private functions
        var demo = function() {
            var datatable = $('#kt_datatable').KTDatatable({
                // datasource definition
                data: {
                    type: 'local',
                    source: getAnalyticsData(),
                    pageSize: 10,
                },
                
                // layout definition
                layout: {
                    scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                    footer: false // display/hide footer
                },
                
                // column sorting
                sortable: true,
                
                pagination: true,
                
                search: {
                    input: $('#kt_datatable_search_query'),
                    key: 'generalSearch'
                },
                
                // columns definition
                columns: [
                    {
                        field: 'date',
                        title: 'Date',
                        width: 120,
                        autoHide: false
                    }, {
                        field: 'clicks',
                        title: 'CTWA Clicks',
                        width: 100,
                        template: function(row) {
                            return '<span class="label label-lg label-light-' + getColor(row.clicks) + ' label-inline">' + row.clicks + '</span>';
                        }
                    }, {
                        field: 'leads',
                        title: 'Leads',
                        width: 100,
                        template: function(row) {
                            return '<span class="label label-lg label-light-' + getColor(row.leads) + ' label-inline">' + row.leads + '</span>';
                        }
                    }, {
                        field: 'impressions',
                        title: 'Impressions',
                        width: 120,
                        template: function(row) {
                            return '<span class="label label-lg label-light-' + getColor(row.impressions) + ' label-inline">' + row.impressions + '</span>';
                        }
                    }
                ],
            });
            
            $('#kt_datatable_search_status').on('change', function() {
                datatable.search($(this).val().toLowerCase(), 'status');
            });
            
            $('#kt_datatable_reset').on('click', function() {
                datatable.setDataSource(getAnalyticsData());
                $('#kt_datatable_search_status').val('');
                $('#kt_datepicker').val('');
            });
            
            // Date range picker
            $('#kt_datepicker').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                var filteredData = filterByDateRange(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                datatable.setDataSource(filteredData);
            });
        };
        
        var getAnalyticsData = function() {
            var data = [];
            $('#analytics_table tbody tr').each(function() {
                var row = {
                    date: $(this).find('td:eq(0)').text(),
                    clicks: parseInt($(this).find('td:eq(1)').text()) || 0,
                    leads: parseInt($(this).find('td:eq(2)').text()) || 0,
                    impressions: parseInt($(this).find('td:eq(3)').text()) || 0
                };
                data.push(row);
            });
            return data;
        };
        
        var filterByDateRange = function(startDate, endDate) {
            var filtered = [];
            $('#analytics_table tbody tr').each(function() {
                var rowDate = $(this).find('td:eq(0)').text();
                if (rowDate >= startDate && rowDate <= endDate) {
                    var row = {
                        date: rowDate,
                        clicks: parseInt($(this).find('td:eq(1)').text()) || 0,
                        leads: parseInt($(this).find('td:eq(2)').text()) || 0,
                        impressions: parseInt($(this).find('td:eq(3)').text()) || 0
                    };
                    filtered.push(row);
                }
            });
            return filtered;
        };
        
        var getColor = function(value) {
            if (value >= 100) return 'success';
            if (value >= 50) return 'primary';
            if (value >= 10) return 'info';
            if (value > 0) return 'warning';
            return 'danger';
        };
        
        return {
            // public functions
            init: function() {
                demo();
            }
        };
    }();
    
    jQuery(document).ready(function() {
        KTDatatable.init();
    });
</script>
@endpush

@push('styles')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush