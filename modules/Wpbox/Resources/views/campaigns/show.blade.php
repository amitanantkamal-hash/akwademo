@extends('general.index-client', [])

@section('title')
    {{ __('Campaign detail') }}
    <x-button-links />
@endsection
@section('customheading')
    @if (config('wpbox.google_maps_enabled', true))
        @include('wpbox::campaigns.map', $item)
    @endif
    <div class="mt-4">
        <div class="row g-5 gx-xl-10">
            @include('wpbox::campaigns.infoboxes-detail', $item)
            @include('wpbox::campaigns.table', $setup)
        </div>
    </div>
@endsection
