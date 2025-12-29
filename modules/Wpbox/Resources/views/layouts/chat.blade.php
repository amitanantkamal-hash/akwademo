<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<!--begin::Head-->
	<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @yield('title')
        <title>{{ config('app.name', 'Site') }}</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

        @include('layouts.rtl')

        <!-- Custom CSS defined by admin -->
        <link type="text/css" href="{{ asset('byadmin') }}/back.css" rel="stylesheet">

        <!-- Select2  -->
        <link type="text/css" href="{{ asset('vendor') }}/select2/select2.min.css" rel="stylesheet">

        <!-- Custom CSS defined by user -->
        <link type="text/css" href="{{ asset('custom') }}/css/custom.css?id={{ config('version.version')}}" rel="stylesheet">

        <!-- Flags -->
        <link type="text/css" href="{{ asset('vendor') }}/flag-icons/css/flag-icons.min.css" rel="stylesheet" />

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
		
        <!-- Icons -->
		<link href="{{ asset('vendor/argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link type="text/css" href="{{ asset('vendor/argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('vendor') }}/jasny/css/jasny-bootstrap.min.css">

		<link rel="shortcut icon" href="{{ asset('') }}/favicon-32x32.png" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('plugins') }}/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css') }}/style.bundle.css" rel="stylesheet" type="text/css" />

		{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDth2CDSIK7oXUvYaXHTrZfsAHt6pzV-oU&callback=initMap&libraries=&v=weekly" defer></script> --}}
		<!--end::Global Stylesheets Bundle-->
		{{-- <script>
			if (window.top != window.self) {
				window.top.location.replace(window.self.location.href);
			}
		</script> --}}
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-sidebar-minimize="on" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">
		<!--begin::Theme mode setup on page load-->
		<script>
			var defaultThemeMode = "light";
			var themeMode; 
			if ( document.documentElement ) { 
				if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { 
					themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); 
				} else { 
					if ( localStorage.getItem("data-bs-theme") !== null ) { 
						themeMode = localStorage.getItem("data-bs-theme"); 
					} else { 
						themeMode = defaultThemeMode; 
					} 
				} if (themeMode === "system") { 
					themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
				} 
				document.documentElement.setAttribute("data-bs-theme", themeMode); 
			}
		</script>
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endauth
		<style>
			.chat-list, .chat-room, .user-details {
				overflow-y: auto;
				height: 100%;
			}

			:root {
				--bs-primary: #36a937;
				--bs-primary-light: #ddf0dd;
			}

			div.modal-backdrop.fade.show {
				display: none !important;
			}

			.message-pane .message-time {
				visibility: hidden;
				font-size: 0;
			}

			.message-pane:hover .message-time {
				visibility: visible;
				font-size: 13px;
			}

			* {
				animation-name: ease;
				animation-duration: 1s;
			}
		</style>
		<!--end::Theme mode setup on page load-->
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				<!--begin::Header-->
				<div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
					<!--begin::Header main-->
					<div class="d-flex flex-stack flex-grow-1 position-relative">
						<div class="app-header-logo d-flex align-items-center ps-lg-12" id="kt_app_header_logo">
							<!--begin::Sidebar mobile toggle-->
							<div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none" id="kt_app_sidebar_mobile_toggle">
								<i class="ki-outline ki-abstract-14 fs-2"></i>
							</div>
							<!--end::Sidebar mobile toggle-->
							<!--begin::Logo-->
							<a href="/dashboard" class="app-sidebar-logo" style="margin-left: 8px;">
								<img alt="Logo" src="{{ asset('') }}" class="theme-light-show" style="height: 64px; transform: translate(-50%, -50%); top: 50%; left: 50; position: absolute;" />
								<img alt="Logo" src="{{ asset('') }}" class="theme-dark-show" style="height: 64px; transform: translate(-50%, -50%); top: 50%; left: 50; position: absolute;" />
							</a>
							<!--end::Logo-->
						</div>
					</div>
					<!--end::Header main-->
				</div>
				<!--end::Header-->
				@php $crn = Route::currentRouteName(); @endphp
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper" style="margin-right: 0; margin-top: 0; z-index: 100;">
					@include('wpbox::partials.sidebar')
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid ">
							<!--begin::Content-->
                            @yield('content')
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
					</div>
					<!--end:::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->
		{{-- <iframe
			title="Ticket Center"
			src=""
			referrerpolicy="origin"
			sandbox="allow-forms allow-popups allow-modals allow-scripts allow-same-origin"
			width="100%"
			height="600px"
			frameborder="0">
		</iframe> --}}
		<!--begin::Javascript-->
		<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "AIzaSyDth2CDSIK7oXUvYaXHTrZfsAHt6pzV-oU", v: "beta"});</script>
		<script>
			var hostUrl = "/";
            var t="<?php echo 'translations'.App::getLocale() ?>";
            window.translations = {!! Cache::get('translations'.App::getLocale(),"[]") !!};
		</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('plugins') }}/global/plugins.bundle.js"></script>
		<script src="{{ asset('js') }}/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
        <script src="{{ asset('vendor/argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <!-- Nouslider -->
        <script src="{{ asset('vendor/argon') }}/vendor/nouislider/distribute/nouislider.min.js" type="text/javascript"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="{{ asset('vendor') }}/jasny/js/jasny-bootstrap.min.js"></script>
        <!-- All in one -->
        <script src="{{ asset('custom') }}/js/js.js?id={{ config('version.version')}}"></script>
        <!-- Notify JS -->
        <script src="{{ asset('custom') }}/js/notify.min.js"></script>
        <script>
            var ONESIGNAL_APP_ID = "{{ config('settings.onesignal_app_id') }}";
            var USER_ID = '{{  auth()->user()&&auth()->user()?auth()->user()->id:"" }}';
            var PUSHER_APP_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
            
            var PUSHER_APP_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
            
            @if (auth()->user()!=null&&auth()->user()->hasRole('staff'))
                USER_ID = '{{ auth()->user()->company->user_id }}';
            @endif
        </script>
        <!-- OneSignal -->
        @if(strlen( config('settings.onesignal_app_id'))>4)
            <script src="{{ asset('vendor') }}/OneSignalSDK/OneSignalSDK.js" async=""></script>
            <script src="{{ asset('custom') }}/js/onesignal.js"></script>
        @endif
        @stack('js')
        <!-- Pusher -->
        @if(strlen(config('broadcasting.connections.pusher.app_id'))>2)
            <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
            @if (config('settings.app_code_name','')=="qrpdf")
                <script src="{{ asset('custom') }}/js/pusher.js"></script>    
            @endif
        @endif
        <!-- Import Select2 --->
        <script src="{{ asset('vendor') }}/select2/select2.min.js"></script>
        <!-- Custom JS defined by admin -->
        <script src="{{ asset('byadmin') }}/back.js"></script>
        <!-- Import Moment -->
        <script type="text/javascript" src="{{ asset('vendor') }}/moment/moment.min.js"></script>
        <script type="text/javascript" src="{{ asset('vendor') }}/moment/momenttz.min.js"></script>
        {{-- <script src="{{ asset('vendor/argon') }}/js/bootstrap.min.js" type="text/javascript"></script> --}}
        <script src="{{ asset('vendor') }}/vue/bootstrap-vue.min.js"></script> 
        <!-- Import AXIOS --->
        <script src="{{ asset('vendor') }}/axios/axios.min.js"></script>
        @yield('js')
	</body>
</html>