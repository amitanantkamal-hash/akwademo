@extends('layouts.app-client')

@section('topcss')
    <!-- Add any additional top CSS if needed -->
@endsection

@section('content')
    <div class="card card-custom gutter-b bg-light">
        <div class="card-title">
            @include('partials.flash')
        </div>
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {{ __('Add a new company') }}
                </div>
            </div>
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <a href="{{ route('partner.dashboard') }}" class="btn btn-info btn-sm">{{ __('Back to list') }}</a>
            </div>
        </div>

    </div>
    {{-- @if (auth()->user()->hasrole('owner') || auth()->user()->hasrole('staff'))
        <div class="row d-flex justify-content-between">
            <div class="col-12 col-lg-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <h1 class="mb-3 mt--3">{{ __('Add a new company') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    {{-- <div class="container-fluid mt-10"> --}}
        <div class="row mt-6">
            <div class="col">
                <div class="card shadow">
                    {{-- <div class="card card-flush">
                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                            <div class="row align-items-center">
                                <div class="card-title">
                                    @include('partials.flash')
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('partner.dashboard') }}" class="btn btn-sm btn-info">
                                        {{ __('Back to list') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <h6 class="heading-small text-muted mb-4">{{ __('Company information') }}</h6>
                        <div class="pl-lg-4">
                            <form method="post" action="{{ route('partner.companies.store') }}">
                                @csrf
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} mt-6">
                                    <label class="form-control-label mb-2" for="name">{{ __('Company Name') }}</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Enter company name') }}" value="" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <hr />

                                <h6 class="heading-small text-muted mb-4">{{ __('Owner information') }}</h6>
                                <div class="form-group{{ $errors->has('name_owner') ? ' has-danger' : '' }}">
                                    <label class="form-control-label mt-2 mb-2"
                                        for="name_owner">{{ __('Name') }}</label>
                                    <input type="text" name="name_owner" id="name_owner"
                                        class="form-control form-control-alternative{{ $errors->has('name_owner') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Enter name') }}" value="" required autofocus>
                                    @if ($errors->has('name_owner'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name_owner') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email_owner') ? ' has-danger' : '' }}">
                                    <label class="form-control-label mt-2 mb-2"
                                        for="email_owner">{{ __('Email') }}</label>
                                    <input type="email" name="email_owner" id="email_owner"
                                        class="form-control form-control-alternative{{ $errors->has('email_owner') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Enter email') }}" value="" required autofocus>
                                    @if ($errors->has('email_owner'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email_owner') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                @include('partials.input', [
                                    'type' => 'text',
                                    'name' => 'WhatsApp number',
                                    'id' => 'phone',
                                    'placeholder' => '9000000000',
                                    'required' => true,
                                    'value' => '',
                                ])

                                @if (isset($_GET['cloneWith']))
                                    <input type="hidden" id="cloneWith" name="cloneWith"
                                        value="{{ $_GET['cloneWith'] }}" />
                                @endif

                                <div class="text-left">
                                    <button type="submit" class="btn btn-info mt-6">{{ __('Create record') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
@endsection
