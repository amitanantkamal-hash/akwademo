@extends('layouts.app', ['title' => __('Companies')])
@section('content')
    <div class="header  pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <h1 class="mb-3 mt--3"><i class="ni ni-circle-08 text-red"></i> {{ __('Partners') }}</h1>
                <div class="row align-items-center pt-2">
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">

                            </div>
                            <div class="col-4 text-right">

                                <a href="{{ route('partners.create') }}"
                                    class="btn btn-sm btn-outline-primary">{{ __('Create Partner Account') }}</a>

                            </div>
                        </div>

                    </div>

                    <div class="col-12">
                        @include('partials.flash')
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Business Name') }}</th>
                                    <th>{{ __('GST Number') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($partners as $partner)
                                    <tr>
                                        <td>{{ $partner->name }}</td>
                                        <td>{{ $partner->phone }}</td>
                                        <td>{{ $partner->email }}</td>
                                        <td>{{ $partner->business_name }}</td>
                                        <td>{{ $partner->gst_number }}</td>
                                        <td>
                                            <a href="{{ route('partners.edit', $partner) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="{{ route('partners.toggle-status', $partner) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                <button type="submit"
                                                    class="btn {{ $partner->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} btn-sm">
                                                    {{ $partner->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
