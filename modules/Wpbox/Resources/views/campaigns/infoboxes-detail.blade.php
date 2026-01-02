@php
    $total = 0;
    $pendingMessages = 0;
    $ignored = 0;
    $read = 0;
    $ignored = 0;
    $sentMessages = 0;
    $failed = 0;
    $totalContacts = 0;
@endphp
<div class="col-xxl-5 mb-md-5 mb-xl-10">
    <!--begin::Row-->
    <div class="row g-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-md-6 col-xl-6 mb-xxl-10">


            <!--begin::Card widget 5-->
            <div class="card card-flush h-md-50 mb-xl-10">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Info-->
                        <div class="d-flex align-items-center">
                            <!--begin::Amount-->
                            <span class="fs-2hx fw-bold text-gray-500 me-2 lh-1 ls-n2">{{ __('Template') }}</span>
                            <!--end::Amount-->
                        </div>
                        <!--end::Info-->
                        <!--begin::Subtitle-->
                        <span class="text-gray-500 pt-1 fw-semibold fs-6"
                            style="word-break: break-word;">{{ $item->template->name ?? 'N/A' }}</span>

                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex flex-column justify-content-end align-items-start pt-0 w-100">
                    <!--begin::Icon-->
                    <div class="d-flex flex-column justify-content-center align-items-center h-100">
                        <div class="notice bg-light-info rounded border-info border border-dashed p-6 mb-3">
                            <i class="ki-outline ki-notepad-bookmark fs-2tx text-info"></i>
                        </div>
                    </div>

                    <!--end::Icon-->

                    <!-- Content -->
                    <div class="w-100 mt-auto">
                        <div class="d-flex justify-content-between w-100">
                            @if ($item->timestamp_for_delivery > now())
                                <span class="w-bolder fs-6 text-gray-900">{{ __('Scheduled for') }}:
                                    {{ date($item->timestamp_for_delivery) }}</span>
                            @else
                                <span
                                    class="w-bolder fs-6 text-gray-900">{{ $item->timestamp_for_delivery ? $item->timestamp_for_delivery : $item->created_at }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 5-->

            <!--begin::Card widget 9-->
            <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
                <!--begin::Card body-->
                <div class="card-body d-flex justify-content-between flex-column">
                    <!--begin::Statistics-->
                    <div class="mb-0 px-0 pb-0">
                        <!--begin::Statistics-->

                        <!--end::Statistics-->
                        <!--begin::Description-->
                        <span class="fs-6 fw-semibold text-gray-500">{{ __('Read by') }}</span>
                        <!--end::Description-->
                        <div class="d-flex align-items-center mb-2 mt-4">
                            <!--begin::Value-->
                            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1"> {{ $item->read_by }} </span>
                            <span class="text-muted">{{ __('Contacts') }}</span>
                            <!--end::Value-->
                            <!--begin::Label-->
                            {{-- <span class="badge badge-light-info fs-base">
                            <i class="ki-outline ki-arrow-up fs-5 text-primary ms-n1"></i>2.6%</span> --}}
                            <!--end::Label-->
                        </div>
                    </div>
                    <!--end::Statistics-->
                    <!--begin::Chart-->
                    {{-- <div id="kt_card_widget_9_chart" class="min-h-auto" style="height: 100px"></div> --}}
                    <!--end::Chart-->

                    <div class="d-flex align-items-center flex-column w-100">
                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-bolder fs-6 text-gray-900">{{ __('Sent messages') }}</span>
                            @if ($item->delivered_to > 0)
                                <span
                                    class="fw-bold fs-6 text-gray-500">{{ round(($item->read_by / $item->delivered_to) * 100, 2) }}%</span>
                            @else
                                <span class="fw-bold fs-6 text-gray-500">0%</span>
                            @endif

                        </div>
                        <div class="h-8px mx-3 w-100 bg-light-success rounded">
                            <div class="bg-success rounded h-8px" role="progressbar"
                                style="width: {{ round(($item->delivered_to ? $item->read_by / $item->delivered_to : 0) * 100, 2) }}%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 9-->

        </div>
        <!--end::Col-->


        <!--begin::Col-->
        <div class="col-md-6 col-xl-6 mb-xxl-10">

            <!--begin::Card widget 8-->
            <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
                <!--begin::Card body-->
                <div class="card-body d-flex justify-content-between flex-column">
                    <!--begin::Statistics-->
                    <div class="mb-0 px-0 pb-0">
                        <!--begin::Info-->
                        <!--begin::Description-->
                        <span class="fs-6 fw-semibold text-gray-500">{{ __('Delivered to') }}</span>
                        <!--end::Description-->
                        <div class="d-flex align-items-center mb-2 ">

                            <!--begin::Value-->
                            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 mt-4">{{ $item->delivered_to }}</span>
                            <span class="text-muted">{{ __('Contacts') }}</span>
                            <!--end::Value-->

                        </div>
                        <!--end::Info-->

                    </div>
                    <!--end::Statistics-->
                    <!--begin::Chart-->
                    {{-- <div id="kt_card_widget_8_chart" class="min-h-auto" style="height: 100px"></div> --}}
                    <!--end::Chart-->
                    <div class="d-flex align-items-center flex-column w-100">
                        {{-- <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-bolder fs-6 text-gray-900">{{ __('Total delivered') }}</span>
                            <span
                                class="fw-bold fs-6 text-gray-500">{{ round(($item->delivered_to / $item->send_to) * 100, 2) }}%</span>
                        </div> --}}
                        {{-- <div class="h-8px mx-3 w-100 bg-light-success rounded">
                            <div class="bg-success rounded h-8px" role="progressbar"
                                style="width: {{ round(($item->delivered_to / $item->send_to) * 100, 2) }}%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div> --}}
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 8-->


            <!--begin::Card widget 7-->
            <div class="card card-flush h-md-50 mb-xl-10">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Amount-->
                        <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{ $item->send_to }}</span>
                        <!--end::Amount-->
                        <!--begin::Subtitle-->
                        <span class="text-gray-500 pt-1 fw-semibold fs-6"> {{ __('Contacts') }}</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex flex-column justify-content-end">

                    <!--begin::Users group-->
                    <div class="symbol-group symbol-hover flex-nowrap">
                        @foreach ($contacts->take(5) as $contact)
                            <div class="symbol symbol-35px symbol-circle" data-toggle="tooltip"
                                title="{{ $contact->name }}">
                                @if ($contact->avatar)
                                    <img alt="Pic" src="{{ $contact->avatar }}" />
                                @else
                                    <span
                                        class="symbol-label bg-{{ $loop->iteration % 2 == 0 ? 'primary' : 'warning' }} text-inverse-{{ $loop->iteration % 2 == 0 ? 'primary' : 'warning' }} fw-bold">
                                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                        @endforeach

                        @if ($total_contacts > 5)
                            <a href="#" class="symbol symbol-35px symbol-circle">
                                <span class="symbol-label bg-light text-gray-400 fs-8 fw-bold">
                                    +{{ $total_contacts - 5 }}
                                </span>
                            </a>
                        @endif
                    </div>
                    <!--end::Users group-->

                    <div class="d-flex align-items-center flex-column mt-2 w-100">
                        @php
                            $percentage = round(($item->send_to / max($total_contacts, 1)) * 100, 2);
                        @endphp
                        <div class="bg-primary rounded h-8px" role="progressbar" style="width: {{ $percentage }}%;"
                            aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                        </div>

                        <div class="h-8px mx-3 w-100 bg-light-primary rounded">
                            <div class="bg-primary rounded h-8px" role="progressbar"
                                style="width: {{ $total_contacts > 0 ? round(($item->send_to / $total_contacts) * 100, 2) : 0 }}%;"
                                aria-valuenow="{{ $total_contacts > 0 ? round(($item->send_to / $total_contacts) * 100, 2) : 0 }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>

                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 7-->
        </div>
        <!--end::Col-->

    </div>


    @if (request()->is('campaigns/*/show'))
        @php
            $pendingMessages = $setup['pendingMessages'] ?? 0;
            $sendingMessages = $setup['sendingCount'] ?? 0;
            $sentMessages = ($setup['sentCount'] ?? 0) + $sendingMessages;

            $ignored = $setup['deliveredCount'] ?? 0;
            $read = $setup['readCount'] ?? 0;
            $failed = $setup['failedCount'] ?? 0;
            $total = $item->send_to ?? 0;
            $totalContacts = $total;

            $pendingPercentage = $total > 0 ? ($pendingMessages / $total) * 100 : 0;
            $sendingPercentage = $total > 0 ? ($sendingMessages / $total) * 100 : 0;
            $sentPercentage = $total > 0 ? ($sentMessages / $total) * 100 : 0;
            $ignoredPercentage = $total > 0 ? ($ignored / $total) * 100 : 0;
            $readPercentage = $total > 0 ? ($read / $total) * 100 : 0;
            $failedPercentage = $total > 0 ? ($failed / $total) * 100 : 0;
        @endphp


        <div class="col-xl-12 col-md-12 mb-2 mt-4">
            <div class="card card-stats card-statsx">
                <div class="card-body mt-4">
                    <h3>{{ __('Campaign Status') }}</h3>
                    <div class="status-bar">
                        <div class="status-section pending" data-percentage="{{ $pendingPercentage }}">
                            <span class="percentage">{{ round($pendingPercentage) }}%</span>
                            <span class="label">{{ __('Pending') }}</span>
                        </div>
                        <div class="status-section sent" data-percentage="{{ $sentPercentage }}">
                            <span class="percentage">{{ round($sentPercentage) }}%</span>
                            <span class="label">{{ __('Sent') }}</span>
                        </div>
                        <div class="status-section ignored" data-percentage="{{ $ignoredPercentage }}">
                            <span class="percentage">{{ round($ignoredPercentage) }}%</span>
                            <span class="label">{{ __('Ignored') }}</span>
                        </div>
                        <div class="status-section read" data-percentage="{{ $readPercentage }}">
                            <span class="percentage">{{ round($readPercentage) }}%</span>
                            <span class="label">{{ __('Read') }}</span>
                        </div>
                        <div class="status-section failed" data-percentage="{{ $failedPercentage }}">
                            <span class="percentage">{{ round($failedPercentage) }}%</span>
                            <span class="label">{{ __('Failed') }}</span>
                        </div>
                    </div>

                    <div class="legend-container">
                        <div class="legend-item">
                            <span class="legend-box pending"></span> {{ __('Pending') }}
                        </div>
                        <div class="legend-item">
                            <span class="legend-box ignored"></span> {{ __('Ignored') }}
                        </div>
                        <div class="legend-item">
                            <span class="legend-box read"></span> {{ __('Read') }}
                        </div>
                        <div class="legend-item">
                            <span class="legend-box read_ignored"></span> {{ __('Read-Ignored') }}
                        </div>
                        <div class="legend-item">
                            <span class="legend-box sent"></span> {{ __('Sent') }}
                        </div>
                        <div class="legend-item">
                            <span class="legend-box failed"></span> {{ __('Failed') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xl-12 col-md-12 mb-2 mt-4">
            <div class="card card-stats card-statsxl">
                <div class="card-body">
                    <div class="title-bar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30"
                            fill="green">
                            <path
                                d="M3 10v4c0 .55.45 1 1 1h2l3.29 3.29c.19.19.45.29.71.29H11c.55 0 1-.45 1-1v-12c0-.55-.45-1-1-1H9.29c-.26 0-.52.1-.71.29L6 9H4c-.55 0-1 .45-1 1zm4.12 1 2.88-2.88V15.9L7.12 13H4v-2h3.12zM14 4v2c2.76 0 5 2.24 5 5s-2.24 5-5 5v2c3.87 0 7-3.13 7-7s-3.13-7-7-7zm0 4v2c1.1 0 2 .9 2 2s-.9 2-2 2v2c2.21 0 4-1.79 4-4s-1.79-4-4-4z" />
                        </svg>
                        <h4>{{ __('Drive higher conversions through smart retargeting') }}</h4>
                    </div>

                    <hr class="partition-line">
                    <div class="summary-body">
                        <div class="summary-left"><select id="audienceFilter" class="form-select mb-3">
                                <option value="all">{{ __('All') }}</option>
                                <option value="pending">{{ __(key: 'Pending') }}</option>
                                <option value="ignored">{{ __('Ignored') }}</option>
                                <option value="read">{{ __('Read') }}</option>
                                <option value="read_ignored">{{ __('Read/Ignored Both') }}</option>
                                <option value="sent">{{ __(key: 'Sent') }}</option>
                                <option value="failed">{{ __('Failed') }}</option>
                            </select>
                            <button id="sendBroadcastButton"
                                class="btn btn-success w-100 {{ ($setup['pendingMessages'] ?? 0) >= 1 ? 'disabled' : '' }}">
                                {{ __('Send New Broadcast') }}
                            </button>

                        </div>
                        <div class="summary-right">
                            <h4>{{ __('Audience Summary') }}</h4>
                            <p><strong>{{ __('Selected') }}:</strong> <span id="selectedType">All</span></p>
                            <p><strong>{{ __('Total Count') }}:</strong> <span
                                    id="audienceCount">{{ $totalContacts }}</span></p>
                            <p class="totalOnStatusBar text-muted">{{ __('out of') }} {{ $totalContacts }}
                                {{ __('recipients') }}</p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif
    <!--end::Row-->
</div>

<div id="customPopup" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="customPopupTitle" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p id="customPopupMessage"></p>
            </div>
        </div>
    </div>
</div>

<div id="progressPopup" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="progressPopupTitle" class="modal-title"></h5>
            </div>
            <div class="modal-body">
                <p id="progressPopupMessage"></p>
                <div class="progress">
                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                        role="progressbar" style="width: 0%">0%</div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('topcss')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .card-statsxl {
            height: 250px !important;
        }

        .card-statsx {
            height: 250px !important;
        }

        @media (max-width: 768px) {
            .card-statsxl {
                height: 240px !important;
            }

            .card-statsx {
                height: 200px !important;
            }
        }

        .status-container {
            max-width: 100%;
            text-align: left;
        }

        .status-bar {
            width: 100%;
            height: 50px;
            background-color: #ddd;
            display: flex;
            overflow: hidden;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
        }

        .status-section {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 12px;
            font-weight: bold;
            color: white;
            text-align: center;
            padding: 0 5px;
            min-width: 35px;
        }

        .pending {
            background-color: #cba313;
        }

        .sending {
            background-color: #afbb60;
        }

        .sent {
            background-color: #505047;
        }

        .ignored {
            background-color: #5D3FD3;
        }

        .read {
            background-color: #2dce89;
        }

        .failed {
            background-color: #D2042D;
        }

        .legend-container {
            display: flex;
            justify-content: left;
            gap: 15px;
            margin-top: 50px
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }

        .legend-box {
            width: 14px;
            height: 14px;
            display: inline-block;
            border-radius: 3px;
        }

        .legend-box.pending {
            background-color: #cba313;
        }

        .legend-box.sending {
            background-color: #afbb60;
        }

        .legend-box.sent {
            background-color: #505047;
        }

        .legend-box.ignored {
            background-color: #5D3FD3;
        }

        .legend-box.read {
            background-color: #2dce89;
        }

        .legend-box.read_ignored {
            background-color: #01d6bd;
        }

        .legend-box.failed {
            background-color: #D2042D;
        }

        #audienceFilter {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .title-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .partition-line {
            border: 0;
            height: 1px;
            background: #ddd;
            width: 100%;
            margin: 10px 0;
        }

        .summary-body {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-top: 10px;
            width: 100%;
        }

        .summary-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .summary-right {
            text-align: right;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .btn-success {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
        }

        .status-tooltip {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.75);
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            display: none;
            z-index: 10;
        }

        .loading-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 18px;
            font-weight: bold;
            flex-direction: column;
            z-index: 1000;
        }

        .spinner {
            border: 6px solid rgba(255, 255, 255, 0.3);
            border-top: 6px solid white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('topjs')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (request()->is('campaigns/*/show'))
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>̦
        <script>
            $(document).ready(function() {
                if ($("#sendBroadcastButton").hasClass("disabled")) {
                    $("#sendBroadcastButton").on("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Action Denied',
                            text: 'You cannot send a new broadcast while pending messages exist!',
                            confirmButtonText: 'OK'
                        });
                    });
                }
                $('#downloadReportBtn').on('click', function() {
                    var selectedFilter = $('#audienceFilter').val();
                    var audienceCount = getAudienceCount(selectedFilter);

                    console.log(audienceCount);
                    if (audienceCount === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Download Denied',
                            text: 'The selected audience count is 0%. Report download is not possible!',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Generating Report...',
                        text: 'Please wait while we generate your report.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('campaigns.report', ['campaign' => $setup['campaign_id']]) }}",
                        type: "POST",
                        data: {
                            filter: selectedFilter,
                            _token: "{{ csrf_token() }}"
                        },
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function(data, status, xhr) {
                            console.log("AJAX request success!");

                            var filename = "campaign_report.csv";
                            var disposition = xhr.getResponseHeader('Content-Disposition');

                            if (disposition && disposition.indexOf('attachment') !== -1) {
                                var matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(
                                    disposition);
                                if (matches != null && matches[1]) filename = matches[1].replace(
                                    /['"]/g, '');
                            }

                            var blob = new Blob([data], {
                                type: "text/csv"
                            });
                            var link = document.createElement("a");
                            link.href = window.URL.createObjectURL(blob);
                            link.download = filename;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);

                            // Swal.fire({
                            //     icon: 'success',
                            //     title: 'Report Generated!',
                            //     text: 'Your report has been downloaded successfully.',
                            //     confirmButtonText: 'OK'
                            // });

                            Swal.fire({
                                icon: "success",
                                title: "{{ __('Report Generated!') }}",
                                text: "{{ __('Your report has been downloaded successfully.') }}",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 1500
                            });

                            let icon = button.querySelector("i");
                            if (icon) {
                                icon.classList.replace("fa-copy", "fa-check");
                                setTimeout(() => icon.classList.replace("fa-check", "fa-copy"),
                                    1500);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX request failed:", xhr);

                            if (xhr.responseType === 'blob') {
                                let reader = new FileReader();
                                reader.onload = function() {
                                    let responseText = reader.result;
                                    try {
                                        let json = JSON.parse(responseText);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: json.message ||
                                                "An unexpected error occurred.",
                                            confirmButtonText: 'OK'
                                        });
                                    } catch (e) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: "An unexpected error occurred. Please try again!",
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                };
                                reader.readAsText(xhr.response);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: "An unexpected error occurred. Please try again!",
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                });

                function getAudienceCount(filter) {
                    var audienceCounts = {
                        'all': {{ $total }},
                        'pending': {{ $pendingMessages }},
                        'ignored': {{ $ignored }},
                        'read': {{ $read }},
                        'read_ignored': {{ $read + $ignored }},
                        'sent': {{ $sentMessages }},
                        'failed': {{ $failed }}
                    };
                    return audienceCounts[filter] || 0;
                }
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let statusBar = document.querySelector(".status-bar");
                let audienceFilter = document.getElementById("audienceFilter");
                let sendButton = document.getElementById("sendBroadcastButton");
                let selectedType = document.getElementById("selectedType");
                let audienceCountElem = document.getElementById("audienceCount");
                let totalRecipientsElem = document.querySelector(".totalOnStatusBar");

                if (!statusBar || !audienceFilter || !sendButton || !selectedType || !audienceCountElem || !
                    totalRecipientsElem) {
                    console.error("{{ __('Error: One or more elements not found in the DOM.') }}");
                    return;
                }

                let totalRecipients = {{ $totalContacts }};
                let counts = {
                    pending: {{ $pendingMessages }},
                    sent: {{ $sentMessages }},
                    read: {{ $read }},
                    ignored: {{ $ignored }},
                    failed: {{ $failed }},
                    read_ignored: {{ $read + $ignored }}
                };

                let bars = {
                    pending: document.querySelector(".status-section.pending"),
                    sent: document.querySelector(".status-section.sent"),
                    ignored: document.querySelector(".status-section.ignored"),
                    read: document.querySelector(".status-section.read"),
                    failed: document.querySelector(".status-section.failed")
                };

                let tooltip = document.createElement("div");
                tooltip.classList.add("status-tooltip");
                document.body.appendChild(tooltip);

                function updateStatusBar(selected) {
                    let audienceCount = counts[selected] || 0;
                    let percentage = totalRecipients > 0 ? ((audienceCount / totalRecipients) * 100).toFixed(2) : 0;
                    let percentageText = selected === "all" ? "" : `(${percentage}%)`;

                    if (selected === "all") {
                        audienceCount = totalRecipients;
                        percentageText = "";
                    }

                    selectedType.textContent = selected.replace("_", " ").toUpperCase();
                    audienceCountElem.textContent = `${audienceCount} ${percentageText}`;
                    totalRecipientsElem.textContent = selected === "all" ? `out of ${totalRecipients} recipient` :
                        `out of ${totalRecipients} recipients`;

                    Object.values(bars).forEach(bar => bar.style.display = "none");

                    let readIgnoredBar = document.querySelector(".status-section.read_ignored");
                    if (readIgnoredBar) readIgnoredBar.remove();

                    if (selected === "all") {
                        ["pending", "sent", "ignored", "read", "failed"].forEach(status => {
                            let count = counts[status];
                            let statusPercentage = totalRecipients > 0 ? ((count / totalRecipients) * 100)
                                .toFixed(2) : 0;
                            let bar = bars[status];

                            if (count > 0) {
                                bar.style.display = "flex";
                                bar.style.width = statusPercentage < 10 ? "15%" : `${statusPercentage}%`;
                                bar.innerHTML =
                                    `<span class="percentage">${count} (${statusPercentage}%)</span><span class="label">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;

                                addTooltip(bar,
                                    `${status.charAt(0).toUpperCase() + status.slice(1)}: ${count} (${statusPercentage}%) out of ${totalRecipients} recipients`
                                );
                            }
                        });
                    } else if (selected === "read_ignored" && audienceCount > 0) {
                        readIgnoredBar = document.createElement("div");
                        readIgnoredBar.classList.add("status-section", "read_ignored");
                        readIgnoredBar.style.backgroundColor = "#01d6bd";
                        readIgnoredBar.style.width = percentage < 10 ? "15%" : `${percentage}%`;
                        readIgnoredBar.innerHTML =
                            `<span class="percentage">${audienceCount} (${percentage}%)</span><span class="label">Read Ignored</span>`;
                        statusBar.prepend(readIgnoredBar);
                        readIgnoredBar.style.display = "flex";

                        addTooltip(readIgnoredBar,
                            `Read Ignored: ${audienceCount} (${percentage}%) out of ${totalRecipients} recipients`);
                    } else {
                        let selectedBar = bars[selected];
                        if (selectedBar && audienceCount > 0) {
                            selectedBar.style.display = "flex";
                            selectedBar.style.width = percentage < 10 ? "15%" : `${percentage}%`;
                            selectedBar.innerHTML =
                                `<span class="percentage">${audienceCount} (${percentage}%)</span><span class="label">${selected.charAt(0).toUpperCase() + selected.slice(1)}</span>`;

                            addTooltip(selectedBar,
                                `${selected.charAt(0).toUpperCase() + selected.slice(1)}: ${audienceCount} (${percentage}%) out of ${totalRecipients} recipients`
                            );
                        }
                    }

                    let totalAudienceBar = document.querySelector(".status-section.total_audience");
                    if (!totalAudienceBar) {
                        totalAudienceBar = document.createElement("div");
                        totalAudienceBar.classList.add("status-section", "total_audience");
                        totalAudienceBar.style.backgroundColor = "#8b7b7b";
                        totalAudienceBar.innerHTML =
                            `<span class="percentage">${totalRecipients}</span><span class="label">Total</span>`;
                        statusBar.appendChild(totalAudienceBar);
                    }

                    if (selected === "all") {
                        totalAudienceBar.style.display = "none";
                    } else if (percentage === "100.00") {
                        totalAudienceBar.style.display = "none";
                    } else if (percentage === "0.00") {
                        totalAudienceBar.style.display = "flex";
                        totalAudienceBar.style.width = "100%";
                        totalAudienceBar.innerHTML =
                            `<span class="percentage">0% out of ${totalRecipients} recipients</span>`;
                        addTooltip(totalAudienceBar,
                            `${toTitleCase(selectedType.textContent)}: 0% out of ${totalRecipients} recipients`);
                        //addTooltip(totalAudienceBar, `Remaining: ${totalRecipients - audienceCount} out of ${totalRecipients} recipients`);
                    } else {
                        totalAudienceBar.style.display = "flex";
                        totalAudienceBar.style.width = `${100 - percentage}%`;
                        totalPercentage = `${100 - percentage}%`;
                        totalAudienceBar.innerHTML =
                            `<span class="percentage">out of ${totalRecipients} recipients</span>`;
                        addTooltip(totalAudienceBar,
                            `${toTitleCase(selectedType.textContent)}: ${audienceCount} (${percentage}%) out of ${totalRecipients} recipients`
                        );
                        //addTooltip(totalAudienceBar, `Remaining: ${totalRecipients - audienceCount} out of ${totalRecipients} recipients`);
                    }

                    // sendButton.disabled = selected === "failed" || selected === "pending";
                    sendButton.disabled = selected === "pending";

                }

                function addTooltip(element, text) {
                    element.addEventListener("mouseover", function(event) {
                        tooltip.innerHTML = text;
                        tooltip.style.display = "block";
                        tooltip.style.left = `${event.pageX + 10}px`;
                        tooltip.style.top = `${event.pageY + 10}px`;
                    });

                    element.addEventListener("mousemove", function(event) {
                        tooltip.style.left = `${event.pageX + 10}px`;
                        tooltip.style.top = `${event.pageY + 10}px`;
                    });

                    element.addEventListener("mouseout", function() {
                        tooltip.style.display = "none";
                    });
                }

                function toTitleCase(str) {
                    return str.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
                }

                updateStatusBar("all");
                audienceFilter.addEventListener("change", function() {
                    updateStatusBar(this.value);
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                let sendButton = document.getElementById("sendBroadcastButton");
                let audienceFilter = document.getElementById("audienceFilter");
                let audienceCountElem = document.getElementById("audienceCount");

                if (!sendButton || !audienceFilter || !audienceCountElem) {
                    console.error("Error: Elements not found!");
                    return;
                }

                sendButton.addEventListener("click", function() {
                    let selectedStatus = audienceFilter.value;
                    let selectedStatusValue = document.getElementById("audienceFilter").value;
                    let audienceCountText = audienceCountElem.textContent.trim();
                    let audienceCount = parseInt(audienceCountText.split(" ")[0]);
                    //console.log("status count: " + selectedStatusValue);
                    if (!selectedStatus) {
                        Swal.fire({
                            icon: "warning",
                            title: "{{ __('No Audience Selected') }}",
                            text: "{{ __('Please select an audience type before starting a broadcast.') }}"
                        });
                        return;
                    }

                    if (isNaN(audienceCount) || audienceCount < 1) {
                        Swal.fire({
                            icon: "error",
                            title: "{{ __('Broadcast Cannot Start') }}",
                            text: "{{ __('The selected audience count is 0%. Please choose a valid audience.') }}"
                        });
                        return;
                    }

                    Swal.fire({
                        title: "{{ __('Are you sure?') }}",
                        text: "{{ __('Do you want to start a new broadcast?') }}",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#28a745",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, Start Broadcast"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //startBroadcast(selectedStatus);
                            let redirectUrl =
                                `{{ route('campaigns.create', ['resend' => $setup['campaign_id']]) }}` +
                                `&rtype=` + encodeURIComponent(selectedStatusValue);
                            window.location.href = redirectUrl;
                        }
                    });
                });

                // function startBroadcast(selectedStatus) {

                //     let loadingPopup = document.createElement("div");
                //     loadingPopup.classList.add("loading-popup");
                //     loadingPopup.innerHTML = `<div class="spinner"></div><p>Starting campaign...</p>`;
                //     document.body.appendChild(loadingPopup);

                //     sendButton.disabled = true;
                //     audienceFilter.disabled = true;

                //     fetch("/start-campaign", {
                //             method: "POST",
                //             headers: {
                //                 "Content-Type": "application/json",
                //                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                //                     "content")
                //             },
                //             body: JSON.stringify({
                //                 audience: selectedStatus
                //             })
                //         })
                //         .then(response => response.json())
                //         .then(data => {
                //             if (data.success) {
                //                 Swal.fire({
                //                     icon: "success",
                //                     title: "{{ __('Broadcast Started!') }}",
                //                     text: "{{ __('Redirecting to your campaign...') }}",
                //                     timer: 2000,
                //                     showConfirmButton: false
                //                 }).then(() => {
                //                     window.location.href = `/campaign/${data.campaign_id}`;
                //                 });
                //             } else {
                //                 Swal.fire({
                //                     icon: "error",
                //                     title: "Error!",
                //                     text: data.message
                //                 });
                //             }
                //         })
                //         .catch(error => {
                //             console.error("Error:", error);
                //             Swal.fire({
                //                 icon: "error",
                //                 title: "{{ __('Oops!') }}",
                //                 text: "{{ __('Something went wrong. Please try again.') }}"
                //             });
                //         })
                //         .finally(() => {

                //             loadingPopup.remove();
                //             sendButton.disabled = false;
                //             audienceFilter.disabled = false;
                //         });
                // }
            });
        </script>
    @endif
@endsection
