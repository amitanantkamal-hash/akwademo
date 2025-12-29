@extends('layouts.app-client')

@section('title')
{{ __('WhatsApp Cloud API Setup') }}
<x-button-links />
@endsection

@section('content')
<div class="mt--8">
    <div class="row">
        <div class="col-12">
            @include('partials.flash')
        </div>
    </div>
    @include('embeddedlogin::template')
{{--
    <div class="row">
        <div class="col-lg-8 col-md-7">
            @include('embeddedlogin::connect')
        </div>
        <div class="col-lg-4 col-md-5">
            @include('wpbox::setup.verified')
        </div>
    </div> --}}
</div>
@endsection