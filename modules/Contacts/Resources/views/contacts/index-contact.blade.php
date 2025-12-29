@extends('client.app')
@section('title')
    {{ __('Dashboard') }}
@endsection
@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div id="kt_app_toolbar" class="app-toolbar">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                    <div class="card-title fw-semibold fs-3">
                        {{ __('Contacts') }}
                        <span class="badge fw-bold px-3 py-2 ms-2 badge-light-info">
                            {{ count($contacts) }}
                        </span>
                    </div>
                    <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="{{ Route('contacts.index') }}" class="btn btn-secondary me-0 me-sm-3">
                            Back to Management</a>
                        <livewire:addContact>
                    </div>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="row g-7">
                <livewire:CheckContact :contacts="$contacts" />
                <div class="col d-flex flex-column">
                    <livewire:user-contact-box :groups="$groups" :camposAdicionales="$camposAdicionales" :contacts="$contacts" :countries="$countries"
                        :contact="$contact[0]" />
                </div>
            </div>
        </div>
    </div>
    @include('contacts::contacts.partials.modals')
@endsection

@section('js')
    <script>
        console.log('Contacts using Livewire')
    </script>
    @include('contacts::contacts.partials.scripts')
@endsection
