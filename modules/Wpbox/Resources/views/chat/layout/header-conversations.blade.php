<div class="card-header">
    <!--begin::Card title-->
    <div class="card-title w-100">
        <!--begin::Search-->
        <div class="d-flex align-items-center position-relative my-1 w-100">
            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                </svg>
            </span>
            <input 
                type="text" 
                v-model="searchQuery" 
                class="form-control form-control-solid w-100 ps-15" 
                placeholder="Search chats..." 
            />
        </div>
        <!--end::Search-->
    </div>
    <!--end::Card title-->

    <!--begin::Card toolbar-->
    <div class="card-toolbar mt-5">
        <!--begin::Tabs-->
        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 w-100">
            <li class="nav-item">
                <a 
                    class="nav-link text-active-primary me-6 active" 
                    @click.prevent="allMessages"
                >
                    <span class="svg-icon svg-icon-4 me-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 19H4C3.4 19 3 18.6 3 18V6C3 5.4 3.4 5 4 5H20C20.6 5 21 5.4 21 6V18C21 18.6 20.6 19 20 19Z" fill="currentColor"></path>
                            <path opacity="0.3" d="M19 5H5C4.4 5 4 5.4 4 6V18C4 18.6 4.4 19 5 19H19C19.6 19 20 18.6 20 18V6C20 5.4 19.6 5 19 5ZM7 12C6.4 12 6 11.6 6 11C6 10.4 6.4 10 7 10C7.6 10 8 10.4 8 11C8 11.6 7.6 12 7 12ZM11 12C10.4 12 10 11.6 10 11C10 10.4 10.4 10 11 10C11.6 10 12 10.4 12 11C12 11.6 11.6 12 11 12ZM15 12C14.4 12 14 11.6 14 11C14 10.4 14.4 10 15 10C15.6 10 16 10.4 16 11C16 11.6 15.6 12 15 12ZM7 16C6.4 16 6 15.6 6 15C6 14.4 6.4 14 7 14C7.6 14 8 14.4 8 15C8 15.6 7.6 16 7 16ZM11 16C10.4 16 10 15.6 10 15C10 14.4 10.4 14 11 14C11.6 14 12 14.4 12 15C12 15.6 11.6 16 11 16ZM15 16C14.4 16 14 15.6 14 15C14 14.4 14.4 14 15 14C15.6 14 16 14.4 16 15C16 15.6 15.6 16 15 16Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    {{ __('All') }}
                    <span class="badge badge-light-primary ms-2">@{{ allCount }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a 
                    class="nav-link text-active-primary me-6" 
                    @click.prevent="mineMessages"
                >
                    <span class="svg-icon svg-icon-4 me-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="currentColor"></path>
                            <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    {{ __('Mine') }}
                    <span class="badge badge-light-primary ms-2">@{{ mineCount }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a 
                    class="nav-link text-active-primary" 
                    @click.prevent="newMessages"
                >
                    <span class="svg-icon svg-icon-4 me-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"></path>
                            <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    {{ __('New') }}
                    <span class="badge badge-light-primary ms-2">@{{ newCount }}</span>
                </a>
            </li>
        </ul>
        <!--end::Tabs-->
    </div>
    <!--end::Card toolbar-->
</div>