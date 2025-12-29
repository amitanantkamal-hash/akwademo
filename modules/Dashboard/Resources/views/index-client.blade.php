@extends('layouts.app-client')
@section('title')
    {{__('Dashboard')}}
@endsection

@section('content')
    @foreach (config('global.modulesWithDashboardInfo') as $moduleWithDashboardInfo)
        @include($moduleWithDashboardInfo.'::dashboard')
    @endforeach

    {{-- @yield('dashboard_content')
    @yield('dashboard_content2')
    @yield('dashboard_content3')
    @yield('dashboard_content4') --}}

@endsection
