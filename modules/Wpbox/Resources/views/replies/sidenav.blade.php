{{-- Brij Mohan Negi Update --}}
<div class="sub-sidebar bg-white d-flex flex-column flex-row-auto">
    <div class="d-flex mb-10 p-20">
        <div class="d-flex align-items-center w-lg-400px">
            <form class="w-100 position-relative ">
                <div class="input-group sp-input-group">
                    <span class="input-group-text bg-light border-0 fs-20 bg-gray-100 text-gray-800"
                        id="sub-menu-search"><i class="fad fa-search"></i></span>
                    <input type="text" class="form-control form-control-solid ps-15 bg-light border-0 search-input"
                        data-search="search-item" name="search" value="" placeholder="{{ __('Search') }}"
                        autocomplete="off">
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex mb-10 p-l-20 p-r-20 m-b-12">
        <h3 class="text-gray-800 fw-bold">{{ __('Chatbot & Features') }}</h3>
    </div>

    <div
        class="sp-menu n-scroll sp-menu-two menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 p-l-20 p-r-20 m-b-12 fw-5 users-list">
        <div class="menu-item">
            <div class="menu-content pb-2 p-b-10">
                <span class="menu-section text-muted text-uppercase fs-12 ls-1">
                    {{ __('Features') }} </span>
            </div>
        </div>
        <div class="search-item">
            <a href="{{ route('replies.index') }}"
                class="sp-menu-item d-flex align-items-center px-2 py-2 rounded bg-hover-light-primary mb-1 users-list @if (Route::is('replies.index')) @if (!isset($_GET['type'])) bg-light-primary @endif @endif @if (isset($_GET['type'])) @if ($_GET['type'] == 'bot') bg-light-primary @endif @endif"
                data-remove-other-active="true" data-active="bg-light-primary" data-result="html"
                data-content="main-wrapper" data-history="">
                <div class="d-flex mb-10 me-auto w-100 align-items-center">
                    <div class="d-flex align-items-center mb-10 ">
                        <div class="symbol symbol-40px p-r-10">
                            <span class="symbol-label border bg-white">
                                <i class="fad fa-user-robot fs-18 text-primary"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1">
                        <h5 class="custom-list-title fw-bold text-gray-800 mb-0 fs-14">{{ __('Chatbot') }}</h5>
                        <span class="text-gray-700 fs-10">{{ __('List all your chatbot rules') }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="search-item">
            <a href="{{ route('replies.quick') }}"
                class="sp-menu-item d-flex align-items-center px-2 py-2 rounded bg-hover-light-primary mb-1 group-role  @if (isset($_GET['type'])) @if ($_GET['type'] == 'qr') bg-light-primary @endif @endif"
                data-remove-other-active="true" data-active="bg-light-primary" data-result="html"
                data-content="main-wrapper" data-history="#">
                <div class="d-flex mb-10 me-auto w-100 align-items-center">
                    <div class="d-flex align-items-center mb-10 ">
                        <div class="symbol symbol-40px p-r-10">
                            <span class="symbol-label border bg-white">
                                <i class="fad fa-reply-all fs-18 text-danger"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1">
                        <h5 class="custom-list-title fw-bold text-gray-800 mb-0 fs-14">{{ __('Quick replies') }}</h5>
                        <span class="text-gray-700 fs-10">{{ __('Manage quick replies for livechat') }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="menu-item">
            <div class="menu-content pb-2 p-b-10">
                <span class="menu-section text-muted text-uppercase fs-12 ls-1">
                    {{ __('Interactive Groups') }} </span>
            </div>
        </div>
        <div class="search-item">
            <a href="{{ route('button_template.index') }}"
                class="sp-menu-item d-flex align-items-center px-2 py-2 rounded bg-hover-light-primary mb-1 @if (Route::is('button_template.index')) bg-light-primary @endif"
                data-remove-other-active="true" data-active="bg-light-primary" data-result="html"
                data-content="main-wrapper" data-history="#">
                <div class="d-flex mb-10 me-auto w-100 align-items-center">
                    <div class="d-flex align-items-center mb-10 ">
                        <div class="symbol symbol-40px p-r-10">
                            <span class="symbol-label border bg-white">
                                <i class="fad fa-pager align-self-center fs-18 text-success"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1">
                        <h5 class="custom-list-title fw-bold text-gray-800 mb-0 fs-14">{{ __('Interactive - Button') }}
                        </h5>
                        <span class="text-gray-700 fs-10">{{ __('Interactive quick reply button') }}</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="search-item">
            <a href="{{ route('list_button_template.index') }}"
                class="sp-menu-item d-flex align-items-center px-2 py-2 rounded bg-hover-light-primary mb-1 @if (Route::is('list_button_template.index')) bg-light-primary @endif"
                data-remove-other-active="true" data-active="bg-light-primary" data-result="html"
                data-content="main-wrapper" data-history="#">
                <div class="d-flex mb-10 me-auto w-100 align-items-center">
                    <div class="d-flex align-items-center mb-10 ">
                        <div class="symbol symbol-40px p-r-10">
                            <span class="symbol-label border bg-white">
                                <i class="fa fa-list-alt align-self-center fs-18 text-success"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1">
                        <h5 class="custom-list-title fw-bold text-gray-800 mb-0 fs-14">{{ __('Interactive - List') }}
                        </h5>
                        <span class="text-gray-700 fs-10">{{ __('Interactive list messages button') }}</span>
                    </div>
                </div>
            </a>
        </div>


        {{-- <div class="menu-item">
            <div class="menu-content pb-2 p-b-10">
                <span class="menu-section text-muted text-uppercase fs-12 ls-1">
                    {{ __('Agents') }} </span>
            </div>
        </div>
        <div class="search-item">
            <a href="{{ route('agent.index') }}"
                class="sp-menu-item d-flex align-items-center px-2 py-2 rounded bg-hover-light-primary mb-1 @if (Route::is('agent.index')) bg-light-primary @endif"
                data-remove-other-active="true" data-active="bg-light-primary" data-result="html"
                data-content="main-wrapper" data-history="#">
                <div class="d-flex mb-10 me-auto w-100 align-items-center">
                    <div class="d-flex align-items-center mb-10 ">
                        <div class="symbol symbol-40px p-r-10">
                            <span class="symbol-label border bg-white">
                                <i class="fad fa-users align-self-center fs-18 text-success"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1">
                        <h5 class="custom-list-title fw-bold text-gray-800 mb-0 fs-14">{{ __('Manage') }}
                        </h5>
                        <span class="text-gray-700 fs-10">{{ __('Live chat agents') }}</span>
                    </div>
                </div>
            </a>
        </div> --}}

    </div>
</div>
