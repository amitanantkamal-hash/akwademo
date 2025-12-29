<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Site') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!-- Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    @yield('head')
    @include('layouts.rtl')

    <link href="{{ asset('Metronic8.2/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('Metronic8.2/assets/plugins/global/plugins.bundle.js') }}"></script>

    <link href="{{ asset('Metronic8.2') }}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('Metronic8.2') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('Metronic8.2') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('Metronic8.2') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

    {{-- <link href="{{ asset('vendor/argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('vendor') }}/jasny/css/jasny-bootstrap.min.css"> --}}
    <link rel="canonical" href="https://preview.keenthemes.com/html/metronic/docs/forms/dropzonejs" />
    {{-- <link href="{{ asset('vendor/argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet"> --}}
    <!--  <link type="text/css" href="{{ asset('vendor/argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">-->
    {{-- <link rel="stylesheet" href="{{ asset('vendor') }}/jasny/css/jasny-bootstrap.min.css"> --}}
    <!-- Custom CSS defined by admin -->
    <link type="text/css" href="{{ asset('byadmin') }}/back.css" rel="stylesheet">
    <!-- Select2  -->
    <link type="text/css" href="{{ asset('vendor') }}/select2/select2.min.css" rel="stylesheet">
    <!-- Custom CSS defined by user -->
    <link type="text/css" href="{{ asset('custom/css/custom_ceftx.css') }}" rel="stylesheet">
    <!-- Flags -->
    <link type="text/css" href="{{ asset('vendor/flag-icons/css/flag-icons.min.css') }}" rel="stylesheet" />
    <!-- Bootstap VUE -->
    <link type="text/css" href="{{ asset('vendor/vue/bootstrap-vue.css') }}" rel="stylesheet" />
    <!-- Import Moment -->
    <script type="text/javascript" src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/moment/momenttz.min.js') }}"></script>

    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    @stack('topcss')
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-sidebar-minimize="on" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">


    <!--layout-partial:partials/theme-mode/_init.html-->
    <!--layout-partial:layout/partials/_page-loader.html-->
    <!--layout-partial:layout/_default.html-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page  flex-column flex-column-fluid" id="kt_app_page">
            @include('client.layout.header')
            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">
                @auth()
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
                @include('client.layout.sidebar')
                <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--layout-partial:layout/partials/_toolbar.html-->
                        @include('client.layout.partials_content.content')
                    </div>
                    @include('client.layout.partials_footer.footer')
                </div>
            </div>
            @stack('modals')
        </div>
    </div>

    <!--layout-partial:partials/_scrolltop.html-->
    <!--layout-partial:partials/modals/_upgrade-plan.html-->
    <!--layout-partial:partials/modals/create-app/_main.html-->
    <!--layout-partial:partials/modals/_new-target.html-->
    <!--layout-partial:partials/modals/_view-users.html-->
    <!--layout-partial:partials/modals/users-search/_main.html-->
    <!--layout-partial:partials/modals/_invite-friends.html-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->

    @guest()
    @endguest
    @yield('topjs')

    <script>
        var t = "<?php echo 'translations' . App::getLocale(); ?>";
        window.translations = {!! Cache::get('translations' . App::getLocale(), '[]') !!};
    </script>
    <!-- Navtabs -->
    <script src="{{ asset('vendor') }}/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="{{ asset('vendor/argon') }}/js/popper.min.js" type="text/javascript"></script>
    <script src="{{ asset('vendor/argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- Nouslider -->
    <script src="{{ asset('vendor/argon') }}/vendor/nouislider/distribute/nouislider.min.js" type="text/javascript">
    </script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset('vendor') }}/jasny/js/jasny-bootstrap.min.js"></script>
    <!-- All in one -->
    <script src="{{ asset('custom') }}/js/js.js?id={{ config('version.version') }}"></script>
    <!-- Notify JS -->
    <script src="{{ asset('custom') }}/js/notify.min.js"></script>
    <!-- Argon JS -->
    <script src="{{ asset('vendor/argon') }}/js/argon.js?v=1.0.0"></script>
    <script>
        var ONESIGNAL_APP_ID = "{{ config('settings.onesignal_app_id') }}";
        var USER_ID = '{{ auth()->user() && auth()->user() ? auth()->user()->id : '' }}';
        var PUSHER_APP_KEY = "{{ config('broadcasting.connections.pusher.key') }}";

        var PUSHER_APP_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
    </script>
    @if (auth()->user() != null && auth()->user()->hasRole('staff'))
        <script>
            USER_ID = '{{ auth()->user()->company->user_id }}';
        </script>
    @endif
    <!-- OneSignal -->
    @if (strlen(config('settings.onesignal_app_id')) > 4)
        <script src="{{ asset('vendor') }}/OneSignalSDK/OneSignalSDK.js" async=""></script>
        <script src="{{ asset('custom') }}/js/onesignal.js"></script>
    @endif
    @stack('js')
    @yield('js')
    <!-- Pusher -->
    @if (strlen(config('broadcasting.connections.pusher.app_id')) > 2)
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        @if (config('settings.app_code_name', '') == 'qrpdf')
            <script src="{{ asset('custom') }}/js/pusher.js"></script>
        @endif
    @endif


    <!-- Import Select2 --->
    <script src="{{ asset('vendor') }}/select2/select2.min.js"></script>
    <!-- Custom JS defined by admin -->
    <script src="{{ asset('byadmin') }}/back.js"></script>

    <script src="{{ asset('vendor/argon') }}/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Import Vue -->
    <script defer src="{{ asset('vendor/vue/vue.js') }}"></script>
    <script defer src="{{ asset('vendor/vue/bootstrap-vue.min.js') }}"></script>
    <!-- Import AXIOS --->
    <script src="{{ asset('vendor') }}/axios/axios.min.js"></script>
    <?php
    echo file_get_contents(base_path('public/byadmin/back.js'));
    ?>

    <script src="{{ asset('Metronic8.2') }}/assets/plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('Metronic8.2') }}/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('Metronic8.2') }}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="{{ asset('Metronic8.2') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('Metronic8.2') }}/assets/js/widgets.bundle.js"></script>
    <script src="{{ asset('Metronic8.2') }}/assets/js/custom/widgets.js"></script>
    <script src="{{ asset('Metronic8.2') }}/assets/js/custom/apps/chat/chat.js"></script>
    <script src="{{ asset('Metronic8.2') }}/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="{{ asset('Metronic8.2') }}/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="{{ asset('Metronic8.2') }}/assets/js/custom/utilities/modals/new-target.js"></script>
    <script src="{{ asset('Metronic8.2') }}/assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
    @include('client.layout.intercom')
</body>

</html>
