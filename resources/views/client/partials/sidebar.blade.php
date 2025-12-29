<aside class="sidebar-wrapper">
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
                        
        <a href="{{ route('dashboard') }}" class="icon-link active">
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

        <a href="{{ route('chat.index') }}" class="icon-link">
            <span class="icon">
                <img src="{{ asset('icons/element.png') }}">
            </span>
        </a>

        <a href="{{ route('chat.index') }}" class="icon-link">
            <span class="icon">
                <img src="{{ asset('icons/broadcast.png') }}">
            </span>
        </a>

        <a href="{{ route('dashboard') }}" class="icon-link">
            <span class="icon">
                <img src="{{ asset('icons/agent.png') }}">
            </span>
        </a>

        <a href="{{ route('chat.index') }}" class="icon-link">
            <span class="icon">
                <img src="{{ asset('icons/wallet.png') }}">
            </span>
        </a>

        <a href="{{ route('chat.index') }}" class="icon-link">
            <span class="icon">
                <img src="{{ asset('icons/app.png') }}">
            </span>
        </a>

        <a href="{{ route('chat.index') }}" class="icon-link">
            <span class="icon">
                <img src="{{ asset('icons/faq.png') }}">
            </span>
        </a>
    </div>

    {{-- MENU PANEL --}}
    <div class="sidebar-menu">

        <div class="search-box">
            <i class="ri-search-line"></i>
            <input type="text" placeholder="Search">
        </div>

        <ul class="sidebar">
            <!-- Dashboard -->
            <li class="active">
                <i class="ri-dashboard-line"></i>
                <span>Dashboard</span>
            </li>
            <!-- Dashboard End -->

             <!-- Chat -->
            <li>
                <i class="ri-message-2-line"></i>
                <span>Chat</span>
            </li>
            <!-- Chat End -->

            <!-- Campaigns -->
            <li data-menu="campaigns" class="has-submenu">
                <i class="ri-send-plane-line"></i>
                <span>Campaigns</span>
                <i class="ri-add-line plus"></i>
            </li>
            
            <li class="submenu" data-submenu="campaigns">Show Campaigns</li>
            <li class="submenu" data-submenu="campaigns">Create Campaign</li>
            <li class="submenu" data-submenu="campaigns">API Campaign</li>
            <!-- Campaigns End -->

            <!-- Contacts -->
            <li data-menu="contacts" class="has-submenu">
                <i class="ri-contacts-line"></i>
                <span>Contacts</span>
                <i class="ri-add-line plus" ></i>
            </li>

            <li class="submenu" data-submenu="contacts">Contact Management</li>
            <li class="submenu" data-submenu="contacts">Fields</li>
            <li class="submenu" data-submenu="contacts">Groups</li>
            <li class="submenu" data-submenu="contacts">Import</li>
            <!-- Contacts End -->

            <!-- Templates -->
            <li>
                <i class="ri-file-list-line"></i>
                <span>Template</span>
            </li>
            <!-- Templates End -->

            <!-- Chatbot -->
            <li data-menu="chatbot" class="has-submenu">
                <i class="ri-robot-line"></i>
                <span>Chatbot</span>
                <i class="ri-add-line plus"></i>
            </li>

            <li class="submenu" data-submenu="chatbot">Chatbot</li>
            <li class="submenu" data-submenu="chatbot">Quick Replies</li>
            <li class="submenu" data-submenu="chatbot">Interactive - Button</li>
            <li class="submenu" data-submenu="chatbot">Interactive - List</li>
            <li class="submenu" data-submenu="chatbot">Flow Bot</li>
            <li class="submenu" data-submenu="chatbot">Bot Flow</li>
            <!-- Chatbot End -->

            <!-- Automation -->
            <li data-menu="automation" class="has-submenu">
                <i class="ri-settings-3-line"></i>
                <span>Automation</span>
                <i class="ri-add-line plus"></i>
            </li>

            <li class="submenu" data-submenu="automation">Meta Ads</li>
            <li class="submenu" data-submenu="automation">WhatsApp Flows</li>
            <li class="submenu" data-submenu="automation">Lead Manager</li>
            <li class="submenu" data-submenu="automation">Workflow</li>
            <li class="submenu" data-submenu="automation">AutoRetarget</li>
            <li class="submenu" data-submenu="automation">Journies</li>
            <li class="submenu" data-submenu="automation">Reminders</li>
            <!-- Automation End -->

            <!-- Catalogue -->
            <li class="has-submenu" data-menu="catalogue">
                <i class="ri-briefcase-line"></i>
                <span>Catalogue</span>
                <i class="ri-add-line plus"></i>
            </li>

            <li class="submenu" data-submenu="catalogue">Orders</li>
            <li class="submenu" data-submenu="catalogue">Products</li>
            <li class="submenu" data-submenu="catalogue">Category</li>
            <li class="submenu" data-submenu="catalogue">Bots</li>
            <li class="submenu" data-submenu="catalogue">Templates</li>
            <li class="submenu" data-submenu="catalogue">Settings</li>

            <!-- Catalogue End -->

            <!-- Drive -->
            <li>
                <i class="ri-folder-line"></i>
                <span>Drive</span>
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