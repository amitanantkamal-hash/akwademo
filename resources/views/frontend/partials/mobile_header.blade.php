<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-content-area">
            <div class="mobile-logo"><a class="d-flex" href="{{route('landing')}}"><img alt="{{config('app.name')}}" src="{{ config('settings.logo') }}"></a></div>
            <div class="burger-icon"><span class="burger-icon-top"></span><span class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
            <div class="perfect-scroll">
                <div class="mobile-menu-wrap mobile-header-border">
                    <ul class="nav nav-tabs nav-tabs-mobile mt-25" role="tablist">
                        <li>
                            <a class="active" href="#tab-menu" data-bs-toggle="tab" role="tab" aria-controls="tab-menu" aria-selected="true">
                                <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                Menu
                            </a>
                        </li>
                        @auth
                        <li>
                            <a href="#tab-account" data-bs-toggle="tab" role="tab" aria-controls="tab-account" aria-selected="false">
                                <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Account
                            </a>
                        </li>
                        @endauth
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-menu" role="tabpanel" aria-labelledby="tab-menu">
                            <nav class="mt-15">
                                <ul class="mobile-menu font-heading">
                                    <li class=""><a class="active" href="{{route('landing')}}">Home</a></li>
                                    <li class=""><a href="{{route('front.pricing')}}">Pricing</a></li>
                                    
                                     <li class=""><a href="{{route('front.products')}}">Products</a></li>
                                    <li class="has-children"><a href="#">Resources</a>
                                        <ul class="sub-menu">
                                            <li><a href="https://support.anantkamalsoftwarelabs.com/user/login" target="_blank">Help Center</a></li>
                                    <li><a href="https://support.anantkamalsoftwarelabs.com/" target="_blank">FAQs</a></li>
                                    <li><a href="https://support.anantkamalsoftwarelabs.com/knowledge" target="_blank">Knowledge Base</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{route('front.contact')}}">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account">
                            @guest
                                <li><a class="active" href="{{route('register')}}">Start {{config('settings.free_trail_days')}}-Days Free Trial</a></li>
                                <li><a class="" href="{{ route('login') }}">{{__('Login')}}</a></li>
                            @endguest
                            
                            @auth
                            <nav class="mt-15">
                                <ul class="mobile-menu font-heading">
                                    <li><a class="active" href="{{ route('home') }}">{{__('Dashboard')}}</a></li>
                                    <li><a class="" href="{{ route('profile.show') }}">{{ __('My profile') }}</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Sign Out') }}</a>
                                    </li>
                                </ul>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </nav>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="site-copyright color-grey-400 mt-0">
                    <div class="box-download-app">
                        <p class="font-xs color-grey-400 mb-25">Download our Apps and get extra 15% Discount on your first Order…!</p>
                        <div class="mb-25"><a class="mr-10" href="#"><img src="assets/imgs/template/appstore.png" alt="iori"></a><a href="#"><img src="assets/imgs/template/google-play.png" alt="iori"></a></div>
                        <p class="font-sm color-grey-400 mt-20 mb-10">Secured Payment Gateways</p><img src="assets/imgs/template/payment-method.png" alt="iori">
                    </div>
                    <div class="mb-0">Copyright 2024     - {{ now()->year }} &copy; <br>Designed by<a href="https://anantkamalsoftwarelabs.com" target="_blank">&nbsp;Anantkamal Software Labs</a></div>
                </div>
            </div>
        </div>
    </div>
</div>