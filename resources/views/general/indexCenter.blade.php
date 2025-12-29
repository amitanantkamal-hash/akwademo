@extends('layouts.app-client', ['title' => __($title)])

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card shadow w-100 w-sm-100 w-md-50">
            <div class="card-header border-0 ">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h3 class="mb-0">{{ __($title) }}</h3>
                    @isset($action_link)
                        <a href="{{ $action_link }}" class="btn btn-sm btn-primary">{{ __($action_name) }}</a>
                    @endisset
                </div>
            </div>
            <div class="col-12">
                @include('partials.flash-client')
            </div>
            @if (isset($iscontent))
                <div class="card-body">
                    @yield('cardbody')
                </div>
            @endif
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
