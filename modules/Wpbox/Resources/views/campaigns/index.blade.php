@extends('general.index-client', $setup)

@section('title')
    {{ __('Campaign Performance') }}
    <x-button-links />
@endsection

@section('content')
    <div class="container-xxl">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-message-text-2 fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    {{ __('Campaign Performance') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $setup['items']->total() }}
                    {{ __('Campaigns') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">

                <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>
                    {{ __('Create Campaign') }}
                </a>
            </div>
        </div>

        @if ($setup['items']->isNotEmpty())
            @php
                // Calculate overall stats from all campaigns
                $totalCampaigns = $setup['items']->count();
                $totalSent = $setup['items']->sum('send_to');
                $totalDelivered = $setup['items']->sum('delivered_to');
                $totalRead = $setup['items']->sum('read_by');
                $totalClicked = $setup['items']->sum('clicked');

                $deliveryRate = $totalSent > 0 ? round(($totalDelivered / $totalSent) * 100, 1) : 0;
                $readRate = $totalDelivered > 0 ? round(($totalRead / $totalDelivered) * 100, 1) : 0;
                $engagementRate =
                    $totalDelivered > 0 ? round((($totalRead + $totalClicked) / $totalDelivered) * 100, 1) : 0;

                $scheduledCampaigns = $setup['items']
                    ->filter(function ($campaign) {
                        return $campaign->timestamp_for_delivery > now();
                    })
                    ->count();

                $completedCampaigns = $totalCampaigns - $scheduledCampaigns;
            @endphp

            <div class="row g-6 mb-7">
                <!-- Total Campaigns -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder">{{ $setup['stats']['totalCampaigns'] }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Total Campaigns') }}</span>
                        <div class="d-flex gap-2 mt-2">
                            <span class="badge badge-light-success">{{ $setup['stats']['completedCampaigns'] }}
                                {{ __('Completed') }}</span>
                            <span class="badge badge-light-warning">{{ $setup['stats']['scheduledCampaigns'] }}
                                {{ __('Scheduled') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Messages Sent -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span
                            class="fs-2hx fw-bolder text-primary">{{ number_format($setup['stats']['totalSent']) }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Messages Sent') }}</span>
                        <div class="progress w-100 mt-3" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $total_contacts > 0 ? min(100, round(($setup['stats']['totalSent'] / $total_contacts) * 100)) : 0 }}%">
                            </div>
                        </div>
                        <small class="text-muted mt-1">
                            {{ $total_contacts > 0 ? round(($setup['stats']['totalSent'] / $total_contacts) * 100, 1) : 0 }}%
                            of total contacts
                        </small>
                    </div>
                </div>

                <!-- Delivery Rate -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-success">{{ $setup['stats']['deliveryRate'] }}%</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Delivery Rate') }}</span>
                        <div class="d-flex align-items-center mt-2">
                            <span class="text-success fs-7 fw-bold">{{ number_format($setup['stats']['totalDelivered']) }}
                                delivered</span>
                            <span class="text-muted mx-2">•</span>
                            <span class="text-gray-600 fs-7">{{ number_format($setup['stats']['totalSent']) }} sent</span>
                        </div>
                        <div class="progress w-100 mt-2" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $setup['stats']['deliveryRate'] }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Read Rate -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-info">{{ $setup['stats']['readRate'] }}%</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Read Rate') }}</span>
                        <div class="d-flex align-items-center mt-2">
                            <span class="text-info fs-7 fw-bold">{{ number_format($setup['stats']['totalRead']) }}
                                read</span>
                            <span class="text-muted mx-2">•</span>
                            <span class="text-gray-600 fs-7">{{ number_format($setup['stats']['totalClicked']) }}
                                clicks</span>
                        </div>
                        <div class="progress w-100 mt-2" style="height: 6px;">
                            <div class="progress-bar bg-info" role="progressbar"
                                style="width: {{ $setup['stats']['readRate'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Performance Overview Card -->
            <div class="card mb-7">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Campaign Performance Overview') }}</h3>
                    <div class="card-toolbar">
                        <span class="text-muted fs-7">{{ __('Last 30 days') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-6">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px symbol-circle me-4">
                                    <div class="symbol-label bg-light-primary">
                                        <i class="ki-duotone ki-send fs-2 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div>
                                    <span
                                        class="text-gray-800 fw-bold fs-4 d-block">{{ number_format($setup['last30DaysStats']['totalSent']) }}</span>
                                    <span class="text-muted fs-7">{{ __('Total Sent') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px symbol-circle me-4">
                                    <div class="symbol-label bg-light-success">
                                        <i class="ki-duotone ki-check fs-2 text-success"></i>
                                    </div>
                                </div>
                                <div>
                                    <span
                                        class="text-gray-800 fw-bold fs-4 d-block">{{ number_format($setup['last30DaysStats']['totalDelivered']) }}</span>
                                    <span class="text-muted fs-7">{{ __('Delivered') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px symbol-circle me-4">
                                    <div class="symbol-label bg-light-info">
                                        <i class="ki-duotone ki-double-check fs-2 text-success">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div>
                                    <span
                                        class="text-gray-800 fw-bold fs-4 d-block">{{ number_format($setup['last30DaysStats']['totalRead']) }}</span>
                                    <span class="text-muted fs-7">{{ __('Read') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px symbol-circle me-4">
                                    <div class="symbol-label bg-light-warning">
                                        <i class="ki-duotone ki-exit-right-corner fs-2 text-warning">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div>
                                    <span
                                        class="text-gray-800 fw-bold fs-4 d-block">{{ number_format($setup['last30DaysStats']['totalClicked']) }}</span>
                                    <span class="text-muted fs-7">{{ __('Clicks') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Campaigns List -->
        <div class="card">
            @if ($setup['items']->isNotEmpty())
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('All Campaigns') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted fs-7">{{ __('Filter by status:') }}</span>
                            <select class="form-select form-select-sm w-150px" id="status-filter">
                                <option value="">{{ __('All Campaigns') }}</option>
                                <option value="scheduled">{{ __('Scheduled') }}</option>
                                <option value="completed">{{ __('Completed') }}</option>
                                <option value="active">{{ __('Active') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Campaigns List -->
                <div class="card-body pt-0">
                    @foreach ($setup['items'] as $item)
                        @if ($item->template)
                            <div class="campaign-item mb-6"
                                data-status="{{ $item->timestamp_for_delivery > now() ? 'scheduled' : 'completed' }}">
                                <!-- Campaign Card -->
                                <div class="card card-flush">
                                    <div class="card-header pt-7">
                                        <div class="card-title">
                                            <h2 class="d-flex align-items-center text-gray-900 fw-bold fs-3">
                                                {{ $item->name }}
                                                @if ($item->timestamp_for_delivery > now())
                                                    <span
                                                        class="badge badge-light-warning ms-2">{{ __('Scheduled') }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-light-success ms-2">{{ __('Completed') }}</span>
                                                @endif
                                            </h2>
                                        </div>
                                        <div class="card-toolbar">
                                            <span class="badge badge-light-primary py-4 px-3 fs-7 me-2">
                                                <i class="ki-outline ki-file-text fs-4 me-2 text-primary"></i>
                                                {{ $item->template->name }}
                                            </span>
                                            <a href="{{ route('campaigns.show', $item->id) }}"
                                                class="btn btn-sm btn-icon btn-light-primary" data-bs-toggle="tooltip"
                                                title="View Details">
                                                <i class="ki-outline ki-eye fs-2"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="card-body pt-0">
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!-- Left Section -->
                                            <div class="flex-lg-row-auto w-lg-300px me-10">
                                                <!-- Timeline -->
                                                <div class="timeline timeline-line-dashed border-transparent">
                                                    <div class="timeline-item align-items-start">
                                                        <div class="timeline-label text-gray-600 fw-bold fs-6">
                                                            {{ $item->created_at->format('M d') }}
                                                        </div>
                                                        <div class="timeline-badge">
                                                            <i class="ki-outline ki-calendar-8 fs-2 text-primary"></i>
                                                        </div>
                                                        <div class="timeline-content fw-semibold text-gray-600">
                                                            {{ __('Created') }}
                                                        </div>
                                                    </div>

                                                    <div class="timeline-item align-items-start">
                                                        <div class="timeline-label text-gray-600 fw-bold fs-6">
                                                           @if (!empty($item->timestamp_for_delivery))
                                                                @php
                                                                    try {
                                                                        $deliveryDate = \Carbon\Carbon::createFromFormat('m/d/Y h:i A', $item->timestamp_for_delivery);
                                                                    } catch (\Exception $e) {
                                                                        $deliveryDate = null;
                                                                    }
                                                                @endphp
                                                            
                                                                {{ $deliveryDate ? $deliveryDate->format('M d') : 'Invalid date' }}
                                                            @endif

                                                        </div>
                                                        <div class="timeline-badge">
                                                            <i
                                                                class="ki-outline ki-send fs-2 text-{{ $item->timestamp_for_delivery > now() ? 'warning' : 'success' }}"></i>
                                                        </div>
                                                        <div
                                                            class="timeline-content fw-semibold text-{{ $item->timestamp_for_delivery > now() ? 'warning' : 'success' }}">
                                                            {{ $item->timestamp_for_delivery > now() ? 'Scheduled' : 'Sent' }}
                                                        </div>
                                                    </div>

                                                    <div class="timeline-item align-items-start">
                                                        <div class="timeline-label text-gray-600 fw-bold fs-6">
                                                            {{ $item->updated_at->format('M d') }}
                                                        </div>
                                                        <div class="timeline-badge">
                                                            <i class="ki-outline ki-clock fs-2 text-gray-400"></i>
                                                        </div>
                                                        <div class="timeline-content fw-semibold text-gray-600">
                                                            {{ __('Last activity') }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Contacts Reached -->
                                                <div
                                                    class="card card-flush bg-light-primary border border-primary border-dashed h-md-50 mt-5 mb-4">
                                                    <div class="card-header pt-5">
                                                        <div class="card-title d-flex flex-column">
                                                            <span
                                                                class="fs-2hx fw-bold text-primary me-2 lh-1">{{ $item->send_to }}</span>
                                                            <span class="text-gray-600 pt-1 fw-semibold fs-6">Contacts
                                                                Reached</span>
                                                        </div>
                                                    </div>
                                                    <div class="card-body pt-0 pb-5">
                                                        <div class="progress bg-primary bg-opacity-10 h-8px">
                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                style="width: {{ $total_contacts > 0 ? round(($item->send_to / $total_contacts) * 100, 2) : 0 }}%">
                                                            </div>
                                                        </div>
                                                        <div class="pt-3">
                                                            <span class="text-gray-600 fw-semibold fs-7">
                                                                {{ $total_contacts > 0 ? round(($item->send_to / $total_contacts) * 100, 2) : 0 }}%
                                                                of total contacts
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Section -->
                                            <div class="flex-lg-fluid">
                                                @if (!$item->is_bot && !$item->is_api)
                                                    <!-- Performance Metrics -->
                                                    <div class="row g-6 mb-6">
                                                        <!-- Delivery Rate -->
                                                        <div class="col-sm-6 col-lg-4">
                                                            <div class="card card-flush h-md-100">
                                                                <div class="card-header pt-5">
                                                                    <div class="card-title d-flex flex-column">
                                                                        <span
                                                                            class="fs-2hx fw-bold text-gray-800 me-2 lh-1">
                                                                            {{ $item->send_to > 0 ? round(($item->delivered_to / $item->send_to) * 100, 2) . '%' : '0%' }}
                                                                        </span>
                                                                        <span
                                                                            class="text-gray-600 pt-1 fw-semibold fs-6">Delivery
                                                                            Rate</span>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body d-flex align-items-end pt-0">
                                                                    <div
                                                                        class="d-flex align-items-center flex-column mt-3 w-100">
                                                                        <div
                                                                            class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                                            <span
                                                                                class="fw-semibold text-success fs-6">{{ $item->delivered_to }}
                                                                                delivered</span>
                                                                            <span
                                                                                class="fw-semibold text-gray-600 fs-6">{{ $item->send_to }}
                                                                                total</span>
                                                                        </div>
                                                                        <div class="progress h-8px w-100 bg-light-success">
                                                                            <div class="progress-bar bg-success"
                                                                                role="progressbar"
                                                                                style="width: {{ $item->send_to > 0 ? round(($item->delivered_to / $item->send_to) * 100, 2) : 0 }}%">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Read Rate -->
                                                        <div class="col-sm-6 col-lg-4">
                                                            <div class="card card-flush h-md-100">
                                                                <div class="card-header pt-5">
                                                                    <div class="card-title d-flex flex-column">
                                                                        <span
                                                                            class="fs-2hx fw-bold text-gray-800 me-2 lh-1">
                                                                            {{ $item->delivered_to > 0 ? round(($item->read_by / $item->delivered_to) * 100, 2) : 0 }}%
                                                                        </span>
                                                                        <span
                                                                            class="text-gray-600 pt-1 fw-semibold fs-6">Read
                                                                            Rate</span>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body d-flex align-items-end pt-0">
                                                                    <div
                                                                        class="d-flex align-items-center flex-column mt-3 w-100">
                                                                        <div
                                                                            class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                                            <span
                                                                                class="fw-semibold text-info fs-6">{{ $item->read_by }}
                                                                                read</span>
                                                                            <span
                                                                                class="fw-semibold text-gray-600 fs-6">{{ $item->delivered_to }}
                                                                                delivered</span>
                                                                        </div>
                                                                        <div class="progress h-8px w-100 bg-light-info">
                                                                            <div class="progress-bar bg-info"
                                                                                role="progressbar"
                                                                                style="width: {{ $item->delivered_to > 0 ? round(($item->read_by / $item->delivered_to) * 100, 2) : 0 }}%">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Engagement -->
                                                        <div class="col-sm-6 col-lg-4">
                                                            <div class="card card-flush h-md-100">
                                                                <div class="card-header pt-5">
                                                                    <div class="card-title d-flex flex-column">
                                                                        <span
                                                                            class="fs-2hx fw-bold text-gray-800 me-2 lh-1">
                                                                            {{ $item->delivered_to > 0 ? round((($item->read_by + $item->clicked) / $item->delivered_to) * 100, 2) : 0 }}%
                                                                        </span>
                                                                        <span
                                                                            class="text-gray-600 pt-1 fw-semibold fs-6">Engagement</span>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body d-flex align-items-end pt-0">
                                                                    <div
                                                                        class="d-flex align-items-center flex-column mt-3 w-100">
                                                                        <div
                                                                            class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                                            <span
                                                                                class="fw-semibold text-primary fs-6">{{ $item->clicked }}
                                                                                clicks</span>
                                                                            <span
                                                                                class="fw-semibold text-gray-600 fs-6">{{ $item->read_by }}
                                                                                read</span>
                                                                        </div>
                                                                        <div class="progress h-8px w-100 bg-light-primary">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar"
                                                                                style="width: {{ $item->delivered_to > 0 ? round((($item->read_by + $item->clicked) / $item->delivered_to) * 100, 2) : 0 }}%">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <!-- Bot/API Notice -->
                                                    <div
                                                        class="notice d-flex bg-light-{{ $item->is_bot ? 'info' : 'primary' }} rounded border-{{ $item->is_bot ? 'info' : 'primary' }} border border-dashed p-6">
                                                        <i
                                                            class="ki-outline ki-{{ $item->is_bot ? 'robot' : 'code' }} fs-2tx text-{{ $item->is_bot ? 'info' : 'primary' }} me-4"></i>
                                                        <div class="d-flex flex-stack flex-grow-1">
                                                            <div class="fw-semibold">
                                                                <h4 class="text-gray-900 fw-bold">
                                                                    {{ $item->is_bot ? 'Automated Bot Campaign' : 'API Integration Campaign' }}
                                                                </h4>
                                                                <div class="fs-6 text-gray-700">
                                                                    This campaign was created
                                                                    {{ $item->is_bot ? 'by an automated bot' : 'via API integration' }}.
                                                                    Detailed metrics may not be available.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($setup['items']->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center">
                            <span class="text-muted fs-7">
                                {{ __('Showing') }}
                                <strong>{{ $setup['items']->firstItem() ?? 0 }}</strong>
                                {{ __('to') }}
                                <strong>{{ $setup['items']->lastItem() ?? 0 }}</strong>
                                {{ __('of') }}
                                <strong>{{ $setup['items']->total() }}</strong>
                                {{ __('entries') }}
                            </span>
                        </div>
                        <div class="d-flex flex-wrap py-2">
                            {{ $setup['items']->links() }}
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="card-body">
                    <div class="text-center py-10">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div class="symbol symbol-100px symbol-circle mb-5">
                                <div class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-message-text-2 fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                            </div>

                            <h3 class="fw-bolder mb-3">{{ __('No Campaigns Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('You haven\'t created any campaigns yet. Campaigns help you engage with your contacts through targeted messaging.') }}
                            </p>

                            <div class="d-flex gap-3">
                                <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    {{ __('Create Your First Campaign') }}
                                </a>
                                <a href="#" class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#helpModal">
                                    <i class="ki-duotone ki-information fs-2"></i>
                                    {{ __('Learn More') }}
                                </a>
                            </div>

                            <div class="mt-10">
                                <div class="d-flex align-items-center text-muted fs-7">
                                    <i class="ki-duotone ki-information fs-3 me-2"></i>
                                    {{ __('Campaigns can be used for marketing, notifications, announcements, and customer engagement.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{ __('About Campaigns') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="mb-3">{{ __('What can campaigns do?') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Send bulk messages to multiple contacts') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Schedule messages for optimal delivery times') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Track delivery and read rates') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Monitor engagement with click tracking') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route('campaigns.create') }}" class="btn btn-primary">{{ __('Create Campaign') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Status filter functionality
            const statusFilter = document.getElementById('status-filter');
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    const status = this.value;
                    const campaigns = document.querySelectorAll('.campaign-item');

                    campaigns.forEach(campaign => {
                        if (status === '' || campaign.getAttribute('data-status') === status) {
                            campaign.style.display = '';
                        } else {
                            campaign.style.display = 'none';
                        }
                    });
                });
            }

            // Search functionality
            const searchInput = document.getElementById('table-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const statusFilterValue = statusFilter ? statusFilter.value : '';
                    const campaigns = document.querySelectorAll('.campaign-item');

                    if (searchTerm.length === 0) {
                        campaigns.forEach(campaign => {
                            if (statusFilterValue === '' || campaign.getAttribute('data-status') ===
                                statusFilterValue) {
                                campaign.style.display = '';
                            } else {
                                campaign.style.display = 'none';
                            }
                        });
                        return;
                    }

                    campaigns.forEach(campaign => {
                        const name = campaign.querySelector('.card-title h2').textContent
                            .toLowerCase();
                        const template = campaign.querySelector('.badge-light-primary').textContent
                            .toLowerCase();

                        const matchesSearch = name.includes(searchTerm) || template.includes(
                            searchTerm);
                        const matchesStatus = statusFilterValue === '' || campaign.getAttribute(
                            'data-status') === statusFilterValue;

                        campaign.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                    });
                });
            }
        });
    </script>
@endpush

@push('css')
    <style>
        .card-dashed {
            border: 1px dashed #e4e6ef;
            background: #fafafa;
        }

        .flex-center {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .campaign-item {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .campaign-item:hover {
            transform: translateY(-2px);
        }

        .timeline-item:hover .timeline-badge i {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        .progress-bar {
            transition: width 1s ease-in-out;
        }

        @media (max-width: 768px) {
            .d-flex.flex-column.flex-sm-row {
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .d-flex.flex-column.flex-sm-row .btn {
                margin-top: 1rem;
                width: 100%;
            }

            .w-250px {
                width: 100% !important;
            }
        }
    </style>
@endpush
