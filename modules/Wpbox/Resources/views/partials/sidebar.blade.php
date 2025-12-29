<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Wrapper-->
    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper">
        <div class="hover-scroll-y my-5 my-lg-2 mx-4" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper"
            data-kt-scroll-offset="5px">
            <!--begin::Sidebar menu-->
            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
                class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-3 mb-5">
                @if (Auth::user()->isImpersonating())
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click" class="menu-item here">
                        <!--begin:Menu link-->
                        <a class="menu-link active active-pro" href="{{ route('admin.companies.stopImpersonate') }}">
                            <span class="menu-icon">
                                <i class="ki-outline ki-home-2 fs-2"></i>
                            </span>
                            <span class="menu-title">{{ __('Back to your account') }}</span>
                        </a>
                    </div>
                    <!--end:Menu item-->
                    <hr class="my-3">
                @endif
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item here">
                    <!--begin:Menu link-->
                    <a class="menu-link @if ($crn == 'dashboard') active @endif"
                        href="{{ route('dashboard') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-home-2 fs-2"></i>
                        </span>
                        <span class="menu-title">{{ __('Dashboard') }}</span>
                    </a>
                </div>
                <!--end:Menu item-->
                @if (auth()->user()->hasRole('admin') && config('settings.admin_companies_enabled', true))
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click" class="menu-item here">
                        <!--begin:Menu link-->
                        <a class="menu-link @if ($crn == 'admin.companies.index') active @endif"
                            href="{{ route('admin.companies.index') }}">
                            <span class="menu-icon">
                                <i class="ki-outline ki-shop fs-2"></i>
                            </span>
                            <span class="menu-title">{{ __('Companies') }}</span>
                        </a>
                    </div>
                @endif
                <!--end:Menu item-->
                <!-- Exrta menus -->
                @foreach (auth()->user()->getExtraMenus() as $menu)
                    @php
                        $icon = '';
                        switch ($menu['icon']) {
                            case 'ni ni-atom text-green':
                                $icon = 'ki-artificial-intelligence';
                                break;
                            case 'ni ni-chat-round text-blue':
                                $icon = 'ki-messages';
                                break;
                            case 'ni ni-send text-green':
                                $icon = 'ki-filter';
                                break;
                            case 'ni ni-badge text-green':
                                $icon = 'ki-people';
                                break;
                            case 'ni ni-single-copy-04 text-green':
                                $icon = 'ki-element-11';
                                break;
                            case 'ni ni-curved-next text-green':
                                $icon = 'ki-message-edit';
                                break;
                            case 'ni ni-world-2 text-green':
                                $icon = 'ki-abstract-7';
                                break;
                            default:
                                $icon = $menu['icon'];
                                break;
                        }
                    @endphp
                    @if (isset($menu['isGroup']) && $menu['isGroup'])
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion @if ($crn == $menu['route']) show @endif">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-outline {{ $icon }} fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __($menu['name']) }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                @foreach ($menu['menus'] as $submenu)
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link @if ($crn == $submenu['route']) active @endif"
                                            href="{{ route($submenu['route'], isset($submenu['params']) ? $submenu['params'] : []) }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{ __($submenu['name']) }}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endforeach
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                    @else
                        <!--begin:Menu item-->
                        <div class="menu-item here">
                            <!--begin:Menu link-->
                            <a class="menu-link @if ($crn == $menu['route']) active @endif"
                                href="{{ route($menu['route'], isset($menu['params']) ? $menu['params'] : []) }}">
                                <span class="menu-icon">
                                    <i class="ki-outline {{ $icon }} fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __($menu['name']) }}</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    @endif
                @endforeach
                @if (auth()->user()->hasRole('owner'))
                    @if (!config('settings.hide_company_profile', false))
                        <!--begin:Menu item-->
                        <div class="menu-item here">
                            <!--begin:Menu link-->
                            <a class="menu-link @if ($crn == 'admin.companies.edit') active @endif"
                                href="{{ route('admin.companies.edit') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-rocket fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('Company') }}</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    @endif
                    @if (config('settings.enable_pricing'))
                        <!--begin:Menu item-->
                        <div class="menu-item here">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="{{ route('plans.current') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-rocket fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('Plan') }}</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    @endif
                    @if (!config('settings.hide_share_link', false))
                        <!--begin:Menu item-->
                        <div class="menu-item here">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="{{ route('admin.share') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-rocket fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('Share') }}</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    @endif
                @endif
                @if (auth()->user()->hasRole('admin'))
                    <!--begin:Menu item-->
                    <div class="menu-item here">
                        <!--begin:Menu link-->
                        <a class="menu-link @if ($crn == 'admin.landing') active @endif"
                            href="{{ route('admin.landing') }}">
                            <span class="menu-icon">
                                <i class="ki-outline ki-rocket fs-2"></i>
                            </span>
                            <span class="menu-title">{{ __('Landing Page') }}</span>
                        </a>
                    </div>

                    <div class="menu-item here">
                        <!--begin:Menu link-->
                        <a class="menu-link @if ($crn == 'partners.index') active @endif"
                            href="{{ route('partners.index') }}">
                            <span class="menu-icon">
                                <i class="ki-outline ki-rocket fs-2"></i>
                            </span>
                            <span class="menu-title">{{ __('Partners') }}</span>
                        </a>
                    </div>
                    <!--end:Menu item-->
                    @if (config('settings.pricing_enabled', true))
                        <!--begin:Menu item-->
                        <div class="menu-item here">
                            <!--begin:Menu link-->
                            <a class="menu-link @if ($crn == 'plans.index') active @endif"
                                href="{{ route('plans.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-dollar fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('Pricing plans') }}</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    @endif
                    <!--begin:Menu item-->
                    <div class="menu-item here">
                        <!--begin:Menu link-->
                        <a class="menu-link" target="_blank"
                            href="{{ url('/tools/languages') . '/' . strtolower(config('settings.app_locale', 'en')) . '/translations' }}">
                            <span class="menu-icon">
                                <i class="ki-outline ki-flag fs-2"></i>
                            </span>
                            <span class="menu-title">{{ __('Translations') }}</span>
                        </a>
                    </div>
                    <!--end:Menu item-->
                    @if (!config('settings.hideApps', false))
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link @if ($crn == 'admin.apps.index') active @endif"
                                href="{{ route('admin.apps.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-abstract-26 fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('Apps') }}</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    @endif
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link @if ($crn == 'admin.settings.index') active @endif"
                            href="{{ route('admin.settings.index') }}">
                            <span class="menu-icon">
                                <i class="ki-outline ki-gear fs-2"></i>
                            </span>
                            <span class="menu-title">{{ __('Site Settings') }}</span>
                        </a>
                    </div>
                    <!--end:Menu item-->
                @endif
            </div>
            <!--end::Sidebar menu-->
            @if (auth()->user()->hasRole('owner') && config('vendorlinks.enable', false))
                <!--begin::Teames-->
                <div class="app-sidebar-menu-secondary menu menu-rounded menu-column px-3">
                    <!--begin::Separator-->
                    <div class="app-sidebar-separator separator mx-4 mt-2 mb-2"></div>
                    <!--end::Separator-->
                    <h6 class="navbar-heading p-0 text-muted"><span
                            class="docs-normal">{{ __(config('vendorlinks.name', '')) }}</span></h6>
                    @if (strlen(config('vendorlinks.link1link', '')) > 4)
                        <!--begin::Menu Item-->
                        <div class="menu-item">
                            <!--begin::Menu link-->
                            <a class="menu-link" href="{{ config('vendorlinks.link1link', '') }}">
                                <!--begin::Bullet-->
                                <span class="menu-icon ps-2">
                                    <span class="bullet bullet-dot h-10px w-10px bg-primary"></span>
                                </span>
                                <!--end::Bullet-->
                                <!--begin::Title-->
                                <span
                                    class="menu-title text-gray-700 fw-bold fs-6">{{ __(config('vendorlinks.link1name', '')) }}</span>
                                <!--end::Title-->
                                <!--begin::Badge-->
                                <span class="menu-badge">
                                    <span class="badge badge-secondary">6</span>
                                </span>
                                <!--end::Badge-->
                            </a>
                            <!--end::Menu link-->
                        </div>
                        <!--end::Menu link-->
                    @endif

                    @if (strlen(config('vendorlinks.link2link', '')) > 4)
                        <div class="menu-item">
                            <!--begin::Menu link-->
                            <a class="menu-link" href="{{ config('vendorlinks.link2link', '') }}">
                                <!--begin::Bullet-->
                                <span class="menu-icon ps-2">
                                    <span class="bullet bullet-dot h-10px w-10px bg-primary"></span>
                                </span>
                                <!--end::Bullet-->
                                <!--begin::Title-->
                                <span
                                    class="menu-title text-gray-700 fw-bold fs-6">{{ __(config('vendorlinks.link2name', '')) }}</span>
                                <!--end::Title-->
                                <!--begin::Badge-->
                                <span class="menu-badge">
                                    <span class="badge badge-secondary">6</span>
                                </span>
                                <!--end::Badge-->
                            </a>
                            <!--end::Menu link-->
                        </div>
                        <!--end::Menu link-->
                    @endif
                    @if (strlen(config('vendorlinks.link3link', '')) > 4)
                        <div class="menu-item">
                            <!--begin::Menu link-->
                            <a class="menu-link" href="{{ config('vendorlinks.link3link', '') }}">
                                <!--begin::Bullet-->
                                <span class="menu-icon ps-2">
                                    <span class="bullet bullet-dot h-10px w-10px bg-primary"></span>
                                </span>
                                <!--end::Bullet-->
                                <!--begin::Title-->
                                <span
                                    class="menu-title text-gray-700 fw-bold fs-6">{{ __(config('vendorlinks.link3name', '')) }}</span>
                                <!--end::Title-->
                                <!--begin::Badge-->
                                <span class="menu-badge">
                                    <span class="badge badge-secondary">6</span>
                                </span>
                                <!--end::Badge-->
                            </a>
                            <!--end::Menu link-->
                        </div>
                        <!--end::Menu link-->
                    @endif
                </div>
                <!--end::Teames-->
            @endif
            @if (auth()->user()->hasRole('admin'))
                <!--begin::Teames-->
                <div class="app-sidebar-menu-secondary menu menu-rounded menu-column px-3">
                    <!--begin::Separator-->
                    <div class="app-sidebar-separator separator mx-4 mt-2 mb-2"></div>
                    <!--end::Separator-->
                    <h6 class="navbar-heading p-0 text-muted">
                        {{ __('Version') }} {{ config('version.version') }} <span id="uptodate"
                            class="badge badge-success" style="display:none;">{{ __('latest') }}</span>
                    </h6>
                    <h6>{{ \Carbon\Carbon::now() }}</h6>
                </div>
                <!--end::Teames-->
            @endif
        </div>
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Sidebar-->
