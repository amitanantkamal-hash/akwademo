<div class="row d-flex align-items-stretch mb-5">

    <div class="col-xl-3 d-flex">
        <div class="card bg-body hoverable card-xl-stretch mb-xl-8 w-100">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center fs-semibold text-gray-600">
                    <i class="ki-outline ki-abstract-14 text-info fs-2x ms-n1 me-2"> </i>
                    {{ __('Template')}}
                </div>
                <div class="text-gray-900 fw-bold fs-4 mb-4 mt-5 flex-grow-1">
                    {{ $item->template->name }}
                </div>
                <div class="fw-semibold text-gray-400 mt-auto">
                    @if ($item->timestamp_for_delivery > now())
                        <span class="text mr-2">{{ __('Scheduled for')}}: {{ date($item->timestamp_for_delivery) }}</span>
                    @else
                        <span class="text-v mr-2">{{ $item->timestamp_for_delivery?$item->timestamp_for_delivery:$item->created_at }}</span>
                    @endif
                </div>
            </div>
            <!--end::Body-->
        </div>
    </div>

    @if ($item->is_bot)
    @elseif ($item->is_api)
    @else

        <div class="col-xl-3 d-flex">
            <div class="card bg-body hoverable card-xl-stretch mb-xl-8 w-100">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center fs-semibold text-gray-600">
                        <i class="ki-outline ki-people text-info fs-2x ms-n1 me-2"></i>
                        {{ __('Contacts')}}
                    </div>
                    <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 flex-grow-1">
                        {{ $item->send_to }}
                    </div>
                    <div class="fw-semibold text-gray-400 mt-auto">
                        <span class="text mr-2">
                            {{ round(($item->send_to/$total_contacts)*100,2) }}% {{ __('of your contacts') }}
                        </span>
                    </div>
                </div>
                <!--end::Body-->
            </div>
        </div>

        <div class="col-xl-3 d-flex">
            <div class="card bg-body hoverable card-xl-stretch mb-xl-8 w-100">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center fs-semibold text-gray-600">
                        <i class="ki-outline ki-check-circle text-info fs-2x ms-n1 me-2"> </i>
                        {{ __('Delivered to')}}
                    </div>
                    <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 flex-grow-1">
                        {{ round(($item->delivered_to/$item->send_to)*100,2) }}%
                    </div>
                    <div class="fw-semibold text-gray-400 mt-auto">
                        <span class="text-info mr-2">{{ $item->delivered_to }}</span>
                        <span class="text-nowrap">{{ __('Contacts') }}</span>
                    </div>
                </div>
                <!--end::Body-->
            </div>
        </div>

        <div class="col-xl-3 d-flex">
            <div class="card bg-body hoverable card-xl-stretch mb-xl-8 w-100">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center fs-semibold text-gray-600">
                        <i class="ki-outline ki-message-notif text-info fs-2x ms-n1 me-2"> </i>
                        {{ __('Read by')}}
                    </div>
                    @if ($item->delivered_to > 0)
                        <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 flex-grow-1">
                            {{ round(($item->read_by/$item->delivered_to)*100,2) }}%
                        </div>
                    @else
                        <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 flex-grow-1">0%</div>
                    @endif
                    <div class="fw-semibold text-gray-400 mt-auto">
                        <span class="text mr-2">
                            {{ $item->read_by }} {{ __('of the')}} {{ $item->delivered_to }} {{ __('Contacts messaged.') }}
                        </span>
                    </div>
                </div>
                <!--end::Body-->
            </div>
        </div>

    @endif
</div>

