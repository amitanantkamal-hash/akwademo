<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ config('app.name','Official WhatsApp Business API Provider | Meta Tech Solutions') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="msapplication-TileColor" content="#0E0E0E">
    <meta name="template-color" content="#0E0E0E">
    <meta name="description" content="Boost your business with WhatsApp Business API solutions from an Official Provider. Get seamless integration, automation, and expert support for customer engagement">
    <meta name="keywords" content="WhatsApp Business API, Meta Tech Provider, WhatsApp API integration, business automation, official Meta Tech Provider">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/imgs/template/site-logo.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link href="{{asset('assets/css/style.css')}}?v={{env('ASSET_VERSION','5.0.0')}}" rel="stylesheet">
    @yield('head')
    <link href="{{asset('assets/css/custom.css')}}?v={{env('ASSET_VERSION','5.0.0')}}" rel="stylesheet">
    <!-- code added by amit -->
    <link href="{{asset('assets/css/front_style.css')}}?v={{env('ASSET_VERSION','5.0.0')}}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/keen-slider.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/keen-slider.min.js"></script>
    <!-- end -->

</head>

<body>
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="page-loading">
                    <div class="page-loading-inner">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.partials.header')
    @include('frontend.partials.mobile_header')
    @yield('content')
    @if(!in_array(Route::currentRouteName(), ['login', 'register','password.request','reset.password']))
        @include('frontend.partials.footer')
    @endif
    @include('frontend.partials.scripts')
    @yield('post_js')
    <x-wademo-chatbot />
</body>

</html>