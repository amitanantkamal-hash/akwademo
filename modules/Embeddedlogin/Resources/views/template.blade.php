<div class="card mb-6">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <!--begin::Avatar-->
            <div
                class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                <img class="mw-50px mw-lg-75px" src="{{ asset('custom/imgs/whatsapp/whatsapp-icon.svg') }}" alt="WhatsApp">
            </div>
            <!--end::Avatar-->

            <!--begin::Info-->
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="flex-1 d-flex flex-column">
                        <!--begin::Title-->
                        <div class="d-flex align-items-center mb-1">
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">
                                Whatsapp
                            </a>
                            @if (
                                $company->getConfig('whatsapp_webhook_verified', 'no') != 'yes' ||
                                    $company->getConfig('whatsapp_settings_done', 'no') != 'yes')
                                <span class="badge badge-light-success me-auto">In Progress</span>
                            @else
                                <span class="badge badge-light-info me-auto">{{ __('Success!') }}</span>
                            @endif
                        </div>
                        <!--end::Title-->

                        <!--begin::Description-->
                        <div class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-600">
                            Send marketing campaigns, and easily receive and respond to WhatsApp messages<br>
                            from your inbox.
                        </div>
                        <!--end::Description-->

                        <!--begin::Meta-->
                        <div class="d-flex flex-row justify-content-start align-items-center text-gray-600">
                            <span class="d-flex align-items-center me-4">
                                <span class="svg-icon svg-icon-2 me-2">
                                    <img class="theme-dark-show" height="15"
                                        src="{{ asset('custom/imgs/icon_dark.svg') }}" alt="Dotflo">
                                    <img class="theme-light-show" height="15"
                                        src="{{ asset('custom/imgs/icon_dark.svg') }}" alt="Dotflo">
                                </span>
                                Built by {{ env('APP_SHORT_NAME') }}.
                            </span>
                            <span class="d-flex align-items-center">
                                <span class="svg-icon svg-icon-2 me-2">
                                    <i class="ki-duotone ki-information-2 text-warning fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                                Mandatory integration.
                            </span>
                        </div>
                        <!--end::Meta-->
                    </div>
                </div>
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->

        <!--begin::Separator-->
        <div class="separator"></div>
        <!--end::Separator-->

        <!--begin::Nav-->
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 active" href="{{ route('whatsapp.setup') }}">
                    Overview
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6" href="#" disabled>
                    Settings
                    <span class="badge badge-light-info ms-4">Beta</span>
                </a>
            </li> -->
        </ul>
        <!--end::Nav-->
    </div>
</div>

<!--begin::Row-->
<div class="row g-6">
    <!--begin::Col-->
    <div class="col-xxl-8" id="noticediv">
        <!--begin::Features Card-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body p-9">
                <p class="fs-6 fw-semibold text-gray-600 mb-8">
                    Send private WhatsApp messages to your Anantkamal Wademo inbox, keeping all your customer communications
                    in one place to provide them with the convenience they want without
                    sacrificing team efficiency or reporting capabilities.
                </p>

                <!--begin::Feature-->
                <div class="d-flex align-items-center mb-8">
                    <span class="svg-icon svg-icon-2hx svg-icon-success me-4">
                        <i class="fas fa-check-circle"></i>
                    </span>
                    <div class="d-flex flex-column">
                        <span class="fw-bold fs-5">Customers can easily start conversations</span>
                        <span class="text-gray-600">using your designated phone number.</span>
                    </div>
                </div>
                <!--end::Feature-->

                <!--begin::Feature-->
                <div class="d-flex align-items-center mb-8">
                    <span class="svg-icon svg-icon-2hx svg-icon-success me-4">
                        <i class="fas fa-check-circle"></i>
                    </span>
                    <div class="d-flex flex-column">
                        <span class="fw-bold fs-5">Team members can efficiently manage WhatsApp conversations</span>
                        <span class="text-gray-600">directly from Anantkamal Wademo, using the same tools and processes they are
                            already familiar with.</span>
                    </div>
                </div>
                <!--end::Feature-->

                <!--begin::Feature-->
                <div class="d-flex align-items-center mb-8">
                    <span class="svg-icon svg-icon-2hx svg-icon-success me-4">
                        <i class="fas fa-check-circle"></i>
                    </span>
                    <div class="d-flex flex-column">
                        <span class="fw-bold fs-5">When customers receive campaigns or the bots conclude</span>
                        <span class="text-gray-600">they can interact directly with agents in Anantkamal Wademo.</span>
                    </div>
                </div>
                <!--end::Feature-->

                <!--begin::Feature-->
                <div class="d-flex align-items-center">
                    <span class="svg-icon svg-icon-2hx svg-icon-success me-4">
                        <i class="fas fa-check-circle"></i>
                    </span>
                    <div class="d-flex flex-column">
                        <span class="fw-bold fs-5">WhatsApp is included in custom reports and campaign exports</span>
                        <span class="text-gray-600">allowing you to evaluate every support interaction throughout the
                            conversation and export the results to CSV.</span>
                    </div>
                </div>
                <!--end::Feature-->
            </div>
        </div>
        <!--end::Features Card-->
        <!--begin::Status Card-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Can Send Message</h3>
            </div>
            <div class="card-body">
                <div class="status-card warning">
                    <div class="d-flex">
                        <div class="status-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h4>LIMITED</h4>
                            <p>Your display name has not been approved yet. Your message limit will increase after the
                                display name is approved. The Business has not passed business verification.</p>
                        </div>
                    </div>
                </div>
                <div class="status-card success">
                    <div class="d-flex">
                        <div class="status-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4>AVAILABLE</h4>
                            <p>This proves the account has done all the verification process for business and the limit
                                is increased from the basic 250 to the higher tier.</p>
                        </div>
                    </div>
                </div>
                <div class="status-card danger">
                    <div class="d-flex">
                        <div class="status-icon">
                            <i class="fas fa-ban"></i>
                        </div>
                        <div>
                            <h4>BLOCKED</h4>
                            <p>There can be issues with your payment method. Please login to your meta business manager
                                and pay off any pending invoices. Please note, this is not about your account being
                                blocked.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Status Card-->
        <div class="col-xl-12">
            <div class="row g-5 mb-5">
                <!--begin::Quality Card-->
                <div class="col-md-6 col-lg-6">
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header">
                            <h3 class="card-title fw-bold">Message Quality Rating</h3>
                        </div>
                        <div class="card-body p-9">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-8">
                                <span class="bullet bullet-vertical bg-success-active me-5 h-40px"></span>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold fs-5">GREEN</span>
                                    <span class="text-gray-600">High Quality</span>
                                </div>
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-8">
                                <span class="bullet bullet-vertical bg-warning me-5 h-40px"></span>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold fs-5">YELLOW</span>
                                    <span class="text-gray-600">Medium Quality</span>
                                </div>
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-8">
                                <span class="bullet bullet-vertical bg-danger me-5 h-40px"></span>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold fs-5">RED</span>
                                    <span class="text-gray-600">Low Quality</span>
                                </div>
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="d-flex align-items-center">
                                <span class="bullet bullet-vertical bg-gray-400 me-5 h-40px"></span>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold fs-5">NA</span>
                                    <span class="text-gray-600">Quality has not been determined</span>
                                </div>
                            </div>
                            <!--end::Item-->
                        </div>
                    </div>
                </div>
                <!--end::Quality Card-->

                <!--begin::Tier Card-->

                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tier Limit Info</h3>
                        </div>
                        <div class="card-body">
                            <div class="tier-item">
                                <div class="tier-badge">250</div>
                                <div class="tier-content">
                                    <h4>TIER_250</h4>
                                    <p>250 Free Service Messages</p>
                                </div>
                            </div>
                            <div class="tier-item">
                                <div class="tier-badge">1K</div>
                                <div class="tier-content">
                                    <h4>TIER_1K</h4>
                                    <p>1,000 Free Service Messages</p>
                                </div>
                            </div>
                            <div class="tier-item">
                                <div class="tier-badge">10K</div>
                                <div class="tier-content">
                                    <h4>TIER_10K</h4>
                                    <p>10,000 Free Service Messages</p>
                                </div>
                            </div>
                            <div class="tier-item">
                                <div class="tier-badge">100K</div>
                                <div class="tier-content">
                                    <h4>TIER_100K</h4>
                                    <p>1,00,000 Free Service Messages</p>
                                </div>
                            </div>
                            <div class="tier-item">
                                <div class="tier-badge">∞</div>
                                <div class="tier-content">
                                    <h4>TIER_UNLIMITED</h4>
                                    <p>Unlimited Free Service Messages</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Tier Card-->
            </div>
        </div>
        <!-- Message Limit End -->

    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xxl-4" id="infodiv">
        <!--begin::Sidebar Card-->
        <div class="card card-xxl-stretch-150 mb-xl-10">
            <div class="card-body p-9">
                @include('wpbox::setup.verified-new')
                @include('embeddedlogin::connect-new')
            </div>
        </div>
        <!--end::Sidebar Card-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
<style>
    :root {
        --primary: #25D366;
        --primary-dark: #128C7E;
        --secondary: #075E54;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --light-gray: #e9ecef;
        --border: #dee2e6;
        --success: #198754;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #0dcaf0;
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary);
    }


    .badge {
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
    }

    .badge-success {
        background-color: rgba(25, 135, 84, 0.15);
        color: var(--success);
    }

    .badge-warning {
        background-color: rgba(255, 193, 7, 0.15);
        color: var(--warning);
    }

    .badge-danger {
        background-color: rgba(220, 53, 69, 0.15);
        color: var(--danger);
    }

    .badge-info {
        background-color: rgba(13, 202, 240, 0.15);
        color: var(--info);
    }

    .badge-primary {
        background-color: rgba(37, 211, 102, 0.15);
        color: var(--primary-dark);
    }

    .feature-list {
        list-style: none;
        padding: 0;
    }

    .feature-item {
        display: flex;
        align-items: flex-start;
        padding: 16px 0;
        border-bottom: 1px solid var(--border);
    }

    .feature-item:last-child {
        border-bottom: none;
    }

    .feature-icon {
        background: rgba(37, 211, 102, 0.1);
        color: var(--primary);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-right: 16px;
    }

    .feature-content h4 {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .feature-content p {
        color: var(--gray);
        margin: 0;
    }

    .status-indicator {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .status-indicator:last-child {
        margin-bottom: 0;
    }

    .status-color {
        width: 12px;
        height: 40px;
        border-radius: 4px;
        margin-right: 16px;
        flex-shrink: 0;
    }

    .status-success {
        background-color: var(--success);
    }

    .status-warning {
        background-color: var(--warning);
    }

    .status-danger {
        background-color: var(--danger);
    }

    .status-gray {
        background-color: var(--gray);
    }

    .tier-item {
        display: flex;
        align-items: center;
        margin-bottom: 24px;
    }

    .tier-badge {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: var(--light-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
        margin-right: 20px;
        color: var(--primary-dark);
        border: 2px solid var(--border);
    }

    .tier-content h4 {
        font-weight: 700;
        margin-bottom: 4px;
    }

    .tier-content p {
        color: var(--gray);
        margin: 0;
    }

    .status-card {
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: var(--card-shadow);
        border-left: 4px solid transparent;
        transition: var(--transition);
    }

    .status-card:hover {
        transform: translateX(5px);
    }

    .status-card.warning {
        border-left-color: var(--warning);
    }

    .status-card.success {
        border-left-color: var(--success);
    }

    .status-card.danger {
        border-left-color: var(--danger);
    }

    .status-icon {
        font-size: 1.5rem;
        margin-right: 16px;
        flex-shrink: 0;
    }

    .status-card.warning .status-icon {
        color: var(--warning);
    }

    .status-card.success .status-icon {
        color: var(--success);
    }

    .status-card.danger .status-icon {
        color: var(--danger);
    }

    .status-card h4 {
        font-weight: 700;
        margin-bottom: 8px;
    }

    .status-card p {
        color: var(--gray);
        margin: 0;
    }

    .connection-card {
        border-radius: 12px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        margin-bottom: 24px;
        border-top: 4px solid var(--primary);
    }

    .connection-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .connection-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--dark);
    }

    .connection-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .connection-status.connected {
        background: rgba(25, 135, 84, 0.15);
        color: var(--success);
    }

    .connection-status.disconnected {
        background: rgba(220, 53, 69, 0.15);
        color: var(--danger);
    }

    .connection-alert {
        display: flex;
        align-items: center;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .connection-alert.disconnected {
        background: rgba(220, 53, 69, 0.05);
        border: 1px solid rgba(220, 53, 69, 0.1);
    }

    .connection-alert.connected {
        background: rgba(25, 135, 84, 0.05);
        border: 1px solid rgba(25, 135, 84, 0.1);
    }

    .alert-icon {
        font-size: 1.5rem;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .connection-alert.disconnected .alert-icon {
        color: var(--danger);
    }

    .connection-alert.connected .alert-icon {
        color: var(--success);
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-outline {
        background: transparent;
        border: 1px solid var(--primary);
        color: var(--primary);
    }

    .btn-outline:hover {
        background: rgba(37, 211, 102, 0.1);
    }

    .btn-block {
        display: block;
        width: 100%;
    }

    .details-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 12px;
        margin-bottom: 20px;
    }

    .detail-label {
        font-weight: 600;
        color: var(--gray);
    }

    .detail-value {
        font-weight: 500;
    }

    .badge-indicator {
        display: inline-flex;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(37, 211, 102, 0.1);
        color: var(--primary-dark);
        border: none;
        cursor: pointer;
        transition: var(--transition);
    }

    .action-btn:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-3px);
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -12px;
    }

    .col {
        padding: 0 12px;
        flex: 1 0 0%;
    }

    .col-8 {
        flex: 0 0 66.6666666667%;
        max-width: 66.6666666667%;
    }

    .col-4 {
        flex: 0 0 33.3333333333%;
        max-width: 33.3333333333%;
    }

    @media (max-width: 992px) {
        .col {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .col-8,
        .col-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    .profile-img {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        background: var(--light-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        overflow: hidden;
    }

    .profile-img img {
        width: 60%;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    .mb-5 {
        margin-bottom: 3rem;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    .text-center {
        text-align: center;
    }

    .nav-tabs {
        display: flex;
        border-bottom: 1px solid var(--border);
        padding: 0 24px;
    }

    .nav-tab {
        padding: 16px 24px;
        font-weight: 600;
        color: var(--gray);
        text-decoration: none;
        border-bottom: 3px solid transparent;
        transition: var(--transition);
    }

    .nav-tab.active {
        color: var(--primary);
        border-bottom: 3px solid var(--primary);
    }

    .nav-tab:hover {
        color: var(--primary-dark);
    }

    .header-card {
        display: flex;
        align-items: center;
        padding: 24px;
    }

    .header-icon {
        width: 80px;
        height: 80px;
        background: rgba(37, 211, 102, 0.1);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-right: 24px;
    }

    .header-icon img {
        width: 50px;
    }

    .header-content h2 {
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 8px;
        color: var(--dark);
    }

    .header-content p {
        color: var(--gray);
        margin-bottom: 12px;
    }

    .header-meta {
        display: flex;
        gap: 24px;
        color: var(--gray);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .meta-item i {
        color: var(--primary);
    }

    .dark .tier-badge,
    [data-theme="dark"] .tier-badge,
    .tier-badge.dark-mode {
        background: #b5c4ed;
        border: 2px solid #1e2129;
    }
</style>

