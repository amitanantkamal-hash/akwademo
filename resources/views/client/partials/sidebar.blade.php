<aside class="app-sidebar">
    <div class="sidebar-icons">
        <div class="logo">
            <a href="/dashboard">
                {{-- Required for anantkamalwademo --}}
                @php
                    $app_logo = asset('backend/Assets/img/logo.png');
                    //  $app_logo = asset('backend/Assets/img/logo.png');

                    $partner_id = auth()->user()->created_by;
                    if ($partner_id != 1) {
                        $partner_data = \App\Models\Partner::where('user_id', $partner_id)->first();

                        if ($partner_data) {
                            if ($partner_data->is_active == 1) {
                                $app_logo = asset($partner_data->logo);
                            }
                        }
                    }
                @endphp
                <img alt="Logo" src="{{ $app_logo }}"/>
            </a>
        </div>
        <div class="sidebar-icons-top">       
            <a href="{{ route('dashboard') }}" class="icon-link @if (Route::currentRouteName() == 'dashboard') active @endif">
                <span class="icon">
                    <img src="{{ asset('icons/dashboard.png') }}">
                </span>
            </a>

            <a href="{{ route('agent.index') }}"
            class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-light menu-link w-35px h-35px w-md-40px h-md-40px @if (Route::currentRouteName() == 'agent.index' ||
                    Route::currentRouteName() == 'agent.create' ||
                    Route::currentRouteName() == 'agent.edit') active @endif icon-link">
                <span class="icon">
                    <img src="{{ asset('icons/people.png') }}">
                </span>
            </a>

            <a href="{{ route('embedwhatsapp.edit') }}" class="icon-link @if (Route::currentRouteName() == 'embedwhatsapp.edit') active @endif">
                <span class="icon">
                    <img src="{{ asset('icons/element.png') }}">
                </span>
            </a>

            <a href="{{ route('campaigns.create') }}" class="icon-link @if (Route::currentRouteName() == 'campaigns.create') active @endif">
                <span class="icon">
                    <img src="{{ asset('icons/broadcast.png') }}">
                </span>
            </a>

            <a href="#" id="createContact" class="icon-link @if (Route::currentRouteName() == 'contacts.index' || Route::currentRouteName() == 'contacts.fields.index' ||Route::currentRouteName() == 'contacts.groups.index') active @endif">
                <span class="icon">
                    <img src="{{ asset('icons/agent.png') }}">
                </span>
            </a>

            @if (!auth()->user()->hasrole(['staff']))
                @if (env('ENABLE_PRICING_FOR_CUSTOMER') == true)
                    <a href="{{ route('available.plans') }}" class="icon-link @if (Route::currentRouteName() == 'available.plans') active @endif">
                        <span class="icon">
                            <img src="{{ asset('icons/wallet.png') }}">
                        </span>
                    </a>
                @endif  
            @endif

            @if (!auth()->user()->hasrole(['staff']))
                <a href="{{ route('admin.apps.company') }}" class="icon-link @if (Route::currentRouteName() == 'admin.apps.company') active @endif">
                    <span class="icon">
                        <img src="{{ asset('icons/app.png') }}">
                    </span>
                </a>
            @endif

            
            <a href="{{ route('chat.index') }}" class="icon-link @if (Route::currentRouteName() == 'dashboard') active @endif">
                <span class="icon">
                    <img src="{{ asset('icons/faq.png') }}">
                </span>
            </a>
        </div>
        <!-- BOTTOM ICONS -->
        <div class="sidebar-icons-bottom">
            <a  id="switchAccountModal" tabindex="-1" aria-hidden="true" href="javascript:void(0);" class="icon-link" data-bs-toggle="modal" data-bs-target="#createOrgModal">
                <span class="icon">
                    <img src="{{ asset('icons/user.png') }}">
                </span>
            </a> 
            
            <a href="#" class="icon-link">
                <span class="icon">
                    <img src="{{ asset('icons/setting-2.png') }}">
                </span>
            </a>

            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="icon-link">
                <span class="icon">
                    <img src="{{ asset('icons/logout.png') }}">
                </span>
            </a>
        </div>
    </div>

    {{-- MENU PANEL --}}
    <div class="sidebar-menu">

        <div class="search-box">
            <i class="ri-search-line"></i>
            <input type="text" placeholder="Search">
        </div>

        <ul class="sidebar">
            <!-- Dashboard -->
            <li class="menu-item @if (Route::currentRouteName() == 'dashboard') active @endif">
                <a href="{{ route('dashboard') }}">
                    <i class="ri-dashboard-line"></i>
                    <span>Dashboard</span>
                </a> 
            </li>
            <!-- Dashboard End -->

             <!-- Chat -->
            <li class="menu-item @if (Route::currentRouteName() == 'chat.index') active @endif">
                <a href="{{ route('chat.index') }}">
                    <i class="ri-message-2-line"></i>
                    <span>Chat</span>
                </a> 
            </li>
            <!-- Chat End -->

            <!-- Campaigns -->
            <li data-menu="campaigns" class="has-submenu @if (Route::currentRouteName() == 'campaigns.index' ||
                            Route::currentRouteName() == 'campaigns.create' ||
                            Route::currentRouteName() == 'campaigns.show' ||
                            (Route::currentRouteName() == 'wpbox.api.index' && Request::query('type') == 'api')) active @endif">
                <i class="ri-send-plane-line"></i>
                <span>Campaigns</span>
                <i class="ri-add-line plus"></i>
            </li>
            
            <li class="submenu link-wb-active @if (Route::currentRouteName() == 'campaigns.index' && !Request::is('campaigns/create')) active @endif" data-submenu="campaigns">
                <a href="{{ route('campaigns.index') }}">
                    Show Campaigns
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'campaigns.create') active @endif" data-submenu="campaigns">
                <a href="{{ route('campaigns.create') }}">
                    Create Campaign
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'wpbox.api.index' && Request::query('type') == 'api') active @endif" data-submenu="campaigns">
                <a href="{{ route('wpbox.api.index', ['type' => 'api']) }}">
                    API Campaign
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'wpbox.api.index' && Request::query('type') == 'api') active @endif" data-submenu="campaigns">
                <a href="{{ route('wpbox.api.index', ['type' => 'api']) }}">
                    Schedule Campaign
                </a>
            </li>
            <!-- Campaigns End -->

            <!-- Contacts -->
            <li data-menu="contacts" class="has-submenu">
                <i class="ri-contacts-line"></i>
                <span>Contacts</span>
                <i class="ri-add-line plus" ></i>
            </li>

            <li class="submenu @if (Route::currentRouteName() == 'contacts.index') active @endif" data-submenu="contacts">
                <a href="{{ route('contacts.index') }}">
                    Contact Management
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'contacts.index') active @endif" data-submenu="contacts">
                <a href="{{ route('contacts.index') }}">
                    Fields
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'contacts.index') active @endif" data-submenu="contacts">
                <a href="{{ route('contacts.index') }}">
                    Groups
                </a>
            </li>

            <li class="submenu @if (Route::currentRouteName() == 'contacts.newimport.index') active @endif" data-submenu="contacts">
                <a href="{{ route('contacts.newimport.index') }}">
                    Import
                </a>
            </li>
            
            <!-- Contacts End -->

            <!-- Templates -->
            <li class="menu-item @if (Route::currentRouteName() == 'templates.index') active @endif">
                <a href="{{ route('templates.index') }}">
                    <i class="ri-file-list-line"></i>
                    <span>Templates</span>
                </a> 
            </li>
            <!-- Templates End -->

            <!-- Chatbot -->
            <li data-menu="chatbot" class="has-submenu @if (Route::currentRouteName() == 'flows.index' ||
                            Route::currentRouteName() == 'replies.create' ||
                            Route::currentRouteName() == 'flowmaker.edit' ||
                            Route::currentRouteName() == 'button_template.index' ||
                            Route::currentRouteName() == 'button_template.create' ||
                            Route::currentRouteName() == 'list_button_template.index' ||
                            Route::currentRouteName() == 'list_button_template.create' ||
                            (Request::is('replies') && Request::query('type') == 'qr')) active @endif">
                <i class="ri-robot-line"></i>
                <span>Chatbot</span>
                <i class="ri-add-line plus"></i>
            </li>

            <li class="submenu link-wb-active @if (Request::is('replies') && Request::query('type') == 'bot') active @endif" data-submenu="chatbot">
                <a href="{{ url('replies?type=bot') }}">
                    Chatbot
                </a>
            </li>
            <li class="submenu link-wb-active @if (Request::is('replies') && Request::query('type') == 'qr') active @endif" data-submenu="chatbot">
                <a href="{{ url('replies?type=qr')  }}">
                    Quick Replies
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'button_template.index' || Route::currentRouteName() == 'button_template.create') active @endif" data-submenu="chatbot">
                <a href="{{ route('button_template.index') }}">
                    Interactive - Button
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'list_button_template.index' || Route::currentRouteName() == 'list_button_template.create') active @endif" data-submenu="chatbot">
                <a href="{{ route('list_button_template.index') }}">
                    Interactive - List
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'flows.index' || Route::currentRouteName() == 'flowmaker.edit') active @endif" data-submenu="chatbot">
                <a href="{{ route('flows.index') }}">
                    Flow Bot
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'bot-flow-list' || Route::currentRouteName() == 'bot-flows.edit') active @endif" data-submenu="chatbot">
                <a href="{{ route('bot-flow-list') }}">
                    Bot Flow
                </a>
            </li>
            <!-- Chatbot End -->

            <!-- Automation -->
            <li data-menu="automation" class="has-submenu @if (Route::currentRouteName() == 'flowisebots.index' ||
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
                            Route::currentRouteName() == 'whatsapp-flows.create') active @endif">
                <i class="ri-settings-3-line"></i>
                <span>Automation</span>
                <i class="ri-add-line plus"></i>
            </li>

            <li class="submenu @if (Route::currentRouteName() == 'ctwameta.index') active @endif" data-submenu="automation">
                <a href="{{ route('ctwameta.index') }}">
                    Meta Ads
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'whatsapp-flows.index') active @endif" data-submenu="automation">
                <a href="{{ route('whatsapp-flows.index') }}">
                    WhatsApp Flows
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'leads.index') active @endif" data-submenu="automation">
                <a href="{{ route('leads.index') }}">
                    Lead Manager
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'workflows.index') active @endif" data-submenu="automation">
                <a href="{{ route('workflows.index') }}">
                    Workflow
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'autoretarget.index') active @endif" data-submenu="automation">
                <a href="{{ route('autoretarget.index') }}">
                    AutoRetarget
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'journies.index') active @endif" data-submenu="automation">
                <a href="{{ route('journies.index') }}">
                    Journies
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'wpbox.api.index' && Request::query('type') == 'api') active @endif" data-submenu="automation">Reminders</li>
            <!-- Automation End -->

            <!-- Catalogue -->
            <li class="has-submenu @if (Route::currentRouteName() == 'Catalog.productsCatalog' ||
                            Route::currentRouteName() == 'Catalog.categoryIndex' ||
                            Route::currentRouteName() == 'Catalog.setting' ||
                            Request::query('bot') == 'catalog' ||
                            Route::currentRouteName() == 'Catalog.orderINdex') active @endif" data-menu="catalogue">
                <i class="ri-briefcase-line"></i>
                <span>Catalogue</span>
                <i class="ri-add-line plus"></i>
            </li>

            <li class="submenu @if (Route::currentRouteName() == 'Catalog.orderINdex') active @endif" data-submenu="catalogue">
                <a href="{{ route('Catalog.orderINdex') }}">
                    Orders
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'Catalog.productsCatalog') active @endif" data-submenu="catalogue">
                <a href="{{ route('Catalog.productsCatalog') }}">
                    Products
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'Catalog.categoryIndex') active @endif" data-submenu="catalogue">
                <a href="{{ route('Catalog.categoryIndex') }}">
                    Category
                </a>
            </li>
            <li class="submenu link-wb-active @if (Request::is('replies') && Request::query('bot') == 'catalog') active @endif" data-submenu="catalogue">
                <a href="{{ url('replies?bot=catalog') }}">
                    Bots
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'Catalog.catalogsTemplatesIndex') active @endif" data-submenu="catalogue">
                <a href="{{ route('Catalog.catalogsTemplatesIndex') }}">
                    Templates
                </a>
            </li>
            <li class="submenu @if (Route::currentRouteName() == 'Catalog.setting') active @endif" data-submenu="catalogue">
                <a href="{{ route('Catalog.setting') }}">
                    Settings
                </a>
            </li>
            <!-- Catalogue End -->

            <!-- Drive -->
            <li class="menu-item @if (Route::currentRouteName() == 'file-manager.index') active @endif">
                <a href="{{ route('file-manager.index') }}">
                    <i class="ri-folder-line"></i>
                    <span>Drive</span>
                </a>
            </li>
            <!-- Drive End -->
        </ul>
                    
    </div>
</aside>
<script>
document.addEventListener('DOMContentLoaded', () => {

    /* 🔥 RESET EVERYTHING ON PAGE LOAD */
    document.querySelectorAll('.has-submenu').forEach(menu => {
        menu.classList.remove('open');
    });

    document.querySelectorAll('.submenu').forEach(sub => {
        sub.style.display = 'none';
    });

    /* EXISTING TOGGLE LOGIC */
    document.querySelectorAll('.has-submenu').forEach(menu => {

        const key = menu.dataset.menu;
        const plus = menu.querySelector('.plus');

        if (!plus) return;

        plus.addEventListener('click', e => {
            e.preventDefault();
            e.stopPropagation();

            const isOpen = menu.classList.contains('open');

            // close all menus
            document.querySelectorAll('.has-submenu').forEach(m => {
                m.classList.remove('open');
            });
            document.querySelectorAll('.submenu').forEach(s => {
                s.style.display = 'none';
            });

            // open current only if it was closed
            if (!isOpen) {
                menu.classList.add('open');
                document.querySelectorAll(
                    `.submenu[data-submenu="${key}"]`
                ).forEach(s => {
                    s.style.display = 'flex';
                });
            }
        });
    });

});
</script>