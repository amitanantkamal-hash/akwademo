@if (auth()->user()->hasrole('owner') || auth()->user()->hasrole('staff'))
    <!-- Action Buttons Section -->
    {{-- <div class="row mb-7">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-end">
                @if (auth()->user()->hasrole('staff'))
                    <div class="m-2">
                        <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
                            <i class="ki-duotone ki-send fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ __('Send Campaign') }}
                        </a>
                    </div>
                @endif
                @if (auth()->user()->hasrole('owner'))
                    <div class="m-2">
                        <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
                            <i class="ki-duotone ki-send fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ __('Send Campaign') }}
                        </a>
                    </div>
                    <div class="m-2">
                        <button type="button" id="createContactDash" class="btn btn-primary">
                            <i class="ki-duotone ki-user-add fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ __('Create Contact') }}
                        </button>
                    </div>
                    <div class="m-2">
                        <a href="{{ route('replies.create') }}" class="btn btn-primary">
                            <i class="ki-duotone ki-robot fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ __('Create Reply Bot') }}
                        </a>
                    </div>
                    <div class="m-2">
                        <a target="_blank" href="{{ route('templates.create') }}" class="btn btn-primary">
                            <i class="ki-duotone ki-file fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ __('Create Template') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div> --}}

    <!--begin::Col-->
    <!--begin::Engage widget 1-->
    <div class="row g-3 g-md-6 mb-4">
        <!-- Welcome Card - Now first on mobile -->
         <!-- style="background-image: url({{ asset('uploads/default/dotflo/city.png') }}); -->
        <div class="col-lg-8 col-md-6 order-1 order-md-2 mb-4 mb-md-0">
            <div class="card min-h-250px min-h-md-300px bg-success border-0 mb-5 mb-xl-8 overflow-hidden"
                style="background-image: url({{ asset('backend/Assets/img/dashBan3.png') }});
                background-position: right bottom;
                background-size: auto 100%;
                background-repeat: no-repeat; 
                background-color: #3D7D52 !important;">
                <div class="card-body d-flex flex-column justify-content-center ps-6 ps-lg-12 py-6">
                    <h3 class="text-white fs-3 fs-md-2qx fw-bold mb-3">
                        {{ __('Welcome,') }} {{ auth()->user()->name }}
                    </h3>
                    <p class="text-white fs-5 fs-md-4 mb-5">
                        {{ __('No-Code Chatbots,') }}<br>
                        {{ __('Automate Responses to Sales and Support Messages.') }}
                    </p>
                    <div>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="">
                            {{ __('Get started') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards Section - Now second on mobile -->
        <div class="col-lg-4 col-md-6 order-2 order-md-1">
            <div class="row g-3 g-xl-5">
                @foreach ([
        ['id' => 'createContactDash', 'icon' => 'ki-badge', 'text' => 'Create Contact', 'subtext' => 'Creating a contact is the first step to start using our WhatsApp CRM. Add your customer\'s details to begin conversations, send messages, and manage interactions seamlessly.'],
        ['route' => 'templates.index', 'icon' => 'ki-abstract-26', 'text' => 'Manage Template', 'subtext' => 'A WhatsApp Template is a pre-approved message format used by businesses to send notifications or updates to users outside the 24-hour chat window. These are especially useful for sending alerts, OTPs, reminders, promotions, and transactional updates.'],
        ['route' => 'whatsapp-flows.create', 'icon' => 'ki-technology-2', 'text' => 'WhatsApp Flows', 'subtext' => 'WhatsApp Flows are forms inside WhatsApp chats. Businesses use them to collect info like names, numbers, or choices'],
        ['route' => 'campaigns.create', 'icon' => 'ki-send', 'text' => 'Send Campaign', 'subtext' => 'Once you’ve created your contacts, set up your templates, and designed your WhatsApp Flows, you’re all set to launch your campaign. Just name your campaign, choose the template you want to use, select your contact group, and you’re ready to send your WhatsApp campaign.'],
    ] as $card)
                    <div class="col-sm-6 col-12">
                        @php
                            $subtext = __($card['subtext']);
                            $shortText = \Illuminate\Support\Str::limit($subtext, 22, '...');
                        @endphp

                        @isset($card['route'])
                            <a class="card text-gray-800 text-hover-primary p-5 p-md-10 d-flex flex-column justify-content-start align-items-start"
                                href="{{ route($card['route']) }}"
                                @if (!empty($subtext)) data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $subtext }}" @endif>
                            @else
                                <button
                                    class="card text-gray-800 text-hover-primary p-5 p-md-10 w-100 d-flex flex-column justify-content-start align-items-start"
                                    id="{{ $card['id'] }}"
                                    @if (!empty($subtext)) data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $subtext }}" @endif>
                                @endisset
                                <i class="ki-duotone {{ $card['icon'] }} fs-2x fs-md-2tx mb-3 mb-md-5 text-success">
                                    @foreach (range(1, 5) as $path)
                                        <span class="path{{ $path }}"></span>
                                    @endforeach
                                </i>
                                <span class="fs-5 fw-bold d-flex align-items-center">{{ __($card['text']) }}</span>
                                @if (!empty($subtext))
                                    <span class="small">{{ $shortText }}</span>
                                @endif

                                @isset($card['route'])
                            </a>
                        @else
                            </button>
                        @endisset
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!--end::Engage widget 1-->

    <!-- Main Dashboard Layout -->
    <div class="row g-5 g-xl-8">
        <!-- Left Column - Information Cards -->
        <div class="col-xl-4">
            <!-- Active Subscription Card -->
            @php
                $user = auth()->user();
                $activeSub = $wpbox['active_subscription'] ?? null;
                $isOwner = $user->hasRole('owner');
                $freePlanID = config('settings.free_pricing_id');
                $isOnTrial = $user->plan_id == $freePlanID;
                $trialExpireDate = $isOnTrial ? new DateTime($user->trial_ends_at) : null;
            @endphp

            @if ($isOwner)
                @php
                    $subscription = $activeSub ?? null;
                    $isExpired = $subscription && \Carbon\Carbon::parse($subscription->expire_date)->isPast();
                    $isTrial = $isOnTrial && $trialExpireDate;
                    $expireDate = $subscription->expire_date ?? ($trialExpireDate ?? null);
                @endphp

                @if ($subscription || $isTrial)
                    <div class="card card-flush mb-5">
                        <div class="card-body p-9">
                            <div class="d-flex align-items-center justify-content-between">
                                <!-- Left: Info -->
                                <div class="d-flex flex-column me-5">
                                    @php
                                        $cardTitle = match (true) {
                                            $isTrial && $isExpired => __('Trial Subscription Expired'),
                                            $isTrial => __('Trial Subscription Active'),
                                            $isExpired => __('Expired Subscription'),
                                            default => __('Active Subscription'),
                                        };

                                        $dateMessage = match (true) {
                                            $isTrial && $isExpired => __('Your Trial has expired on'),
                                            $isTrial => __('Your Trial expires on'),
                                            $isExpired => __('Your subscription has expired on'),
                                            ($subscription->package_type ?? null) == 3 => __(
                                                'Your subscription is for a Lifetime',
                                            ),
                                            default => __('Your subscription expires on'),
                                        };
                                    @endphp

                                    <h3 class="fw-bold text-gray-800 mb-3">{{ $cardTitle }}</h3>

                                    <div class="mb-3">
                                        @if (($subscription->package_type ?? null) != 3 && $expireDate)
                                            <span class="text-gray-500 fs-6">{{ $dateMessage }}</span>
                                            <div
                                                class="fw-semibold fs-4 {{ $isExpired ? 'text-danger' : 'text-info' }}">
                                                {{ \Carbon\Carbon::parse($expireDate)->format('d-M-Y') }}
                                            </div>

                                            @if ($isExpired && !$isTrial)
                                                <div class="mt-4">
                                                    <a href="{{ route('available.plans') }}" class="btn btn-primary">
                                                        <i class="ki-solid ki-rotate-left fs-3 me-2"></i>
                                                        {{ __('Renew Subscription') }}
                                                    </a>
                                                </div>
                                            @endif
                                        @elseif(($subscription->package_type ?? null) == 3)
                                            <span class="text-gray-500 fs-6">{{ $dateMessage }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Right: Icon -->
                                <div class="symbol symbol-circle symbol-70px bg-info p-3">
                                    <i class="ki-solid ki-calendar fs-2x text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <!-- WhatsApp Business Details Card -->
            @include('wpbox::info_verified')

            <!-- Coming Soon Card -->
            <div class="card card-flush">
                <div class="card-body text-center p-9">
                    <img src="{{ asset('Metronic/assets/media/illustrations/sketchy-1/17.png') }}" class="h-150px mb-5"
                        alt="Coming Soon">
                    <h3 class="fw-bold text-gray-800 mb-3">New Features Coming!</h3>
                    <div class="text-gray-600 fs-6 mb-6">
                        We're working on exciting new analytics features to help you better understand your campaign
                        performance.
                    </div>
                    <div class="progress h-6px mb-5">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 65%" aria-valuenow="65"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="badge badge-light-primary fs-7 mb-5">65% Complete</span>
                    <button class="btn btn-sm btn-light-primary fw-bold">Notify Me When Ready</button>
                </div>
            </div>
        </div>

        <!-- Right Column - Stats and Campaign Data -->
        <div class="col-xl-8">
            <!-- Stats Cards Row -->
            <div class="row g-5 mb-5">
                <!-- Chats Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-flush h-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span
                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1">{{ $wpbox['chats']['main_value'] }}</span>
                                <span
                                    class="text-gray-600 pt-1 fw-semibold fs-6">{{ __($wpbox['chats']['title']) }}</span>
                            </div>
                            <div class="card-toolbar">
                                <span
                                    class="badge badge-light-{{ $wpbox['chats']['sub_value'] > 0 ? 'success' : 'danger' }} fs-7 fw-bold">
                                    {{ round($wpbox['chats']['sub_value'] * 100, 2) }}%
                                </span>
                            </div>
                        </div>
                        <div class="card-body pt-2 pb-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <span class="fs-6 text-gray-700 fw-semibold me-2">
                                    {{ $wpbox['chats']['sub_value'] }} {{ __($wpbox['chats']['sub_title']) }}
                                </span>
                                <i class="ki-duotone ki-messages fs-2x"
                                    style="color: {{ $wpbox['chats']['color_elements'] ?? '#6993FF' }};">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div
                                class="progress h-8px bg-light-{{ $wpbox['chats']['sub_value'] > 0 ? 'success' : 'danger' }}">
                                <div class="progress-bar rounded" role="progressbar"
                                    style="width: {{ round($wpbox['chats']['sub_value'] * 100, 2) }}%; background-color: {{ $wpbox['chats']['color_elements'] ?? '#6993FF' }};">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contacts Card -->
                @php
                    /* style="background-color: {{ $wpbox['contacts']['color_bg'] ?? '#f8f9fa' }};" */
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card card-flush h-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span
                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1">{{ $wpbox['contacts']['main_value'] }}</span>
                                <span
                                    class="text-gray-600 pt-1 fw-semibold fs-6">{{ __($wpbox['contacts']['title']) }}</span>
                            </div>
                            <div class="card-toolbar">
                                <i class="ki-duotone ki-profile-user fs-2x"
                                    style="color: {{ $wpbox['contacts']['color_elements'] ?? '#6993FF' }};">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                        <div class="card-body pt-2 pb-4">
                            <div class="mb-5">
                                <span class="fs-6 text-gray-700 fw-semibold">
                                    {{ $wpbox['contacts']['sub_value'] }} {{ __($wpbox['contacts']['sub_title']) }}
                                </span>
                            </div>
                            <div class="symbol-group symbol-hover">
                                @if (count($wpbox['all_contacts']) == 0)
                                    <div class="symbol symbol-35px symbol-circle">
                                        <span class="symbol-label bg-light-danger text-danger fw-bold">0</span>
                                    </div>
                                    <span class="fs-7 text-gray-600 fw-semibold ms-2">{{ __('No contacts') }}</span>
                                @else
                                    @foreach ($wpbox['all_contacts']->take(4) as $contact)
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                            title="{{ $contact->name }}">
                                            @if ($contact->avatar)
                                                <img src="{{ $contact->avatar }}" alt="{{ $contact->name }}"
                                                    class="object-cover">
                                            @else
                                                <span
                                                    class="symbol-label bg-{{ $loop->iteration % 2 == 0 ? 'primary' : 'info' }} text-inverse-{{ $loop->iteration % 2 == 0 ? 'primary' : 'info' }} fw-bold">
                                                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if ($wpbox['contacts']['main_value'] > 4)
                                        <a href="{{ route('contacts.index') }}"
                                            class="symbol symbol-35px symbol-circle">
                                            <span class="symbol-label bg-light text-gray-600 fw-bold">
                                                +{{ $wpbox['contacts']['main_value'] - 4 }}
                                            </span>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Templates Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-flush h-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span
                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1">{{ $wpbox['templates']['main_value'] }}</span>
                                <span
                                    class="text-gray-600 pt-1 fw-semibold fs-6">{{ __($wpbox['templates']['title']) }}</span>
                            </div>
                            <div class="card-toolbar">
                                <span
                                    class="badge badge-light-{{ $wpbox['templates']['sub_value'] > 50 ? 'success' : 'warning' }} fs-7 fw-bold">
                                    {{ $wpbox['templates']['sub_value'] }}%
                                </span>
                            </div>
                        </div>
                        <div class="card-body pt-2 pb-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <span class="fs-6 text-gray-700 fw-semibold me-2">Usage Rate</span>
                                <i class="ki-duotone ki-file fs-2x"
                                    style="color: {{ $wpbox['templates']['color_elements'] ?? '#6993FF' }};">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div
                                class="progress h-8px bg-light-{{ $wpbox['templates']['sub_value'] > 50 ? 'success' : 'warning' }}">
                                <div class="progress-bar rounded" role="progressbar"
                                    style="width: {{ $wpbox['templates']['sub_value'] }}%; background-color: {{ $wpbox['templates']['color_elements'] ?? '#6993FF' }};">
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('templates.index') }}"
                                    class="btn btn-sm btn-light-{{ $wpbox['templates']['sub_value'] > 50 ? 'success' : 'warning' }} fw-bold">
                                    View All Templates
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Campaign Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-flush h-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span
                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1">{{ $wpbox['campaign']['main_value'] }}</span>
                                <span
                                    class="text-gray-600 pt-1 fw-semibold fs-6">{{ __($wpbox['campaign']['title']) }}</span>
                            </div>
                            <div class="card-toolbar">
                                <i class="ki-duotone ki-send fs-2x"
                                    style="color: {{ $wpbox['campaign']['color_elements'] ?? '#6993FF' }};">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                        <div class="card-body pt-2 pb-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <span class="fs-6 text-gray-700 fw-semibold me-2">Success Rate</span>
                                <i class="ki-duotone ki-chart-line fs-2x"
                                    style="color: {{ $wpbox['campaign']['color_elements'] ?? '#6993FF' }};">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div
                                class="progress h-8px bg-light-{{ $wpbox['campaign']['sub_value'] > 50 ? 'success' : 'danger' }}">
                                <div class="progress-bar rounded" role="progressbar"
                                    style="width: {{ $wpbox['campaign']['sub_value'] }}%; background-color: {{ $wpbox['campaign']['color_elements'] ?? '#6993FF' }};">
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('campaigns.index') }}"
                                    class="btn btn-sm btn-light-{{ $wpbox['campaign']['sub_value'] > 50 ? 'success' : 'danger' }} fw-bold">
                                    View Campaigns
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bot Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-flush h-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span
                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1">{{ $wpbox['bot']['main_value'] }}</span>
                                <span
                                    class="text-gray-600 pt-1 fw-semibold fs-6">{{ __($wpbox['bot']['title']) }}</span>
                            </div>
                            <div class="card-toolbar">
                                <i class="ki-duotone ki-robot fs-2x"
                                    style="color: {{ $wpbox['bot']['color_elements'] ?? '#6993FF' }};">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                        <div class="card-body pt-2 pb-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <span
                                    class="fs-6 text-gray-700 fw-semibold me-2">{{ __($wpbox['bot']['sub_title']) }}</span>
                                <i class="ki-duotone ki-abstract-26 fs-2x"
                                    style="color: {{ $wpbox['bot']['color_elements'] ?? '#6993FF' }};">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div
                                class="progress h-8px bg-light-{{ $wpbox['bot']['sub_value'] > 50 ? 'success' : 'warning' }}">
                                <div class="progress-bar rounded" role="progressbar"
                                    style="width: {{ $wpbox['bot']['sub_value'] }}%; background-color: {{ $wpbox['bot']['color_elements'] ?? '#6993FF' }};">
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ $wpbox['bot']['href'] }}"
                                    class="btn btn-sm btn-light-{{ $wpbox['bot']['sub_value'] > 50 ? 'success' : 'warning' }} fw-bold">
                                    Manage Bots
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Send Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-flush h-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span
                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1">{{ $wpbox['single_send']['main_value'] }}</span>
                                <span
                                    class="text-gray-600 pt-1 fw-semibold fs-6">{{ __($wpbox['single_send']['title']) }}</span>
                            </div>
                            <div class="card-toolbar">
                                <i class="ki-duotone ki-calendar-tick fs-2x"
                                    style="color: {{ $wpbox['single_send']['color_elements'] ?? '#6993FF' }};">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                        <div class="card-body pt-2 pb-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <span class="fs-6 text-gray-700 fw-semibold me-2">
                                    {{ $wpbox['single_send']['sub_value'] ? 'Success Rate' : 'No Templates' }}
                                </span>
                                <i class="ki-duotone ki-calendar-8 fs-2x"
                                    style="color: {{ $wpbox['single_send']['color_elements'] ?? '#6993FF' }};">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            @if ($wpbox['single_send']['sub_value'])
                                <div
                                    class="progress h-8px bg-light-{{ $wpbox['single_send']['sub_value'] > 50 ? 'success' : 'warning' }}">
                                    <div class="progress-bar rounded" role="progressbar"
                                        style="width: {{ $wpbox['single_send']['sub_value'] }}%; background-color: {{ $wpbox['single_send']['color_elements'] ?? '#6993FF' }};">
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-light-warning d-flex align-items-center p-3">
                                    <i class="ki-duotone ki-information fs-3 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="text-gray-700">No templates available for single sends</span>
                                </div>
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('templates.create') }}"
                                    class="btn btn-sm btn-light-primary fw-bold">
                                    Create Template
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campaign Performance Card -->
            <!-- <div class="card card-flush mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="fw-bold text-gray-800">
                            <i class="ki-duotone ki-map fs-2 me-2 text-primary">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Campaign Performance
                            <br>
                            <span class="form-text text-muted mt-2">Geographical distribution of your last
                                campaign</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button class="btn btn-sm btn-light-primary">
                            <i class="ki-duotone ki-eye fs-2 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            View Full Report
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    @php
                        $oferta = [
                            'id' => null,
                            'name' => '',
                            'send_to' => null,
                            // ... rest of your default values
                        ];
                    @endphp

                    @if (config('wpbox.google_maps_enabled', true))
                        @isset($item)
                            @include('wpbox::campaigns.dashboard-map', $item)
                        @else
                            @include('wpbox::campaigns.dashboard-map-vacio', $oferta)
                        @endisset
                    @endif
                </div>
            </div> -->

            <!-- Recent Campaigns Card -->
            <div class="card card-flush mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="fw-bold text-gray-800">
                            <i class="ki-duotone ki-chart-line fs-2 me-2 text-primary">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Recent Campaigns
                            <br>
                            <span class="form-text text-muted mt-2">Detailed performance metrics</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-icon btn-color-gray-500 btn-active-color-primary"
                                data-bs-toggle="dropdown">
                                <i class="ki-duotone ki-filter fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" onclick="orderTable('sent')">
                                    <i class="ki-duotone ki-send fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Sent Campaigns
                                </a>
                                <a class="dropdown-item" onclick="orderTable('Scheduled')">
                                    <i class="ki-duotone ki-clock fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Scheduled Campaigns
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" onclick="orderTable('all')">
                                    <i class="ki-duotone ki-list fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @include('partials.table-campaign')
                </div>
            </div>
        </div>
    </div>

    <!-- Phone Registration Modal -->
    <div class="modal fade" id="kt_modal_1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-450px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">WhatsApp Number Registration</h2>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <form action="{{ route('phoneRegister') }}" method="POST">
                    @csrf
                    <div class="modal-body py-10 px-5">
                        <div class="text-center mb-10">
                            <i class="ki-duotone ki-whatsapp fs-5x text-success mb-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <h3 class="fw-bold text-gray-900 mb-2">Connect Your WhatsApp</h3>
                            <span class="text-gray-500 fs-6">Enter your WhatsApp business number to enable
                                messaging</span>
                        </div>
                        <div class="fv-row mb-5">
                            <label class="form-label required">Phone Number</label>
                            <input id="phone" name="phone" type="tel"
                                class="form-control form-control-solid" placeholder="e.g. +1 234 567 8900" required>
                            <div class="text-muted fs-7 mt-1">Include country code (e.g. +1 for USA)</div>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Connect Number</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Switch Account Modal -->
    <div class="modal fade" id="switchAccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Switch Organization Account</h2>
                    <div class="card-toolbar">
                        @if (config('settings.enable_create_company', true))
                            
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createOrgModals" data-bs-original-title="{{ __('Add new organization') }}">
                                <i class="ki-duotone ki-plus fs-2 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ __('New Organization') }}
                            </button>
                        @endif
                    </div> 
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body py-10 px-5">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">{{ __('Name') }}</th>
                                    @if (config('settings.show_company_logo'))
                                        <th class="min-w-50px">{{ __('Logo') }}</th>
                                    @endif
                                    <th class="min-w-100px">{{ __('Status') }}</th>
                                    <th class="text-end min-w-125px">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach (auth()->user()->companies->where('active', 1) as $company)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.organizations.edit', $company) }}"
                                                class="text-gray-800 text-hover-primary fs-5 fw-bold">
                                                {{ $company->name }}
                                            </a>
                                        </td>
                                        @if (config('settings.show_company_logo'))
                                            <td>
                                                <img src="{{ $company->icon }}" class="img-fluid rounded-circle"
                                                    width="40" height="40">
                                            </td>
                                        @endif
                                        <td>
                                            <span class="badge badge-light-success">{{ __('Active') }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end">
                                                {{-- <a href="{{ route('admin.organizations.edit', $company) }}"
                                                    class="btn btn-icon btn-sm btn-light-info me-2"
                                                    data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                    <i class="ki-duotone ki-pencil fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a> --}}
                                                <a href="{{ route('admin.companies.switch', $company) }}"
                                                    class="btn btn-icon btn-sm btn-light-primary me-2"
                                                    data-bs-toggle="tooltip" title="{{ __('Switch Account') }}">
                                                    <i class="ki-duotone ki-switch fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </a>
                                                @if ($company->id != auth()->user()->company_id)
                                                    <form action="{{ route('admin.companies.destroy', $company) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-icon btn-sm btn-light-danger"
                                                            onclick="return confirm('{{ __('Are you sure you want to delete this organization?') }}')"
                                                            data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                            <i class="ki-duotone ki-trash fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                            </i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
<!-- new org add code by amit pawar-->
    <div class="modal fade" id="createOrgModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">{{ __('Create new organization') }}</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body py-10 px-4">
                    <form action="{{ route('admin.organizations.create') }}" method="POST">
                        @csrf
                        <div class="fv-row mb-10">
                            <input type="text" class="form-control form-control-solid" id="organization_name" placeholder="{{ __('Organization name') }}" name="name" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-info">
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M10.3 14.3L11 13.6L7.70002 10.3C7.30002 9.9 6.7 9.9 6.3 10.3C5.9 10.7 5.9 11.3 6.3 11.7L10.3 15.7C10.7 16.1 11.3 16.1 11.7 15.7C12.1 15.3 12.1 14.7 11.7 14.3H10.3Z" fill="currentColor"></path>
                                        <path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM11.7 15.7C11.3 16.1 10.7 16.1 10.3 15.7L6.3 11.7C5.9 11.3 5.9 10.7 6.3 10.3C6.7 9.9 7.30002 9.9 7.70002 10.3L11 13.6L10.3 14.3H11.7C12.1 14.7 12.1 15.3 11.7 15.7Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                {{ __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- new org end -->
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Initialize Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        function copyWhatsAppLink() {
            @if (auth()->check() && auth()->id() != 1)
                const dbPhonenumber =
                    "{{ str_replace([' ', '+'], '', auth()->user()->company->getConfig('display_phone_number', '11111111')) }}";
                const phoneNumber = dbPhonenumber;
                const waLink = `https://wa.me/${phoneNumber}`;

                const copyToClipboard = (text) => {
                    if (navigator.clipboard) {
                        return navigator.clipboard.writeText(text);
                    } else {
                        const textarea = document.createElement('textarea');
                        textarea.value = text;
                        document.body.appendChild(textarea);
                        textarea.select();
                        try {
                            document.execCommand('copy');
                            return Promise.resolve();
                        } catch (err) {
                            return Promise.reject(err);
                        } finally {
                            document.body.removeChild(textarea);
                        }
                    }
                };

                copyToClipboard(waLink).then(() => {
                    Toast.fire({
                        icon: "success",
                        title: "WhatsApp link copied to clipboard!"
                    });
                }).catch(err => {
                    Toast.fire({
                        icon: "error",
                        title: "Failed to copy link"
                    });
                    console.error('Failed to copy: ', err);
                });
            @else
                Toast.fire({
                    icon: "error",
                    title: "Operation not allowed"
                });
            @endif
        }


        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Create contact modal logic
            const currentUrl = window.location.href;
            const targetUrl = "{{ route('contacts.index', ['type' => 'create']) }}";
            const baseUrl = "{{ route('contacts.index') }}";

            document.getElementById('createContactDash').addEventListener('click', function() {
                if (currentUrl === targetUrl || currentUrl.startsWith(baseUrl)) {
                    $('#kt_modal_create').modal('show');
                } else {
                    window.location.href = targetUrl;
                }
            });

            // Check for type=create parameter on page load
            setTimeout(() => {
                const urlParams = new URLSearchParams(window.location.search);
                const type = urlParams.get('type');
                if (type === 'create') {
                    $('#kt_modal_create').modal('show');
                }
            }, 1000);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endpush
