<div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="/dashboard">
            <img alt="Logo" src="{{ asset('custom/imgs/logo/logodark.png') }}"
                class="h-25px app-sidebar-logo-default theme-light-show ms-3" />
            <img alt="Logo" src="{{ asset('custom/imgs/icono-light.png') }}"
                class="h-20px app-sidebar-logo-minimize theme-light-show" />
            <img alt="Logo" src="{{ asset('custom/imgs/logo/logowhite.png') }}"
                class="h-25px app-sidebar-logo-default theme-dark-show ms-3" />
            <img alt="Logo" src="{{ asset('custom/imgs/icono-dark.png') }}"
                class="h-20px app-sidebar-logo-minimize theme-dark-show" />
        </a>
        <!--begin::Minimized sidebar setup:
                if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") {
                    1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
                    2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
                    3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
                    4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
                }
            -->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-success h-30px w-30px position-absolute top-50 start-100 translate-middle rotate active"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-solid ki-black-left-line fs-3 rotate-180"></i>
        </div>
    </div>
    <div class="separator separator-dashed border-secondary"></div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                        <!--begin:Menu link-->

                        <div class="menu-item">
                            <a class="menu-link @if (Route::currentRouteName() == 'dashboard') active @endif"
                                href="{{ route('dashboard') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-abstract-36 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </div>

                        <div class="menu-item pt-5">
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">
                                    FUNCIONES
                                </span>
                            </div>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if (Route::currentRouteName() == 'chat.index') active @endif"
                                href="{{ route('chat.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-messages fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Conversaciones</span>
                            </a>
                        </div>
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion @if (Route::currentRouteName() == 'campaigns.index' ||
                                    Route::currentRouteName() == 'campaigns.create' ||
                                    (Route::currentRouteName() == 'wpbox.api.index' && Request::query('type') == 'api')) show @endif">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-add-notepad fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">
                                    Campañas
                                </span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion @if (Route::currentRouteName() == 'campaigns.index' ||
                                    Route::currentRouteName() == 'campaigns.create' ||
                                    (Route::currentRouteName() == 'wpbox.api.index' && Request::query('type') == 'api')) show @endif"
                                @if (Route::currentRouteName() == 'campaigns.index' ||
                                        Route::currentRouteName() == 'campaigns.create' ||
                                        (Route::currentRouteName() == 'wpbox.api.index' && Request::query('type') == 'api')) @else style="display: none; overflow: hidden;" @endif
                                kt-hidden-height="251">
                                <div class="menu-item">
                                    <a class="menu-link @if (Route::currentRouteName() == 'campaigns.index' && !Request::is('campaigns/create')) active @endif"
                                        href="{{ route('campaigns.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">
                                            Ver Campañas
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link @if (Route::currentRouteName() == 'campaigns.create') active @endif"
                                        href="{{ route('campaigns.create') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">
                                            Crear Campaña
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link @if (Route::currentRouteName() == 'wpbox.api.index' && Request::query('type') == 'api') ) active @endif"
                                        href="{{ route('wpbox.api.index', ['type' => 'api']) }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">
                                            Api Campaña
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion @if (Route::currentRouteName() == 'contacts.index' ||
                                    Route::currentRouteName() == 'contacts.fields.index' ||
                                    Route::currentRouteName() == 'contacts.groups.index') show @endif">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-badge fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </span>
                                <span class="menu-title">
                                    {{ __('Contacts') }}
                                </span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion @if (Route::currentRouteName() == 'contacts.index' ||
                                    Route::currentRouteName() == 'contacts.fields.index' ||
                                    Route::currentRouteName() == 'contacts.groups.index') show @endif"
                                @if (Route::currentRouteName() == 'contacts.index' ||
                                        Route::currentRouteName() == 'contacts.fields.index' ||
                                        Route::currentRouteName() == 'contacts.groups.index') @else style="display: none; overflow: hidden;" @endif
                                kt-hidden-height="251">
                                <div class="menu-item">
                                    <a class="menu-link @if (Route::currentRouteName() == 'contacts.index') active @endif"
                                        href="{{ route('contacts.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">
                                            {{__('Contact List')}}
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link @if (Route::currentRouteName() == 'contacts.fields.index') active @endif"
                                        href="{{ route('contacts.fields.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">
                                            Campos
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link @if (Route::currentRouteName() == 'contacts.groups.index') active @endif"
                                        href="{{ route('contacts.groups.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">
                                            {{ __('Groups') }}
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if (Route::currentRouteName() == 'agent.index') active @endif"
                                href="{{ route('agent.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-people fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Agentes</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if (Route::currentRouteName() == 'templates.index') active @endif"
                                href="{{ route('templates.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-paintbucket fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Template</span>
                            </a>
                        </div>
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion @if (Route::currentRouteName() == 'flowisebots.index' ||
                                    Route::currentRouteName() == 'replies.index' ||
                                    Route::currentRouteName() == 'flows.index' ||
                                    (Request::is('replies') && Request::query('type') == 'qr')) show @endif">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-technology-2 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">
                                    Automatización
                                </span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion @if (Route::currentRouteName() == 'flowisebots.indexcompany' ||
                                    Route::currentRouteName() == 'replies.index' ||
                                    Route::currentRouteName() == 'flows.index' ||
                                    (Request::is('replies') && Request::query('type') == 'qr')) show @endif"
                                @if (Route::currentRouteName() == 'flowisebots.indexcompany' ||
                                        Route::currentRouteName() == 'replies.index' ||
                                        Route::currentRouteName() == 'flows.index' ||
                                        (Request::is('replies') && Request::query('type') == 'qr')) @else style="display: none; overflow: hidden;" @endif
                                kt-hidden-height="251">
                                <div class="menu-item">
                                    <a class="menu-link @if (Route::currentRouteName() == 'flowisebots.indexcompany') active @endif"
                                        href="{{ route('flowisebots.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">
                                            Bots de IA
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link @if (Route::currentRouteName() == 'replies.index' && !Request::query('type')) active @endif"
                                        href="{{ route('replies.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">
                                            Bots de Plantilla
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link @if (Route::currentRouteName() == 'flows.index') active @endif"
                                        href="{{ route('flows.index') }}">

                                        <span class="menu-bullet">

                                            <span class="bullet bullet-dot"></span>

                                        </span>

                                        <span class="menu-title">

                                            Flow Bots

                                        </span>

                                    </a>

                                </div>

                                <div class="menu-item">

                                    <a class="menu-link @if (Request::is('replies') && Request::query('type') == 'qr') active @endif"
                                        href="{{ url('replies?type=qr') }}">

                                        <span class="menu-bullet">

                                            <span class="bullet bullet-dot"></span>

                                        </span>

                                        <span class="menu-title">

                                            Respuestas Rápidas

                                        </span>

                                    </a>

                                </div>

                            </div>

                        </div>

                        <div class="menu-item pt-5">
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">
                                    HERRAMIENTAS
                                </span>
                            </div>
                        </div>
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion @if (Route::currentRouteName() == 'reminders.reservations.index' ||
                                    Route::currentRouteName() == 'reminders.reminders.index' ||
                                    Route::currentRouteName() == 'reminders.sources.index') show @endif">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-calendar-8 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                    </i>
                                </span>
                                <span class="menu-title">
                                    Reminders
                                </span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion @if (Route::currentRouteName() == 'reminders.reservations.index' ||
                                    Route::currentRouteName() == 'reminders.reminders.index' ||
                                    Route::currentRouteName() == 'reminders.sources.index') show @endif"
                                @if (Route::currentRouteName() == 'reminders.reservations.index' ||
                                        Route::currentRouteName() == 'reminders.reminders.index' ||
                                        Route::currentRouteName() == 'reminders.sources.index') @else style="display: none; overflow: hidden;" @endif
                                kt-hidden-height="251">
                                <div class="menu-item">
                                    <a class="menu-link @if (Request::is('reminders/reservations')) active @endif"
                                        href="{{ route('reminders.reservations.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">
                                            Reservaciones
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link @if (Request::is('reminders/reminders')) active @endif"
                                        href="{{ route('reminders.reminders.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">
                                            Reminders
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link @if (Request::is('reminders/sources')) active @endif"
                                        href="{{ route('reminders.sources.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">
                                            Sources
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="menu-item">
                            <a class="menu-link @if (Route::currentRouteName() == 'embedwhatsapp.edit') active @endif"
                                href="{{ route('embedwhatsapp.edit') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-message-minus fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Generador de widget</span>
                            </a>
                        </div>

                        <div class="menu-item pt-5">
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">
                                    CONFIGURACIÓN
                                </span>
                            </div>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link @if (Route::currentRouteName() == 'subscription.info') active @endif"
                                href="{{ route('subscription.info') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-credit-cart fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Planes</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if (Route::currentRouteName() == 'admin.apps.company') active @endif"
                                href="{{ route('admin.apps.company') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-element-plus fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Apps</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if (Route::currentRouteName() == 'api.info') active @endif"
                                href="{{ route('api.info') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-message-programming fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">APIS</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if (Route::currentRouteName() == 'profile.show') active @endif"
                                href="{{ route('profile.show') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-profile-circle fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Cuenta</span>
                            </a>
                        </div>

                        <div class="menu-item pt-5">
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">
                                    AYUDA
                                </span>
                            </div>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="https://dotflo.io/configurar-en-minutos">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-setting-2 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">wizard</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="https://dotflo.io/kb">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-book fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Documentación</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="https://dotflo.io/portal">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-text-align-justify-center fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Abrir ticket</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-security-user fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Hablar agente</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
