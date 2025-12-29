<div class="app-navbar flex-shrink-0">
    @if (auth()->user()->hasRole('owner') || auth()->user()->hasRole('staff'))
        @if (auth()->user()->hasRole('owner'))
            <?php $urlToVendor = auth()->user()->companies()->get()->first()->getLinkAttribute(); ?>
        @endif
        @if (auth()->user()->hasRole('staff'))
            <?php $urlToVendor = auth()->user()->company->getLinkAttribute(); ?>
        @endif
        @if (config('settings.show_company_page', true))
            <a href="{{ $urlToVendor }}" target="_blank" class="nav-link" role="button">
                <i class="ni ni-shop"></i>
                <span class="nav-link-inner--text bold">{{ __(config('settings.vendor_entity_name')) }}</span>
            </a>
        @endif
    @endif
    <?php
    $availableLanguagesENV = config('settings.front_languages');
    $exploded = explode(',', $availableLanguagesENV);
    $availableLanguages = [];
    for ($i = 0; $i < count($exploded); $i += 2) {
        $availableLanguages[$exploded[$i]] = $exploded[$i + 1];
    }
    $locale = isset($locale) ? $locale : (Cookie::get('lang') ? Cookie::get('lang') : config('settings.app_locale'));
    ?>
    <div class="app-navbar-item align-items-stretch ms-1 ms-md-4">
        @include('new_client.layout.partials_header.search-dropdown')
    </div>
    <div class="app-navbar-item ms-1 ms-md-4">
        <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
            id="kt_activities_toggle">
            <i class="ki-solid ki-messages fs-2"></i>
        </div>
    </div>
    <div class="app-navbar-item ms-1 ms-md-4">
        <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end" id="kt_menu_item_wow">
            <i class="ki-solid ki-notification-status fs-2"></i>
        </div>
        @include('new_client.layout.partials_header.notification-menu')
    </div>

    <div class="app-navbar-item ms-1 ms-md-4">
        <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px position-relative"
            id="kt_drawer_chat_toggle">
            <i class="ki-solid ki-message-text-2 fs-2"></i>
            <span
                class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink">
            </span>
        </div>
    </div>
    {{-- <div class="app-navbar-item ms-1 ms-md-4">
        <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end">
            <i class="ki-solid ki-element-11 fs-2"></i>
        </div>
        @include('new_client.layout.partials_header.my-apps-menu')
    </div> --}}
    {{-- <div class="app-navbar-item ms-1 ms-md-4">
        @include('new_client.layout.partials_header.theme')
    </div> --}}
    <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
        <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <img src="{{ 'https://www.gravatar.com/avatar/' . md5(auth()->user()->email) }}" class="rounded-3"
                alt="user" />
        </div>
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
            data-kt-menu="true" style="">
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <div class="symbol symbol-50px me-5">
                        <img alt="Logo" src="{{ 'https://www.gravatar.com/avatar/' . md5(auth()->user()->email) }}">
                    </div>
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5">{{ auth()->user()->name }}
                            @if (isset(auth()->user()->name_company) && auth()->user()->name_company != '')
                                <span
                                    class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{ auth()->user()->name_company }}</span>
                            @endif
                        </div>
                        <a href="#"
                            class="fw-semibold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
                    </div>
                </div>
            </div>
            <div class="separator my-2"></div>
            <div class="menu-item px-5">
                <a href="account/overview.html" class="menu-link px-5">My Profile</a>
            </div>
            <div class="menu-item px-5">
                <a href="apps/projects/list.html" class="menu-link px-5">
                    <span class="menu-text">My Projects</span>
                    <span class="menu-badge">
                        <span class="badge badge-light-danger badge-circle fw-bold fs-7">3</span>
                    </span>
                </a>
            </div>
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="menu-link px-5">
                    <span class="menu-title">My Subscription</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                    <div class="menu-item px-3">
                        <a href="account/referrals.html" class="menu-link px-5">Referrals</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="account/billing.html" class="menu-link px-5">Billing</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="account/statements.html" class="menu-link px-5">Payments</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="account/statements.html" class="menu-link d-flex flex-stack px-5">Statements
                            <span class="ms-2 lh-0" data-bs-toggle="tooltip" aria-label="View your statements"
                                data-bs-original-title="View your statements" data-kt-initialized="1">
                                <i class="ki-duotone ki-information-5 fs-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span></a>
                    </div>
                    <div class="separator my-2"></div>
                    <div class="menu-item px-3">
                        <div class="menu-content px-3">
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input w-30px h-20px" type="checkbox" value="1"
                                    checked="checked" name="notifications">
                                <span class="form-check-label text-muted fs-7">Notifications</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-item px-5">
                <a href="account/statements.html" class="menu-link px-5">My Statements</a>
            </div>
            <div class="separator my-2"></div>
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="menu-link px-5">
                    <span class="menu-title position-relative">Mode
                        <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                            <i class="ki-duotone ki-night-day theme-light-show fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                                <span class="path7"></span>
                                <span class="path8"></span>
                                <span class="path9"></span>
                                <span class="path10"></span>
                            </i>
                            <i class="ki-duotone ki-moon theme-dark-show fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span></span>
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-solid ki-night-day fs-2"></i> </span>
                            <span class="menu-title">
                                {{ __('Light') }}
                            </span>
                        </a>
                    </div>
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-solid ki-moon fs-2"></i> </span>
                            <span class="menu-title">
                                {{ __('Dark') }}
                            </span>
                        </a>
                    </div>
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-screen fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">System</span>
                        </a>
                    </div>
                </div>
            </div>
            @if (isset($availableLanguages) && count($availableLanguages) > 1 && isset($locale))
                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                    data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                    <a href="#" class="menu-link px-5">
                        @foreach ($availableLanguages as $short => $lang)
                            @if (strtolower($short) == strtolower($locale))
                                <span class="menu-title position-relative">{{ __('Language') }}
                                    <span
                                        class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                                        @if ($short == 'EN')
                                        {{ __($lang) }}
                                            <img class="w-15px h-15px rounded-1 ms-2"
                                                src="{{ asset('Metronic/assets') }}/media/flags/united-states.svg"
                                                alt="" />
                                        @else
                                        {{ __($lang) }}
                                            <img class="w-15px h-15px rounded-1 ms-2"
                                                src="{{ asset('Metronic/assets') }}/media/flags/spain.svg"
                                                alt="" />
                                        @endif
                                    </span></span>
                            @endif
                        @endforeach
                    </a>
                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                        @foreach ($availableLanguages as $short => $lang)
                            <div class="menu-item px-3">
                                <a href="{{ route('home', $short) }}" class="menu-link d-flex px-5 active">
                                    <span class="symbol symbol-20px me-4">
                                        @if ($short == 'EN')
                                            <img class="rounded-1"
                                                src="{{ asset('Metronic/assets') }}/media/flags/united-states.svg"
                                                alt="" />
                                        @else
                                            <img class="rounded-1"
                                                src="{{ asset('Metronic/assets') }}/media/flags/spain.svg"
                                                alt="" />
                                        @endif
                                    </span>{{ __($lang) }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            {{-- <div class="menu-item px-5 my-1">
                <a href="account/settings.html" class="menu-link px-5">Account Settings</a>
            </div> --}}
            <div class="menu-item px-5">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="menu-link px-5">{{ __('Logout') }}</a>
            </div>
        </div>
    </div>
    <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
        <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
            <i class="ki-solid ki-element-4 fs-1"></i>
        </div>
    </div>
</div>
