<style>
    .menu-state-primary .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-title,
    .menu-state-primary .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-title {
        color: white !important;
    }

    .menu-state-primary .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-icon-title,
    .menu-state-primary .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-icon-title {
        color: white !important;
    }

    .menu-state-bullet-primary .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-bullet .bullet,
    .menu-state-bullet-primary .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-bullet .bullet {
        background-color: white !important;
    }

    .menu-state-primary .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here),
    .menu-state-primary .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) {

        color: white !important;
    }

    .menu-flecha-hover:hover {
        color: white !important;
    }

    .menu-item .link-wb-active.active .menu-title,
    .menu-item .link-wb-active.active .bullet-wb {
        color: white !important;
    }

    .menu-item .link-wb-active.active .menu-icon-title,
    .menu-item .link-wb-active.active .bullet-wb {
        color: white !important;
    }

    .menu-state-bullet-primary .menu-item .menu-link.active .menu-bullet .bullet {
        background-color: white !important;
    }

    .menu-state-primary .menu-item.here>.menu-link .menu-title {
        color: white !important;
    }

    .menu-state-primary .menu-item.here>.menu-link .menu-icon-title {
        color: white !important;
    }

    .menu-state-bullet-primary .menu-item.show>.menu-link .menu-bullet .bullet {
        background-color: white !important;
    }

    .menu-state-bullet-primary .menu-item.here>.menu-link .menu-bullet .bullet {
        background-color: white !important;
    }

    .menu-item:hover i {
        color: var(--theme-icon-color-hover) !important;
    }
 
    .menu-item.active:hover i {
        color: var(--theme-icon-color-active) !important;
    }

    .menu-item.here:hover i {
        color: var(--theme-icon-color-active) !important;
    }

    /* NEW STYLES */
    .menu-icon-title {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        color: var(--menu-icon-title-color);
    }

    .menu-icon {
        margin-bottom: 6px;
    }

    .menu-icon-title {
        font-size: 0.75rem !important;
        line-height: 1.2;
        text-align: center;
    }

    /* Larger menu boxes */
    .app-sidebar .app-sidebar-menu .menu>.menu-item>.menu-link {
        height: 50px;
        /* Increased height */
        width: 64px;
        padding: 8px 0;
        /* Added vertical padding */
    }

    /* Adjust dropdown positioning */
    .menu-sub {
        margin-left: 80px;
    }

    /* Ensure proper hover states */
    .menu-state-primary .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-title,
    .menu-state-primary .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-title,
    .menu-state-primary .menu-item.here>.menu-link .menu-title {
        color: white !important;
    }

    .menu-state-primary .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-icon-title,
    .menu-state-primary .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-icon-title,
    .menu-state-primary .menu-item.here>.menu-link .menu-icon-title {
        color: #0F8C83 !important;
    }
</style>
<div id="kt_app_sidebar" style="top: 54px; background-color: var(--theme-color-sidebar);" class="app-sidebar  flex-column "
    data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true" data-kt-drawer-width="80px" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <div class="app-sidebar-menu flex-grow-1 hover-scroll-y scroll-lg-ps my-5" id="kt_aside_menu_wrapper"
        data-kt-scroll="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
        <!--begin::Menu-->
        <div id="kt_aside_menu"
            class="menu menu-rounded menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6"
            data-kt-menu="true">
            <!--begin:Menu item-->
            @if (Auth::user()->isImpersonating())
            <a href="{{ route('owner.stopImpersonate') }}" class="menu-item  py-2" data-bs-toggle="tooltip"
                data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="{{ __('Back Owner') }}">
                <span class="menu-link menu-center ">
                    <span class="menu-icon me-0" style="color: var(--theme-icon-color);">
                        <i class="ki-duotone ki-left text-muted fs-2"></i>
                    </span>
                </span>
            </a>
            @endif
            <a href="{{ route('dashboard') }}" class="menu-item @if (Route::currentRouteName() == 'dashboard' || Route::currentRouteName() == 'home') here @endif py-2"
                data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right"
                title="{{ __('Dashboard') }}">
                <span class="menu-link menu-center">
                    <span class="menu-icon-title">
                        <span class="menu-icon me-0 mt-4" style="color: var(--theme-icon-color);">
                            <i class="ki-duotone ki-abstract-36 fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-icon-title mt-2">{{ __('Dashboard') }}</span>
                    </span>
                </span>
            </a>
            {{-- <hr class="hr my-2 mx-2 text-light"> --}}

            <a href="{{ route('chat.index') }}" class="menu-item  py-2 @if (Route::currentRouteName() == 'chat.index') here @endif"
                data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right"
                title="{{ __('Conversations') }}">
                <span class="menu-link menu-center">
                    <span class="menu-icon-title">
                        <span class="menu-icon me-0 mt-4" style="color: var(--theme-icon-color);">
                            <i class="ki-duotone ki-messages fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </span>
                        <span class="menu-icon-title mt-2">{{ __('Chat') }}</span>
                    </span>
                </span>
            </a>
            {{-- @if (auth()->user()->hasrole(['staff']))
                <a href="{{ route('campaigns.index') }}"
            class="menu-item py-2 @if (Route::currentRouteName() == 'campaigns.index') here @endif" data-bs-toggle="tooltip"
            data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="{{ __('Campaings') }}">
            <span class="menu-link menu-center">
                <span class="menu-icon-title">
                    <span class="menu-icon me-0 mt-4" style="color: var(--theme-icon-color);">
                        <i class="ki-duotone ki-messages fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>
                    </span>
                    <span class="menu-icon-title mt-2">{{ __('Broadcast') }}</span>
                </span>
            </span>
            </a>
            @endif --}}

            {{-- @if (!auth()->user()->hasrole(['staff'])) --}}
            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                class="menu-item py-2 @if (Route::currentRouteName() == 'campaigns.index' ||
                            Route::currentRouteName() == 'campaigns.create' ||
                            Route::currentRouteName() == 'campaigns.show' ||
                            (Route::currentRouteName() == 'wpbox.api.index' && Request::query('type') == 'api')) here @endif">
                <!--begin:Menu link-->
                <span class="menu-link menu-center">
                    <span class="menu-icon-title">
                        <span class="menu-icon me-0 mt-4" style="color: var(--theme-icon-color);">
                            <i class="ki-duotone ki-send">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-icon-title mt-2">{{ __('Broadcast') }}</span>
                    </span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div
                    class="bg-dark menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu content-->
                        <div class="menu-content "><span
                                class="menu-section text-white link-offset-2 fs-5 fw-bolder ps-1 py-1">
                                {{ __('Campaings') }}</span>
                        </div>
                        <!--end:Menu content-->
                    </div>

                    <div class="menu-item">
                        <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'campaigns.index' && !Request::is('campaigns/create')) active @endif"
                            href="{{ route('campaigns.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot text-white"></span>
                            </span>
                            <span class="menu-title">
                                {{ __('Show Campaigns') }}
                            </span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'campaigns.create') ) active @endif"
                            href="{{ route('campaigns.create') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">
                                {{ __('Create Campaign') }}
                            </span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'wpbox.api.index' && Request::query('type') == 'api') ) active @endif"
                            href="{{ route('wpbox.api.index', ['type' => 'api']) }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">
                                {{ __('API Campaign') }}
                            </span>
                        </a>
                    </div>

                </div>
                <!--end:Menu sub-->
            </div>
            {{-- @endif --}}

            {{-- Contacts --}}
            {{-- @if (!auth()->user()->hasrole(['staff'])) --}}
            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                class="menu-item py-2 @if (Route::currentRouteName() == 'contacts.index' ||
                            Route::currentRouteName() == 'contacts.fields.index' ||
                            Route::currentRouteName() == 'contacts.newimport.index' ||
                            Route::currentRouteName() == 'contacts.edit' ||
                            Route::currentRouteName() == 'contacts.groups.index') here @endif">
                <!--begin:Menu link-->


                <span class="menu-link menu-center">
                    <span class="menu-icon-title">
                        <span class="menu-icon me-0 mt-4" style="color: var(--theme-icon-color);">
                            <i class="ki-duotone ki-badge fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </span>
                        <span class="menu-icon-title mt-2">{{ __('Contacts') }}</span>
                    </span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="bg-dark menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto  @if (Route::currentRouteName() == 'contacts.index' ||
                            Route::currentRouteName() == 'contacts.fields.index' ||
                            Route::currentRouteName() == 'contacts.newimport.index' ||
                            Route::currentRouteName() == 'contacts.edit' ||
                            Route::currentRouteName() == 'contacts.groups.index') show @endif"
                    @if (Route::currentRouteName()=='contacts.index' ||
                    Route::currentRouteName()=='contacts.edit' ||
                    Route::currentRouteName()=='contacts.fields.index' ||
                    Route::currentRouteName()=='contacts.newimport.index' ||
                    Route::currentRouteName()=='contacts.groups.index' ) @else style="display: none; overflow: hidden;" @endif>
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu content-->
                        <div class="menu-content "><span
                                class="menu-section text-white link-offset-2 fs-5 fw-bolder ps-1 py-1">
                                {{ __('Contacts') }}</span>
                        </div>
                        <!--end:Menu content-->
                    </div>

                    <div class="menu-item">
                        <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'contacts.index') active @endif"
                            href="{{ route('contacts.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">
                                {{ __('Contact Management') }}
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'contacts.fields.index') active @endif"
                            href="{{ route('contacts.fields.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">
                                {{ __('Fields') }}
                            </span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'contacts.groups.index') active @endif"
                            href="{{ route('contacts.groups.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">
                                {{ __('Groups') }}
                            </span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'contacts.newimport.index') active @endif"
                            href="{{ route('contacts.newimport.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">
                                {{ __('Import') }}
                            </span>
                        </a>
                    </div>

                </div>
                <!--end:Menu sub-->
            </div>
            {{-- @endif --}}
            {{-- Agentes --}}
            {{-- @if (!auth()->user()->hasrole(['staff']))
                <a href="{{ route('agent.index') }}"
            class="menu-item py-2 @if (Route::currentRouteName() == 'agent.index' || Route::currentRouteName() == 'agent.create') here @endif" data-bs-toggle="tooltip"
            data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="{{ __('Agents') }}">
            <span class="menu-link menu-center">
                <span class="menu-icon me-0" style="color: var(--theme-icon-color);">
                    <i class="ki-duotone ki-people fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                </span>
            </span>
            </a>
            @endif --}}
            {{-- template --}}
            {{-- @if (!auth()->user()->hasrole(['staff'])) --}}
            <a href="{{ route('templates.index') }}"
                class="menu-item  py-2 @if (Route::currentRouteName() == 'templates.index' || Route::currentRouteName() == 'templates.create') here @endif" data-bs-toggle="tooltip"
                data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="{{ __('Templates') }}">
                <span class="menu-link menu-center">
                    <span class="menu-icon-title">
                        <span class="menu-icon me-0 mt-4" style="color: var(--theme-icon-color);">
                            <i class="ki-duotone ki-color-swatch fs-2"><span class="path1"></span><span
                                    class="path2"></span><span class="path3"></span><span
                                    class="path4"></span><span class="path5"></span><span
                                    class="path6"></span><span class="path7"></span><span
                                    class="path8"></span><span class="path9"></span><span
                                    class="path10"></span><span class="path11"></span><span
                                    class="path12"></span><span class="path13"></span><span
                                    class="path14"></span><span class="path15"></span><span
                                    class="path16"></span><span class="path17"></span><span
                                    class="path18"></span><span class="path19"></span><span
                                    class="path20"></span><span class="path21"></span></i>
                        </span>
                        <span class="menu-icon-title mt-2">{{ __('Template') }}</span>
                    </span>
                </span>
            </a>
            {{-- @endif --}}
            {{-- @if (!auth()->user()->hasrole(['staff'])) --}}
            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                class="menu-item py-2 @if (Route::currentRouteName() == 'flows.index' ||
                            Route::currentRouteName() == 'replies.create' ||
                            Route::currentRouteName() == 'flowmaker.edit' ||
                            Route::currentRouteName() == 'button_template.index' ||
                            Route::currentRouteName() == 'button_template.create' ||
                            Route::currentRouteName() == 'list_button_template.index' ||
                            Route::currentRouteName() == 'list_button_template.create' ||
                            (Request::is('replies') && Request::query('type') == 'qr')) show here @endif">
                <!--begin:Menu link-->
                <span class="menu-link menu-center">
                    <span class="menu-icon-title">
                        <span class="menu-icon me-0 mt-4" style="color: var(--theme-icon-color);">
                            <i class="ki-duotone ki-abstract-42 fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                        <span class="menu-icon-title mt-2">{{ __('Chatbot') }}</span>
                    </span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="bg-dark menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto @if (Route::currentRouteName() == 'replies.index' ||
                            Route::currentRouteName() == 'replies.create' ||
                            Route::currentRouteName() == 'flows.index' ||
                            Route::currentRouteName() == 'flowmaker.edit' ||
                            Route::currentRouteName() == 'button_template.index' ||
                            (Request::is('replies') && Request::query('type') == 'qr')) here show @endif"
                    @if (Route::currentRouteName()=='flowisebots.indexcompany' ||
                    Route::currentRouteName()=='replies.create' ||
                    Route::currentRouteName()=='flows.index' ||
                    Route::currentRouteName()=='flowmaker.edit' ||
                    Route::currentRouteName()=='button_template.index' ||
                    (Request::is('replies') && Request::query('type')=='qr' )) @else style="display: none; overflow: hidden;" @endif>
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu content-->
                        <div class="menu-content "><span
                                class="menu-section text-white link-offset-2 fs-5 fw-bolder ps-1 py-1">
                                {{ __('Chatbot & Features') }}</span>
                        </div>
                        <!--end:Menu content-->
                    </div>

                    {{-- <div class="menu-item">
                            <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'flowisebots.indexcompany') active @endif"
                                href="{{ route('flowisebots.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">
                        {{ __("AI Bot") }}
                    </span>
                    </a>
                </div> --}}

                <div class="menu-item">
                    <a class="menu-link link-wb-active @if (Request::is('replies') && Request::query('type') == 'bot') active @endif"
                        href="{{ url('replies?type=bot') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">
                            {{ __('Chatbot') }}
                        </span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link link-wb-active @if (Request::is('replies') && Request::query('type') == 'qr') active @endif"
                        href="{{ url('replies?type=qr') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">
                            {{ __('Quick Replies') }}
                        </span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'button_template.index' || Route::currentRouteName() == 'button_template.create') active @endif"
                        href="{{ route('button_template.index') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">
                            {{ __('Interactive - Button') }}
                        </span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'list_button_template.index' ||
                                    Route::currentRouteName() == 'list_button_template.create') active @endif"
                        href="{{ route('list_button_template.index') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">
                            {{ __('Interactive - List') }}
                        </span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'flows.index' || Route::currentRouteName() == 'flowmaker.edit') active @endif"
                        href="{{ route('flows.index') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">
                            {{ __('Flow Bot') }}
                        </span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'bot-flow-list' || Route::currentRouteName() == 'bot-flows.edit') active @endif"
                        href="{{ route('bot-flow-list') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">
                            {{ __('Bot Flow') }}
                        </span>
                    </a>
                </div>

            </div>
            <!--end:Menu sub-->
        </div>
        {{-- @endif --}}
        {{-- Automatizacion --}}
        {{-- @if (!auth()->user()->hasrole(['staff'])) --}}
        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
            class="menu-item py-2 @if (Route::currentRouteName() == 'flowisebots.index' ||
                            Route::currentRouteName() == 'whatsapp-flows.index' ||
                            Route::currentRouteName() == 'whatsapp-flows.viewdata' ||
                            Route::currentRouteName() == 'workflows.index' ||
                            Route::currentRouteName() == 'workflows.create' ||
                            Route::currentRouteName() == 'workflows.edit' ||
                            Route::currentRouteName() == 'journies.index' ||
                            Route::currentRouteName() == 'journies.create' ||
                            Route::currentRouteName() == 'journies.edit' ||
                            Route::currentRouteName() == 'journies.kanban' ||
                            Route::currentRouteName() == 'stages.index' ||
                            Route::currentRouteName() == 'stages.create' ||
                            Route::currentRouteName() == 'stages.edit' ||
                            Route::currentRouteName() == 'autoretarget.index' ||
                            Route::currentRouteName() == 'autoretarget.create' ||
                            Route::currentRouteName() == 'autoretarget.edit' ||
                            Route::currentRouteName() == 'leads.index' ||
                                    Route::currentRouteName() == 'leads.create' ||
                                    Route::currentRouteName() == 'leads.edit' ||
                                    Route::currentRouteName() == 'leads.kanban' ||
                                    Route::currentRouteName() == 'leads.show' ||
                            Route::currentRouteName() == 'whatsapp-flows.create') show here @endif">
            <!--begin:Menu link-->
            <span class="menu-link menu-center">
                <span class="menu-icon-title">
                    <span class="menu-icon me-0 mt-4" style="color: var(--theme-icon-color);">
                        <i class="ki-duotone ki-technology-2 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-icon-title mt-2">{{ __('Automation') }}</span>
                </span>
            </span>
            <!--end:Menu link-->
            <!--begin:Menu sub-->
            <div class="bg-dark menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto @if (Route::currentRouteName() == 'flowisebots.indexcompany' ||
                            Route::currentRouteName() == 'whatsapp-flows.index' ||
                            Route::currentRouteName() == 'whatsapp-flows.viewdata' ||
                            Route::currentRouteName() == 'whatsapp-flows.create' ||
                            Route::currentRouteName() == 'reminders.reservations.index' ||
                            Route::currentRouteName() == 'reminders.reminders.index' ||
                            Route::currentRouteName() == 'reminders.sources.index' ||
                            Route::currentRouteName() == 'leads.index' ||
                                    Route::currentRouteName() == 'leads.create' ||
                                    Route::currentRouteName() == 'leads.edit' ||
                                    Route::currentRouteName() == 'leads.kanban' ||
                            (Request::is('replies') && Request::query('type') == 'qr')) here show @endif"
                @if (Route::currentRouteName()=='flowisebots.indexcompany' ||
                Route::currentRouteName()=='whatsapp-flows.index' ||
                Route::currentRouteName()=='whatsapp-flows.viewdata' ||
                Route::currentRouteName()=='whatsapp-flows.create' ||
                Route::currentRouteName()=='workflows.index' ||
                Route::currentRouteName()=='workflows.create' ||
                Route::currentRouteName()=='workflows.edit' ||
                (Request::is('replies') && Request::query('type')=='qr' )) @else style="display: none; overflow: hidden;" @endif>
                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu content-->
                    <div class="menu-content "><span
                            class="menu-section text-white link-offset-2 fs-5 fw-bolder ps-1 py-1">
                            {{ __('Automation') }}</span>
                    </div>
                    <!--end:Menu content-->
                </div>

                {{-- <div class="menu-item">
                            <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'flowisebots.indexcompany') active @endif"
                                href="{{ route('flowisebots.index') }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">
                    {{ __("AI Bot") }}
                </span>
                </a>
            </div> --}}

            <!-- Meta ad's -->
            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'ctwameta.index') active @endif"
                    href="{{ route('ctwameta.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">
                        {{ __('Meta Ads') }}
                    </span>
                </a>
            </div>
            <!-- Meta ad's end -->

            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'whatsapp-flows.index' ||
                                    Route::currentRouteName() == 'whatsapp-flows.viewdata' ||
                                    Route::currentRouteName() == 'whatsapp-flows.create') active @endif"
                    href="{{ route('whatsapp-flows.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">
                        {{ __('WhatsApp Flows') }}
                    </span>
                </a>
            </div>

            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'leads.index' ||
                                    Route::currentRouteName() == 'leads.create' ||
                                    Route::currentRouteName() == 'leads.edit' ||
                                    Route::currentRouteName() == 'leads.show' ||
                                    Route::currentRouteName() == 'leads.kanban') active @endif"
                    href="{{ route('leads.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">
                        {{ __('Lead Manager') }}
                    </span>
                </a>
            </div>

            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'workflows.index' ||
                                    Route::currentRouteName() == 'workflows.edit' ||
                                    Route::currentRouteName() == 'workflows.create') active @endif"
                    href="{{ route('workflows.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">
                        {{ __('Workflow') }}
                    </span>
                </a>
            </div>


            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'autoretarget.index' ||
                                    Route::currentRouteName() == 'autoretarget.edit' ||
                                    Route::currentRouteName() == 'autoretarget.create') active @endif"
                    href="{{ route('autoretarget.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">
                        {{ __('AutoRetarget') }}
                    </span>
                </a>
            </div>

            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'journies.index' ||
                                    Route::currentRouteName() == 'journies.create' ||
                                    Route::currentRouteName() == 'journies.edit' ||
                                    Route::currentRouteName() == 'journies.kanban' ||
                                    Route::currentRouteName() == 'stages.index' ||
                                    Route::currentRouteName() == 'stages.create' ||
                                    Route::currentRouteName() == 'stages.edit') active @endif"
                    href="{{ route('journies.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">
                        {{ __('Journies') }}
                    </span>
                </a>
            </div>

            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion @if (Route::currentRouteName() == 'reminders.reservations.index' ||
                                    Route::currentRouteName() == 'reminders.reminders.index' ||
                                    Route::currentRouteName() == 'reminders.sources.index') show here @endif">
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">
                        {{ __('Reminders') }}
                    </span>
                    <span class="menu-arrow menu-flecha-hover"
                        style="    color: var(--theme-icon-color);">
                        <i class="ki-duotone ki-down"></i>
                    </span>
                </span>
                <div class="menu-sub menu-sub-accordion @if (Route::currentRouteName() == 'reminders.reservations.index' ||
                                    Route::currentRouteName() == 'reminders.reminders.index' ||
                                    Route::currentRouteName() == 'reminders.sources.index') show @endif"
                    @if (Route::currentRouteName()=='reminders.reservations.index' ||
                    Route::currentRouteName()=='reminders.reminders.index' ||
                    Route::currentRouteName()=='reminders.sources.index' ) @else style="display: none; overflow: hidden;" @endif
                    kt-hidden-height="251">
                    <div class="menu-item">
                        <a class="menu-link link-wb-active @if (Request::is('reminders/reservations')) active @endif"
                            href="{{ route('reminders.reservations.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">
                                {{ __('Reservations') }}
                            </span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link link-wb-active @if (Request::is('reminders/reminders')) active @endif"
                            href="{{ route('reminders.reminders.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">
                                {{ __('Reminders') }}
                            </span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link link-wb-active @if (Request::is('reminders/sources')) active @endif"
                            href="{{ route('reminders.sources.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">
                                {{ __('Sources') }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--end:Menu sub-->
    </div>
    {{-- @endif --}}
    {{-- Catalog --}}
    {{-- @if (!auth()->user()->hasrole(['staff'])) --}}
    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
        class="menu-item py-2 @if (Route::currentRouteName() == 'Catalog.productsCatalog' ||
                            Route::currentRouteName() == 'Catalog.categoryIndex' ||
                            Route::currentRouteName() == 'Catalog.setting' ||
                            Request::query('bot') == 'catalog' ||
                            Route::currentRouteName() == 'Catalog.orderINdex') show here @endif">
        <!--begin:Menu link-->
        <span class="menu-link menu-center">
            <span class="menu-icon-title">
                <span class="menu-icon me-0 mt-4" style="color: var(--theme-icon-color);">
                    <i class="ki-duotone ki-purchase fs-2 pt-1 mb-2"><span class="path1"></span><span
                            class="path2"></span><span class="path3"></span><span
                            class="path4"></span></i>
                </span>
                <span class="menu-icon-title mt-1">{{ __('Catalogue') }}</span>
            </span>
        </span>

        <!--end:Menu link-->
        <!--begin:Menu sub-->
        <div
            class="bg-dark menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto">
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu content-->
                <div class="menu-content "><span
                        class="menu-section text-white link-offset-2 fs-5 fw-bolder ps-1 py-1">{{ __('Catalogue') }}</span>
                </div>
                <!--end:Menu content-->
            </div>
            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'Catalog.orderINdex') active @endif"
                    href="{{ route('Catalog.orderINdex') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"
                            style="    color: var(--theme-icon-color);"></span>
                    </span>
                    <span class="menu-title">{{ __('Orders') }}</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'Catalog.productsCatalog') active @endif"
                    href="{{ route('Catalog.productsCatalog') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"
                            style="    color: var(--theme-icon-color);"></span>
                    </span>
                    <span class="menu-title">{{ __('Products') }}</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'Catalog.categoryIndex') active @endif"
                    href="{{ route('Catalog.categoryIndex') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"
                            style="    color: var(--theme-icon-color);"></span>
                    </span>
                    <span class="menu-title">{{ __('Category') }}</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Request::is('replies') && Request::query('bot') == 'catalog') active @endif"
                    href="{{ url('replies?bot=catalog') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"
                            style="    color: var(--theme-icon-color);"></span>
                    </span>
                    <span class="menu-title">{{ __('Bots') }}</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'Catalog.catalogsTemplatesIndex') active @endif"
                    href="{{ route('Catalog.catalogsTemplatesIndex') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"
                            style="    color: var(--theme-icon-color);"></span>
                    </span>
                    <span class="menu-title">{{ __('Templates') }}</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'Catalog.setting') active @endif"
                    href="{{ route('Catalog.setting') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"
                            style="    color: var(--theme-icon-color);"></span>
                    </span>
                    <span class="menu-title">{{ __('Settings') }}</span>
                </a>
            </div>
        </div>
        <!--end:Menu sub-->
    </div>
    {{-- @endif --}}

    {{-- File manager --}}


    {{-- @if (!auth()->user()->hasrole(['staff'])) --}}
    <a href="{{ route('file-manager.index') }}"
        class="menu-item  py-2 @if (Route::currentRouteName() == 'file-manager.index') here @endif" data-bs-toggle="tooltip"
        data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="{{ __('Drive') }}">
        <span class="menu-link menu-center">
            <span class="menu-icon-title">
                <span class="menu-icon me-0 mt-4" style="color: var(--theme-icon-color);">
                    <i class="ki-duotone ki-picture fs-2 pt-1 mb-2"><span class="path1"></span><span
                            class="path2"></span><span class="path3"></span><span
                            class="path4"></span></i>
                </span>
                <span class="menu-icon-title mt-1">{{ __('Drive') }}</span>
            </span>
        </span>
    </a>
    {{-- @endif --}}

    {{-- tools --}}
    {{-- @if (!auth()->user()->hasrole(['staff']))
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                    class="menu-item py-2 @if (Route::currentRouteName() == 'reminders.reservations.index' || Route::currentRouteName() == 'reminders.reminders.index' || Route::currentRouteName() == 'embedwhatsapp.edit' || Route::currentRouteName() == 'reminders.sources.index') show here @endif">
                    <!--begin:Menu link-->
                    <span class="menu-link menu-center">
                        <span class="menu-icon me-0" style="color: var(--theme-icon-color);">
                            <i class="ki-duotone ki-briefcase fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div
                        class="bg-dark menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu content-->
                            <div class="menu-content "><span
                                    class="menu-section text-white link-offset-2 fs-5 fw-bolder ps-1 py-1">{{ __('Tools') }}</span>
</div>
<!--end:Menu content-->
</div>



<div class="menu-item">
    <a class="menu-link link-wb-active @if (Route::currentRouteName() == 'embedwhatsapp.edit') active @endif"
        href="{{ route('embedwhatsapp.edit') }}">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"
                style="    color: var(--theme-icon-color);"></span>
        </span>
        <span class="menu-title">{{ __('Widget Generator') }}</span>
    </a>
</div>
</div>
<!--end:Menu sub-->
</div>
@endif --}}
{{-- <hr class="hr my-2 mx-2 text-light"> --}}

{{-- <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"   data-kt-menu-placement="right-end"
                class="menu-item py-2">
                <!--begin:Menu link-->
                <span class="menu-link menu-center">
                    <span class="menu-icon me-0">
                        <i class="ki-duotone ki-rescue fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="bg-dark menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto">
                <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu content-->
                        <div class="menu-content "><span class="menu-section link-light link-offset-2 fs-5 fw-bolder ps-1 py-1">{{ __('Help') }}</span>
</div>
<!--end:Menu content-->
</div>

<div class="menu-item">
    <a href="#" class="menu-link" data-bs-toggle="modal" data-bs-target="#kt_modal_offer_a_deal">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
        <span class="menu-title">Wizard</span>
    </a>
</div>
<div class="menu-item">
    <a class="menu-link" href="https://support.dotflo.io/es/" target="_blank">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
        <span class="menu-title">{{ __('Documentation') }}</span>
    </a>
</div>
<div class="menu-item">
    <a class="menu-link" href="https://support.dotflo.io/es/tickets-portal" target="_blank">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
        <span class="menu-title">{{ __('Open Ticket') }}</span>
    </a>
</div>
<div class="menu-item">
    <a class="menu-link" href="#" onclick="window.Intercom('show');">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
        <span class="menu-title">{{ __('Talk to agent') }}</span>
    </a>
</div>

</div>
<!--end:Menu sub-->
</div>
{{-- Apis --
            @if (!auth()->user()->hasrole(['staff']))
                <a href="{{ route('account.profile.api') }}" class="menu-item py-2 @if (Route::currentRouteName() == 'account.profile.api') here @endif" data-bs-toggle="tooltip"
data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="{{ __("Apis") }}">
<span class="menu-link menu-center">
    <span class="menu-icon me-0">
        <i class="ki-duotone ki-message-programming fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
        </i>
    </span>
</span>
</a>
@endif
{{-- apps --
            @if (!auth()->user()->hasrole(['staff']))
                <a href="{{ route('admin.apps.company') }}" class="menu-item py-2 @if (Route::currentRouteName() == 'admin.apps.company') here @endif" data-bs-toggle="tooltip"
data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="{{ __("Apps") }}">
<span class="menu-link menu-center">
    <span class="menu-icon me-0">
        <i class="ki-duotone ki-element-plus fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
            <span class="path5"></span>
        </i>
    </span>
</span>
</a>
@endif
{{-- Planes --
            @if (!auth()->user()->hasrole(['staff']))
                <a href="{{ route('available.plans') }}" class="menu-item py-2 @if (Route::currentRouteName() == 'available.plans') here @endif" data-bs-toggle="tooltip"
data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="{{ __("Plans") }}">
<span class="menu-link menu-center">
    <span class="menu-icon me-0">
        <i class="ki-duotone ki-credit-cart fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </span>
</span>
</a>
@endif --}}

<!--end:Menu item-->
</div>
<!--end::Menu-->
</div>



<div class="d-flex flex-column flex-center pb-4 pb-lg-8" id="kt_app_sidebar_footer">
    <div id="kt_aside_menu"
        class="menu menu-rounded menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6"
        data-kt-menu="true">

        {{-- Planes --}}
        @if (!auth()->user()->hasrole(['staff']))
        @if (env('ENABLE_PRICING_FOR_CUSTOMER') == true)
        <a href="{{ route('available.plans') }}"
            class="menu-item  py-2  @if (Route::currentRouteName() == 'available.plans') here @endif"
            data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right"
            title="{{ __('Plans') }}">
            <span class="menu-link menu-center">
                <span class="menu-icon me-0">
                    <i class="ki-duotone ki-credit-cart fs-2" style="    color: var(--theme-icon-color);">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span>
            </span>
        </a>
        @endif
        @endif
        {{-- apps --}}
        @if (!auth()->user()->hasrole(['staff']))
        <a href="{{ route('admin.apps.company') }}"
            class="menu-item  py-2  @if (Route::currentRouteName() == 'admin.apps.company') here @endif" data-bs-toggle="tooltip"
            data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="{{ __('Apps') }}">
            <span class="menu-link menu-center">
                <span class="menu-icon me-0">
                    <i class="ki-duotone ki-element-plus fs-2" style="    color: var(--theme-icon-color);">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                </span>
            </span>
        </a>
        @endif
        {{-- Apis --}}
        {{-- @if (!auth()->user()->hasrole(['staff']))
                <a href="{{ route('account.profile.api') }}"
        class="menu-item py-2 @if (Route::currentRouteName() == 'account.profile.api') here @endif" data-bs-toggle="tooltip"
        data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="{{ __('Apis') }}">
        <span class="menu-link menu-center">
            <span class="menu-icon me-0">
                <i class="ki-duotone ki-message-programming fs-2" style="    color: var(--theme-icon-color);">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
            </span>
        </span>
        </a>
        @endif --}}
        {{-- @if (!auth()->user()->hasrole(['staff']) &&
    auth()->user()->type == 3)
                <a href="{{ route('partner.dashboard') }}"
        class="menu-item py-2 @if (Route::currentRouteName() == 'partner.dashboard') here @endif" data-bs-toggle="tooltip"
        data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="{{ __('Partner Dashboard') }}">
        <span class="menu-link menu-center">
            <span class="menu-icon me-0">
                <i class="ki-duotone ki-send fs-2" style="    color: var(--theme-icon-color);">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
            </span>
        </span>
        </a>
        @endif --}}
        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-end"
            class="menu-item py-2">
            <!--begin:Menu link-->
            <span class="menu-link menu-center">
                <span class="menu-icon me-0">
                    <i class="ki-duotone ki-rescue fs-2" style="    color: var(--theme-icon-color);">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                </span>
            </span>
            <!--end:Menu link-->
            <!--begin:Menu sub-->
            <div
                class="bg-dark menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto">
                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu content-->
                    <div class="menu-content "><span
                            class="menu-section text-white link-offset-2 fs-5 fw-bolder ps-1 py-1">{{ __('Help') }}</span>
                    </div>
                    <!--end:Menu content-->
                </div>

                {{-- <div class="menu-item">
                        <a href="#" class="menu-link" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_offer_a_deal">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Wizard</span>
                        </a>
                    </div> --}}
                <div class="menu-item">
                    <a class="menu-link" href="https://support.anantkamalsoftwarelabs.com/" target="_blank">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">{{ __('Documentation') }}</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="https://support.anantkamalsoftwarelabs.com/" target="_blank">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">{{ __('Open Ticket') }}</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="https://support.anantkamalsoftwarelabs.com/" onclick="window.Intercom('show');">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">{{ __('Talk to agent') }}</span>
                    </a>
                </div>

            </div>
            <!--end:Menu sub-->
        </div>
    </div>
</div>
</div>
<!--end::Primary menu-->