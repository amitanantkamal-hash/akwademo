@extends('client.app-profile')

@section('content')
    <div>
        <div id="kt_app_content_container" class="container-fluid ">
            <div class="card mb-6">
                @include('profile.components.card-header')
            </div>
            {{-- @include('profile.components.card-body') --}}
            <div class="tab-content">
                <div class="tab-pane show active">
                    @include('profile.components.sub.tab2')
                </div>
            </div>
            <div class="card-footer">
                @include('profile.components.card-footer')
            </div>
            {{-- <div class="card mb-6">
                @include('profile.components.card-header')
            </div>
            @include('profile.components.card-body')
            <div class="card-footer">
                @include('profile.components.card-footer')
            </div> --}}
            {{-- Modals --}}
        </div>
    </div>
@endsection

@section('js')
@include('common.delete-script')
    @include('profile.components.scripts')
@endsection
