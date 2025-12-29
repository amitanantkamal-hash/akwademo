<!--begin::Card-->
<div class="card">
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table-->
        @php
            $dataChart = \Modules\Wpbox\Models\Campaign::where('company_id', auth()->user()->company->id)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get()
                ->toArray();

        @endphp
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
            <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="text-center min-w-100px">{{ __('Name') }}</th>
                    <th class="text-center min-w-100px">{{ __('Contacts') }}</th>
                    <th class="text-center min-w-100px">{{ __('Views') }}</th>
                    <th class="text-center min-w-100px">{{ __('Date') }}</th>
                    <th class="text-center min-w-100px">{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @foreach ($dataChart as $item)
                    @php
                        try {
                            $deliveryTime = \Carbon\Carbon::createFromFormat(
                                'm/d/Y h:i A',
                                $item['timestamp_for_delivery'],
                            );
                        } catch (\Exception $e) {
                            $deliveryTime = null;
                        }
                    @endphp
                    <tr>
                        <td class="text-start">
                            <div class="d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label bg-light-primary">
                                        <i class="ki-duotone ki-sms fs-2x text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Icon-->

                                <div class="ms-0">
                                    <a href="{{ route('campaigns.show', ['campaign' => $item['id']]) }}"
                                        class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 100%;">
                                        {{ $item['name'] }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="text-center" data-order="{{ $item['send_to'] }}">
                            <span class="fw-bold d-flex align-items-center justify-content-center">
                                <i class="ki-duotone ki-profile-user fs-3 me-2 text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                {{ $item['send_to'] }}
                            </span>
                        </td>
                        <td class="text-center" data-order="{{ $item['read_by'] }}">
                            <span class="fw-bold d-flex align-items-center justify-content-center">
                                <i class="ki-duotone ki-eye fs-3 me-2 text-info">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ $item['read_by'] }}
                            </span>
                        </td>
                        <td class="text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <span class="fw-bold d-flex align-items-center justify-content-center">
                                <i class="ki-duotone ki-calendar-8 fs-3 me-2 text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ $deliveryTime ? $deliveryTime->format('Y-m-d') : 'Invalid date' }}
                            </span>
                        </td>

                        <td class="text-center"
                            data-order="{{ $deliveryTime ? $deliveryTime->format('Y-m-d H:i') : '' }}">
                            @if ($deliveryTime && $deliveryTime->isPast())
                                <span
                                    class="badge badge-light-success d-flex align-items-center justify-content-center py-3 px-4">
                                    <i class="ki-duotone ki-check-circle fs-3 me-2 text-success">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ __('Sent') }}
                                </span>
                            @else
                                <span
                                    class="badge badge-light-warning d-flex align-items-center justify-content-center py-3 px-4">
                                    <i class="ki-duotone ki-clock fs-3 me-2 text-warning">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                    Scheduled
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

@push('js')
    <script>
        $(document).ready(function() {
            // Destroy existing DataTable if already initialized
            if ($.fn.DataTable.isDataTable('#kt_ecommerce_products_table')) {
                $('#kt_ecommerce_products_table').DataTable().destroy();
            }
            // Initialize DataTable with a button instead of "info" text
            $('#kt_ecommerce_products_table').DataTable({
                "lengthMenu": [
                    [5, 10],
                    [5, 10]
                ],
                "language": {
                    "info": '<a href="{{ route('campaigns.index') }}" class="btn btn-info btn-sm mx-3">{{ __('Show Campaigns') }}</a>'
                }
            });
        });

        function orderTable(status) {
            var table = $('#kt_ecommerce_products_table').DataTable();
            if (status === 'sent') {
                table.column(4).order('asc').draw();
            } else {
                table.column(4).order('des').draw();
            }
        }
    </script>
@endpush
